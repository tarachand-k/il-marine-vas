<?php

use App\Enums\MlceAssignmentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlce_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_indent_id')->constrained("mlce_indents")
                ->cascadeOnDelete();
            $table->foreignId('mlce_indent_location_id')->constrained("mlce_indent_locations")
                ->cascadeOnDelete();
            $table->foreignId('inspector_id')->constrained("users")
                ->cascadeOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained("users")
                ->nullOnDelete();

            $table->enum('status', array_column(MlceAssignmentStatus::cases(), "value"))
                ->default(MlceAssignmentStatus::ASSIGNED->value);
            $table->dateTime('completed_at')->nullable();

            $table->mediumText("observation_description")->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_assignments');
    }
};
