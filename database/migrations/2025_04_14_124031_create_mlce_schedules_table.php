<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlce_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained("users")->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained("customers")->cascadeOnDelete();

            $table->date('date');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_schedules');
    }
};
