<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('presentation_user', function (Blueprint $table) {
            $table->foreignId('presentation_id');
            $table->foreignId('user_id');

            $table->primary(['presentation_id', 'user_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('presentation_user');
    }
};
