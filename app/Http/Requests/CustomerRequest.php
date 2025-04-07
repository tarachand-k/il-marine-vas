<?php

namespace App\Http\Requests;

use App\Enums\AccountType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'rm_id' => ['required', 'exists:users,id'],
            'under_writer_id' => ['required', 'exists:users,id'],
            'channel_partner_id' => ['required', 'exists:users,id'],

            'name' => ['required', 'string'],
            'email' => ['required', "email", Rule::unique("customers")],
            'mobile_no' => ['required', 'string', 'max:20', Rule::unique('customers')],
            'policy_no' => ['required', 'string'],
            'policy_type' => ['required', 'string'],
            'policy_start_date' => ['required', 'date_format:Y-m-d'],
            'policy_end_date' => ['required', 'date_format:Y-m-d'],
            "account_type" => ["required", Rule::enum(AccountType::class)],
            'address' => ['nullable', 'string', 'max:600'],
            'about' => ['nullable', 'string'],
            'coverage_terms' => ['nullable', 'string'],
            'cargo_details' => ['nullable', 'string'],
            'transit_details' => ['nullable', 'string'],
        ];

        if ($this->routeIs("customers.update")) {
            $customerId = $this->route("customer");

            $rules['rm_id'][0] = "sometimes";
            $rules['under_writer_id'][0] = "sometimes";
            $rules['channel_partner_id'][0] = "sometimes";
            $rules["name"][0] = "sometimes";
            $rules["email"][0] = "sometimes";
            $rules["email"][2] = Rule::unique("customers")->ignore($customerId);
            $rules["mobile_no"][0] = "sometimes";
            $rules["mobile_no"][3] = Rule::unique("customers")->ignore($customerId);
            $rules['policy_no'][0] = "sometimes";
            $rules['policy_type'][0] = "sometimes";
            $rules['policy_start_date'][0] = "sometimes";
            $rules['policy_end_date'][0] = "sometimes";
            $rules["account_type"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
