<?php

namespace App\Http\Resources;

use App\Models\MlceIndent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceIndent */
class MlceIndentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'created_by_id' => $this->created_by_id,
            'customer_id' => $this->customer_id,
            'mlce_type_id' => $this->mlce_type_id,
            'insured_representative_id' => $this->insured_representative_id,
            'rm_id' => $this->rm_id,
            'vertical_rm_id' => $this->vertical_rm_id,
            'under_writer_id' => $this->under_writer_id,

            'ref_no' => $this->ref_no,
            'policy_no' => $this->policy_no,
            'policy_type' => $this->policy_type,
            'policy_start_date' => $this->policy_start_date,
            'policy_end_date' => $this->policy_end_date,
            'hub' => $this->hub,
            'gwp' => $this->gwp,
            'nic' => $this->nic,
            'nep' => $this->nep,
            'lr_percentage' => $this->lr_percentage,
            'vertical_name' => $this->vertical_name,
            'insured_commodity' => $this->insured_commodity,
            'industry' => $this->industry,
            'pdr_observation' => $this->pdr_observation,
            'job_scope' => $this->job_scope,
            'status' => $this->status,
            'completed_at' => $this->completed_at,

            // relations
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'mlce_type' => new MlceTypeResource($this->whenLoaded('mlceType')),
            'insured_representative' => new UserResource($this->whenLoaded("insuredRepresentative")),
            'rm' => new UserResource($this->whenLoaded("rm")),
            'vertical_rm' => new UserResource($this->whenLoaded("verticalRm")),
            'under_writer' => new UserResource($this->whenLoaded("underWriter")),
            'allowed_users' => UserResource::collection($this->whenLoaded("allowedUsers")),
            "locations" => MlceIndentLocationResource::collection($this->whenLoaded("locations")),
            "assignments" => MlceAssignmentResource::collection($this->whenLoaded("assignments")),
            "executive_summary_photos" => ExecutiveSummaryPhotoResource::collection($this->whenLoaded("executiveSummaryPhotos")),
            "report" => new MlceReportResource($this->whenLoaded("report")),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
