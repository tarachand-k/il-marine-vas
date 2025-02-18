<?php

namespace App\Http\Requests;

use App\Enums\MlceReportStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MlceReportRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'mlce_indent_id' => ['required', 'exists:mlce_indents,id'],
            'mlce_assignment_id' => ['required', 'exists:mlce_assignments,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'acknowledgment' => ['required', 'string'],
            'about_us' => ['required', 'string'],
            'marine_vas' => ['required', 'string'],
            'navigation_report_manual' => ['required', 'string'],
            'findings' => ['required', 'string'],
            'observation_closure_summery' => ['required', 'string'],
            'status_of_comment' => ['required', 'string'],
            'mlce_outcome' => ['required', 'string'],
            'status' => ['sometimes', Rule::enum(MlceReportStatus::class)],
        ];

        if ($this->routeIs("mlce-reports.update")) {
            $rules["mlce_indent_id"][0] = "sometimes";
            $rules["mlce_assignment_id"][0] = "sometimes";
            $rules["acknowledgment"][0] = "sometimes";
            $rules["about_us"][0] = "sometimes";
            $rules["marine_vas"][0] = "sometimes";
            $rules["navigation_report_manual"][0] = "sometimes";
            $rules["findings"][0] = "sometimes";
            $rules["observation_closure_summery"][0] = "sometimes";
            $rules["status_of_comment"][0] = "sometimes";
            $rules["mlce_outcome"][0] = "sometimes";
            $rules["customer_id"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
