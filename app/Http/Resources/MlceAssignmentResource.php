<?php

namespace App\Http\Resources;

use App\Models\MlceAssignment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceAssignment */
class MlceAssignmentResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'mlce_indent_id' => $this->mlce_indent_id,
            'mlce_indent_location_id' => $this->mlce_indent_location_id,
            'inspector_id' => $this->inspector_id,
            'supervisor_id' => $this->supervisor_id,

            'status' => $this->status,
            'location_status' => $this->location_status,
            'completed_at' => $this->completed_at,

            // relations
            'mlce_indent' => new MlceIndentResource($this->whenLoaded('mlceIndent')),
            'mlce_indent_location' => new MlceIndentLocationResource($this->whenLoaded('mlceIndentLocation')),
            'inspector' => new UserResource($this->whenLoaded('inspector')),
            'supervisor' => new UserResource($this->whenLoaded('supervisor')),

            'assignee_location_tracks' => AssigneeLocationTrackResource::collection(
                $this->whenLoaded("assigneeLocationTracks")),
            "assignment_observations" => AssignmentObservationResource::collection(
                $this->whenLoaded("assignmentObservations")),
            "mlce_recommendations" => MlceRecommendationResource::collection(
                $this->whenLoaded("mlceRecommendations")),
            "assignment_photos" => AssignmentPhotoResource::collection($this->whenLoaded("assignmentPhotos")),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
