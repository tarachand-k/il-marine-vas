<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VesselAssessmentAssignRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'assigned_to_id' => [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', UserRole::MARINE_EXT_TEAM_MEMBER->value);
                }),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'assigned_to_id.exists' => 'The selected user must be a Marine EXT Team member.',
        ];
    }
}