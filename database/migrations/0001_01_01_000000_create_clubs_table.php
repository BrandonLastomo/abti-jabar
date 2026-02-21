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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('city');

            $table->string('director_club');        // Direktur Klub
            $table->string('administrator');        // Administrator
            $table->string('technical_director');   // Direktur Teknik
            $table->string('training_venue');       // Venue Latihan

            $table->string('email')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('website')->nullable();

            $table->year('founded_year')->nullable();
            $table->enum('status', ['member', 'guest'])->default('member');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
