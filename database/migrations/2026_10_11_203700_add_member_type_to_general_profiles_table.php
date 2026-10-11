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
        Schema::table('general_profiles', function (Blueprint $table) {
            $table->string('member_type')->default('atlet')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_profiles', function (Blueprint $table) {
            $table->dropColumn('member_type');
        });
    }
};
