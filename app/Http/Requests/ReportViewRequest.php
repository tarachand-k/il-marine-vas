<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportViewRequest extends FormRequest
{
    public function rules(): array {
        return [
            'mlce_report_id' => ['sometimes', 'exists:mlce_reports,id'],
            'user_id' => ['required', 'exists:users,id'],
            'page_name' => ['nullable', 'string'],
            'device_info' => ['nullable', 'string'],
            'ip_address' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
