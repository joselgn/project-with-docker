@extends('welcome') <!--Extende Layout Principal -->
@extends('menu-lateral') <!--Extende menu lateral -->
@extends('slide-produtos') <!--Extende Layout de ultimos produtos cadastrados -->

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/carrinhos/script.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#btnManterEndereco').on('click',function(){
                scriptJS.manterEndereco();
            });
            $('#btnCadastrar').on('click',function(){
                scriptJS.cadastraEndereco();
            });
            $('#btnFinalizar').on('click',function(){
                scriptJS.finalizaPedido();
            });
        });
    </script>


@endsection

@section('conteudo')

    <!-- CARRINHO -->
    <div class="tab-content">

        <?php

            if(isset($dados)){
                $carrinho = $dados['carrinho'];
                $totalItens = $carrinho['itensTotal'];
                $totalValor = $carrinho['vlTotal'];
            }else{
                $carrinho=[];
                $totalItens = 0;
                $totalValor = 0;
            }//if / else carrinho
        ?>


        <h3>
            CARRINHO DE COMPRAS  [{{ $totalItens }} Item(ns)] no total de <span style="color: #2ba949;"><b>R$ {{ $totalValor }}</b></span>
        </h3>

        @if(session()->has('error'))
            <?php
                if($erro==1){
                    $class = 'danger';
                    $ttlMsg = 'Atenção!';
                    $msg = session()->get('msg');
                }else{
                    $class = 'success';
                    $ttlMsg = session()->get('msg');
                    $msg = '';
                }//if/else erro
            ?>
            <div class="alert alert-{{ $class }}">
                <h3>{{ $ttlMsg }}</h3>
                {{ $msg }}
            </div>
        @endif

        <hr class="soft"/>

        <div class="well well-small">
            <input type="hidden" id="pedido" name="pedido" value="{{ $carrinho['id'] }}"/>
            <span class="badge badge-warning pull-left">Endereço Cadastrado</span><br/><br/>
            <?php if(isset($carrinho['endereco']) && $carrinho['endereco']!=''){
                $endereco = $carrinho['endereco'];
            }else{
                $endereco = '';
            }//endereco?>

            <textarea class="input-xxlarge" disabled id="enderecoAtual" name="enderecoAtual" rows="3">{{ $endereco }}</textarea><br><br><br>
            @if(!empty($endereco))
                <button id="btnManterEndereco" name="btnManterEndereco" class="btn btn-primary">Manter mesmo endereço</button>
            @endif
            <br/><br/><br/>
            <span class="badge badge-warning pull-left">Endereço de Entrega</span><br/><br/>
            <div>
                CEP:<br> <input type="text" class="input-small" id="cep" name="cep" value=""/>
            </div>
            <div>
                Endereço: <br> <textarea class="input-xxlarge" id="endereco" name="endereco" rows="3"></textarea>
            </div>
            <div >
                <button id="btnCadastrar" name="btnCadastrar" class="btn btn-success">Atualizar endereço</button>
                <button id="btnFinalizar" name="btnFinalizar" class="btn btn-danger">Finalizar pedido</button>
            </div>
        </div>



    </div>


@endsection
