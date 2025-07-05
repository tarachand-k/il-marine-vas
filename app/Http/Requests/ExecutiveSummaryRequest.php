<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecutiveSummaryRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'sting'],
            'content' => ['required', 'sting'],
        ];

        if ($this->routeIs('executive-summaries.update')) {
            $rules['title'][0] = 'sometimes';
            $rules['content'][0] = 'sometimes';
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
