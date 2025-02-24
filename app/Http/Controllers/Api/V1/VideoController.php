<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

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
    public function index(): JsonResponse {
        $videos = $this->paginateOrGet(
            Video::with($this->getRelations())->latest());

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
            $video->allowedUsers()->sync($request->validated("allowed_users"));
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
