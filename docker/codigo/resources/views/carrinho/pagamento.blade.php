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
        });
    </script>


@endsection

@section('conteudo')

    <!-- CARRINHO -->
    <div class="tab-content">

        <?php

            if(isset($dados)){
                $nuPedido = $dados['nuPedido'];
                $totalValor = $dados['valorTotal'];
            }else{
                $nuPedido = '';
                $totalValor = '0,00';
            }//if / else carrinho
        ?>

        <h3>
            PEDIDO  #{{ $nuPedido  }} no total de <span style="color: #2ba949;"><b>R$ {{ $totalValor }}</b></span> FINALIZADO !!!
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
            <span class="badge badge-warning pull-left">Processando pagamento</span><br/><br/>

            <div class="progress progress-striped active">
                <div class="bar" style="width: 99%;"></div>
            </div>
        </div>



    </div>


@endsection
