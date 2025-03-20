<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string("email")->unique();
            $table->string("mobile_no", 20)->unique();
            $table->string('policy_no');
            $table->string('policy_type');
            $table->string('policy_start_date');
            $table->string('policy_end_date');
            $table->longText('about')->nullable();
            $table->longText('coverage_terms')->nullable();
            $table->longText('cargo_details')->nullable();
            $table->longText('transit_details')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customers');
    }
};
