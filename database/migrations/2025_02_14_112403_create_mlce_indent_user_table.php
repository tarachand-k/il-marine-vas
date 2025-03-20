<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlce_indent_user', function (Blueprint $table) {
            $table->foreignId('mlce_indent_id')->constrained("mlce_indents")
                ->cascadeOnDelete();
            $table->foreignId('user_id')->constrained("users")
                ->cascadeOnDelete();

            $table->primary(["mlce_indent_id", "user_id"]);
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_indent_user');
    }
};
