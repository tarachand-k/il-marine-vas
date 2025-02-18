<?php

namespace Database\Factories;

use App\Models\AboutUs;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AboutUsFactory extends Factory
{
    protected $model = AboutUs::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->word(),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
