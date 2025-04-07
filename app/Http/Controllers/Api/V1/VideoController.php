<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Http\Resources\VideoResource;
use App\Mail\VideoMail;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VideoController extends Controller
{
    protected array $relations = [
        "uploadedBy", "allowedUsers",
    ];


    protected array $fileFieldNames = [
        "video",
    ];

    protected array $fileFolderPaths = [
        "videos",
    ];

    /**
     * Display a listing of the videos.
     */
    public function index(Request $request): JsonResponse {
        $user = $request->user();
        $query = Video::query();

        if ($user->role !== UserRole::ILGIC_MLCE_ADMIN->value) {
            $query->whereHas("allowedUsers", fn($query) => $query->where("users.id", $user->id));
        }

        $videos = $this->paginateOrGet(
            $query->with($this->getRelations())->latest());

        return $this->respondWithResourceCollection(
            VideoResource::collection($videos)
        );
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(VideoRequest $request): JsonResponse {
        $video = new Video($request->validated());
        $this->storeFiles($request, $video);
        $video->save();

        if ($request->has("allowed_users")) {
            $video->allowedUsers()->attach($request->validated("allowed_users"));
        }

        $video->allowedUsers->each(fn($user) => Mail::to($user->email)->send(new VideoMail($video, $user)));

        return $this->respondCreated(
            new VideoResource($video),
            "Video created successfully!"
        );
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video): JsonResponse {
        $video->loadMissing($this->getRelations());

        return $this->respondWithResource(new VideoResource($video));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(VideoRequest $request, Video $video): JsonResponse {
        $video->fill($request->validated());
        $this->updateFiles($request, $video);
        $video->save();

        if ($request->has("allowed_users")) {
            // get the current allowed users' IDs before sync
            $existingUserIds = $video->allowedUsers->pluck('id')->toArray();

            // get the new allowed users from request
            $newUserIds = $request->validated("allowed_users");

            // find newly added user IDs by comparing new IDs with existing ones
            $newlyAddedUserIds = array_diff($newUserIds, $existingUserIds);

            // sync all allowed users
            $video->allowedUsers()->sync($newUserIds);

            // get the newly added users and send them emails
            $video->allowedUsers()
                ->whereIn('id', $newlyAddedUserIds)
                ->each(fn($user) => Mail::to($user->email)->send(new VideoMail($video, $user)));
        }

        return $this->respondUpdated(
            new VideoResource($video),
            "Video updated successfully!"
        );
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video): JsonResponse {
        $this->deleteFiles($video);
        $video->delete();

        return $this->respondSuccess("Video deleted successfully!");
    }
}
