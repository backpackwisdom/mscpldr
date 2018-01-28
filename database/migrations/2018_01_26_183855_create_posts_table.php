<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('n_felh_id');
            $table->integer('n_szam_id');
            $table->integer('n_valasz_id')->nullable();
            $table->timestamps();
            $table->text('c_szoveg');
            $table->foreign('n_felh_id')->references('id')->on('users');
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
        Schema::dropIfExists('posts');
    }
}
