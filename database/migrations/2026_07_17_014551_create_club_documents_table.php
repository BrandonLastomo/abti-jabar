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
        Schema::create('club_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->cascadeOnDelete();
            $table->string('akta_notaris')->nullable();
            $table->string('akta_notaris_path')->nullable();
            $table->date('akta_notaris_date')->nullable();
            $table->string('badan_hukum')->nullable();
            $table->string('badan_hukum_path')->nullable();
            $table->date('badan_hukum_date')->nullable();
            $table->string('npwp')->nullable();
            $table->string('npwp_path')->nullable();
            $table->date('npwp_date')->nullable();
            $table->string('sk')->nullable();
            $table->string('sk_path')->nullable();
            $table->date('sk_date')->nullable();
            $table->string('ad_art')->nullable();
            $table->string('ad_art_path')->nullable();
            $table->date('ad_art_date')->nullable();
            $table->string('keorganisasian')->nullable();
            $table->string('keorganisasian_path')->nullable();
            $table->date('keorganisasian_date')->nullable();
            $table->string('keolahragaan')->nullable();
            $table->string('keolahragaan_path')->nullable();
            $table->date('keolahragaan_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_documents');
    }
};
