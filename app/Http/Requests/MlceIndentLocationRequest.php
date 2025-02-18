<?php

namespace App\Http\Requests;

use App\Enums\MlceIndentLocationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MlceIndentLocationRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'mlce_indent_id' => ['required', 'exists:mlce_indents,id'],
            'location' => ['required'],
            'address' => ['nullable'],
            'spoc_name' => ['nullable'],
            'spoc_email' => ['nullable', 'email', 'max:254', Rule::unique("mlce_indent_locations")],
            'spoc_mobile_no' => ['nullable'],
            'spoc_whatsapp_no' => ['nullable'],
            'google_map_link' => ['nullable'],
            'status' => ['sometimes', Rule::enum(MlceIndentLocationStatus::class)],
        ];

        if ($this->routeIs("mlce-indent-locations.update")) {
            $mlceIndentLocationId = $this->route("mlce_indent_location");

            $rules["mlce_indent_id"][0] = "sometimes";
            $rules["location"][0] = "sometimes";
            $rules["spoc_email"][3] = Rule::unique("mlce_indent_locations", "spoc_email")
                ->ignore($mlceIndentLocationId);
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
