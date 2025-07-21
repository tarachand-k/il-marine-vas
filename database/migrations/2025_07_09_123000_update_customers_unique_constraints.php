<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop existing unique constraints
            $table->dropUnique(['email']);
            $table->dropUnique(['mobile_no']);
            
            // Add new unique constraints that allow null values
            $table->unique(['email'], 'customers_email_unique_not_null')
                  ->whereNotNull('email');
            $table->unique(['mobile_no'], 'customers_mobile_no_unique_not_null')
                  ->whereNotNull('mobile_no');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop the new unique constraints
            $table->dropIndex('customers_email_unique_not_null');
            $table->dropIndex('customers_mobile_no_unique_not_null');
            
            // Restore original unique constraints
            $table->unique('email');
            $table->unique('mobile_no');
        });
    }
};