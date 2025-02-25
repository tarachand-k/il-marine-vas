<?php

use App\Enums\MlceRecommendationClosurePriority;
use App\Enums\MlceRecommendationStatus;
use App\Enums\MlceRecommendationTimeline;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlce_recommendations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_assignment_id')->constrained("mlce_assignments")
                ->cascadeOnDelete();

            $table->string('ref_no')->nullable();
            $table->string('location');
            $table->string('sub_location')->nullable();
            $table->text('brief')->nullable();
            $table->enum('closure_priority', array_column(MlceRecommendationClosurePriority::cases(), "value"))
                ->default(MlceRecommendationClosurePriority::LOW->value);
            $table->boolean('is_capital_required')->default(false);
            $table->longText('current_observation');
            $table->longText('hazard')->nullable();
            $table->longText('recommendations');
            $table->text('client_response')->nullable();
            $table->enum('status', array_column(MlceRecommendationStatus::cases(), "value"))
                ->default(MlceRecommendationStatus::PENDING->value);
            $table->enum('timeline', array_column(MlceRecommendationTimeline::cases(), "value"))
                ->default(MlceRecommendationTimeline::DAYS_7->value);

            $table->string("photo_1", 100)->nullable();
            $table->string("photo_2", 100)->nullable();
            $table->string("photo_3", 100)->nullable();
            $table->string("photo_4", 100)->nullable();
            $table->text("photo_1_desc")->nullable();
            $table->text("photo_2_desc")->nullable();
            $table->text("photo_3_desc")->nullable();
            $table->text("photo_4_desc")->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_recommendations');
    }
};
