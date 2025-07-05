<?php

namespace Database\Factories;

use App\Models\MlceSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MlceScheduleFactory extends Factory
{
    protected $model = MlceSchedule::class;

    public function definition(): array {
        return [
            'date' => Carbon::now()
        ];
    }
}
