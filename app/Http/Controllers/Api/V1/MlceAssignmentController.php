<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\AssigneeLocationTrackStatus;
use App\Enums\MlceAssignmentStatus;
use App\Enums\MlceIndentLocationStatus;
use App\Enums\MlceIndentStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssigneeLocationTrackRequest;
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
        $user = request()->user();
        $query = MlceAssignment::query();

        if ($user->role === UserRole::MARINE_EXT_TEAM_MEMBER->value) {
            $query->where("inspector_id", $user->id);
        }

        $mlceAssignments = $this->paginateOrGet(
            $query->with($this->getRelations())->filter()->latest());

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

        if ($mlceAssignment->mlceIndent->status === MlceIndentStatus::CREATED->value) {
            $mlceAssignment->mlceIndent->update(["status" => MlceIndentStatus::IN_PROGRESS->value]);
        }

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

    /**
     * Remove the specified mlceAssignment from storage.
     */
    public function destroy(MlceAssignment $mlceAssignment): JsonResponse {
        $mlceAssignment->delete();

        return $this->respondSuccess("MlceAssignment deleted successfully!");
    }

    public function mobilise(AssigneeLocationTrackRequest $request, MlceAssignment $mlceAssignment) {
        if ($mlceAssignment->status !== MlceAssignmentStatus::ASSIGNED->value) {
            return $this->respondError("Assignment has already been mobilised", statusCode: 400);
        }

        $mlceAssignment->update(["status" => MlceAssignmentStatus::MOBILISED->value]);

        $mlceAssignment->assigneeLocationTracks()->create(
            $request->validated() + ["status" => AssigneeLocationTrackStatus::CMMI->value]);

        return $this->respondSuccess(
            "Assignment has been mobilised successfully!"
        );
    }

    public function startSurvey(AssigneeLocationTrackRequest $request, MlceAssignment $mlceAssignment) {
        if ($mlceAssignment->status !== MlceAssignmentStatus::MOBILISED->value) {
            return $this->respondError("Assignment survey has already been started or completed", statusCode: 400);
        }

        $mlceAssignment->update(["status" => MlceAssignmentStatus::SURVEY_STARTED->value]);

        $mlceAssignment->assigneeLocationTracks()->create(
            $request->validated() + ["status" => AssigneeLocationTrackStatus::ROS_2C_MLCE->value]);

        return $this->respondSuccess(
            "Assignment survey has been started"
        );
    }

    public function completeSurvey(AssigneeLocationTrackRequest $request, MlceAssignment $mlceAssignment) {
        if ($mlceAssignment->status !== MlceAssignmentStatus::SURVEY_STARTED->value) {
            return $this->respondError("Assignment survey has already been completed", statusCode: 400);
        }

        $mlceAssignment->update([
            "status" => MlceAssignmentStatus::SURVEY_COMPLETED->value,
            "completed_at" => now()->format("Y-m-d H:i:s"),
        ]);

        $mlceAssignment->assigneeLocationTracks()->create(
            $request->validated() + ["status" => AssigneeLocationTrackStatus::CMCD->value]);

        $mlceAssignment->mlceIndentLocation()
            ->update(["status" => MlceIndentLocationStatus::COMPLETED->value]);

        return $this->respondSuccess(
            "Assignment survey has been completed"
        );
    }

    public function demobilise(AssigneeLocationTrackRequest $request, MlceAssignment $mlceAssignment) {
        if ($mlceAssignment->status !== MlceAssignmentStatus::SURVEY_COMPLETED->value) {
            return $this->respondError("Assignment has already been demobilised", statusCode: 400);
        }

        $mlceAssignment->update(["status" => MlceAssignmentStatus::DEMOBILISED->value,]);

        $mlceAssignment->assigneeLocationTracks()->create(
            $request->validated() + ["status" => AssigneeLocationTrackStatus::DMC->value]);

        return $this->respondSuccess(
            "Assignment has been demobilised"
        );
    }

    public function submitRecommendations(MlceAssignment $mlceAssignment) {
        if ($mlceAssignment->status !== MlceAssignmentStatus::DEMOBILISED->value) {
            return $this->respondError("Assignment recommendations have already been submitted", statusCode: 400);
        }

        $mlceAssignment->update(["status" => MlceAssignmentStatus::RECOMMENDATIONS_SUBMITTED->value,]);

        return $this->respondSuccess(
            "Assignment recommendations have been submitted"
        );
    }
}
