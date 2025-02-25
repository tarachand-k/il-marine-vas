<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sops', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained("customers")
                ->cascadeOnDelete();

            $table->string('pdf', 100);
            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sops');
    }
};
