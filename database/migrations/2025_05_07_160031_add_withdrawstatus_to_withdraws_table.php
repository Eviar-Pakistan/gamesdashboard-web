<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->integer('withdrawstatus')->default(1)->after('user_id'); // Or place it where you prefer
        });
    }
    
    public function down()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->dropColumn('withdrawstatus');
        });
    }
};
