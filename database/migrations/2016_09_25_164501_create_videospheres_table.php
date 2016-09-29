<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideospheresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videospheres', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id');
            $table->integer('file_id');
            $table->text('caption');
            $table->text('description');
            $table->text('duration');
            $table->integer('width');
            $table->integer('height');
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
        Schema::drop('videospheres');
    }
}
