<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mlce_reports', function (Blueprint $table) {
            $table->longText("executive_summary")->nullable()->after("mlce_outcome");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mlce_reports', function (Blueprint $table) {
            $table->dropColumn('executive_summary');
        });
    }
};
