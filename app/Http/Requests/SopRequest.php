<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SopRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'customer_id' => ['required', 'exists:customers,id'],
            'pdf' => ['required', 'file', "max:2048"],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d'],

            'allowed_users' => ["required", "array"],
            "allowed_users.*" => ["required", "exists:users,id"],
        ];

        if ($this->routeIs("sops.update")) {
            $rules["customer_id"][0] = "sometimes";
            $rules["pdf"] = $this->hasFile("pdf")
                ? ["nullable", "file", "max:2048"]
                : ["sometimes", "string", "max:100"];
            $rules["start_date"][0] = "sometimes";
            $rules["end_date"][0] = "sometimes";
            $rules["allowed_users"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
