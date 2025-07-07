<?php

namespace App\Http\Resources;

use App\Models\MlceReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceReport */
class MlceReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'mlce_indent_id' => $this->mlce_indent_id,
            'customer_id' => $this->customer_id,
            'submitted_by_id' => $this->submitted_by_id,
            'approved_by_id' => $this->approved_by_id,

            'report_code' => $this->report_code,
            'acknowledgment' => $this->acknowledgment,
            'about_us' => $this->about_us,
            'marine_vas' => $this->marine_vas,
            'why_mlce' => $this->why_mlce,
            'navigation_report_manual' => $this->navigation_report_manual,
            'findings' => $this->findings,
            'observation_closure_summery' => $this->observation_closure_summery,
            'disclaimer' => $this->disclaimer,
            'mlce_outcome' => $this->mlce_outcome,
            'executive_summary' => $this->executive_summary,
            'status' => $this->status,
            'view_count' => $this->view_count,
            'submitted_at' => $this->submitted_at,
            'approved_at' => $this->approved_at,
            'published_at' => $this->published_at,

            // relations
            'mlce_indent' => new MlceIndentResource($this->whenLoaded('mlceIndent')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            "submitted_by" => new UserResource($this->whenLoaded("submittedBy")),
            "approved_by" => new UserResource($this->whenLoaded("approvedBy")),
            "views" => ReportViewResource::collection($this->whenLoaded("views")),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
