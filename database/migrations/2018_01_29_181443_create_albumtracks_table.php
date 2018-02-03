<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumtracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albumtracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('n_album_id')->unsigned();
            $table->integer('n_szam_id')->unsigned();
            $table->foreign('n_album_id')->references('id')->on('albums');
            $table->foreign('n_szam_id')->references('id')->on('tracks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albumtracks');
    }
}
