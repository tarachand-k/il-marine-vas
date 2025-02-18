<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignment_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_assignment_id')->constrained("mlce_assignments")
                ->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->string('description');

            $table->string('photo', 100);
        });
    }

    public function down(): void {
        Schema::dropIfExists('assignment_photos');
    }
};
