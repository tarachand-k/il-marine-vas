<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('why_mlce', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('content');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('why_mlce');
    }
};
