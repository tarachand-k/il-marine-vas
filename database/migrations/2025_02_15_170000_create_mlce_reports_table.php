<?php

use App\Enums\MlceReportStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlce_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_indent_id')->constrained("mlce_indents")->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained("customers")->cascadeOnDelete();
            $table->foreignId("approved_by_id")->nullable()->constrained("users")->nullOnDelete();

            $table->string("report_code", 50);
            $table->longText('acknowledgment')->nullable();
            $table->longText('about_us')->nullable();
            $table->longText('marine_vas')->nullable();
            $table->longText("why_mlce")->nullable();
            $table->longText('navigation_report_manual')->nullable();
            $table->longText('findings')->nullable();
            $table->longText('observation_closure_summery')->nullable();
            $table->longText('disclaimer')->nullable();
            $table->longText('mlce_outcome')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->enum('status', array_column(MlceReportStatus::cases(), "value"))
                ->default(MlceReportStatus::PENDING->value);

            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_reports');
    }
};
