<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaCarrinhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_carrinhos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_carrinho',false)->unsigned();
            $table->integer('id_prod',false)->unsigned();
            $table->integer('qde',false)->nullable();
            $table->decimal('preco',10,2)->nullable();
            $table->decimal('preco_total',10,2)->nullable();

            $table->foreign('id_carrinho')->references('id')->on('carrinhos');
            $table->foreign('id_prod')->references('id')->on('produtos');

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
        Schema::dropIfExists('lista_carrinhos');
    }
}
