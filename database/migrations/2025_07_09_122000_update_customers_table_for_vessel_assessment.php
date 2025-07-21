<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Make fields nullable for vessel assessment customers
            $table->foreignId("rm_id")->nullable()->change();
            $table->string("email")->nullable()->change();
            $table->string("mobile_no", 20)->nullable()->change();
            $table->string('policy_no')->nullable()->change();
            $table->string('policy_type')->nullable()->change();
            $table->string('policy_start_date')->nullable()->change();
            $table->string('policy_end_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Revert fields back to required (non-nullable)
            $table->foreignId("rm_id")->nullable(false)->change();
            $table->string("email")->nullable(false)->change();
            $table->string("mobile_no", 20)->nullable(false)->change();
            $table->string('policy_no')->nullable(false)->change();
            $table->string('policy_type')->nullable(false)->change();
            $table->string('policy_start_date')->nullable(false)->change();
            $table->string('policy_end_date')->nullable(false)->change();
        });
    }
};