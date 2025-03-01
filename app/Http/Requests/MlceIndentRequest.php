<?php

namespace App\Http\Requests;

use App\Enums\MlceIndentLocationStatus;
use App\Enums\MlceIndentUserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MlceIndentRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'created_by_id' => ['required', 'exists:users,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'mlce_type_id' => ['required', 'exists:mlce_types,id'],
            'insured_representative_id' => ['required', 'exists:users,id'],
            'rm_id' => ['required', 'exists:users,id'],
            'vertical_rm_id' => ['required', 'exists:users,id'],
            'under_writer_id' => ['required', 'exists:users,id'],

            'ref_no' => ['required', 'string'],
            'policy_no' => ['required', 'string'],
            'policy_type' => ['required', 'string'],
            'policy_start_date' => ['required', 'date_format:Y-m-d'],
            'policy_end_date' => ['required', 'date_format:Y-m-d'],
            'hub' => ['nullable', 'string'],
            'gwp' => ['nullable', 'string'],
            'nic' => ['nullable', 'string'],
            'nep' => ['nullable', 'string'],
            'lr_percentage' => ['nullable', 'string'],
            'vertical_name' => ['nullable', 'string'],
            'insured_commodity' => ['nullable', 'string'],
            'industry' => ['nullable', 'string'],
            'pdr_observation' => ['nullable', ...$this->validateFile("pdr_observation")],
            'job_scope' => ['nullable', "string"],

            'users' => ["nullable", 'array'],
            "users.*.id" => ["sometimes", 'exists:mlce_indent_user,id'],
            "users.*.user_id" => ["nullable", "exists:users,id"],
            "users.*.type" => ["required", Rule::enum(MlceIndentUserType::class)],

            // Guest-specific validation
            "users.*.name" => ["nullable", "required_if:users.*.type,Guest", "string"],
            "users.*.email" => ["nullable", "required_if:users.*.type,Guest", "email", Rule::unique("users", "email")],
            "users.*.mobile_no" => ["nullable", "required_if:users.*.type,Guest", "string", "max:20"],

            "locations" => ["required", "array", "min:1"],
            "locations.*.id" => ["nullable", "exists:mlce_indent_locations,id"],
            'locations.*.mlce_visit_date' => ['required', 'date_format:Y-m-d'],
            'locations.*.cargo_risk_assessment_at' => ['required', 'string'],
            'locations.*.location' => ['required', 'string'],
            'locations.*.address' => ['nullable'],
            'locations.*.spoc_name' => ['nullable'],
            'locations.*.spoc_email' => ['nullable', 'email', 'max:254', Rule::unique("mlce_indent_locations")],
            'locations.*.spoc_mobile_no' => ['nullable'],
            'locations.*.spoc_whatsapp_no' => ['nullable'],
            'locations.*.google_map_link' => ['nullable'],
            'locations.*.status' => ['sometimes', Rule::enum(MlceIndentLocationStatus::class)],
        ];

        if ($this->routeIs("mlce-indents.update")) {
            $rules["created_by_id"][0] = "sometimes";
            $rules["customer_id"][0] = "sometimes";
            $rules["mlce_type_id"][0] = "sometimes";
            $rules["insured_representative_id"][0] = "sometimes";
            $rules["rm_id"][0] = "sometimes";
            $rules["vertical_rm_id"][0] = "sometimes";
            $rules["under_writer_id"][0] = "sometimes";

            $rules["ref_no"][0] = "sometimes";
            $rules["policy_no"][0] = "sometimes";
            $rules["policy_type"][0] = "sometimes";
            $rules["policy_start_date"][0] = "sometimes";
            $rules["policy_end_date"][0] = "sometimes";

            $rules["users.*.user_id"][0] = "sometimes";
            $rules["locations"] = ["sometimes", "array"];
            $rules["locations.*.location"][0] = "sometimes";
            $rules["locations.*.spoc_email"][3] = "";
        }

        return $rules;
    }

    public function validateFile(string $fileName): array {
        return $this->hasFile($fileName)
            ? ["file", "max:2048"]
            : ["string", "max:100"];
    }

    public function authorize(): bool {
        return true;
    }
}
