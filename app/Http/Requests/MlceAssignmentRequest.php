<?php

namespace App\Http\Requests;

use App\Enums\MlceAssignmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MlceAssignmentRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'mlce_indent_id' => ['required', 'exists:mlce_indents,id'],
            'mlce_indent_location_id' => ['required', 'exists:mlce_indent_locations,id'],
            'inspector_id' => ['required', 'exists:users,id'],
            'supervisor_id' => ['nullable', 'exists:users,id'],

            'status' => ['sometimes', Rule::enum(MlceAssignmentStatus::class)],
        ];

        if ($this->routeIs("mlce-assignments.update")) {
            $rules["mlce_indent_id"][0] = "sometimes";
            $rules["mlce_indent_location_id"][0] = "sometimes";
            $rules["inspector_id"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
