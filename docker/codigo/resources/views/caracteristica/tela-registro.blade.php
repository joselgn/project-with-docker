@extends('welcome')
@extends('menu-lateral-admin');

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/caracteristicas/script.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            //Btn delete
            $('#btnDelete').on('click',function(){
                scriptJS.delete();
            });//btn delete
        });//$.function
    </script>
@endsection

@section('conteudo')

    <div class="container">
        <!-- CATEGORIAS -->
        <div class="well well-small pagination-centered">
            <h3 class="themeTitle">Controle de Caracter&iacute;sticas</h3>
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

            <form class="form-horizontal alignL" method="POST" action="{{ url('/caracteristica') }}">
                @csrf

                <input type="hidden" id="id" name="id" value="<?php echo isset($dadosRegistro->id)?$dadosRegistro->id:'' ?>">

                <!-- NOME -->
                <div class="control-group">
                    <label class="label label-success alignL" for="nome" > Nome </label><br/>
                    <input id="nome" type="text" class="form-control{{ $errors->has('nome') ? '-is-invalid' : '' }}" name="nome" value="<?php echo isset($dadosRegistro->nome)?$dadosRegistro->nome:'' ?>" required autofocus placeholder="Nome">

                    @if ($errors->has('nome'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nome') }}</strong>
                    </span>
                    @endif
                </div>

                <!-- ATIVO -->
                <div class="control-group">
                    <label class="label label-success alignL" for="ativo" > Status </label><br/>
                    <?php $checked = isset($dadosRegistro->ativo) ? ($dadosRegistro->ativo==1 ? 'checked' : ''):'' ?>
                    <input id="ativo" name="ativo" type="checkbox" <?=$checked?> class="form-control{{ $errors->has('ativo') ? '-is-invalid' : '' }}" placeholder="Status">
                    Ativo
                </div>

                <!-- BOTOES -->
                <div class="control-group">
                    <button type="submit" class="btn btn-primary">
                        <?php echo isset($dadosRegistro->id) ? 'Editar' : 'Cadastrar'; ?>
                    </button>

                    <?php
                        if(isset($dadosRegistro->id) && $dadosRegistro->id!=''){
                            echo '<button type="button" id="btnDelete" name="btnDelete" class="btn btn-danger">
                            <i class="icon-trash"></i> Excluir </button>';
                        }//if btn delete
                    ?>
                </div>
            </form>
        </div>
    </div>




@endsection
