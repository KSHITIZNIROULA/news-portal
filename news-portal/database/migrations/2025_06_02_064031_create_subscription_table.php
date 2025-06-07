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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Subscriber (user role)
            $table->foreignId('publisher_id')->constrained('users')->onDelete('cascade'); // Publisher (user with publisher role)
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // For time-based subscriptions
            $table->string('status')->default('active'); // e.g., active, expired, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
