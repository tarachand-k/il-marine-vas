<?php

namespace Database\Factories;

use App\Models\AssignmentObservation;
use App\Models\MlceAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AssignmentObservationFactory extends Factory
{
    protected $model = AssignmentObservation::class;

    public function definition(): array {
        return [
            'ref_no' => $this->faker->password(8, 8),
            'location' => $this->faker->word(),
            'sub_location' => $this->faker->word(),
            'brief' => $this->faker->word(),
            'type' => $this->faker->word(),
            'current_observation' => $this->faker->paragraph(1),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mlce_assignment_id' => MlceAssignment::factory(),
        ];
    }
}
