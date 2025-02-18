<?php

namespace Database\Factories;

use App\Models\MlceAssignment;
use App\Models\MlceIndent;
use App\Models\MlceIndentLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MlceAssignmentFactory extends Factory
{
    protected $model = MlceAssignment::class;

    public function definition(): array {
        return [
            // 'status' => $this->faker->word(),
            'completed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mlce_indent_id' => MlceIndent::factory(),
            'mlce_indent_location_id' => MlceIndentLocation::factory(),
            'inspector_id' => User::factory(),
            'supervisor_id' => User::factory(),
        ];
    }
}
