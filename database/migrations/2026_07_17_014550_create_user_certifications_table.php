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
        Schema::create('user_certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('certification_type', ['handball', 'professional'])->nullable();
            $table->string('court_type')->nullable();
            $table->string('competition_level')->nullable();
            $table->string('certification_grade')->nullable();
            $table->string('event_role')->nullable();
            $table->string('issued_date')->nullable();
            $table->string('regency')->nullable();
            $table->string('province')->nullable();
            $table->string('certification_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_certifications');
    }
};
