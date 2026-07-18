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
        DB::statement("ALTER TABLE education MODIFY category ENUM('Multiplier', 'Coach', 'Goalkeeper Coach', 'Referee', 'Delegates', 'Training Management', 'Club Management') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE education MODIFY category VARCHAR(100) NOT NULL");
    }
};
