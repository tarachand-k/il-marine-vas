<?php

namespace Database\Factories;

use App\Enums\Quarter;
use App\Models\Marketing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MarketingFactory extends Factory
{
    protected $model = Marketing::class;

    public function definition(): array
    {
        return [
            'ref_no' => $this->faker->uuid(),
            'vas_type' => $this->faker->word(),
            'cat' => $this->faker->word(),
            'policy_no' => $this->faker->randomNumber(8),
            'policy_start_date' => $this->faker->date,
            'policy_end_date' => $this->faker->date,
            'account' => $this->faker->name(),
            'account_type' => $this->faker->word(),
            'industry' => $this->faker->word(),
            'is_mnc' => $this->faker->boolean(),
            'year' => $this->faker->year,
            'quarter' => Quarter::Q4->value,
            'month' => 'DEC',
            'sales_rm_name' => $this->faker->name(),
            'sales_band_1' => $this->faker->name(),
            'claims_manager_level_1' => $this->faker->name(),
            'claims_manager' => $this->faker->name(),
            'reporting_manager' => $this->faker->name(),
            'hub' => $this->faker->city(),
            'actual_hub' => $this->faker->city(),
            'vertical' => $this->faker->name(),
            'vertical_type' => $this->faker->randomElement(["Retail", "Corporate"]),
            'status' => $this->faker->word(),
            'expense' => $this->faker->randomNumber(5),
            'surveyor_name' => $this->faker->name(),
            'visit_date' => $this->faker->date,
            'gwp' => $this->faker->word(),
            'nic' => $this->faker->word(),
            'nep' => $this->faker->word(),
            'number_of_claims' => $this->faker->randomNumber(1),
            'lr_ytd' => $this->faker->word(),
            'pending_reason_description' => $this->faker->text(),
            'rm_name' => $this->faker->name(),
            'agent_name' => $this->faker->name(),
            'branch' => $this->faker->word(),
            'should_send_mail' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
