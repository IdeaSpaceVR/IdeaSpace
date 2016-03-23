<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldDataImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_data_images', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('space_id');
            $table->integer('field_control_id');
            $table->integer('file_id');
            $table->integer('weight');

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
        Schema::drop('field_data_images');
    }
}
