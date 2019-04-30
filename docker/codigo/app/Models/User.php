<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'password','salt','ativo','endereco','cep','perfil'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','salt'
    ];

    /**
     * Descriçao de Variaveis
     */
    //Tipo de Perfil do usuario
    public $_dscTipoPerfil = [1=>'Administrador',2=>'Usuario'];

    //Situaçao do Usuario
    public $_dscSituacao = [1=>'Ativo', 2=>'Inativo'];

    //Save New Register
    public function saveNew($arrData){
        //Cria Salt
        $salt = $this->_createSalt();
        //Setting Values
        $userModel = new User();
        $userModel->nome     = $arrData['name'];
        $userModel->email    = $arrData['email'];
        $userModel->password = Hash::make($this->_criptoSenha($salt,$arrData['password']));
        $userModel->salt     = $salt;
        return $userModel->saveOrFail();
    }//save new

    //Cadastra/Edita dados de usuario
    public function salvarDados($array){
        if(!isset($array['id'])){
            $modelUsuario = new User();
            $modelUsuario->salt  = $this->_createSalt();

            if(isset($array['password'])&&$array['password']=='')
                $modelUsuario->password =Hash::make($this->_criptoSenha($modelUsuario->salt,'teste'));
        }else
            $modelUsuario = $this->find($array['id']);

        $modelUsuario->nome   = isset($array['nome'])?$array['nome']:'';
        $modelUsuario->email  = isset($array['email'])?$array['email']:'';
        $modelUsuario->ativo  = isset($array['ativo'])?$array['ativo']:1;
        $modelUsuario->perfil = isset($array['perfil'])?$array['perfil']:2;
        $modelUsuario->cep    = isset($array['cep'])?$array['cep']:null;
        $modelUsuario->endereco = isset($array['endereco'])?$array['endereco']:null;

        if(isset($array['password'])&&$array['password']!='')
            $modelUsuario->password = Hash::make($this->_criptoSenha($modelUsuario->salt,$array['password']));

        if($modelUsuario->save())
            return $modelUsuario->id;
        else
            return false;
    }//cadastrar

    //Funçao para criptografar a senha
    public function _criptoSenha($salt,$senha){
        return $salt.'.'.$senha;
    }//Cripto senha

    //Funçao para Criar SALT - Create SALT
    public function _createSalt($min = 6, $max = 90){
        $arrPossibilities = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '$', '%', '/', '.', '@', '&', '-', '$', '#', '+', '*', '!', '?',
        ];//array

        $qntyChars = rand($min, $max);
        $strSalt = '';
        for ($i = 0; $i < $qntyChars; $i++) {
            $charpos = rand(0, (count($arrPossibilities) - 1));

            $strSalt .= $arrPossibilities[$charpos];
        }//for mounting SALT

        return $strSalt;
    }//create SALT



}//class
