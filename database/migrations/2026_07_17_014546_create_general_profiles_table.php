<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('general_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('birth_regency')->nullable();
            $table->string('birth_province')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address_by_id')->nullable();
            $table->string('current_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('branch_board_regency')->nullable();
            $table->string('branch_board_province')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_profiles');
    }
};
