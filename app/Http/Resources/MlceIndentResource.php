<?php

namespace App\Http\Resources;

use App\Models\MlceIndent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceIndent */
class MlceIndentResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'created_by_id' => $this->created_by_id,
            'customer_id' => $this->customer_id,
            'mlce_type_id' => $this->mlce_type_id,

            'indent_code' => $this->indent_code,
            'pdr_observation' => $this->pdr_observation,
            'job_scope' => $this->job_scope,
            'why_mlce' => $this->why_mlce,

            // relations
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'mlce_type' => new MlceTypeResource($this->whenLoaded('mlceType')),
            'users' => UserResource::collection($this->whenLoaded("users")),
            "locations" => MlceIndentLocationResource::collection($this->whenLoaded("locations")),
            "assignments" => MlceAssignmentResource::collection($this->whenLoaded("assignments")),
            "report" => new MlceReportResource($this->whenLoaded("report")),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
