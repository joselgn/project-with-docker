<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produto;
use App\Models\Categoria;


class IndexController extends Controller{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest');
    }//__constructor

    //Index
    public function index(){
        return view('inicio',[
            'layout'=>$this->_initLayout()
        ]);
    }//index action

    //Filtro categoria
    public function filtraCategoria(Request $request){
        $modelProdutos = new Produto();
        $modelCategoria = new Categoria();
        $dadosLayout = $this->_initLayout();

        if(isset($request->menuid)) {
            $filtro = $request->menuid;

            $vincProdCateg = $modelProdutos->vinculoProdCategPsq('id_categ',$filtro);//Produtos com o ID da categoria                         
            $aIdProdPermitidos =[];
            if($vincProdCateg!=null){
                foreach ($vincProdCateg as $vinc){
                    $aIdProdPermitidos[]= $vinc->id_prod;
                }//foreach categorias
            }else{
                //Verifica se possui 
                $categoriasVinculadas = $modelCategoria->where(['id_cat_pai'=>$filtro])->get();//Todas as categorias vinculadas a uma categoria, caso essa categoria seja pai
                if($categoriasVinculadas!=null){
                    foreach($categoriasVinculadas as $catPai){
                        //Pesquisa por produtos Vinculadas a categoria
                        $prodsVinc = $modelProdutos->vinculoProdCategPsq('id_categ',$catPai->id);//Produtos com o ID da categoria                         
                        if($prodsVinc!=null){
                            foreach ($prodsVinc as $vinc){
                                $aIdProdPermitidos[]= $vinc->id_prod;
                            }//foreach categorias
                        }//if prods vinc a categorias
                    }//foreach categorias vinculadas                    
                }//if categorias vinculadas                
            }//if / else vinc Prod Categoria

            $aProd = [];
            foreach($dadosLayout['allProds'] as $produto){
                if(in_array($produto['id'],$aIdProdPermitidos)){
                    $aProd[]=$produto;
                }//if verif prod
            }//foreach produtos

            $dadosLayout['allProds'] = $aProd;
        }//if trata produtos

        return view('inicio',[
                'layout'=>$dadosLayout
        ]);
    }//Categoria filtro action

    //Registro controller
    public function novoRegistro(){
        return view('auth.register');
    }//novo registro Action
}//class
