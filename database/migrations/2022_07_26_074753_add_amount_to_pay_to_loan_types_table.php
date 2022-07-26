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
        Schema::table('loan_types', function (Blueprint $table) {
            $table->float('amount_to_pay')->default(0)->after('interest');
            $table->integer('due_type')->default(0)->after('amount_to_pay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pay_to_loan_types', function (Blueprint $table) {
            $table->float('amount_to_pay')->default(0)->after('interest');
            $table->integer('due_type')->default(0)->after('amount_to_pay');
        });
    }
};
