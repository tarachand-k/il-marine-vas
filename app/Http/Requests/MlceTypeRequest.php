<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MlceTypeRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ];

        if ($this->routeIs("mlce-types.update")) {
            $rules["name"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
