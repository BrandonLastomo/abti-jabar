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
        Schema::create('document_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // The user who owns the document
            $table->morphs('documentable'); // documentable_id, documentable_type
            $table->string('field_name'); // e.g. 'national_id_path'
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('notes')->nullable(); // Superadmin notes (e.g. rejection reason)
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Ensure one verification record per document field per model
            $table->unique(['documentable_id', 'documentable_type', 'field_name'], 'doc_verification_unique');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_verifications');
    }
};
