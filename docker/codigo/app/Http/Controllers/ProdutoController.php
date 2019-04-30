<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Caracteristica;
use App\Models\Produto;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller{
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
        return view('produto.index',['dadosPessoais'=>$this->_dadosPessoais]);
    }//index action

    //TELA - Novo / Editar registro
    public function tela(Request $request){
        $this->_init();
        $modelRegistro = new Produto();

        //Verifica se possui dados para ediçao
        if(isset($request->id) && $request->id!=null){
            $dadosRegistro = $modelRegistro->where(['id'=>$request->id])->first();

            //Pesquisa vinculos
            $vincCarac = $modelRegistro->vinculoProdCaracPsq('id_prod',$request->id);//Caracteristicas
            $aCarac = [];
            foreach ($vincCarac as $carac){
                $aCarac []= $carac->id_carac;
            }//foreach carac

            $vincCateg = $modelRegistro->vinculoProdCategPsq('id_prod',$request->id);//Categorias
            $aCateg = [];
            foreach ($vincCateg as $dados){
                //$aCateg []=  $dados->id_categ.'_'.$dadosCateg->nome;
                $aCateg []=$dados->id_categ;
            }//foreach categ

            //Verificando a imagem
            if($dadosRegistro->url_imagem!=''){
                $dadosRegistro->url_imagem = $this->_storagePath.$dadosRegistro->url_imagem;//->get($this->_storagePath.$dadosRegistro->url_imagem);

                //Storage::setVisibility($this->_storagePath.$dadosRegistro->url_imagem, 'public');
                //$dadosRegistro->url_imagem = Storage::getVisibility($this->_storagePath.$dadosRegistro->url_imagem);

            }//if iiamge url

        }else{
            $dadosRegistro = [];
            $aCarac = [];
            $aCateg = [];
        }//if / else dados

        return view('produto.tela-registro',[
            'dadosPessoais'=>$this->_dadosPessoais,
            'dadosRegistro' => $dadosRegistro,
            'vinCarac' =>implode(',',$aCarac),
            'vinCateg' => implode(',',$aCateg),
        ]);//return to view
    }//novo Action

    //CADASTRAR  / EDITAR -registro
    public function salvar(Request $request){
        $erro = 0;
        $msg = '';
        $modelRegistro = new Produto();

        //cadastra Novo
        $aCadastro = [
            'nome'       => $request->nome,
            'ativo'      => $request->ativo=='on'?1:2,
            'preco'      => number_format(str_replace(',','.',str_replace('.','',$request->preco)),2,'.',''),
            //'url_imagem' => $request->nome,
            'descricao'  => $request->descricao,
            //itens para Vincular
            'caracteristicas' => $request->caracteristicas!=''?explode(',',$request->caracteristicas):null,
            'categorias' => $request->categorias!=''?explode(',',$request->categorias):null,
            'foto' => $request->imgProfile,
        ];//aCadastro

        $flag = '';
        if($request->id!=null){
            $aCadastro['id'] = $request->id;
            $flag = 'edit';
        }//if id

        $idRegistro = $modelRegistro->salvarDados($aCadastro);
        if($idRegistro!=false){
            //Verifica as vinculaçoes
            //Caracteristicas
            $dbCarac = '';
            if($aCadastro['caracteristicas']!=null){
                $delVinculos = $modelRegistro->vinculoProdCaracDelete($idRegistro);

                foreach ($aCadastro['caracteristicas'] as $id){
                    $dbCarac = $modelRegistro->vinculoProdCarac($idRegistro,$id);
                }//foreach
            }//Caracteristicas

            $dbCateg = '';
            if($aCadastro['categorias']!=null){
                $delVinculos2 = $modelRegistro->vinculoProdCategDelete($idRegistro);

                foreach ($aCadastro['categorias'] as $id){
                    $dbCateg = $modelRegistro->vinculoProdCateg($idRegistro,$id);
                }//foreach
            }//Categoria

            if($dbCarac==false || $dbCateg==false){
                $erro = 1;
                $msg  = 'Erro ao adicionar dados do produto [Caracteristica ou Categorias]';
            }else{
                //Add a imagem do produto caso possua
                if($request->hasFile('imgProfile') && $request->file('imgProfile')->isValid()){
                    //Imagem válida faz o upload
                    $ext = $request->imgProfile->extension();//Extensão arquivo
                    $nomeImagem = $idRegistro.'.'.$ext;

                   //Faz o upload utilziabndo o storage do laravel
                    //$upload = $request->file('imgProfile')->storeAs('public',$nomeImagem);
                    $upload = $request->file('imgProfile')->move(public_path('img-up'),$nomeImagem);

                    if(!$upload){
                        $erro = 1;
                        $msg  = 'Erro ao fazer upload da Imagem.';
                    }else{
                        //Atualiza o nome da Imagem no perfil do produto
                        $dadosRegistroImg = $modelRegistro->where(['id'=>$idRegistro])->first();
                        $dadosRegistroImg->url_imagem = $nomeImagem;
                        $dadosRegistroImg->save();
                    }//if upload
                }//if imagem

                if($erro==0){
                    $msg  = 'Registro '.($flag=='edit'?'editado':'cadastrado').' com sucesso!';
                }
            }//if / else finaliza CRUD
        }else{
            $erro = 1;
            $msg  = 'Erro ao '.($flag=='edit'?'editar':'cadastrar').' dados!';
        }//if /else salvar dados

        $url = '/produto';
        $url .= ($idRegistro!=false ? '/'.$idRegistro:'');

        Session::flash('msg',$msg);
        return redirect($url)->with('error',$erro);
    }//Cadastrar action

    /************************************
     ** Funçoes Relacionadas ao AJAX ****
     ************************************/

    //Ajax de dados para a montagem da grid
    public function ajaxGrid(Request $request){
        $modelRegistro = new Produto();
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
        //$listaPaginada = $modelRegistro->count()>$itensPagina?$modelRegistro->forPage($page,$itensPagina):$listaregistros;
        $listaPaginada = $listaregistros;

        $listaDados = array();
        foreach ($listaPaginada as $lst){
            $listaDados[] = array(
                'nome'  => $lst->nome,
                'ativo' => $modelRegistro->_dscStatus[$lst->ativo],
                'preco' => 'R$ '.number_format($lst->preco,2,',','.'),
                'edit'  => '<a href="produto/'.$lst->id.'" title="Editar: '.$lst->nome.'"><i class="icon-edit"></i></a>'
            );
        }//foreach

        echo json_encode([
            'TotalRows' => $listaPaginada->count(),
            'Rows' => $listaDados
        ]);exit;
    }//AJax Grid

    //Deleta um registro
    public function delete(Request $request){
        $modelRegistro = new Produto();
        $dadosRegistroAtual = $modelRegistro->find($request->id);

        //Verificar as relaçoes do registro e deletar
        //Verifica os relaciomentos deste registro
        //Exclui imagem do item caso possua
        if($dadosRegistroAtual->url_imagem!='' && file_exists(public_path($this->_storagePath.$dadosRegistroAtual->url_imagem)))
            unlink(public_path($this->_storagePath.$dadosRegistroAtual->url_imagem));
        //Exclui as caracteriscas vinculadas
        $modelRegistro->vinculoProdCaracDelete($request->id);
        $modelRegistro->vinculoProdCategDelete($request->id);


        //Deleta o Item atual
        $dadosRegistroAtual->delete();

        echo json_encode(['erro'=>0,'msg'=>'Registro deletado e itens desvinculados com sucesso.']);
        exit;
    }//Ajax Delete

    //Visualiza os detalhes de um produto
    public function verRegistro(Request $request){
        $modelRegistro = new Produto();
        $dadosRegistroAtual = $modelRegistro->find($request->id);
        $retorno = [];

        //Ajuste url da imagem
        if($dadosRegistroAtual!=null && $dadosRegistroAtual->url_imagem!=''){
            $dadosRegistroAtual->url_imagem = $this->_storagePath.$dadosRegistroAtual->url_imagem;
        }//if dados imagem

        //Ajuste do preco
        $dadosRegistroAtual->preco = $this->__convertPrecoTOUser($dadosRegistroAtual->preco);

        $retorno['dadosPessoais'] = $this->_dadosPessoais;
        $retorno['dadosRegistro'] = $dadosRegistroAtual;
        $retorno['layout'] = $this->_initLayout();

        //Verifica se possui erro
        if(isset($request->error)){
            $erro =  $request->error;
            $retorno['error'] =$request->error;
        }//if set error

        return view('produto.detalhe-registro',$retorno);//return to view
    }//ver registro



}//Class
