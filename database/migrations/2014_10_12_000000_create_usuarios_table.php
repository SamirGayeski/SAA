<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 50);
            $table->string('password', 200);
            $table->string('email', 50)->unique;
            $table->string('telefone', 15);
            $table->string('sexo', 10);
            $table->date('dataCriacao');
            $table->string('situacao', 10);
            $table->boolean('flagAdmin');
            $table->string('tipoUsuario', 30);
            $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
    }
}
