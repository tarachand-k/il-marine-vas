<?php

namespace App\Http\Requests;

use App\Enums\Quarter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MarketingRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'ref_no' => ['required', 'string'],
            'vas_type' => ['required', 'string'],
            'cat' => ['required', 'string'],
            'policy_no' => ['required', 'string'],
            'policy_start_date' => ['required', 'date_format:Y-m-d'],
            'policy_end_date' => ['required', 'date_format:Y-m-d'],
            'account' => ['required', 'string'],
            'account_type' => ['required', 'string'],
            'industry' => ['required', 'string'],
            'is_mnc' => ['required', 'boolean'],
            'year' => ['required', 'date_format:Y'],
            'quarter' => ['required', Rule::enum(Quarter::class)],
            'month' => ['required', 'string'],
            'sales_rm_name' => ['required', 'string'],
            'sales_band_1' => ['required', 'string'],
            'claims_manager_level_1' => ['required', 'string'],
            'claims_manager' => ['required', 'string'],
            'reporting_manager' => ['required', 'string'],
            'hub' => ['required', 'string'],
            'actual_hub' => ['required', 'string'],
            'vertical' => ['required', 'string'],
            'vertical_type' => ['required', 'string'],
            'status' => ['required', 'string'],
            'expense' => ['required', 'string'],
            'surveyor_name' => ['required', 'string'],
            'visit_date' => ['required', 'date_format:Y-m-d'],
            'gwp' => ['required', 'string'],
            'nic' => ['required', 'string'],
            'nep' => ['required', 'string'],
            'number_of_claims' => ['required', 'string'],
            'lr_ytd' => ['required', 'string'],
            'pending_reason_description' => ['required', 'string'],
            'rm_name' => ['required', 'string'],
            'agent_name' => ['required', 'string'],
            'branch' => ['required', 'string'],
            'should_send_mail' => ['sometimes', 'boolean'],
        ];

        if ($this->routeIs("marketings.update")) {
            $rules['ref_no'][0] = "sometimes";
            $rules['vas_type'][0] = "sometimes";
            $rules['cat'][0] = "sometimes";
            $rules['policy_no'][0] = "sometimes";
            $rules['policy_start_date'][0] = "sometimes";
            $rules['policy_end_date'][0] = "sometimes";
            $rules['account'][0] = "sometimes";
            $rules['account_type'][0] = "sometimes";
            $rules['industry'][0] = "sometimes";
            $rules['is_mnc'][0] = "sometimes";
            $rules['year'][0] = "sometimes";
            $rules['quarter'][0] = "sometimes";
            $rules['month'][0] = "sometimes";
            $rules['sales_rm_name'][0] = "sometimes";
            $rules['sales_band_1'][0] = "sometimes";
            $rules['claims_manager_level_1'][0] = "sometimes";
            $rules['claims_manager'][0] = "sometimes";
            $rules['reporting_manager'][0] = "sometimes";
            $rules['hub'][0] = "sometimes";
            $rules['actual_hub'][0] = "sometimes";
            $rules['vertical'][0] = "sometimes";
            $rules['vertical_type'][0] = "sometimes";
            $rules['status'][0] = "sometimes";
            $rules['expense'][0] = "sometimes";
            $rules['surveyor_name'][0] = "sometimes";
            $rules['visit_date'][0] = "sometimes";
            $rules['gwp'][0] = "sometimes";
            $rules['nic'][0] = "sometimes";
            $rules['nep'][0] = "sometimes";
            $rules['number_of_claims'][0] = "sometimes";
            $rules['lr_ytd'][0] = "sometimes";
            $rules['pending_reason_description'][0] = "sometimes";
            $rules['rm_name'][0] = "sometimes";
            $rules['agent_name'][0] = "sometimes";
            $rules['branch'][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
