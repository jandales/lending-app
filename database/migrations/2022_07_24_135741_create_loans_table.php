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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_number')->nullable();
            $table->unsignedBigInteger('borrower_id'); 
            $table->integer('terms')->default(0);
            $table->string('type', 50)->nullable();
            $table->integer('interest')->default(0);
            $table->float('total_interest')->default(0);
            $table->float('collection_amount')->default(0);       
            $table->float('principal_amount')->default(0);
            $table->float('total_amount')->default(0);
            $table->float('balance_amount')->default(0);              
            $table->timestamp('effective_at')->nullable();
            $table->date('due_date_at')->nullable();
            $table->string('status',50)->nullable();
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('borrower_id')->references('id')->on('borrowers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
