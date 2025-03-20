<?php

namespace Database\Factories;

use App\Models\MlceIndent;
use Illuminate\Database\Eloquent\Factories\Factory;

class MlceIndentFactory extends Factory
{
    protected $model = MlceIndent::class;

    public function definition(): array {
        return [
            'ref_no' => MlceIndent::generateRefNo(),
            'pdr_observation' => $this->faker->word(),
            'job_scope' => $this->faker->paragraphs(),
            'policy_no' => $this->faker->word,
            'policy_type' => $this->faker->word,
            'policy_start_date' => $this->faker->date,
            'policy_end_date' => $this->faker->date,
            'hub' => $this->faker->word,
            'gwp' => $this->faker->word,
            'nic' => $this->faker->word,
            'nep' => $this->faker->word,
            'lr_percentage' => $this->faker->word,
            'vertical_name' => $this->faker->word,
            'insured_commodity' => $this->faker->word,
            'industry' => $this->faker->word,
        ];
    }
}
