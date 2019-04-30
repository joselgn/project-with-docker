@extends('welcome')
@extends('menu-lateral-admin');

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/produtos/script.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            //Carrega a combo de caracteristicas
            scriptJS.comboCaracteristicas();
            scriptJS.comboCategorias();

            //Alimentando Inputs
            $('#comboCaracteristicas').on('change', function (event){
                console.log('change');
                var checkedItems = "";
                var items = $(this).jqxListBox('getSelectedItems');
                $.each(items, function (index) {
                    checkedItems += this.value + ",";
                });
                $('#caracteristicas').val(checkedItems.slice(0, -1));
            });//alimenta Input
            $('#comboCategorias').on('change', function (event){
                 var checkedItems = "";
                 var items = $(this).jqxListBox('getSelectedItems');
                 $.each(items, function (index) {
                     checkedItems += this.value + ",";
                 });
                 $('#categorias').val(checkedItems.slice(0, -1));
            });//alimenta Input

            //Foto / imagem
            $("#imgProfile").change(function() {
                scriptJS.readURL(this);
            });//foto


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
            <h3 class="themeTitle">Controle de Produtos</h3>
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

            <form class="form-horizontal alignL span12" method="POST" action="{{ url('/produto') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" id="id" name="id" value="<?php echo isset($dadosRegistro->id)?$dadosRegistro->id:'' ?>">

                <!-- NOME -->
                <div class="control-group span5">
                    <label class="label label-success alignL" for="nome" > Nome </label><br/>
                    <input id="nome" type="text" class="form-control{{ $errors->has('nome') ? '-is-invalid' : '' }} span5" name="nome" value="<?php echo isset($dadosRegistro->nome)?$dadosRegistro->nome:'' ?>" required autofocus placeholder="Nome">

                    @if ($errors->has('nome'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nome') }}</strong>
                    </span>
                    @endif
                </div>

                <!-- ATIVO -->
                <div class="control-group  span5">
                    <label class="label label-success alignL" for="ativo" > Status </label><br/>
                    <?php $checked = isset($dadosRegistro->ativo) ? ($dadosRegistro->ativo==1 ? 'checked' : ''):'' ?>
                    <input id="ativo" name="ativo" type="checkbox" <?=$checked?> class="form-control{{ $errors->has('ativo') ? '-is-invalid' : '' }}" placeholder="Status">
                    Ativo
                </div>


                <!-- PREÇO -->
                <div class="control-group  span5">
                    <label class="label label-success alignL" for="preco" > Preço </label><br/>
                    R$ <input id="preco" name="preco" type="text" class="form-control{{ $errors->has('ativo') ? '-is-invalid' : '' }} span4" value="<?php echo isset($dadosRegistro->preco) ? number_format($dadosRegistro->preco,2,',','.'): '' ?>" required placeholder="Preço">

                    @if ($errors->has('preco'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('preco') }}</strong>
                    </span>
                    @endif
                </div>

                <!-- DESCRIÇAO -->
                <div class="control-group  span5">
                    <label class="label label-success alignL" for="descricao" > Descriç&atilde;o </label><br/>
                    <textarea id="descricao" name="descricao" class="alignL form-control{{ $errors->has('descricao') ? '-is-invalid' : '' }} span5" placeholder="Descriç&atilde;o"><?php echo isset($dadosRegistro->descricao) ? trim($dadosRegistro->descricao) : '' ?></textarea>

                    @if ($errors->has('preco'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('preco') }}</strong>
                    </span>
                    @endif
                </div>

                <!-- CARACTERISTICAS DO PRODUTO -->
                <div class="control-group  span5">
                    <label class="label label-success alignL" for="caracteristicas" > Caracter&iacute;sticas </label><br/>
                    <div style="margin-top: 5px;" id="comboCaracteristicas" title="Digite para começar ou clique na seta ao lado!"></div>
                    <input type="hidden" id="caracteristicas" name="caracteristicas" value="">
                    <input type="hidden" id="valuesCarac" name="valuesCarac" value="<?= !empty($vinCarac)?$vinCarac:'' ?>">
                </div>

                <!-- CATEGORIAS DO PRODUTO -->
                <div class="control-group  span5">
                    <label class="label label-success alignL" for="categorias" > Categorias </label><br/>
                    <div style="margin-top: 5px;" id="comboCategorias"></div>
                    <input type="hidden" id="categorias" name="categorias"  value="">
                    <input type="hidden" id="valuesCateg" name="valuesCateg" value="<?= !empty($vinCateg)?$vinCateg:'' ?>">
                </div>

                <!-- IMAGEM DO PRODUTO -->
                <div class="control-group  span5">
                    <label class="label label-success alignL" for="img" > Imagem </label><br/>
                    <input type='file' id="imgProfile" name="imgProfile"/>
                </div>

                <!-- IMAGEM DO PRODUTO -->
                <div class="control-group  span5">
                    <img id="foto" src="<?php echo isset($dadosRegistro->url_imagem)?asset($dadosRegistro->url_imagem):'#'?>" alt="Pré Visualização da Foto" />
                </div>


                <!-- BOTOES -->
                <div class="control-group span12">
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
