<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDestinations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_destinations', function (Blueprint $table) {
            $table->id('transaction_destination_id');
            $table->bigInteger('destination_place_id')->unsigned()->nullable();
            $table->integer('transaction_detail_total_price')->unsigned()->nullable();
            $table->integer('transaction_detail_total')->unsigned()->nullable();
            $table->integer('transaction_detail_status')->unsigned()->nullable();
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->unsigned();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('destination_place_id')
                ->references('destination_place_id')
                ->on('destination_places')
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
        Schema::dropIfExists('transaction_destinations');
    }
}
