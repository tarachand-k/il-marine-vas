<?php

namespace App\Http\Requests;

use App\Enums\AccountType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'rm_id' => ['nullable', 'exists:users,id'],
            'under_writer_id' => ['required', 'exists:users,id'],
            'channel_partner_id' => ['required', 'exists:users,id'],

            'name' => ['required', 'string'],
            'email' => ['nullable', "email", Rule::unique("customers")],
            'mobile_no' => ['nullable', 'string', 'max:20', Rule::unique('customers')],
            'policy_no' => ['required', 'string'],
            'policy_type' => ['nullable', 'string'],
            'policy_start_date' => ['nullable', 'date_format:Y-m-d'],
            'policy_end_date' => ['nullable', 'date_format:Y-m-d'],
            "account_type" => ["required", Rule::enum(AccountType::class)],
            "business_team_mo_name" => ['required', 'string'],
            'address' => ['nullable', 'string', 'max:600'],
            'about' => ['nullable', 'string'],
            'coverage_terms' => ['nullable', 'string'],
            'cargo_details' => ['nullable', 'string'],
            'transit_details' => ['nullable', 'string'],
        ];

        if ($this->routeIs("customers.update")) {
            $customerId = $this->route("customer");

            $rules['under_writer_id'][0] = "sometimes";
            $rules['channel_partner_id'][0] = "sometimes";
            $rules['name'][0] = "sometimes";
            $rules["email"][2] = Rule::unique("customers")->ignore($customerId);
            $rules["mobile_no"][3] = Rule::unique("customers")->ignore($customerId);
            $rules['policy_no'][0] = "sometimes";
            $rules["account_type"][0] = "sometimes";
            $rules["business_team_mo_name"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
