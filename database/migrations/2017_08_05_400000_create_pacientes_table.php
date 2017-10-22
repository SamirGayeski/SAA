<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 70);
            $table->date('dataNascimento');
            $table->string('sexo',10);
            $table->string('email', 50);
            $table->string('telefoneCelular', 15);
            //$table->boolean('aceitasms');
            $table->string('telefoneResidencial', 15)->nullable();
            $table->string('endereco', 50);
            $table->string('bairro', 50);
            $table->string('numero', 10);
            $table->string('complemento', 50)->nullable();
            $table->integer('cidade_id')->unsigned();
            $table->foreign('cidade_id')->references('id')->on('cidades');
            $table->string('cpf', 20);
            $table->string('rg', 20);
            $table->string('estadoCivil', 15);
            $table->string('profissao', 50)->nullable();
            $table->string('situacao', 10);
            $table->string('cns', 10)->nullable();
            $table->integer('convenio_id')->unsigned()->nullable();
            $table->foreign('convenio_id')->references('id')->on('convenios');
            $table->integer('plano_id')->unsigned()->nullable();
            $table->foreign('plano_id')->references('id')->on('planos');
            $table->string('numeroCarteirinha', 15)->nullable();
            $table->date('validade')->nullable();
            $table->string('acomodacao', 25)->nullable();
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
        Schema::dropIfExists('pacientes');
    }
}
