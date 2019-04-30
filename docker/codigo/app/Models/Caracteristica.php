<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome','ativo'
    ];

    //Status
    public $_dscStatus = [1=>'Ativo', 2=>'Inativo'];

    //Cadastra/Edita dados
    public function salvarDados($array){
        if(!isset($array['id']))
            $modelRegistro = new Caracteristica();
        else
            $modelRegistro = $this->find($array['id']);

        $modelRegistro->nome   = isset($array['nome'])?$array['nome']:'';
        $modelRegistro->ativo  = isset($array['ativo'])?$array['ativo']:1;

        if($modelRegistro->save())
            return $modelRegistro->id;
        else
            return false;
    }//cadastrar


}//class
