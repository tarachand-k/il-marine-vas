<?php

namespace App\Http\Resources;

use App\Models\ReportView;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ReportView */
class ReportViewResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'mlce_report_id' => $this->mlce_report_id,
            'user_id' => $this->user_id,

            'page_name' => $this->page_name,
            'viewed_at' => $this->viewed_at,
            'device_info' => $this->device_info,
            'ip_address' => $this->ip_address,

            // 'mlceReport' => new MlceReportResource($this->whenLoaded('mlceReport')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
