<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignment_observations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_assignment_id')->constrained("mlce_assignments")
                ->cascadeOnDelete();

            $table->string('ref_no')->nullable();
            $table->string('location');
            $table->string('sub_location')->nullable();
            $table->string('brief')->nullable();
            $table->string('type');
            $table->longText('current_observation');

            $table->string("photo_1", 100)->nullable();
            $table->string("photo_2", 100)->nullable();
            $table->string("photo_3", 100)->nullable();
            $table->string("photo_4", 100)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assignment_observations');
    }
};
