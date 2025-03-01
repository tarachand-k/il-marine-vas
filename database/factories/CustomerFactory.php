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
            'transit_coverage_from' => $this->faker->words(asText: true),
            'transit_coverage_to' => $this->faker->words(asText: true),
            'about' => $this->faker->paragraphs(),
            'coverage_terms' => $this->faker->paragraphs(),
            'cargo_details' => $this->faker->paragraphs(),
            'transit_details' => $this->faker->paragraphs(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
