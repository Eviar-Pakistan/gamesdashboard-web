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
        Schema::table('gift_coins', function (Blueprint $table) {
            $table->dropColumn(['purchase_coins', 'lose_coins', 'withdraw_coins', 'won_coins', 'available_coins', 'user_id']);
            $table->integer('from_user_id')->after('id');
            $table->integer('to_user_id')->after('from_user_id');
            $table->integer('coin_type')->after('to_user_id')->comment('1=>purchase,2=>lose,3=>won,4=>withdraw,5=>general_transfer');
            $table->decimal('coins', 65, 2)->after('coin_type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->decimal('coin_balance', 65, 2)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
