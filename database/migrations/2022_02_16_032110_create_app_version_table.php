<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_version', function (Blueprint $table) {
            $table->string('os_type');
            $table->string('app_name');
            $table->string('version');
            $table->string('store_url');
            $table->integer('update_status');
            $table->primary(['app_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_version');
    }
}
