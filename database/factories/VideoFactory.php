<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'video' => $this->faker->word(),
            'view_count' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'uploaded_by_id' => User::factory(),
        ];
    }
}
