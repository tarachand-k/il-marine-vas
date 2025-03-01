<?php

namespace Database\Factories;

use App\Models\Presentation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PresentationFactory extends Factory
{
    protected $model = Presentation::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'presentation' => $this->faker->word(),
            'view_count' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'uploaded_by_id' => User::factory(),
        ];
    }
}
