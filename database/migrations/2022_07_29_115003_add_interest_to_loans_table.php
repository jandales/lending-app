<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->integer('interest')->default(0)->after('principal_amount');
            $table->timestamp('effective_at', $precision = 0)->nullable()->after('user_id');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->integer('interest')->default(0)->after('amount');   
            $table->timestamp('effective_at', $precision = 0)->nullable()->after('user_id');
        });
    }
};
