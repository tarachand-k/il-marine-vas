<?php

namespace App\Http\Requests;

use App\Enums\MlceRecommendationClosurePriority;
use App\Enums\MlceRecommendationStatus;
use App\Enums\MlceRecommendationTimeline;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MlceRecommendationRequest extends FormRequest
{
    public function rules(): array {
        $rules = [
            'mlce_assignment_id' => ['required', 'exists:mlce_assignments,id'],

            'ref_no' => ['required', 'string'],
            'location' => ['required', 'string'],
            'sub_location' => ['nullable', 'string'],
            'brief' => ['nullable', 'string'],
            'closure_priority' => ['required', Rule::enum(MlceRecommendationClosurePriority::class)],
            'is_capital_required' => ['boolean'],
            'current_observation' => ['required', 'string'],
            'hazard' => ['nullable', 'string'],
            'recommendations' => ['required', 'string'],
            'client_response' => ['nullable', 'string'],
            'status' => ['sometimes', Rule::enum(MlceRecommendationStatus::class)],
            'timeline' => ['required', Rule::enum(MlceRecommendationTimeline::class)],
            'photo_1' => $this->validateFile("photo_1"),
            'photo_2' => $this->validateFile("photo_2"),
            'photo_3' => $this->validateFile("photo_3"),
            'photo_4' => $this->validateFile("photo_4"),
            "photo_1_desc" => ["nullable", "string"],
            "photo_2_desc" => ["nullable", "string"],
            "photo_3_desc" => ["nullable", "string"],
            "photo_4_desc" => ["nullable", "string"],
        ];

        if ($this->routeIs("mlce-recommendations.update")) {
            $rules["mlce_assignment_id"][0] = "sometimes";

            $rules["ref_no"][0] = "sometimes";
            $rules["location"][0] = "sometimes";
            $rules["closure_priority"][0] = "sometimes";
            $rules["current_observation"][0] = "sometimes";
            $rules["recommendations"][0] = "sometimes";
            $rules["timeline"][0] = "sometimes";
        }

        return $rules;
    }

    protected function validateFile($file): array {
        return $this->hasFile($file)
            ? ["nullable", "file", "max:2048"]
            : ["nullable", "string", "max:100"];
    }

    public function authorize(): bool {
        return true;
    }
}
