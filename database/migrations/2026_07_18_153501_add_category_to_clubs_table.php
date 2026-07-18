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
        Schema::table('clubs', function (Blueprint $table) {
            $table->enum('category', ['indoor', 'beach', 'wheelchair'])->nullable()->after('name');
            $table->enum('subcategory', [
                'Senior putra',
                'Senior putri',
                'U-21 putra',
                'U-21 putri',
                'U-17 putra',
                'U-17 putri',
                'U-15 putra',
                'U-15 putri',
                'Lihat Semua Tim'
            ])->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn(['category', 'subcategory']);
        });
    }
};
