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
        Schema::table('integrity_documents', function (Blueprint $table) {
            $table->dropColumn(['issue_date', 'integrity_type', 'integrity_path']);
            
            $table->string('type')->nullable();
            $table->date('signed_date')->nullable();
            $table->string('file_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('integrity_documents', function (Blueprint $table) {
            $table->dropColumn(['type', 'signed_date', 'file_path']);
            
            $table->date('issue_date')->nullable();
            $table->enum('integrity_type', ['jawa barat', 'kota/kabupaten', 'keabsahan mutasi'])->nullable();
            $table->string('integrity_path')->nullable();
        });
    }
};
