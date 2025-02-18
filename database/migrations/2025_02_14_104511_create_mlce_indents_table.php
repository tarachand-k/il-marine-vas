<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlce_indents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by_id')
                ->constrained("users")->cascadeOnDelete();
            $table->foreignId('customer_id')
                ->constrained("customers")->cascadeOnDelete();
            $table->foreignId('mlce_type_id')
                ->constrained("mlce_types")->cascadeOnDelete();

            $table->string('indent_code', 50);
            $table->string('pdr_observation', 100)->nullable();
            $table->string('job_scope', 100)->nullable();
            $table->longText('why_mlce')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_indents');
    }
};
