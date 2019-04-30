<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('ativo')->default(1)->comment('Verifica se a categoria esta ativa: 1 - Ativa / 2 - Inativa');
            $table->integer('tipo',false)->comment('Tipo de Link: 1-Cat Pai / 2-SubCategoria');
            $table->integer('id_cat_pai',false)->unsigned()->nullable();
            $table->string('nome');

            $table->foreign('id_cat_pai')->references('id')->on('categorias');
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
        Schema::dropIfExists('categorias');
    }
}
