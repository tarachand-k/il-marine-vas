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
            'mobile_no' => ['required', 'string', 'max:20', Rule::unique('customers')],

            'transit_coverage_from' => ['required', 'string'],
            'transit_coverage_to' => ['required', 'string'],
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
            $rules["mobile_no"][3] = Rule::unique("customers")->ignore($customerId);
            $rules["transit_coverage_from"][0] = "sometimes";
            $rules["transit_coverage_to"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
