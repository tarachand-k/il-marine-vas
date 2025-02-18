<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhyMlceRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ];

        if ($this->routeIs("acknowledgements.update")) {
            $rules['title'][0] = "sometimes";
            $rules['content'][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
