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
        Schema::create('prompt_logs', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->text("prompt");
            $table->text("context");
            $table->text("response")->nullable();
            $table->string("status");
            $table->unsignedInteger("relevance_score")->nullable();
            $table->unsignedInteger("clarity_score")->nullable();
            $table->unsignedInteger("tone_score")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompt_logs');
    }
};
