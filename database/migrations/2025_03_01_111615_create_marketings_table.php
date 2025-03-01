<?php

use App\Enums\Quarter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('marketings', function (Blueprint $table) {
            $table->id();

            $table->string('ref_no');
            $table->string('vas_type');
            $table->string('cat');
            $table->string('policy_no');
            $table->date('policy_start_date');
            $table->date('policy_end_date');
            $table->string('account');
            $table->string('account_type');
            $table->string('industry');
            $table->boolean('is_mnc')->default(false);
            $table->year('year');
            $table->enum('quarter', array_column(Quarter::cases(), "value"))
                ->default(Quarter::Q1->value);
            $table->string('month', 10);
            $table->string('sales_rm_name');
            $table->string('sales_band_1');
            $table->string('claims_manager_level_1');
            $table->string('claims_manager');
            $table->string('reporting_manager');
            $table->string('hub');
            $table->string('actual_hub');
            $table->string('vertical');
            $table->string('vertical_type');
            $table->string('status');
            $table->string('expense');
            $table->string('surveyor_name');
            $table->date('visit_date');
            $table->string('gwp');
            $table->string('nic');
            $table->string('nep');
            $table->string('number_of_claims');
            $table->string('lr_ytd');
            $table->text('pending_reason_description');
            $table->string('rm_name');
            $table->string('agent_name');
            $table->string('branch');
            $table->boolean('should_send_mail')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('marketings');
    }
};
