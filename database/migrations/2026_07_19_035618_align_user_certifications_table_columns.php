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
            $table->dropColumn(['certification_type', 'court_type', 'competition_level', 'certification_grade', 'event_role', 'issued_date']);
            
            $table->string('certification_number')->nullable()->after('certification_name');
            $table->string('organizer')->nullable()->after('certification_number');
            $table->date('date_of_issue')->nullable()->after('province');
            $table->string('type')->nullable()->after('date_of_issue');
            $table->string('level')->nullable()->after('type');
            $table->string('file_path')->nullable()->after('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_certifications', function (Blueprint $table) {
            $table->dropColumn(['certification_number', 'organizer', 'date_of_issue', 'type', 'level', 'file_path']);
            
            $table->enum('certification_type', ['handball', 'professional'])->nullable();
            $table->string('court_type')->nullable();
            $table->string('competition_level')->nullable();
            $table->string('certification_grade')->nullable();
            $table->string('event_role')->nullable();
            $table->string('issued_date')->nullable();
        });
    }
};
