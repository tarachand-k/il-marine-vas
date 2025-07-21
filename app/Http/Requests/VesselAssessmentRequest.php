<?php

namespace App\Http\Requests;

use App\Enums\VesselAssessmentLoadType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VesselAssessmentRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'customer_id' => ['required', 'exists:customers,id'],
            'vessel_name' => ['required', 'string', 'max:255'],
            'imo_no' => ['required', 'string', 'max:255'],
            'cargo_commodity_description' => ['required', 'string'],
            'load_type' => ['required', 'string', Rule::enum(VesselAssessmentLoadType::class)],
        ];

        if ($this->routeIs('vessel-assessments.update')) {
            $rules['customer_id'][0] = 'sometimes';
            $rules['vessel_name'][0] = 'sometimes';
            $rules['imo_no'][0] = 'sometimes';
            $rules['cargo_commodity_description'][0] = 'sometimes';
            $rules['load_type'][0] = 'sometimes';
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
