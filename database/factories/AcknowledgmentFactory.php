<?php

namespace Database\Factories;

use App\Models\Acknowledgment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcknowledgmentFactory extends Factory
{
    protected $model = Acknowledgment::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->word()
        ];
    }
}
