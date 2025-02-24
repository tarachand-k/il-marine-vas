<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoView;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VideoViewFactory extends Factory
{
    protected $model = VideoView::class;

    public function definition(): array {
        return [
            'viewed_at' => Carbon::now(),

            'video_id' => Video::factory(),
            'user_id' => User::factory(),
        ];
    }
}
