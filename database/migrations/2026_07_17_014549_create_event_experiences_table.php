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
        Schema::create('event_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('club_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event_role')->nullable();
            $table->string('court_type')->nullable();
            $table->string('event_format')->nullable();
            $table->string('competition_level')->nullable();
            $table->string('participant_scope')->nullable();
            $table->string('age_category')->nullable();
            $table->date('event_start_date')->nullable();
            $table->date('event_end_date')->nullable();
            $table->string('result')->nullable();
            $table->string('event_regency')->nullable();
            $table->string('event_province')->nullable();
            $table->string('event_name')->nullable();
            $table->string('team_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_experiences');
    }
};
