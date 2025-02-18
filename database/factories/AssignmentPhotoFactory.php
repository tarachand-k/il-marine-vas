<?php

namespace Database\Factories;

use App\Models\AssignmentPhoto;
use App\Models\MlceAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentPhotoFactory extends Factory
{
    protected $model = AssignmentPhoto::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'photo' => $this->faker->word(),

            'mlce_assignment_id' => MlceAssignment::factory(),
        ];
    }
}
