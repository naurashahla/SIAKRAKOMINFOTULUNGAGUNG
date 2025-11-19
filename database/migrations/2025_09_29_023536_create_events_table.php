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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('startDate');
            $table->string('startTime')->nullable();
            $table->date('endDate')->nullable();
            $table->string('endTime')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->enum('notification_status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamps();
            $table->tinyInteger('reminder_sent')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
