<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('ativo')->default(true)->comment('Verifica se o Usuario esta ativo: 1 - Ativo / 2 - Inativo');
            $table->integer('perfil')->default('2')->comment('Tipo de Perfil: 1 - Administrador / 2 - Usuario');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('salt');
            $table->text('endereco')->nullable();
            $table->integer('cep',false)->nullable();
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
        Schema::dropIfExists('users');
    }
}
