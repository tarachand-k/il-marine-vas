<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRole;
use App\Enums\VesselAssessmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\VesselAssessmentAssignRequest;
use App\Http\Requests\VesselAssessmentParameterRequest;
use App\Http\Requests\VesselAssessmentRequest;
use App\Http\Resources\VesselAssessmentResource;
use App\Models\VesselAssessment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class VesselAssessmentController extends Controller
{
    protected array $relations = ["customer", "createdBy", "assignedTo", "assignedBy", "approvedBy"];

    /**
     * Display a listing of vessel assessments (admin/internal team)
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $query = VesselAssessment::with($this->getRelations())->latest();

        // Filter based on user role
        if ($user->role === UserRole::MARINE_EXT_TEAM_MEMBER) {
            $query->where('assigned_to_id', $user->id);
        }

        if (in_array($user->role, [UserRole::INSURED_ADMIN, UserRole::INSURED_REPRESENTATIVE])) {
            $query->where('customer_id', $user->customer_id);
        }

        $assessments = $this->paginateOrGet($query);

        return $this->respondWithResourceCollection(
            VesselAssessmentResource::collection($assessments)
        );
    }

    /**
     * Store a newly created vessel assessment (customer initialization)
     */
    public function store(VesselAssessmentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by_id'] = $request->user()->id;
        $data['status'] = VesselAssessmentStatus::INITIALIZED;

        $assessment = VesselAssessment::create($data);

        return $this->respondCreated(
            new VesselAssessmentResource($assessment->load($this->relations)),
            "Vessel assessment initialized successfully!"
        );
    }

    /**
     * Display the specified vessel assessment
     */
    public function show(VesselAssessment $vesselAssessment): JsonResponse
    {
        $user = Auth::user();

        // Check permissions
        if ($user->role === UserRole::MARINE_EXT_TEAM_MEMBER) {
            if ($vesselAssessment->assigned_to_id !== $user->id) {
                return $this->respondForbidden("You don't have permission to view this assessment.");
            }
        } elseif (in_array($user->role, [UserRole::INSURED_ADMIN, UserRole::INSURED_REPRESENTATIVE])) {
            if ($vesselAssessment->customer_id !== $user->customer_id) {
                return $this->respondForbidden("You don't have permission to view this assessment.");
            }
        }

        return $this->respondWithResource(
            new VesselAssessmentResource($vesselAssessment->load($this->relations))
        );
    }

    /**
     * Update the specified vessel assessment (admin/internal team only)
     */
    public function update(VesselAssessmentRequest $request, VesselAssessment $vesselAssessment): JsonResponse
    {
        $user = Auth::user();

        // Only admin and internal team can update
        if (!in_array($user->role, [
            UserRole::ILGIC_MLCE_ADMIN,
            UserRole::MARINE_MLCE_TEAM_MEMBER,
            UserRole::INSURED_ADMIN,
            UserRole::INSURED_REPRESENTATIVE,
        ])) {
            return $this->respondForbidden("You don't have permission to update this assessment.");
        }

        $vesselAssessment->update($request->validated());

        return $this->respondUpdated(
            new VesselAssessmentResource($vesselAssessment->load($this->relations)),
            "Vessel assessment updated successfully!"
        );
    }

    /**
     * Remove the specified vessel assessment (admin only)
     */
    public function destroy(VesselAssessment $vesselAssessment): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== UserRole::ILGIC_MLCE_ADMIN) {
            return $this->respondForbidden("You don't have permission to delete this assessment.");
        }

        $vesselAssessment->delete();

        return $this->respondSuccess("Vessel assessment deleted successfully!");
    }

    /**
     * Assign vessel assessment to external team member
     */
    public function assign(VesselAssessmentAssignRequest $request, VesselAssessment $vesselAssessment): JsonResponse
    {
        $user = Auth::user();

        // Only admin and internal team can assign
        if (!in_array($user->role, [UserRole::ILGIC_MLCE_ADMIN, UserRole::MARINE_MLCE_TEAM_MEMBER])) {
            return $this->respondForbidden("You don't have permission to assign this assessment.");
        }

        if (!$vesselAssessment->canBeAssigned()) {
            return $this->respondError("Assessment cannot be assigned at this stage.", statusCode: 400);
        }

        $vesselAssessment->markAsAssigned($request->assigned_to_id, $request->user()->id);

        return $this->respondUpdated(
            new VesselAssessmentResource($vesselAssessment->load($this->relations)),
            "Vessel assessment assigned successfully!"
        );
    }

    /**
     * Complete vessel assessment directly (internal team)
     */
    public function complete(VesselAssessmentParameterRequest $request, VesselAssessment $vesselAssessment): JsonResponse
    {
        $user = Auth::user();

        // Only admin and internal team can complete directly
        if (!in_array($user->role, [UserRole::ILGIC_MLCE_ADMIN, UserRole::MARINE_MLCE_TEAM_MEMBER])) {
            return $this->respondForbidden("You don't have permission to complete this assessment.");
        }

        if (!$vesselAssessment->canBeCompleted()) {
            return $this->respondError("Assessment cannot be completed at this stage.", statusCode: 400);
        }

        $vesselAssessment->update($request->validated());
        $vesselAssessment->markAsCompleted();

        return $this->respondUpdated(
            new VesselAssessmentResource($vesselAssessment->load($this->relations)),
            "Vessel assessment completed successfully!"
        );
    }

    /**
     * Approve submitted vessel assessment (admin)
     */
    public function approve(VesselAssessment $vesselAssessment): JsonResponse
    {
        $data = request()->validate([
            "description" => "nullable|string",
        ]);

        $user = Auth::user();

        // Only admin can approve
        if ($user->role !== UserRole::ILGIC_MLCE_ADMIN) {
            return $this->respondForbidden("You don't have permission to approve this assessment.");
        }

        if (!$vesselAssessment->canBeApproved()) {
            return $this->respondError("Assessment cannot be approved at this stage.", statusCode: 400);
        }

        $vesselAssessment->update(["description" => $data["description"] ?? null]);
        $vesselAssessment->markAsApproved($user->id);

        return $this->respondUpdated(
            new VesselAssessmentResource($vesselAssessment->load($this->relations)),
            "Vessel assessment approved successfully!"
        );
    }

    /**
     * List assigned vessel assessments (external team)
     */
    public function myAssignments(): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== UserRole::MARINE_EXT_TEAM_MEMBER) {
            return $this->respondForbidden("This endpoint is only for external team members.");
        }

        $assessments = $this->paginateOrGet(
            $user->assignedVesselAssessments()->with($this->getRelations())->latest()
        );

        return $this->respondWithResourceCollection(
            VesselAssessmentResource::collection($assessments)
        );
    }

    /**
     * Update assessment parameters (external team)
     */
    public function updateParameters(VesselAssessmentParameterRequest $request, VesselAssessment $vesselAssessment): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== UserRole::MARINE_EXT_TEAM_MEMBER) {
            return $this->respondForbidden("This endpoint is only for external team members.");
        }

        if ($vesselAssessment->assigned_to_id !== $user->id) {
            return $this->respondForbidden("You don't have permission to update this assessment.");
        }

        // Mark as in progress if not already
        if ($vesselAssessment->status === VesselAssessmentStatus::ASSIGNED) {
            $vesselAssessment->markAsInProgress();
        }

        $vesselAssessment->update($request->validated());

        return $this->respondUpdated(
            new VesselAssessmentResource($vesselAssessment->load($this->relations)),
            "Assessment parameters updated successfully!"
        );
    }

    /**
     * Submit completed assessment (external team)
     */
    public function submit(VesselAssessmentParameterRequest $request, VesselAssessment $vesselAssessment): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== UserRole::MARINE_EXT_TEAM_MEMBER) {
            return $this->respondForbidden("This endpoint is only for external team members.");
        }

        if ($vesselAssessment->assigned_to_id !== $user->id) {
            return $this->respondForbidden("You don't have permission to submit this assessment.");
        }

        if (!$vesselAssessment->canBeSubmitted()) {
            return $this->respondError("Assessment cannot be submitted at this stage.");
        }

        $vesselAssessment->update($request->validated());
        $vesselAssessment->markAsSubmitted();

        return $this->respondUpdated(
            new VesselAssessmentResource($vesselAssessment->load($this->relations)),
            "Assessment submitted successfully!"
        );
    }
}
