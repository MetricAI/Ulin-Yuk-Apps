<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_statistics', function (Blueprint $table) {
            $table->id('log_statistic_id');
            $table->string('ip_address', 100)->nullable();
            $table->string('url_access', 500)->nullable();
            $table->string('page_access', 500)->nullable();
            $table->integer('hits_url_access')->nullable();
            $table->string('browser_access', 50)->nullable();
            $table->string('device_access', 50)->nullable();
            $table->string('operating_system_access', 50)->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_statistics');
    }
}
