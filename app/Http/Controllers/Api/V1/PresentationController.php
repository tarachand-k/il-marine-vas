<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\PresentationRequest;
use App\Http\Resources\PresentationResource;
use App\Mail\PresentationMail;
use App\Models\Presentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PresentationController extends Controller
{
    protected array $relations = [
        "uploadedBy", "allowedUsers",
    ];


    protected array $fileFieldNames = [
        "presentation",
    ];

    protected array $fileFolderPaths = [
        "presentations",
    ];

    /**
     * Display a listing of the presentations.
     */
    public function index(Request $request): JsonResponse {
        $user = $request->user();
        $query = Presentation::query();

        if ($user->role !== UserRole::ILGIC_MLCE_ADMIN->value) {
            $query->whereHas("allowedUsers", fn($query) => $query->where("users.id", $user->id));
        }

        $presentations = $this->paginateOrGet(
            $query->with($this->getRelations())->latest());


        return $this->respondWithResourceCollection(
            PresentationResource::collection($presentations)
        );
    }

    /**
     * Store a newly created presentation in storage.
     */
    public function store(PresentationRequest $request): JsonResponse {
        $presentation = new Presentation($request->validated());
        $this->storeFiles($request, $presentation);
        $presentation->save();

        if ($request->has("allowed_users")) {
            $presentation->allowedUsers()->attach($request->validated("allowed_users"));
        }

        $presentation->allowedUsers->each(
            fn($user) => Mail::to($user->email)->send(new PresentationMail($presentation, $user)));

        return $this->respondCreated(
            new PresentationResource($presentation),
            "Presentation created successfully!"
        );
    }

    /**
     * Display the specified presentation.
     */
    public function show(Presentation $presentation): JsonResponse {
        $presentation->loadMissing($this->getRelations());

        return $this->respondWithResource(new PresentationResource($presentation));
    }

    /**
     * Update the specified presentation in storage.
     */
    public function update(PresentationRequest $request, Presentation $presentation): JsonResponse {
        $presentation->fill($request->validated());
        $this->updateFiles($request, $presentation);
        $presentation->save();

        if ($request->has("allowed_users")) {
            // Get the current allowed users' IDs before sync
            $existingUserIds = $presentation->allowedUsers->pluck('id')->toArray();

            // Get the new allowed users from request
            $newUserIds = $request->validated("allowed_users");

            // Find newly added user IDs by comparing new IDs with existing ones
            $newlyAddedUserIds = array_diff($newUserIds, $existingUserIds);

            // Sync all allowed users
            $presentation->allowedUsers()->sync($newUserIds);

            // Get the newly added users and send them emails
            $presentation->allowedUsers()
                ->whereIn('id', $newlyAddedUserIds)
                ->each(fn($user) => Mail::to($user->email)->send(new PresentationMail($presentation, $user)));
        }

        return $this->respondUpdated(
            new PresentationResource($presentation),
            "Presentation updated successfully!"
        );
    }

    /**
     * Remove the specified presentation from storage.
     */
    public function destroy(Presentation $presentation): JsonResponse {
        $this->deleteFiles($presentation);
        $presentation->delete();

        return $this->respondSuccess("Presentation deleted successfully!");
    }
}
