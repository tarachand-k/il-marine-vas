<?php

namespace Database\Factories;

use App\Enums\MlceIndentLocationStatus;
use App\Models\MlceIndent;
use App\Models\MlceIndentLocation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MlceIndentLocationFactory extends Factory
{
    protected $model = MlceIndentLocation::class;

    public function definition(): array {
        return [
            'location' => $this->faker->word(),
            'address' => $this->faker->address(),
            'spoc_name' => $this->faker->name(),
            'spoc_email' => $this->faker->unique()->safeEmail(),
            'spoc_mobile_no' => $this->faker->phoneNumber(),
            'google_map_link' => $this->faker->url(),
            'status' => $this->faker->randomElement(array_column(MlceIndentLocationStatus::cases(), "value")),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mlce_indent_id' => MlceIndent::factory(),
        ];
    }
}
