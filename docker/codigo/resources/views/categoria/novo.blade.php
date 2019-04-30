@extends('welcome')
@extends('menu-lateral-admin');

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/categorias/script-cat.js') }}"></script>
@endsection

@section('conteudo')

    <div class="container">
        <!-- CATEGORIAS -->
        <div class="well well-small pagination-centered">
            <h3 class="themeTitle">Controle de Categorias</h3>
            <hr/>

            <!-- Formulario -->
            @if (session()->has('error'))
                @if (session()->get('error')=='1' && session()->has('msg'))
                    <div class="alert alert-danger">
                        <h3>Ocorreu um erro</h3>
                        {!! session()->get('msg') !!}
                    </div>
                @else
                    @if(session()->has('msg'))
                        <div class="alert alert-success">
                            <h3>{!! session()->get('msg') !!}</h3>
                        </div>
                    @endif
                @endif
            @endif

            <form class="form-horizontal alignL" id="formCategoria" name="formCategoria" method="POST" action="{{ url('/categoria') }}">
                @csrf

                <input type="hidden" id="id" name="id" value="<?php echo isset($dadosCategoria->id)?$dadosCategoria->id:'' ?>">

                <!-- NOME -->
                <div class="control-group">
                    <label class="label label-success alignL" for="nome" > Nome </label><br/>
                    <input id="nome" type="text" class="form-control{{ $errors->has('nome') ? '-is-invalid' : '' }}" name="nome" value="<?php echo isset($dadosCategoria->nome)?$dadosCategoria->nome:'' ?>" required autofocus placeholder="Nome">

                    @if ($errors->has('nome'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nome') }}</strong>
                    </span>
                    @endif
                </div>

                <!-- CATEGORIA PAI  -->
                <div class="control-group">
                    <label  class="label label-success" for="password">Categoria PAI</label><br/>
                    <select id="cat_pai_id" name="cat_pai_id" >
                        <option value="">Nenhuma opç&atilde;o escolhida</option>
                        <?php
                            if($listaCategorias->count()>0){
                                foreach ($listaCategorias as $lst){
                                    $selec = '';

                                    if(isset($dadosCategoria->id_cat_pai) && $dadosCategoria->id_cat_pai==$lst->id)
                                        $selec = 'selected';

                                    if(isset($dadosCategoria->id)){
                                        if($dadosCategoria->id != $lst->id)
                                            echo '<option value="'.$lst->id.'" '.$selec.'>'.$lst->nome.'</option>';
                                    }else
                                        echo '<option value="'.$lst->id.'" '.$selec.'>'.$lst->nome.'</option>';
                                }//foreach
                            }//count lista categorias
                        ?>
                    </select>
                </div>

                <!-- STATUS -->
                <div class="control-group">
                    <label class="label label-success alignL" for="status" > Status </label><br/>
                    <?php $checked = isset($dadosCategoria->ativo) ? ($dadosCategoria->ativo==1 ? 'checked' : ''):'' ?>
                    <input id="status" name="status" type="checkbox" <?=$checked?> class="form-control{{ $errors->has('status') ? '-is-invalid' : '' }}" placeholder="Status">
                    Ativo
                </div>

                <!-- BOTOES -->
                <div class="control-group">
                    <button type="submit" class="btn btn-primary">
                        <?php echo isset($dadosCategoria->id) ? 'Editar' : 'Cadastrar'; ?>
                    </button>

                    <?php
                        if(isset($dadosCategoria->id) && $dadosCategoria->id!=''){
                            echo '<button type="button" id="btnDelete" name="btnDelete" class="btn btn-danger">
                            <i class="icon-trash"></i> Excluir </button>';
                        }//if btn delete
                    ?>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            //Btn delete
            $('#btnDelete').on('click',function(){
                catJS.deleteCategoria();
            });//btn delete
        });//$.function
    </script>


@endsection
