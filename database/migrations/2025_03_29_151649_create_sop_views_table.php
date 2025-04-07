<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sop_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sop_id')->constrained("sops")
                ->cascadeOnDelete();
            $table->foreignId('user_id')->constrained("users")
                ->cascadeOnDelete();

            $table->dateTime('viewed_at');

            $table->index(["sop_id", "viewed_at"]);
            $table->index(["user_id", "viewed_at"]);
        });
    }

    public function down(): void {
        Schema::dropIfExists('sop_views');
    }
};
