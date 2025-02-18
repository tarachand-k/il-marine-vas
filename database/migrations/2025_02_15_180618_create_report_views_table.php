<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('report_views', function (Blueprint $table) {

            $table->foreignId('mlce_report_id')->constrained("mlce_reports")
                ->cascadeOnDelete();
            $table->foreignId('user_id')->constrained("users")
                ->cascadeOnDelete();

            $table->string("page_name")->nullable();
            $table->dateTime('viewed_at');
            $table->string('device_info')->nullable();
            $table->string('ip_address', 50)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('report_views');
    }
};
