<?php

use App\Enums\AccountType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->foreignId("rm_id")->constrained("users")
                ->cascadeOnDelete();
            $table->foreignId("under_writer_id")->constrained("users")
                ->cascadeOnDelete();
            $table->foreignId("channel_partner_id")->constrained("users")
                ->cascadeOnDelete();

            $table->string('name');
            $table->string("email")->unique();
            $table->string("mobile_no", 20)->unique();
            $table->string('policy_no');
            $table->string('policy_type');
            $table->string('policy_start_date');
            $table->string('policy_end_date');
            $table->enum('account_type', array_column(AccountType::cases(), "value"))
                ->default(AccountType::CORPORATE->value);
            $table->string("address", 600)->nullable();
            $table->mediumText('about')->nullable();
            $table->mediumText('coverage_terms')->nullable();
            $table->mediumText('cargo_details')->nullable();
            $table->mediumText('transit_details')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customers');
    }
};
