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
        Schema::create('gift_coins', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('purchase_coins');
            $table->integer('available_coins');
            $table->integer('lose_coins');
            $table->integer('won_coins');
            $table->integer('withdraw_coins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_coins');
    }
};
