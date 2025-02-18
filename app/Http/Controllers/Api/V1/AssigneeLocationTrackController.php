<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssigneeLocationTrackRequest;
use App\Http\Resources\AssigneeLocationTrackResource;
use App\Models\AssigneeLocationTrack;
use App\Models\MlceAssignment;
use Illuminate\Http\JsonResponse;

class AssigneeLocationTrackController extends Controller
{
    protected array $relations = [
        "mlceAssignment"
    ];

    public function index(): JsonResponse {
        $assigneeLocationTracks = $this->paginateOrGet(
            AssigneeLocationTrack::with($this->getRelations())->filter()->latest());

        return $this->respondWithResourceCollection(
            AssigneeLocationTrackResource::collection($assigneeLocationTracks)
        );
    }

    /**
     * Store a newly created assigneeLocationTrack in storage.
     */
    public function store(MlceAssignment $mlceAssignment, AssigneeLocationTrackRequest $request): JsonResponse {
        $isLocationTrackExists = $mlceAssignment->assigneeLocationTracks()
            ->where('status', $request->validated('status'))
            ->exists();

        if ($isLocationTrackExists) {
            return $this->respondError("Location track already exists!");
        }

        $assigneeLocationTrack = AssigneeLocationTrack::create($request->validated());
        $mlceAssignment->update(["location_status" => $assigneeLocationTrack->status]);

        return $this->respondCreated(
            new AssigneeLocationTrackResource($assigneeLocationTrack),
            "Assignee Location Track created successfully!"
        );
    }

    /**
     * Update the specified assigneeLocationTrack in storage.
     */
//    public function update(
//        AssigneeLocationTrackRequest $request,
//        AssigneeLocationTrack $assigneeLocationTrack
//    ): JsonResponse {
//        $assigneeLocationTrack->update($request->validated());
//
//        return $this->respondUpdated(
//            new AssigneeLocationTrackResource($assigneeLocationTrack),
//            "AssigneeLocationTrack updated successfully!"
//        );
//    }

    /**
     * Display the specified assigneeLocationTrack.
     */
//    public function show(AssigneeLocationTrack $assigneeLocationTrack): JsonResponse {
//        return $this->respondWithResource(
//            new AssigneeLocationTrackResource($assigneeLocationTrack));
//    }

    /**
     * Remove the specified assigneeLocationTrack from storage.
     */
//    public function destroy(AssigneeLocationTrack $assigneeLocationTrack): JsonResponse {
//        $assigneeLocationTrack->delete();
//
//        return $this->respondSuccess("AssigneeLocationTrack deleted successfully!");
//    }
}
