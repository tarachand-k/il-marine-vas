<?php

namespace Database\Factories;

use App\Models\AssigneeLocationTrack;
use App\Models\MlceAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AssigneeLocationTrackFactory extends Factory
{
    protected $model = AssigneeLocationTrack::class;

    public function definition(): array {
        return [
            // 'status' => $this->faker->randomElement(array_column(AssigneeLocationTrackStatus::cases(), "value")),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'battery_level' => $this->faker->numberBetween(0, 100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mlce_assignment_id' => MlceAssignment::factory(),
        ];
    }
}
