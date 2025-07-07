<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('executive_summary_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_indent_id')->constrained('mlce_indents')->cascadeOnDelete();

            $table->string('description');
            $table->string('photo', 100);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('executive_summary_photos');
    }
};
