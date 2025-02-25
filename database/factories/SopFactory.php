<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Sop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SopFactory extends Factory
{
    protected $model = Sop::class;

    public function definition(): array {
        return [
            'pdf' => $this->faker->word(),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'customer_id' => Customer::factory(),
        ];
    }
}
