<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UsuarioController extends Controller{
    private $_dadosPessoais;
    private $_authInstance;

    //Init Vars / Auth
    public function _init()  {
        $this->_authInstance = Auth::user();
        $this->_dadosPessoais = ['nome'=>$this->_authInstance->nome,'email'=>$this->_authInstance->email];

        //somente admins para acessar essa parte
        if($this->_authInstance->perfil!=1){
            return redirect()->route('home')->send();
        }//if
    }//Init Vars / Auth

    //Iniciando a View
    public function index(){
        $this->_init();
        return view('usuario.index',['dadosPessoais'=>$this->_dadosPessoais]);
    }//index action

    //TELA - Novo registro
    public function tela(Request $request){
        $this->_init();
        $modelRegistro = new User();

        //Verifica se possui categoria para ediçao
        if(isset($request->id) && $request->id!=null){
            $dadosRegistro = $modelRegistro->where(['id'=>$request->id])->first();
        }else{
            $dadosRegistro = [];
        }//if / else dados categoria

        //Perfil
        $arrayPerfil = $modelRegistro->_dscTipoPerfil;

        return view('usuario.tela-registro',[
            'dadosPessoais'=>$this->_dadosPessoais,
            'dadosPerfis'=> $arrayPerfil,
            'dadosRegistro' => $dadosRegistro,
        ]);//return to view
    }//novo Action

    //CADASTRAR  / EDITAR -registro
    public function salvar(Request $request){
        $erro = 0;
        $msg = '';
        $modelRegistro = new User();

        //cadastra Novo
        $aCadastro = [
            'nome'     => $request->nome,
            'email'    => $request->email,
            'ativo'    => $request->ativo=='on'?1:2,
            'perfil'   => $request->perfil==''?2:$request->perfil,
            'cep'      => $request->cep,
            'endereco' => $request->endereco,
            'password' => $request->password!=''?$request->password:''
        ];//aCadastro

        //Verifica se add ou edita
        $flag = '';
        if($request->id!=null){
            $aCadastro['id'] = $request->id;
            $flag = 'edit';
        }//if id

        $idRegistro = $modelRegistro->salvarDados($aCadastro);
        if($idRegistro!=false){
            $erro = 0;
            $msg  = 'Registro '.($flag=='edit'?'editado':'cadastrado').' com sucesso!';
        }else{
            $erro = 1;
            $msg  = 'Erro ao '.($flag=='edit'?'editar':'cadastrar').' dados!';
        }//if /else salvar dados

        $url = '/usuario';
        $url .= ($idRegistro!=false ? '/'.$idRegistro:'');

        Session::flash('msg',$msg);
        return redirect($url)->with('error',$erro);
    }//Cadastrar action




    /************************************
     ** Funçoes Relacionadas ao AJAX ****
     ************************************/

    //Ajax de dados para a montagem da grid
    public function ajaxGrid(Request $request){
        $modelRegistro = new User();
        $listaregistros = $modelRegistro->all();
        $totalLista = $listaregistros->count();

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
        //$listaPaginada = $modelRegistro->forPage($page,$itensPagina);
        $listaPaginada = $listaregistros;
        $i=0;//Controle de indices

        //dd($listaPaginada);
        $listaDados = array();
        foreach ($listaPaginada as $lst){
            $listaDados[] = array(
                'nome'  => $lst->nome,
                'email' => $lst->email,
                'ativo' => $modelRegistro->_dscSituacao[$lst->ativo],
                'perfil'=> $modelRegistro->_dscTipoPerfil[$lst->perfil],
                'edit'  => '<a href="usuario/'.$lst->id.'" title="Editar: '.$lst->nome.'"><i class="icon-edit"></i></a>'
            );
        }//foreach

        echo json_encode([
            'TotalRows' => $listaPaginada->count(),
            'Rows' => $listaDados
        ]);exit;
    }//AJax Grid

    //Deleta um registro
    public function delete(Request $request){
        $modelRegistro = new User();
        $dadosRegistroAtual = $modelRegistro->find($request->id);

        //Verificar as relaçoes do registro e deletar
        //Verifica os relaciomentos deste registro

        //Deleta o Item atual
        $dadosRegistroAtual->delete();

        echo json_encode(['erro'=>0,'msg'=>'Registro deletado e itens desvinculados com sucesso.']);
        exit;
    }//Ajax Delete

}//class
