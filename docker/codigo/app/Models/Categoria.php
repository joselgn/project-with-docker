<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'id_cat_pai', 'tipo','ativo'
    ];

    /**
     * Descriçao de Variaveis
     */
    //Tipo de Perfil do usuario
    public $_dscTipo = [1=>"Categoria", 2=>"Sub-Categoria"];

    //Situaçao do Usuario
    public $_dscAtivo = [1=>'Ativo', 2=>'Inativo'];


    //Cadastra nova Categoria
    public function salvarDados($array){
        if(!isset($array['id']))
            $modelCadastro = new Categoria();
        else
            $modelCadastro = $this->find($array['id']);

        $modelCadastro->nome  = $array['nome'];
        $modelCadastro->ativo = $array['status']==''?1:$array['status'];
        $modelCadastro->id_cat_pai = $array['id_cat_pai'];
        $modelCadastro->tipo  = ($array['id_cat_pai']==''?1:2);

        if($modelCadastro->save())
            return $modelCadastro->id;
        else
            return false;
    }//cadastrar



}//class
