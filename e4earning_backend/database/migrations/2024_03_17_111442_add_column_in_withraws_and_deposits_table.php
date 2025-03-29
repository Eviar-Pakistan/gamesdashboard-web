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
        Schema::table('withdraws', function (Blueprint $table) {
            $table->integer('status')->default(0)->after('user_id');       
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->integer('status')->default(0)->after('user_id');       
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
