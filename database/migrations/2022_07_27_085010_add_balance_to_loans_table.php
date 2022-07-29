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
            $table->float('balance_amount')->default(0)->after('principal_amount');
            $table->float('total_amount')->default(0)->after('balance_amount');
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
            $table->float('balance_amount')->default(0)->after('principal_amount');
            $table->float('total_amount')->default(0)->after('balance_amount');
        });
    }
};
