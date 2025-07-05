<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MlceScheduleRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'user_id' => ['required', 'exists:users,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'date' => ['required', 'date_format:Y-m-d'],
        ];

        if ($this->routeIs("mlce-schedules.update")) {
            $rules["user_id"][0] = "sometimes";
            $rules["customer_id"][0] = "sometimes";
            $rules["date"][0] = "sometimes";
        }

        return $rules;
    }

    public function authorize(): bool {
        return true;
    }
}
