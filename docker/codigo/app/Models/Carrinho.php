<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user','status','total','dt_finalizado'
    ];

    //Status
    public $_dscStatus = [1=>'Em andamento', 2=>'Finalizado'];

    //Cadastra/Edita dados
    public function salvarDados($array){
        if(!isset($array['id']))
            $modelRegistro = new Carrinho();
        else
            $modelRegistro = $this->find($array['id']);

        $modelRegistro->id_user   = isset($array['id_user'])?$array['id_user']:'';
        $modelRegistro->status    = isset($array['status'])?$array['status']:1;
        $modelRegistro->total     = isset($array['total'])?$array['total']:0.00;
        $modelRegistro->dt_finalizado = isset($array['dt_fin'])?$array['dt_fin']:null;

        if($modelRegistro->save())
            return $modelRegistro->id;
        else
            return false;
    }//cadastrar

}//class
