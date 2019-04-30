<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VinProdCateg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('vin_prod_categ', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_prod',false)->unsigned();
            $table->integer('id_categ',false)->unsigned();

            $table->foreign('id_prod')->references('id')->on('produtos');
            $table->foreign('id_categ')->references('id')->on('categorias');
        });
    }//up

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
