<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('n_felh_id');
            $table->string('c_albumnev', 256);
            $table->string('c_eloado', 256);
            $table->integer('n_kiadev');
            $table->string('c_albumlink');
            $table->string('c_boritonev');
            $table->string('c_leiras');
            $table->integer('n_mufaj_id');
            $table->timestamps();
            $table->foreign('n_felh_id')->references('id')->on('users');
            $table->foreign('n_mufaj_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
