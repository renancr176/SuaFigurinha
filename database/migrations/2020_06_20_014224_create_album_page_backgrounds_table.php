<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumPageBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_page_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->integer('sequence');
            $table->integer('x_position');
            $table->integer('y_position');
            $table->integer('rotation');
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
        Schema::dropIfExists('album_page_backgrounds');
    }
}
