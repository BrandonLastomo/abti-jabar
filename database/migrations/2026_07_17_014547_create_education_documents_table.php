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
        Schema::create('education_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('elementary_school_name')->nullable();
            $table->string('elementary_school_path')->nullable();
            $table->string('junior_high_school_name')->nullable();
            $table->string('junior_high_school_path')->nullable();
            $table->string('senior_high_school_name')->nullable();
            $table->string('senior_high_school_path')->nullable();
            $table->string('bachelor_university_name')->nullable();
            $table->string('bachelor_university_path')->nullable();
            $table->string('masters_university_name')->nullable();
            $table->string('masters_university_path')->nullable();
            $table->string('doctoral_university_name')->nullable();
            $table->string('doctoral_university_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_documents');
    }
};
