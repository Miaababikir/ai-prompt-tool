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
        Schema::table('prompt_logs', function (Blueprint $table) {
            $table->text("relevance_suggestion")->nullable();
            $table->text("clarity_suggestion")->nullable();
            $table->text("tone_suggestion")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prompt_logs', function (Blueprint $table) {
            //
        });
    }
};
