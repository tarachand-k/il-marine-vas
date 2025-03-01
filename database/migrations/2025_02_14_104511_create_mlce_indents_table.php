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
            $table->foreignId("insured_representative_id")->nullable()
                ->constrained("users")->nullOnDelete();
            $table->foreignId("rm_id")->nullable()
                ->constrained("users")->nullOnDelete();
            $table->foreignId("vertical_rm_id")->nullable()
                ->constrained("users")->nullOnDelete();
            $table->foreignId("under_writer_id")->nullable()
                ->constrained("users")->nullOnDelete();

            $table->string('indent_code', 50);
            $table->string('ref_no', 50);
            $table->string('policy_no');
            $table->string('policy_type');
            $table->string('policy_start_date');
            $table->string('policy_end_date');
            $table->string('hub',)->nullable();
            $table->string('gwp',)->nullable();
            $table->string('nic',)->nullable();
            $table->string('nep',)->nullable();
            $table->string('lr_percentage',)->nullable();
            $table->string('vertical_name',)->nullable();
            $table->string('insured_commodity',)->nullable();
            $table->string('industry',)->nullable();
            $table->string('pdr_observation', 100)->nullable();
            $table->longText('job_scope')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_indents');
    }
};
