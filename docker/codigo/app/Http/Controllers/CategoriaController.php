<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Categoria;

class CategoriaController extends Controller{
    private $_dadosPessoais;
    private $_authInstance;

    //Init Vars
    public function _init()  {
        $this->_authInstance = Auth::user();
        $this->_dadosPessoais = ['nome'=>$this->_authInstance->nome,'email'=>$this->_authInstance->email];

        //somente admins para acessar essa parte
        if($this->_authInstance->perfil!=1){
                return redirect()->route('home')->send();
        }//if
    }//Init Vars

    //Iniciando a View
    public function index(){
       $this->_init();
       return view('categoria.index',['dadosPessoais'=>$this->_dadosPessoais]);
    }//index action

    //Tela para adicionar nova categoria
    public function novo(Request $request){
        $this->_init();
        $modelCategoria = new Categoria();

        //Busca todas as categorias "PAI" ativas
        $listaCategorias = $modelCategoria->where([
            'ativo'=> 1, //Categorias ativas
            'tipo' => 1, //Apenas categorias - Nao retorna subcategorias
        ])->get();//lista categorias

        //Verifica se possui categoria para ediçao
        if(isset($request->id) && $request->id!=null){
            $dadosCategoria = $modelCategoria->where(['id'=>$request->id])->first();
        }else{
            $dadosCategoria = [];
        }//if /; else dados categoria

        return view('categoria.novo',[
            'dadosPessoais'=>$this->_dadosPessoais,
            'listaCategorias'=>$listaCategorias,
            'dadosCategoria' => $dadosCategoria,
        ]);//return to view
    }//novo Action


    //Cadastrar nova Categoria
    public function cadastrar(Request $request){
        $erro = 0;
        $msg = '';
        $modelCategoria = new Categoria();

        //cadastra Novo
        $aCadastro = [
            'nome'       => $request->nome,
            'status'     => $request->status=='on'?1:2,
            'id_cat_pai' => $request->cat_pai_id
        ];//aCadastro

       //Verifica se add ou edita
        $flag = '';
        if($request->id!=null){
            $aCadastro['id'] = $request->id;
            $flag = 'edit';
        }//if id

        $idRegistro = $modelCategoria->salvarDados($aCadastro);
        if($idRegistro!=false){
            $erro = 0;
            $msg  = 'Registro '.($flag=='edit'?'editado':'cadastrado').' com sucesso!';
        }else{
            $erro = 1;
            $msg  = 'Erro ao '.($flag=='edit'?'editar':'cadastrar').' dados!';
        }//if /else salvar dados

        $url = '/categoria';
        $url .= ($idRegistro!=false ? '/'.$idRegistro:'');

        Session::flash('msg',$msg);
        return redirect($url)->with('error',$erro);
    }//Cadastrar action


    /************************************
     ** Funçoes Relacionadas ao AJAX ****
     ************************************/

    //Ajax de dados para a montagem da grid
    public function ajaxGrid(Request $request){
        $modelCategoria = new Categoria();
        $listaCategorias = $modelCategoria->all();
        $totalLista = $listaCategorias->count();

        //Dados enviados da grid
        $sidx  = $request->sidx;//Índice a ser ordenado
        $sord  = $request->sord;//Tipo de ordenação do índice - Asc ou Desc
        $page  = isset($request->page) ? $request->page : 1;//Página atual
        $itensPagina = $request->rows==0?10:$request->rows;//Quantidade de Registros por página

        //Contagem de total de páginas...
        if($totalLista > 0){
            $total_pages = ceil($totalLista/$itensPagina);
        }else{
            $total_pages = 0;
        }//qde de paginas

        if($page > $total_pages)
            $page = $total_pages;

        //Preparando array Json com resposta para a grid
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $totalLista;

        //Pesquisa lista paginada
        $listaPaginada = $listaCategorias->forPage($page,$itensPagina);
        $i=0;//Controle de indices

        //dd($listaPaginada);
        $listaDados = array();
        foreach ($listaPaginada as $lst){
            //Dados Cat Pai
            if($lst->id_cat_pai != '')
                $dadosCatPai = $modelCategoria->find($lst->id_cat_pai);

            $listaDados[] = array(
                'nome'   => $lst->nome,
                'status' => $modelCategoria->_dscAtivo[$lst->ativo],
                'idPai'  => $lst->id_cat_pai!=''? ($dadosCatPai->count()>0 ? $dadosCatPai->nome :'' ) : '' ,
                'edit'   => '<a href="categoria/'.$lst->id.'" title="Editar categoria: '.$lst->nome.'"><i class="icon-edit"></i></a>'
            );
            $i++;
        }//foreach

        echo json_encode([
            'TotalRows' => $listaPaginada->count(),
            'Rows' => $listaDados
        ]);
        exit;
    }//AJax Grid

    //Busca uma lista de registros de acordo com uma condiçao
    public function ajaxBusca(Request $request){
        $condicoes = $request->all();
        $modelRegistros = new Categoria();

        //trata os campos passados
        $where = [];
        if(count($condicoes)>0){
            $camposPossiveis = $modelRegistros->getFillable();
            foreach($condicoes as $campo => $valor){
                if(in_array($campo,$camposPossiveis)){
                    if(!empty($valor))
                        $where[$campo]=$valor;
                }//if campos possiveis
            }//foreach array condicoes where
        }//if condicoes

        //Buscando Registros
        $listaRegistros = $modelRegistros->where($where)->orderBy('nome','ASC')->get();

        //Retorna label de identificaçao
        $retorno=[];
        foreach ($listaRegistros as $registro) {
            if($registro->tipo==1)
                $label = '';
            else{
                $dadosRegistro = $registro->id_cat_pai!='' ? $modelRegistros->where(['id'=>$registro->id_cat_pai])->first()->nome : '';
                $label = ' ~> SubCategoria de '.$dadosRegistro;
            }//if / else label subcategoria

            $retorno[]=[
                'id' => $registro->id,
                'nome'=> $registro->nome.''.$label,
            ];
        }//foreach
        echo json_encode($retorno);exit;
    }//Ajx Busca

    //Deleta uma categoria pelo id
    public function delete(Request $request){
        $modelCategoria = new Categoria();
        $dadosCategoriaAtual = $modelCategoria->find($request->id);

        //Verificar as relaçoes das categorias e deletar
        //Verifica se possui alguma categoria com este ID como PAI
        $catFilhos = $modelCategoria->where(['id_cat_pai'=>$dadosCategoriaAtual->id]);
        if($catFilhos->count()>0){
            $catFilhos->update(['id_cat_pai' => null,'tipo'=>1]);
        }//if cat filhos

        //Verifica os produtos relacionados a esta categoria e os remove desta categoria.


        //Deleta o Item atual
        $dadosCategoriaAtual->delete();

        Session::flash('msg','Categoria deletada e itens desvinculados com sucesso.');
        echo json_encode(['erro'=>0,'msg'=>'Categoria deletada e itens desvinculados com sucesso.']);
        exit;
    }//Ajax Delete

}//Class
