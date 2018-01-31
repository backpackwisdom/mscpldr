<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('n_felhid');
            $table->string('c_cim', 256);
            $table->string('c_eloado', 256);
            $table->string('c_album', 256);
            $table->string('c_zenenev');
            $table->string('c_zenelink');
            $table->string('c_boritonev');
            $table->integer('n_kiadev');
            $table->text('c_leiras')->nullable();
            $table->integer('n_mufajazon');
            $table->timestamps();
            $table->foreign('n_felhid')->references('id')->on('users');
            $table->foreign('n_mufajazon')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
