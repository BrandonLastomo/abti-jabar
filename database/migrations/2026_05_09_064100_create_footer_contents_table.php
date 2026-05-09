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
        Schema::create('footer_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();   // e.g. 'org_name', 'email', 'nav_col_1', etc.
            $table->string('label');            // Human-readable label for the CMS form
            $table->text('value')->nullable();  // The actual content (plain text or JSON for nav links)
            $table->string('type')->default('text'); // text, textarea, image, json
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_contents');
    }
};
