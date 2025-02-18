<?php

namespace App\Http\Resources;

use App\Models\AssigneeLocationTrack;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AssigneeLocationTrack */
class AssigneeLocationTrackResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'mlce_assignment_id' => $this->mlce_assignment_id,

            'status' => $this->status,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'battery_level' => $this->battery_level,


            // relation
            'mlce_assignment' => new MlceAssignmentResource($this->whenLoaded('mlceAssignment')),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
