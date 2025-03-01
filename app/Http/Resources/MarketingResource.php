<?php

namespace App\Http\Resources;

use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Marketing */
class MarketingResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'ref_no' => $this->ref_no,
            'vas_type' => $this->vas_type,
            'cat' => $this->cat,
            'policy_no' => $this->policy_no,
            'policy_start_date' => $this->policy_start_date,
            'policy_end_date' => $this->policy_end_date,
            'account' => $this->account,
            'account_type' => $this->account_type,
            'industry' => $this->industry,
            'is_mnc' => $this->is_mnc,
            'year' => $this->year,
            'quarter' => $this->quarter,
            'month' => $this->month,
            'sales_rm_name' => $this->sales_rm_name,
            'sales_band_1' => $this->sales_band_1,
            'claims_manager_level_1' => $this->claims_manager_level_1,
            'claims_manager' => $this->claims_manager,
            'reporting_manager' => $this->reporting_manager,
            'hub' => $this->hub,
            'actual_hub' => $this->actual_hub,
            'vertical' => $this->vertical,
            'vertical_type' => $this->vertical_type,
            'status' => $this->status,
            'expense' => $this->expense,
            'surveyor_name' => $this->surveyor_name,
            'visit_date' => $this->visit_date,
            'gwp' => $this->gwp,
            'nic' => $this->nic,
            'nep' => $this->nep,
            'number_of_claims' => $this->number_of_claims,
            'lr_ytd' => $this->lr_ytd,
            'pending_reason_description' => $this->pending_reason_description,
            'rm_name' => $this->rm_name,
            'agent_name' => $this->agent_name,
            'branch' => $this->branch,
            'should_send_mail' => $this->should_send_mail,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
