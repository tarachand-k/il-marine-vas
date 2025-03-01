<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('uploaded_by_id')->constrained("users")
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('description')->nullable();
            $table->string('presentation', 100);
            $table->unsignedInteger('view_count')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('presentations');
    }
};
