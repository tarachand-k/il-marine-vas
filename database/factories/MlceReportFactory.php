<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\MlceIndent;
use App\Models\MlceReport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MlceReportFactory extends Factory
{
    protected $model = MlceReport::class;

    public function definition(): array {
        return [
            'report_code' => MlceReport::generateReportCode(),
            'acknowledgment' => $this->faker->paragraphs(),
            'about_us' => $this->faker->paragraphs(),
            'marine_vas' => $this->faker->paragraphs(),
            'why_mlce' => $this->faker->paragraphs(),
            'navigation_report_manual' => $this->faker->paragraphs(),
            'findings' => $this->faker->paragraphs(),
            'observation_closure_summery' => $this->faker->paragraphs(),
            'status_of_comment' => $this->faker->paragraphs(),
            'mlce_outcome' => $this->faker->paragraphs(),
            // 'status' => $this->faker->word(),
            // 'view_count' => $this->faker->numberBetween(1, 100),
            // 'approved_at' => Carbon::now(),
            // 'published_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mlce_indent_id' => MlceIndent::factory(),
            'customer_id' => Customer::factory(),
        ];
    }
}
