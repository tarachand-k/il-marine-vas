<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VesselAssessmentParameterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'age_of_vessel' => ['nullable', 'integer', 'min:0'],
            'vessel_type_detail' => ['nullable', 'string', 'max:255'],
            'flag' => ['nullable', 'string', 'max:255'],
            'is_iacs_class' => ['nullable', 'boolean'],
            'psc_detention_last_6_months' => ['nullable', 'string', 'max:255'],
            'machinery_deficiencies_remarks' => ['nullable', 'string'],
            'is_sanction_compliant' => ['nullable', 'boolean'],
            'has_active_insurance' => ['nullable', 'string', 'max:255'],
            'vessel_approved_for_cargo' => ['nullable', 'string', 'max:255'],
            'other_remarks' => ['nullable', 'string'],
            'final_remarks' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
