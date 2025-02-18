<?php

namespace App\Http\Requests;

use App\Enums\MlceIndentUserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MlceIndentUserRequest extends FormRequest
{
    public function rules(): array {
        return [
            'mlce_indent_id' => ['required', 'exists:mlce_indents,id'],
            'user_id' => ['required', 'exists:users,id'],

            'type' => ['required', Rule::enum(MlceIndentUserType::class)],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
