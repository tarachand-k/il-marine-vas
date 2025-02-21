<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignmentPhotoRequest;
use App\Http\Resources\AssignmentPhotoResource;
use App\Models\AssignmentPhoto;
use Illuminate\Http\JsonResponse;

class AssignmentPhotoController extends Controller
{
    protected array $relations = [
        "mlceAssignment",
    ];

    protected array $fileFieldNames = [
        "photo",
    ];

    protected array $fileFolderPaths = [
        "assignment-photos"
    ];

    public function index(): JsonResponse {
        $assignmentPhotos = $this->paginateOrGet(
            AssignmentPhoto::with($this->getRelations())->latest("id"));

        return $this->respondWithResourceCollection(
            AssignmentPhotoResource::collection($assignmentPhotos)
        );
    }

    /**
     * Store a newly created assignmentPhoto in storage.
     */
    public function store(AssignmentPhotoRequest $request): JsonResponse {
        $assignmentPhoto = new AssignmentPhoto($request->validated());
        $this->storeFiles($request, $assignmentPhoto);
        $assignmentPhoto->save();

        return $this->respondCreated(
            new AssignmentPhotoResource($assignmentPhoto),
            "AssignmentPhoto created successfully!"
        );
    }

    /**
     * Display the specified assignmentPhoto.
     */
    public function show(AssignmentPhoto $assignmentPhoto): JsonResponse {
        $assignmentPhoto->loadMissing($this->getRelations());

        return $this->respondWithResource(new AssignmentPhotoResource($assignmentPhoto));
    }

    /**
     * Update the specified assignmentPhoto in storage.
     */
    public function update(
        AssignmentPhotoRequest $request,
        AssignmentPhoto $assignmentPhoto
    ): JsonResponse {
        $assignmentPhoto->fill($request->validated());
        $this->updateFiles($request, $assignmentPhoto);
        $assignmentPhoto->save();

        return $this->respondUpdated(
            new AssignmentPhotoResource($assignmentPhoto),
            "AssignmentPhoto updated successfully!"
        );
    }

    /**
     * Remove the specified assignmentPhoto from storage.
     */
    public function destroy(AssignmentPhoto $assignmentPhoto): JsonResponse {
        $this->deleteFiles($assignmentPhoto);
        $assignmentPhoto->delete();

        return $this->respondSuccess("AssignmentPhoto deleted successfully!");
    }
}
