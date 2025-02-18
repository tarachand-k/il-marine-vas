<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\MlceAssignment;
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
            'acknowledgment' => $this->faker->paragraph(1),
            'about_us' => $this->faker->paragraph(1),
            'marine_vas' => $this->faker->paragraph(1),
            'navigation_report_manual' => $this->faker->paragraph(1),
            'findings' => $this->faker->paragraph(1),
            'observation_closure_summery' => $this->faker->paragraph(1),
            'status_of_comment' => $this->faker->paragraph(1),
            'mlce_outcome' => $this->faker->paragraph(1),
            // 'status' => $this->faker->word(),
            // 'view_count' => $this->faker->numberBetween(1, 100),
            // 'approved_at' => Carbon::now(),
            // 'published_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'mlce_indent_id' => MlceIndent::factory(),
            'mlce_assignment_id' => MlceAssignment::factory(),
            'customer_id' => Customer::factory(),
        ];
    }
}
