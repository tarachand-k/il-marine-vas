<?php

namespace App\Http\Resources;

use App\Models\MlceReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MlceReport */
class MlceReportResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,

            'mlce_indent_id' => $this->mlce_indent_id,
            'customer_id' => $this->customer_id,

            'report_code' => $this->report_code,
            'acknowledgment' => $this->acknowledgment,
            'about_us' => $this->about_us,
            'marine_vas' => $this->marine_vas,
            'why_mlce' => $this->why_mlce,
            'navigation_report_manual' => $this->navigation_report_manual,
            'findings' => $this->findings,
            'observation_closure_summery' => $this->observation_closure_summery,
            'status_of_comment' => $this->status_of_comment,
            'mlce_outcome' => $this->mlce_outcome,
            'status' => $this->status,
            'view_count' => $this->view_count,
            'approved_at' => $this->approved_at,
            'published_at' => $this->published_at,

            // relations
            'mlce_indent' => new MlceIndentResource($this->whenLoaded('mlceIndent')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            "views" => ReportViewResource::collection($this->whenLoaded("views")),

            // timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
