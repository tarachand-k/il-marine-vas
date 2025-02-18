<?php

namespace Database\Factories;

use App\Models\MlceIndent;
use App\Models\MlceIndentUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MlceIndentUserFactory extends Factory
{
    protected $model = MlceIndentUser::class;

    public function definition(): array {
        return [
            'type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mlce_indent_id' => MlceIndent::factory(),
            'user_id' => User::factory(),
        ];
    }
}
