<?php

namespace Database\Factories;

use App\Models\MlceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class MlceTypeFactory extends Factory
{
    protected $model = MlceType::class;

    public function definition(): array {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
        ];
    }
}
