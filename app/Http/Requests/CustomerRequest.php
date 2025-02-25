<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', "email", Rule::unique("customers")],
            'mobile_no' => ['required', 'string', 'max:20'],
            'policy_no' => ['required', 'string', "max:40"],
            'policy_type' => ['required', 'string'],
            'coverage_from' => ['required', 'date'],
            'coverage_to' => ['required', 'date'],
            'address' => ['nullable', 'string'],
            'about' => ['nullable', 'array'],
            'coverage_terms' => ['nullable', 'array'],
            'cargo_details' => ['nullable', 'array'],
            'transit_details' => ['nullable', 'array'],
        ];

        if ($this->routeIs("customers.update")) {
            $customerId = $this->route("customer");

            $rules["name"][0] = "sometimes";
            $rules["email"][0] = "sometimes";
            $rules["email"][2] = Rule::unique("customers")->ignore($customerId);
            $rules["mobile_no"][0] = "sometimes";
            $rules["policy_no"][0] = "sometimes";
            $rules["policy_type"][0] = "sometimes";
            $rules["coverage_from"][0] = "sometimes";
            $rules["coverage_to"][0] = "sometimes";
        }


        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
