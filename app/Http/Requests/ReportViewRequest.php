<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportViewRequest extends FormRequest
{
    public function rules(): array {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'page_name' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
