<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('marine_vas', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('content');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('marine_vas');
    }
};
