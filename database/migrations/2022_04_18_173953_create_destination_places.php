<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination_places', function (Blueprint $table) {
            $table->id('destination_place_id');
            $table->bigInteger('area_location_id')->unsigned();
            $table->string('destination_device_code', 50);
            $table->bigInteger('photo_id')->unsigned();
            $table->string('destination_place_title', 50);
            $table->string('destination_place_latitude', 50);
            $table->string('destination_place_longitude', 50);
            $table->longText('destination_place_description');
            $table->integer('destination_place_price');
            $table->integer('destination_place_status');
            $table->integer('destination_place_rating');
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->unsigned();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('area_location_id')
                ->references('area_location_id')
                ->on('area_locations')
                ->onDelete('cascade');

            $table->foreign('photo_id')
                ->references('photo_id')
                ->on('photos')
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
        Schema::dropIfExists('destination_places');
    }
}
