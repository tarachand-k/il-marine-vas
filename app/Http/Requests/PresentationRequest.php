<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresentationRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'uploaded_by_id' => ['required', 'exists:users,id'],

            'title' => ['required', 'string'],
            'description' => ['nullable'],
            'presentation' => ['required', 'file'],

            'allowed_users' => ["required", "array", "min:1"],
            "allowed_users.*" => ["required", "exists:users,id"],
        ];

        if ($this->routeIs("presentations.update")) {
            $rules["uploaded_by_id"][0] = "sometimes";
            $rules["title"][0] = "sometimes";
            $rules["presentation"] = $this->hasFile("presentation")
                ? ["nullable", "file"]
                : ["nullable", "string", "max:100"];
            $rules["users"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
