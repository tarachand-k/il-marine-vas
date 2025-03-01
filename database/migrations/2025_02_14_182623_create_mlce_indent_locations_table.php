<?php

use App\Enums\MlceIndentLocationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlce_indent_locations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_indent_id')->constrained("mlce_indents")
                ->cascadeOnDelete();

            $table->date('mlce_visit_date');
            $table->string('cargo_risk_assessment_at');
            $table->string('location');
            $table->text('address')->nullable();
            $table->string('spoc_name')->nullable();
            $table->string('spoc_email')->nullable()->unique();
            $table->string('spoc_mobile_no', 20)->nullable();
            $table->string('spoc_whatsapp_no', 20)->nullable();
            $table->string('google_map_link')->nullable();
            $table->enum('status', array_column(MlceIndentLocationStatus::cases(), "value"))
                ->default(MlceIndentLocationStatus::NOT_ASSIGNED->value);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_indent_locations');
    }
};
