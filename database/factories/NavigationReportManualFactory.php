<?php

namespace Database\Factories;

use App\Models\NavigationReportManual;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NavigationReportManualFactory extends Factory
{
    protected $model = NavigationReportManual::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
