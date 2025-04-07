<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssigneeLocationTrackRequest extends FormRequest
{
    public function rules(): array {
        return [
            // 'mlce_assignment_id' => ['required', 'exists:mlce_assignments,id'],

            // 'status' => ['required', Rule::enum(AssigneeLocationTrackStatus::class)],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'battery_level' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
