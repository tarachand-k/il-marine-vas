<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\MlceIndent;
use App\Models\MlceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MlceIndentFactory extends Factory
{
    protected $model = MlceIndent::class;

    public function definition(): array {
        return [
            'indent_code' => MlceIndent::generateIndentCode(),
            'pdr_observation' => $this->faker->word(),
            'job_scope' => $this->faker->word(),
            'why_mlce' => $this->faker->paragraph(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'created_by_id' => User::factory(),
            'customer_id' => Customer::factory(),
            'mlce_type_id' => MlceType::factory(),
        ];
    }
}
