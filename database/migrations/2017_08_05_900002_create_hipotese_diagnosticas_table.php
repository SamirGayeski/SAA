<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHipoteseDiagnosticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hipotese_diagnosticas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('diagnostico', 100);
            $table->string('observacoes', 100)->nullable();
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
        Schema::dropIfExists('hipotese_diagnosticas');
    }
}
