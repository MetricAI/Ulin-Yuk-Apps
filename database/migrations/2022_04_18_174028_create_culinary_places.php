<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCulinaryPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('culinary_places', function (Blueprint $table) {
            $table->id('culinary_place_id');
            $table->bigInteger('area_location_id')->unsigned();
            $table->bigInteger('photo_id')->unsigned();
            $table->string('culinary_place_title', 50);
            $table->longText('culinary_place_description');
            $table->integer('culinary_place_price');
            $table->integer('culinary_place_status');
            $table->integer('culinary_place_rating');
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->unsigned();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('area_location_id')
                ->references('area_location_id')
                ->on('area_locations')
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
        Schema::dropIfExists('culinary_places');
    }
}
