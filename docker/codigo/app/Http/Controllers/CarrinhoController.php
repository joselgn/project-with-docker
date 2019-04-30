<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

//Models
use App\Models\User;
use App\Models\Produto;
use App\Models\Carrinho;
use App\Models\ListaCarrinho;

class CarrinhoController extends Controller{
    private $_dadosPessoais;
    private $_authInstance;

    //Init Vars
    public function _init()  {
        $this->_authInstance = Auth::user();
        $this->_dadosPessoais = ['nome'=>$this->_authInstance->nome,'email'=>$this->_authInstance->email];
    }//Init Vars

    //Iniciando a View
    public function index(){
        $this->_init();
        return view('carrinho.index',
            [
                'dadosPessoais'=>$this->_dadosPessoais,
                'layout' => $this->_initLayout(),
            ]);
    }//index action

    public function comprar(Request $request){
        $modelCarrinho = new Carrinho();
        $modelListaCarrinho = new ListaCarrinho();
        $modelProduto = new Produto();

        $erro = 0;
        $msg = '';

        //Verifica se o produto eh valido
        $dadosProduto=$modelProduto->find($request->id);
        if($dadosProduto!=null){
            //Verifica se o usuário possui um carrinho ativo
            $dadosCarrinho = $modelCarrinho->where(['id_user'=>Auth::id(),'status'=>1])->first();
            if($dadosCarrinho==null){
                //cria novo carrinho
                $novoCarrinho = new Carrinho();
                $idCarrinho = $novoCarrinho->salvarDados([
                        'id_user' => Auth::id()
                ]);
                $dadosCarrinho =  $modelCarrinho->find($idCarrinho);
            }//if dados carrinho

            //já possui o carro de compras add o produto no carrinho
            $qde = isset($request->qde)?$request->qde:1;
            //Verifica se ja possui o item na lista
            $dadosLista = $modelListaCarrinho->where(['id_carrinho'=>$dadosCarrinho->id,'id_prod'=>$dadosProduto->id])->first();
            if($dadosLista!=null){
                //Faz update
                $qdeAtual = $dadosLista->qde+1;
                $dadosLista->qde = $qdeAtual;
                $dadosLista->preco_total = ($qdeAtual*$dadosLista->preco);

                $novaCompra = $dadosLista->save();
            }else{
                //item novo add
                $novaCompra = $modelListaCarrinho->salvarDados(
                    [
                        'carrinho'=>$dadosCarrinho->id,
                        'produto'=>$dadosProduto->id,
                        'preco'=>$dadosProduto->preco,
                        'qde'=>$qde,
                        'total'=> ($qde*$dadosProduto->preco)
                    ]
                );
            }//if / else itens

            if($novaCompra){
                $msg = 'Produto ['.$dadosProduto->nome.']x'.$qde.' adicionado ao carrinho.';

                //Atualiza o total do carrinho
                $dadosCarrinho->total = $dadosCarrinho->total +  ($qde*$dadosProduto->preco);
                $dadosCarrinho->save();
            }else{
                $erro = 1;
                $msg  = 'Erro ao adicionar o produto ao carrinho.';
            }//if / else compra

        }else{
            $erro =1;
            $msg = 'Erro ao comprar o produto. Produto inválido e/ou indisponível.';
        }//if / else produto

        Session::flash('msg',$msg);
        if($erro==1){
            return redirect('/ver-produto/'.$request->id.'/'.$erro)->with('error',$erro);
        }else{
            return redirect('/carrinho/'.$dadosCarrinho->id);
        }//if / else adicionar produto
    }//comprar action


    //Finalizando compra
    public function telaFinalizaCompra(Request $request){
        $this->_init();
        $modelCarrinho = new Carrinho();
        $modelUsuario  = new User();
        $modelListaCarrinho = new ListaCarrinho();

        //Dados de retorno
        $retorno=[];

        //Dadops do usuario
        $dadosUsuario = $modelUsuario->where(['id'=>Auth::id()])->first();
        //dd($dadosUsuario);

        $endereco = $dadosUsuario->endereco!=null&&$dadosUsuario->endereco!=''?($dadosUsuario->cep!=null?'CEP: '.$dadosUsuario->cep.' - ':'').$dadosUsuario->endereco :'';//endereço

        //Verificando os dados do carrinho
        if(isset($request->id)){
            $dadosCarrinho = $modelCarrinho->where(['id'=>$request->id])->first();
        }else{
            $dadosCarrinho = $modelCarrinho->where(['id_user'=>Auth::id(),'ativo'=>1])->first();
        }//if id

        //Verifica se o carrinho possui itens para compra
        $dadosListaCarrinho = $dadosCarrinho!=null?$modelListaCarrinho->where(['id_carrinho'=>$dadosCarrinho->id])->get():null;
        $qdeItens = 0;
        if($dadosListaCarrinho!=null){
            //Vertifica qde de itens

            foreach ($dadosListaCarrinho as $list){
                $qdeItens += $list->qde;
            }//foreach

            $retorno['carrinho']= [
                'id' => $dadosCarrinho!=null?$dadosCarrinho->id:'',
                'vlTotal' => $this->__convertPrecoTOUser($dadosCarrinho->total),
                'itensTotal' => $qdeItens,
                'endereco' => $endereco,
            ];
        }//if dados lista carrinho

        if($qdeItens==0||$dadosCarrinho==null)
            return redirect('/');

        return view('carrinho.finaliza',
            [
                'dadosPessoais'=>$this->_dadosPessoais,
                'layout' => $this->_initLayout(),
                'dados' => $retorno,
            ]);
    }//finaliza compra action

    //tela de pagamento do carrinho
    public function telaPagamento(Request $request){
        $modelCarrinho = new Carrinho();
        $dadosCarrinho = $modelCarrinho->where(['id'=>$request->id])->first();

        if(!isset($request->id)||$dadosCarrinho==null)
            return redirect('/');

        return view( 'carrinho.pagamento',[
            'dadosPessoais'=>$this->_dadosPessoais,
            'layout' => $this->_initLayout(),
                'dados' =>[
                    'nuPedido' => $dadosCarrinho->id,
                    'valorTotal' => $dadosCarrinho->total,
                ]//dados
        ]);
    }//tela pagamento action



    /********************************
     ****** Funções AJAX ************
     *******************************/
    public function ajaxItem(Request $request){
        $modelCarrinho = new Carrinho();
        $modelLista = new ListaCarrinho();
        $return = [];
        $acoes  = ['p','c','m'];
        $erro = 0;
        $msg  ='';

        $dadosCarrinho = $modelCarrinho->where(['id'=>$request->id_carrinho])->first();
        $dadosLista = $modelLista->where(['id_carrinho'=>$request->id_carrinho,'id'=>$request->id])->first();
        //Verifica se possui os dados solicitado
        if($dadosLista!=null && in_array($request->acao,$acoes) && $dadosCarrinho!=null){
            //Retirando item
            if($request->acao == 'm'){
                if($dadosLista->qde == 0)
                    $erro = 1;
                else{
                    $qde = 1;

                    $resto = ($dadosLista->qde-$qde);
                    $totalAtualLista = $dadosLista->preco_total;

                    //upload da lista
                    $dadosLista->qde = $resto;
                    $dadosLista->preco_total = ($resto*$dadosLista->preco);
                    $dadosLista->save();

                    //upload do carrinho
                    $difValor = ($totalAtualLista - $dadosLista->preco_total);
                    $dadosCarrinho->total = ($dadosCarrinho->total - $difValor);
                    $dadosCarrinho->save();

                    //calcula a nova quantidade de itens do carrinho
                    $listaTotalCarrinho = $modelLista->where(['id_carrinho'=>$dadosCarrinho->id])->get();
                    $contaTotal = 0;
                    foreach($listaTotalCarrinho as $lst){
                        $contaTotal += $lst->qde;
                    }


                    $return['acao'] = 'm';
                    $return['qde'] = $resto;
                    $return['id'] = $dadosLista->id;
                    $return['valorLista'] = $this->__convertPrecoTOUser($dadosLista->preco_total);
                    $return['valorTotal'] = $this->__convertPrecoTOUser($dadosCarrinho->total);
                    $return['itensCarrinho'] = $contaTotal;
                }//if quantidade -1
            }//acao retirar item

            //Adicionando 1 item
            if($request->acao=='p'){
                $qde = 1;
                $dif= ($dadosLista->qde+$qde);
                $totalAtualLista = $dadosLista->preco_total;

                //upload da lista
                $dadosLista->qde = $dif;
                $dadosLista->preco_total = ($dif*$dadosLista->preco);
                $dadosLista->save();

                //upload do carrinho
                $dadosCarrinho->total = ($dadosCarrinho->total+$dadosLista->preco);
                $dadosCarrinho->save();

                //calcula a nova quantidade de itens do carrinho
                $listaTotalCarrinho = $modelLista->where(['id_carrinho'=>$dadosCarrinho->id])->get();
                $contaTotal = 0;
                foreach($listaTotalCarrinho as $lst){
                    $contaTotal += $lst->qde;
                }

                $return['acao'] = 'p';
                $return['qde'] = $dif;
                $return['id'] = $dadosLista->id;
                $return['valorLista'] = $this->__convertPrecoTOUser($dadosLista->preco_total);
                $return['valorTotal'] = $this->__convertPrecoTOUser($dadosCarrinho->total);
                $return['itensCarrinho'] = $contaTotal;
            }//if Add 1 item

            //Cancela/Exclui item(ns) do carrinho
            if($request->acao=='c'){
                $qde = $dadosLista->qde;
                $valorRemover = $dadosLista->preco_total;

                //calcula a nova quantidade de itens do carrinho
                $listaTotalCarrinho = $modelLista->where(['id_carrinho'=>$dadosCarrinho->id])->get();
                $contaTotal = 0;
                if($listaTotalCarrinho!=null){
                    foreach($listaTotalCarrinho as $lst){
                        $contaTotal += $lst->qde;
                    }//foreach
                }//if

                //Valor para remover do carrinho
                $vlrRemove = ($dadosCarrinho->total-$valorRemover);


                $return['acao'] = 'c';
                $return['qde'] = $qde;
                $return['id'] = $dadosLista->id;
                $return['valorLista'] = $this->__convertPrecoTOUser($valorRemover);
                $return['valorTotal'] = $this->__convertPrecoTOUser($vlrRemove);
                $return['itensCarrinho'] = ($contaTotal-$qde);

                $dadosLista->delete();

                //upload do carrinho
                $dadosCarrinho->total = ($vlrRemove);
                $dadosCarrinho->save();
            }//if cancela/exlcui item lista
        }//if dados lista

        $return['erro']=$erro;
        $return['msg'] =$msg;

        return response()->json($return);
    }//ajax item

    //Atualizar endereco do usuario
    public function atualizar(Request $request){
        $erro =0;
        $modelCarrinho = new Carrinho();
        $modelUsuario = new User();

        $dadosCarrinho = $modelCarrinho->where(['id'=>$request->id])->first();
        $dadosUsuario  = $modelUsuario->where(['id'=>Auth::id()])->first();

        if($dadosCarrinho==null||$request->endereco=='')
            $erro=1;

        if($erro==0){
            //Atualiza dados do usuario
            $dadosUsuario->endereco = $request->endereco;
            $dadosUsuario->save();
        }//if erro 0

        echo json_encode([
            'erro' => $erro,
            'endereco' => $dadosUsuario->endereco!=null?$dadosUsuario->endereco:'',
        ]);exit;
    }//ajax atualizar endereco

    //Finaliza pedido e envia para pagamento
    public function pagamento(Request $request){
        $erro =0;
        $id='';
        $modelCarrinho = new Carrinho();
        $dadosCarrinho = $modelCarrinho->where(['id'=>$request->id])->first();

        if($dadosCarrinho==null||$request->endereco=='')
            $erro=1;
        else{
            $id = $dadosCarrinho->id;
            $dadosCarrinho->entrega = $request->endereco;
            $dadosCarrinho->dt_finalizado = date('Y-m-d H:i:s');
            $dadosCarrinho->status = 2;
            $dadosCarrinho->save();
        }//if / else dados carrinho finaliza

        echo json_encode([
            'erro' => $erro,
            'id' => $id
        ]);exit;
    }//finalzia pedido e envia para pagamento

}//Class
