<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Produto;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $authInstance = Auth::user();
        $modelUsuario = new User();

        return view('home',[
            'perfil' => $authInstance->perfil,
            'dadosPessoais' => ['nome'=>$authInstance->nome,'email'=>$authInstance->email,'endereco'=>$authInstance->email],
            'layout'=>$this->_initLayout(),
        ]);
    }//index

    //Filtro categoria
    public function filtraCategoria(Request $request){
        $authInstance = Auth::user();
        $modelProdutos = new Produto();
        $dadosLayout = $this->_initLayout();

        if(isset($request->menuid)) {
            $filtro = $request->menuid;

            $vincProdCateg = $modelProdutos->vinculoProdCategPsq('id_categ',$filtro);
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

        return view('home',[
            'perfil' => $authInstance->perfil,
            'dadosPessoais' => ['nome'=>$authInstance->nome,'email'=>$authInstance->email,'endereco'=>$authInstance->email],
            'layout'=>$dadosLayout
        ]);
    }//index action

}//class
