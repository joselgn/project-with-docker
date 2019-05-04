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

            $prodsCateg = $modelProdutos->vinculoProdCategPsq('id_categ',$filtro);//Produtos com o ID da categoria 
            $prodsCategPai = $modelCategoria->where(['id_cat_pai'=>$filtro])->get();//Todos os produtos vinculados a uma categoria, caso essa categoria seja pai
            $vincProdCateg = $prodsCateg !=null ? $prodsCateg : $prodsCategPai;
            $aIdProdPermitidos =[];
            if($vincProdCateg!=null){
                foreach ($vincProdCateg as $vinc){
                    $aIdProdPermitidos[]= $vinc->id_prod;
                }//foreach categorias
            }//if vinc Prod Categoria

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
