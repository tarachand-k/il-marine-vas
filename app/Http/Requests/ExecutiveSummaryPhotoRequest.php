<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecutiveSummaryPhotoRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'description' => ['required', 'string'],
            'photo' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:10240'],
        ];

        if ($this->routeIs("mlce-indents.executive-summary-photos.update")) {
            $rules["description"][0] = "sometimes";
            $rules["photo"][0] = $this->hasFile("photo")
                ? ["nullable", "image", "mimes:jpeg,png,jpg", "max:10240"]
                : ["sometimes", "string", "max:255"];
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
