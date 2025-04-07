<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MlceReportRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'mlce_indent_id' => ['required', 'exists:mlce_indents,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'acknowledgment' => ['nullable', 'array'],
            'about_us' => ['nullable', 'array'],
            'marine_vas' => ['nullable', 'array'],
            'why_mlce' => ['nullable', 'array'],
            'navigation_report_manual' => ['nullable', 'array'],
            'findings' => ['nullable', 'array'],
            'observation_closure_summery' => ['nullable', 'array'],
            'disclaimer' => ['nullable', 'array'],
            'mlce_outcome' => ['nullable', 'array'],
        ];

        if ($this->routeIs("mlce-reports.update")) {
            $rules["mlce_indent_id"][0] = "sometimes";
            $rules["customer_id"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
