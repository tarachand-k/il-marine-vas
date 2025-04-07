<?php

namespace Database\Factories;

use App\Models\Sop;
use App\Models\SopView;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SopViewFactory extends Factory
{
    protected $model = SopView::class;

    public function definition(): array {
        return [
            'viewed_at' => Carbon::now(),

            'sop_id' => Sop::factory(),
            'user_id' => User::factory(),
        ];
    }
}
