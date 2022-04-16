<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_settings', function (Blueprint $table) {
            $table->id('menu_setting_id');
            $table->string('menu_setting_name', 100)->nullable();
            $table->string('menu_setting_url', 100)->nullable();
            $table->bigInteger('menu_parent_setting_id')->nullable();
            $table->smallInteger('menu_setting_level')->default(0);
            $table->smallInteger('menu_setting_link_eksternal')->default(0);
            $table->smallInteger('menu_setting_status')->default(0);
            $table->smallInteger('menu_setting_position')->default(0);
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->unsigned();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

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
        Schema::dropIfExists('menu_settings');
    }
}
