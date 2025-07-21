<?php

use App\Enums\VesselAssessmentLoadType;
use App\Enums\VesselAssessmentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vessel_assessments', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('created_by_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_to_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_by_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by_id')->nullable()->constrained('users')->cascadeOnDelete();

            // Enums
            $table->enum('status', array_column(VesselAssessmentStatus::cases(), 'value'))
                ->default(VesselAssessmentStatus::INITIALIZED->value);
            $table->enum('load_type', array_column(VesselAssessmentLoadType::cases(), 'value'))
                ->default(VesselAssessmentLoadType::PARTIAL->value);

            // Basic Vessel Details (filled by customer)
            $table->string('vessel_name');
            $table->string('imo_no');
            $table->text('cargo_commodity_description');

            // Assessment Parameters (filled by assessor)
            $table->integer('age_of_vessel')->nullable();
            $table->string('vessel_type_detail')->nullable();
            $table->string('flag')->nullable();
            $table->boolean('is_iacs_class')->nullable();
            $table->string('psc_detention_last_6_months')->nullable();
            $table->text('machinery_deficiencies_remarks')->nullable();
            $table->boolean('is_sanction_compliant')->nullable();
            $table->string('has_active_insurance')->nullable();
            $table->string('vessel_approved_for_cargo')->nullable();
            $table->text('other_remarks')->nullable();
            $table->text('final_remarks')->nullable();
            $table->longText('description')->nullable();

            // Auto-generated Reference
            $table->string('ref_no')->unique();

            // Workflow Timestamps
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vessel_assessments');
    }
};
