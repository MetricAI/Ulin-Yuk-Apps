<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id('transaction_detail_id');
            $table->bigInteger('transaction_total_id')->unsigned()->nullable();
            $table->bigInteger('culinary_place_id')->unsigned()->nullable();
            $table->integer('transaction_total')->unsigned()->nullable();
            $table->integer('transaction_total_price')->unsigned()->nullable();
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->unsigned();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('transaction_total_id')
                ->references('transaction_total_id')
                ->on('transaction_totals')
                ->onDelete('cascade');

            $table->foreign('culinary_place_id')
                ->references('culinary_place_id')
                ->on('culinary_places')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('user_id')
                ->on('sys_users')
                ->onDelete('cascade');

            $table->foreign('updated_by')
                ->references('user_id')
                ->on('sys_users')
                ->onDelete('cascade');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
