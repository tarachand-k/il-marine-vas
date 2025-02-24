<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MlceAssignmentStatus;
use App\Enums\MlceIndentLocationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\MlceAssignmentRequest;
use App\Http\Resources\MlceAssignmentResource;
use App\Models\MlceAssignment;
use Illuminate\Http\JsonResponse;

class MlceAssignmentController extends Controller
{
    protected array $relations = [
        "mlceIndent", "mlceIndentLocation", "inspector", "supervisor",
        "assigneeLocationTracks", "assignmentObservations", "mlceRecommendations", "assignmentPhotos"
    ];

    public function index(): JsonResponse {
        $mlceAssignments = $this->paginateOrGet(
            MlceAssignment::with($this->getRelations())->latest());

        return $this->respondWithResourceCollection(
            MlceAssignmentResource::collection($mlceAssignments)
        );
    }

    /**
     * Store a newly created mlceAssignment in storage.
     */
    public function store(MlceAssignmentRequest $request): JsonResponse {
        if (MlceAssignment::where("mlce_indent_id", $request->validated("mlce_indent_id"))
            ->where("mlce_indent_location_id", $request->validated("mlce_indent_location_id"))->exists()) {
            return $this->respondError('Indent location has already been assigned', null, 400);
        }

        $mlceAssignment = MlceAssignment::create($request->validated());
        $mlceAssignment->mlceIndentLocation()
            ->update(["status" => MlceIndentLocationStatus::PENDING->value]);

        return $this->respondCreated(
            new MlceAssignmentResource($mlceAssignment),
            "MlceAssignment created successfully!"
        );
    }

    /**
     * Update the specified mlceAssignment in storage.
     */
    public function update(MlceAssignmentRequest $request, MlceAssignment $mlceAssignment): JsonResponse {
        $mlceAssignment->update($request->validated());

        return $this->respondUpdated(
            new MlceAssignmentResource($mlceAssignment),
            "MlceAssignment updated successfully!"
        );
    }

    /**
     * Display the specified mlceAssignment.
     */
    public function show(MlceAssignment $mlceAssignment): JsonResponse {
        $mlceAssignment->loadMissing($this->getRelations());

        return $this->respondWithResource(new MlceAssignmentResource($mlceAssignment));
    }

    public function completeAssignment(MlceAssignment $mlceAssignment) {
        $mlceAssignment->update([
            "status" => MlceAssignmentStatus::COMPLETED->value,
            "completed_at" => now()->format("Y-m-d H:i:s"),
        ]);

        $mlceAssignment->mlceIndentLocation()
            ->update(["status" => MlceIndentLocationStatus::COMPLETED->value]);

        return $this->respondSuccess(
            "Assignment completed successfully!"
        );
    }

    public function cancelAssignment(MlceAssignment $mlceAssignment) {
        $mlceAssignment->update([
            "status" => MlceAssignmentStatus::CANCELLED->value,
        ]);

        $mlceAssignment->mlceIndentLocation()
            ->update(["status" => MlceIndentLocationStatus::CANCELLED->value]);

        return $this->respondSuccess(
            "Assignment declined successfully!"
        );
    }

    /**
     * Remove the specified mlceAssignment from storage.
     */
    public function destroy(MlceAssignment $mlceAssignment): JsonResponse {
        $mlceAssignment->delete();

        return $this->respondSuccess("MlceAssignment deleted successfully!");
    }
}
