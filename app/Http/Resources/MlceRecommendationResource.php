<?php

namespace App\Http\Resources;

use App\Models\MlceRecommendation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceRecommendation */
class MlceRecommendationResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'mlce_indent_id' => $this->mlce_indent_id,
            'mlce_assignment_id' => $this->mlce_assignment_id,

            'ref_no' => $this->ref_no,
            'sub_location' => $this->sub_location,
            'brief' => $this->brief,
            'closure_priority' => $this->closure_priority,
            'capital_involvement' => $this->capital_involvement,
            'current_observation' => $this->current_observation,
            'hazard' => $this->hazard,
            'recommendations' => $this->recommendations,
            'client_response' => $this->client_response,
            'status' => $this->status,
            'timeline' => $this->timeline,
            'completed_at' => $this->completed_at,
            'is_implemented' => $this->is_implemented,
            'comment' => $this->comment,
            'photo_1' => $this->photo_1,
            'photo_2' => $this->photo_2,
            'photo_3' => $this->photo_3,
            'photo_4' => $this->photo_4,
            'photo_1_desc' => $this->photo_1_desc,
            'photo_2_desc' => $this->photo_2_desc,
            'photo_3_desc' => $this->photo_3_desc,
            'photo_4_desc' => $this->photo_4_desc,

            // relations
            // 'mlce_indent' => new MlceIndentResource($this->whenLoaded("mlceIndent")),
            'mlce_assignment' => new MlceAssignmentResource($this->whenLoaded('mlceAssignment')),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
