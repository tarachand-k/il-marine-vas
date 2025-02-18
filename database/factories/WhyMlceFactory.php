<?php

namespace Database\Factories;

use App\Models\WhyMlce;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WhyMlceFactory extends Factory
{
    protected $model = WhyMlce::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
