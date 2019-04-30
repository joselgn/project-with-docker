<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VinProdCarac extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('vin_prod_carac', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_prod',false)->unsigned();
            $table->integer('id_carac',false)->unsigned();

            $table->foreign('id_prod')->references('id')->on('produtos');
            $table->foreign('id_carac')->references('id')->on('caracteristicas');
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
