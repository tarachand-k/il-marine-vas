<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignmentObservationRequest;
use App\Http\Resources\AssignmentObservationResource;
use App\Models\AssignmentObservation;
use Illuminate\Http\JsonResponse;

class AssignmentObservationController extends Controller
{
    protected array $relations = [
        "mlceAssignment",
    ];

    protected ?string $resourceName = "assignment-observations";

    protected array $fileFieldNames = [
        "photo_1", "photo_2", "photo_3", "photo_4",
    ];

    protected array $fileFolderPaths = [
        "photos", "photos", "photos", "photos"
    ];

    public function index(): JsonResponse {
        $assignmentObservations = $this->paginateOrGet(
            AssignmentObservation::with($this->getRelations())->latest());

        return $this->respondWithResourceCollection(
            AssignmentObservationResource::collection($assignmentObservations)
        );
    }

    /**
     * Store a newly created assignmentObservation in storage.
     */
    public function store(AssignmentObservationRequest $request): JsonResponse {
        $assignmentObservation = new AssignmentObservation($request->validated());
        $this->storeFiles($request, $assignmentObservation);
        $assignmentObservation->save();

        return $this->respondCreated(
            new AssignmentObservationResource($assignmentObservation),
            "AssignmentObservation created successfully!"
        );
    }

    /**
     * Display the specified assignmentObservation.
     */
    public function show(AssignmentObservation $assignmentObservation): JsonResponse {
        $assignmentObservation->loadMissing($this->getRelations());

        return $this->respondWithResource(new AssignmentObservationResource($assignmentObservation));
    }

    /**
     * Update the specified assignmentObservation in storage.
     */
    public function update(
        AssignmentObservationRequest $request,
        AssignmentObservation $assignmentObservation
    ): JsonResponse {
        $assignmentObservation->fill($request->validated());
        $this->updateFiles($request, $assignmentObservation);
        $assignmentObservation->save();

        return $this->respondUpdated(
            new AssignmentObservationResource($assignmentObservation),
            "AssignmentObservation updated successfully!"
        );
    }

    /**
     * Remove the specified assignmentObservation from storage.
     */
    public function destroy(AssignmentObservation $assignmentObservation): JsonResponse {
        $this->deleteFiles($assignmentObservation);
        $assignmentObservation->delete();

        return $this->respondSuccess("AssignmentObservation deleted successfully!");
    }
}
