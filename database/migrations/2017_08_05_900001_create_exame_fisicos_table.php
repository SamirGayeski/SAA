<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExameFisicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exame_fisicos', function (Blueprint $table) {
            $table->increments('id');
            $table->double('altura');
            $table->double('peso');
            $table->integer('frenquenciaCardiaca');
            $table->integer('pressaoSistolica');
            $table->integer('pressaoDiastolica');
            $table->string('observacoesGerais', 100)->nullable();
            $table->integer('atendimento_id')->unsigned();
            $table->foreign('atendimento_id')->references('id')->on('atendimentos');
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
        Schema::dropIfExists('exame_fisicos');
    }
}
