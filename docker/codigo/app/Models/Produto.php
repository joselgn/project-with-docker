<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use http\QueryString;
use Illuminate\Support\Facades\DB;

class Produto extends Model{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome','ativo','preco','url_imagem','descricao'
    ];

    //Status
    public $_dscStatus = [1=>'Ativo', 2=>'Inativo'];

    //Cadastra/Edita dados
    public function salvarDados($array){
        if(!isset($array['id']))
            $modelRegistro = new Produto();
        else
            $modelRegistro = $this->find($array['id']);

        $modelRegistro->nome   = isset($array['nome'])?$array['nome']:'';
        $modelRegistro->ativo  = isset($array['ativo'])?$array['ativo']:1;
        $modelRegistro->preco  = isset($array['preco'])?$array['preco']:0.00;
        $modelRegistro->url_imagem  = isset($array['url_imagem'])?$array['url_imagem']:($modelRegistro->url_imagem!=''?$modelRegistro->url_imagem:null);
        $modelRegistro->descricao  = isset($array['descricao'])?$array['descricao']:null;

        if($modelRegistro->save())
            return $modelRegistro->id;
        else
            return false;
    }//cadastrar

    //Pesquisa os Vinculos da tabela
    //$campo == [id_prod || id_carac]
    public function vinculoProdCaracPsq($campo,$valor){
        $sql = DB::select('SELECT * FROM vin_prod_carac WHERE '.$campo.'='.$valor);
        return $sql;
    }//Pesquisa vinculos

    //Cadastra Vinculo produto / Caracteristica
    public function vinculoProdCarac($idProduto,$idCarac){
            $sql = DB::insert('INSERT INTO vin_prod_carac (id_prod, id_carac) values (?, ?)', [$idProduto,$idCarac]);
            if($sql)
                return true;
            else
                return false;
    }//Vincula produtos e caracteristicas

    //Exclui Vinculos caracteristicas dos produtos
    public function vinculoProdCaracDelete($idProduto){
        $sql = DB::delete('DELETE FROM vin_prod_carac WHERE id_prod='.$idProduto);
        if($sql)
            return true;
        else
            return false;
    }//exclui vinculos produto caracteristica

    //Pesquisa os Vinculos da tabela
    //$campo == [id_prod || id_carac]
    public function vinculoProdCategPsq($campo,$valor){
        $sql = DB::select('SELECT * FROM vin_prod_categ WHERE '.$campo.'='.$valor);
        return $sql;
    }//Pesquisa vinculos

    //Cadastra Vinculo produto / Categorias
    public function vinculoProdCateg($idProduto,$idCat){
            $sql = DB::insert('INSERT INTO vin_prod_categ (id_prod, id_categ) values (?, ?)', [$idProduto,$idCat]);
            if($sql)
                return true;
            else
                return false;
    }//Vincula produtos e caracteristicas

    //Exclui Vinculos Categoria dos produtos
    public function vinculoProdCategDelete($idProduto){
        $sql = DB::delete('DELETE FROM vin_prod_categ WHERE id_prod='.$idProduto);
        if($sql)
            return true;
        else
            return false;
    }//exclui vinculos produto categoria


}//Class
