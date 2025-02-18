<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentPhotoRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'mlce_assignment_id' => ['required', 'exists:mlce_assignments,id'],

            'title' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            "photo" => ["required", 'file', "max:2048"],
        ];

        if ($this->routeIs()) {
            $rules["mlce_assignment_id"][0] = "sometimes";
            $rules["description"][0] = "sometimes";
            $rules["photo"] = $this->hasFile("photo")
                ? ["file", "max:2048"]
                : ["nullable", "string", "100"];
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
