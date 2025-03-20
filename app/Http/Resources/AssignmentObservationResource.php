<?php

namespace App\Http\Resources;

use App\Models\AssignmentObservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AssignmentObservation */
class AssignmentObservationResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'mlce_assignment_id' => $this->mlce_assignment_id,

            'ref_no' => $this->ref_no,
            'location' => $this->location,
            'brief' => $this->brief,
            'type' => $this->type,
            'current_observation' => $this->current_observation,

            'photo_1' => $this->photo_1,
            'photo_2' => $this->photo_2,
            'photo_3' => $this->photo_3,
            'photo_4' => $this->photo_4,
            'photo_1_desc' => $this->photo_1_desc,
            'photo_2_desc' => $this->photo_2_desc,
            'photo_3_desc' => $this->photo_3_desc,
            'photo_4_desc' => $this->photo_4_desc,

            // relation
            'mlce_assignment' => new MlceAssignmentResource($this->whenLoaded('mlceAssignment')),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
