<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentObservationRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'mlce_assignment_id' => ['required', 'exists:mlce_assignments,id'],
            'location' => ['required', 'string'],
            'brief' => ['nullable', 'string'],
            'type' => ['required', 'string'],
            'current_observation' => ['required', 'string'],
            'photo_1' => $this->validateFile("photo_1"),
            'photo_2' => $this->validateFile("photo_2"),
            'photo_3' => $this->validateFile("photo_3"),
            'photo_4' => $this->validateFile("photo_4"),
            "photo_1_desc" => ["nullable", "string"],
            "photo_2_desc" => ["nullable", "string"],
            "photo_3_desc" => ["nullable", "string"],
            "photo_4_desc" => ["nullable", "string"],
        ];

        if ($this->routeIs("mlce-assignments.observations.update")) {
            $rules["mlce_assignment_id"][0] = "sometimes";
            $rules["location"][0] = "sometimes";
            $rules["type"][0] = "sometimes";
        }

        return $rules;
    }

    protected function validateFile($file): array {
        return $this->hasFile($file)
            ? ["nullable", "file", "max:2048"]
            : ["nullable", "string", "max:100"];
    }

    public function authorize(): bool {
        return true;
    }
}
