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
        Schema::table('user_certifications', function (Blueprint $table) {
            $table->string('category')->default('Handball')->after('user_id');
            $table->string('role')->nullable()->after('category');
            $table->string('course')->nullable()->after('role');
            $table->string('number')->nullable()->after('course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_certifications', function (Blueprint $table) {
            $table->dropColumn(['category', 'role', 'course', 'number']);
        });
    }
};
