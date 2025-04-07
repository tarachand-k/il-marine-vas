<?php

namespace Database\Factories;

use App\Enums\CapitalInvolvement;
use App\Models\MlceAssignment;
use App\Models\MlceRecommendation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MlceRecommendationFactory extends Factory
{
    protected $model = MlceRecommendation::class;

    public function definition(): array {
        return [
            'sub_location' => $this->faker->streetName(),
            'brief' => $this->faker->word(),
            // 'closure_priority' => $this->faker->word(),
            'capital_involvement' => $this->faker->randomElement(array_column(CapitalInvolvement::cases(), "value")),
            'current_observation' => $this->faker->paragraph(1),
            'hazard' => $this->faker->paragraph(1),
            'recommendations' => $this->faker->paragraph(1),
            'client_response' => $this->faker->word(),
            // 'status' => $this->faker->word(),
            // 'timeline' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mlce_assignment_id' => MlceAssignment::factory(),
        ];
    }
}
