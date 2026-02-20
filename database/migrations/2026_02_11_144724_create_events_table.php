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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id')->nullable();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('loc')->nullable();
            $table->text('athletes')->nullable();
            $table->text('coaches')->nullable();
            $table->text('teams')->nullable();
            $table->text('management')->nullable();
            $table->text('audience_offline')->nullable();
            $table->string('website')->nullable();
            $table->string('administrator')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
