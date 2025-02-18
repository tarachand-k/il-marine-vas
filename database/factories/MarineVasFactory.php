<?php

namespace Database\Factories;

use App\Models\MarineVas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MarineVasFactory extends Factory
{
    protected $model = MarineVas::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
