<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('user_uid')->nullable();
            $table->string('user_image')->nullable();
            $table->string('user_image_link')->nullable();
            $table->string('user_name', 100);
            $table->string('user_email', 100)->unique();
            $table->string('user_password');
            $table->string('user_phone', 20)->nullable();
            $table->string('user_place_of_birth', 20)->nullable();
            $table->string('user_date_of_birth', 20)->nullable();
            $table->text('user_address')->nullable();
            $table->bigInteger('user_saldo')->nullable();
            $table->string('user_latitude')->nullable();
            $table->string('user_longitude')->nullable();
            $table->smallInteger('user_status')->default(0);
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

            $table->foreign('group_id')
                ->references('group_id')
                ->on('sys_user_groups');

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
        Schema::dropIfExists('sys_users');
    }
}
