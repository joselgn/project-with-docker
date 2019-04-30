<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaCarrinho extends Model{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_carrinho','id_prod','qde','preco','preco_total'
    ];

    //Status
    public $_dscStatus = [1=>'Em andamento', 2=>'Finalizado'];

    //Cadastra/Edita dados
    public function salvarDados($array){
        if(!isset($array['id']))
            $modelRegistro = new ListaCarrinho();
        else
            $modelRegistro = $this->find($array['id']);

        $modelRegistro->id_carrinho = isset($array['carrinho'])?$array['carrinho']:'';
        $modelRegistro->id_prod     = isset($array['produto'])?$array['produto']:'';
        $modelRegistro->preco       = isset($array['preco'])?$array['preco']:0.00;
        $modelRegistro->qde         = isset($array['qde'])?$array['qde']:0;
        $modelRegistro->preco_total = isset($array['total'])?$array['total']:0.00;

        if($modelRegistro->save())
            return $modelRegistro->id;
        else
            return false;
    }//cadastrar
}//class
