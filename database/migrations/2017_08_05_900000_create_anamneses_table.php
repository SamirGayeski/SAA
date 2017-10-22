<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnamnesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anamnese', function (Blueprint $table) {
            $table->increments('id');
            $table->string('queixaPrincipal', 80);
            $table->string('historia', 300);
            $table->string('problemasRenais', 50);
            $table->string('problemasArticulares', 50);
            $table->string('problemasCardiacos', 50);
            $table->string('problemasRespiratorios', 50);
            $table->string('problemasGastricos', 50);
            $table->string('alergias', 50);
            $table->boolean('hepatite', 50);
            $table->boolean('gravidez', 50)->nullable();
            $table->boolean('diabetes', 50);
            $table->string('usoMedicamento', 100);
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
        Schema::dropIfExists('anamneses');
    }
}
