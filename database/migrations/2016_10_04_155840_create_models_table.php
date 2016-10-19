<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id');
            $table->integer('file_id_0');
            $table->integer('file_id_1')->nullable();
            $table->integer('file_id_preview');
            $table->text('caption');
            $table->text('description');
            $table->text('data');

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
        Schema::drop('models');
    }
}
