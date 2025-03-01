<?php

namespace Database\Factories;

use App\Models\Presentation;
use App\Models\PresentationView;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PresentationViewFactory extends Factory
{
    protected $model = PresentationView::class;

    public function definition(): array {
        return [
            'viewed_at' => Carbon::now(),

            'presentation_id' => Presentation::factory(),
            'user_id' => User::factory(),
        ];
    }
}
