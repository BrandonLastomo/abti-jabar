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
        Schema::create('identity_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('photo_path')->nullable();
            $table->string('birth_certificate_number')->nullable();
            $table->string('birth_certificate_path')->nullable();
            $table->string('family_card_number')->nullable();
            $table->string('family_card_path')->nullable();
            $table->string('child_identity_card_number')->nullable();
            $table->string('child_identity_path')->nullable();
            $table->string('national_id_number')->nullable();
            $table->string('national_id_path')->nullable();
            $table->string('bpjs_number')->nullable();
            $table->string('bpjs_path')->nullable();
            $table->string('private_insurance_number')->nullable();
            $table->string('private_insurance_path')->nullable();
            $table->string('under_16_integrity_pact_name')->nullable();
            $table->string('under_16_integrity_pact_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identity_documents');
    }
};
