<?php

use App\Enums\MlceIndentUserType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlce_indent_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mlce_indent_id')->constrained("mlce_indents")
                ->cascadeOnDelete();
            $table->foreignId('user_id')->constrained("users")
                ->cascadeOnDelete();

            $table->enum('type', array_column(MlceIndentUserType::cases(), "value"))
                ->default(MlceIndentUserType::RM->value);
        });
    }

    public function down(): void {
        Schema::dropIfExists('mlce_indent_user');
    }
};
