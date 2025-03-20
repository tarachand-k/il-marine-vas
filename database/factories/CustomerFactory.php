<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'mobile_no' => $this->faker->phoneNumber(),
            'policy_no' => $this->faker->password,
            'policy_type' => $this->faker->word,
            'policy_start_date' => $this->faker->date(),
            'policy_end_date' => $this->faker->date(),
            'about' => $this->faker->paragraph(),
            'coverage_terms' => $this->faker->paragraph(),
            'cargo_details' => $this->faker->paragraph(),
            'transit_details' => $this->faker->paragraph(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
