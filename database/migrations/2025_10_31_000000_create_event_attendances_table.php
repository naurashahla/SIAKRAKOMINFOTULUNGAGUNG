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
        // Make migration idempotent: only create table if it does not already exist
        if (!Schema::hasTable('event_attendances')) {
            Schema::create('event_attendances', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('event_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                $table->enum('status', ['attended', 'transferred'])->default('attended');
                $table->unsignedBigInteger('transferred_to_user_id')->nullable()->index();
                $table->timestamp('transferred_at')->nullable();
                $table->timestamps();

                // don't add foreign keys to avoid migration FK issues across environments
                $table->unique(['event_id', 'user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendances');
    }
};
