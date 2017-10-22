<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecepcionistaAtendesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcionista_atendes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recepcionista_id')->unsigned();
            $table->foreign('recepcionista_id')->references('id')->on('usuarios');
            $table->integer('profissionalsaude_id')->unsigned();
            $table->foreign('profissionalsaude_id')->references('id')->on('usuarios');
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
        Schema::dropIfExists('recepcionista_atendes');
    }
}
