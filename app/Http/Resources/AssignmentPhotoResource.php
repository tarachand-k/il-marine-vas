<?php

namespace App\Http\Resources;

use App\Models\AssignmentPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AssignmentPhoto */
class AssignmentPhotoResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'mlce_assignment_id' => $this->mlce_assignment_id,

            'title' => $this->title,
            'description' => $this->description,
            'photo' => $this->photo,

            // relation
            'mlceAssignment' => new MlceAssignmentResource($this->whenLoaded('mlceAssignment')),
        ];
    }
}
