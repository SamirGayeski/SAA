<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfNotificacaoPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conf_notificacao_pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->time('horarioEnvio');
            $table->integer('antecedeAtendimento');
            $table->boolean('reenviaDiaAtendimento');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('usuarios');
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
        Schema::dropIfExists('conf_notificacao_pacientes');
    }
}
