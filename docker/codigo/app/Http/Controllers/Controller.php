<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica;
use App\Models\Carrinho;
use App\Models\ListaCarrinho;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

//Models
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Variaveis padrao
    public $_storagePath;

    public function __construct(){
        $this->_storagePath = 'img-up/';
    }//construct

    //Inicia o carregamento padrao de layout
    public function _initLayout($array=null){
        return [
            'menu' => $this->_montaMenuLateral(),
            'lastProds' => $this->_ultimosProdutos(),
            'allProds' =>$this->_listaProdutos(),
            'linkCarrinho' => $this->_linkCarrinho(),
            'carrinhoDetalhes' => $this->_carrinhoDetalhado(),
        ];
    }//init layout


    //Monta menu lateral
    public function _montaMenuLateral(){
        $modelCategorias = new Categoria();
        $listaCategoriasPai = $modelCategorias->where(['ativo'=>1,'tipo'=>1])->orderBy('nome')->get();

        $arrayMenu = [];
        foreach ($listaCategoriasPai as $menu) {
            $verifSubmenu = $modelCategorias->where(['ativo'=>1,'id_cat_pai'=>$menu->id])->orderBy('nome')->get();

            //Submenus
            $arrSubmenu = [];
            if($verifSubmenu->count()>0){
                foreach ($verifSubmenu as $submenu){
                    $arrSubmenu[$submenu->nome] = [
                        'id' => $submenu->id,
                        'nome'=> $submenu->nome,
                        'tipo'=> $submenu->tipo
                    ];//arr submenu
                }//foreach submenu
            }//if submenu

            //menu
            $arrayMenu[$menu->nome] = [
                'id' => $menu->id,
                'nome'=> $menu->nome,
                'tipo'=> $menu->tipo,
                'submenu' => $arrSubmenu
            ];//arr menu
        }//foreach

        return $arrayMenu;
    }//menu lateral

    //Últimos Produtos cadastrados
    public function _ultimosProdutos(){
        $modelProdutos = new Produto();
        $listaProds = $modelProdutos->where(['ativo'=>1])->orderBy('created_at','Desc')->take(8)->get();

        $arrayProds=[];
        foreach ($listaProds as $prod){
            $arrayProds[] =[
                'id'=> $prod->id,
                'nome'=> $prod->nome,
                'preco'=> 'R$ '.number_format($prod->preco,2,',','.'),
                'img'=>'img-up/'.$prod->url_imagem,
            ];
        }//foreach array prods
        return $arrayProds;
    }//ultimos produtos


    //Toda a lista de Produtos ativos
    public function _listaProdutos(){
        $modelProdutos = new Produto();
        $listaProds = $modelProdutos->where(['ativo'=>1])->get();
        $modelCaracteristicas = new Caracteristica();

        $arrayProds=[];
        foreach ($listaProds as $prod){
            //Verifica as características vinculadas ao produto
            $dadosVincCarac = $modelProdutos->vinculoProdCaracPsq('id_prod',$prod->id);
            $caracteristicas='';
            if($dadosVincCarac!=null){
                foreach($dadosVincCarac as $carac){
                    $dadosCaracteristicas = $modelCaracteristicas->where(['id'=>$carac->id_carac])->first();

                    if($dadosCaracteristicas!=null)
                        $caracteristicas .= $dadosCaracteristicas->nome.' / ';
                }//foreach lista caracteristicas
            }//if caracteristicas

            $arrayProds[] =[
                'id'=> $prod->id,
                'nome'=> $prod->nome,
                'preco'=> 'R$ '.number_format($prod->preco,2,',','.'),
                'img'=>'img-up/'.$prod->url_imagem,
                'desc'=>$prod->descricao,
                'caracteristicas' => $caracteristicas
            ];
        }//foreach array prods

        return $arrayProds;
    }//lista produtos


    //Retorna os dados de link do carrinho - Menu lateral
     public function _linkCarrinho(){
        $modelCarrinho = new Carrinho();
        $dadosCarrinho = $modelCarrinho->where(['id_user'=>Auth::id(),'status'=>1])->first();

        return [
            'id' => $dadosCarrinho!=null?$dadosCarrinho->id:'',
            'totalParcial' =>$dadosCarrinho!=null?$this->__convertPrecoTOUser($dadosCarrinho->total):'0,00',
        ];
     }//link do carrinho


    //Carrinho de compras atual detalhado - Lista
    public function _carrinhoDetalhado(){
        $modelCarrinho = new Carrinho();
        $modelListaCar = new ListaCarrinho();
        $modelProduto = new Produto();

        //Array de retorno
        $retorno =[];

        //busca o último carrinho ativo
        $dadosCarrinhoAtual = $modelCarrinho->where(['id_user'=>Auth::id(),'status'=>1])->first();
        if($dadosCarrinhoAtual!=null){
            $retorno['carrinho'] = [
                'id' => $dadosCarrinhoAtual->id,
                'total'=> $this->__convertPrecoTOUser($dadosCarrinhoAtual->total),
            ];

            //Verifica listaCarrinho
            $dadosListaCarrinho = $modelListaCar->where(['id_carrinho'=>$dadosCarrinhoAtual->id])->get();
            $totalItens = 0;//tottal de itens no carrinho
            if($dadosListaCarrinho!=null){
                $aux = [];
                foreach($dadosListaCarrinho as $list){
                    $dadosProduto = $modelProduto->find($list->id_prod);

                    $aux[] = [
                        'id_lista' =>   $list->id,
                        'qde'      =>   $list->qde,
                        'preco'    =>   $this->__convertPrecoTOUser($list->preco),
                        'preco_total'=> $this->__convertPrecoTOUser($list->preco_total),
                        'id_prod'    => $dadosProduto!=null?$dadosProduto->id:'',
                        'nome'       => $dadosProduto!=null?$dadosProduto->nome:'',
                        'img'        => $dadosProduto!=null?$this->_storagePath.$dadosProduto->url_imagem:'',
                    ];

                    $totalItens += $list->qde;
                }//foreach

                if(count($aux)>0)
                    $retorno['carrinho']['lista'] = $aux;

                $retorno['carrinho']['totalItens'] = $totalItens;
            }//if lista carinho
        }//if possui carrinho

        return $retorno;
    }//Carrinho detalhado = Lista




    /*
     * FUNÇÕES AUXILIARES     *
     */
    public function __convertPrecoTOBD($preco){
        return number_format(str_replace(',','.',str_replace('.','',$preco)),2,'.','');
    }///_preco to BD
    public function __convertPrecoTOUser($preco){
        return number_format($preco,2,',','.');
    }///_preco to BD


}//class
