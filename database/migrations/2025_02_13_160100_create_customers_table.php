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
            $table->string("mobile_no", 20);
            $table->string('policy_no', 40);
            $table->string('policy_type');
            $table->date('coverage_from');
            $table->date('coverage_to');
            $table->text('address')->nullable();
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
