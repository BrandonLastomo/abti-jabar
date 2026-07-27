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
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('logo')->nullable();
            $table->string('name');
            $table->string('pengcab_address')->nullable();
            $table->string('office_address')->nullable();
            $table->text('office_address_complete')->nullable();
            $table->string('venue_address')->nullable();
            $table->text('venue_address_complete')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('club_status', ['amatir', 'profesional'])->nullable();
            $table->string('picture')->nullable();

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
