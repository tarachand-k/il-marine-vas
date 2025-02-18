<?php

use App\Enums\AssigneeLocationTrackStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignee_location_tracks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_assignment_id')->constrained("mlce_assignments")
                ->cascadeOnDelete();

            $table->enum('status', array_column(AssigneeLocationTrackStatus::cases(), "value"));
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->unsignedTinyInteger('battery_level');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assignee_location_tracks');
    }
};
