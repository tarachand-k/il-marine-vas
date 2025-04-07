<?php

namespace Database\Factories;

use App\Models\Disclaimer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DisclaimerFactory extends Factory
{
    protected $model = Disclaimer::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->paragraphs(asText: true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
