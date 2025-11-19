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
        Schema::create('event_completions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->text('notulen')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();

            // foreign keys are optional to avoid migration issues in older environments
            // but add them if the tables exist
            if (Schema::hasTable('events')) {
                $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            }
            if (Schema::hasTable('users')) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_completions');
    }
};
