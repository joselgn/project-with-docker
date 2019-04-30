@extends('welcome') <!--Extende Layout Principal -->
@extends('menu-lateral') <!--Extende menu lateral -->
@extends('slide-produtos') <!--Extende Layout de ultimos produtos cadastrados -->

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/carrinhos/script.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>


@endsection

@section('conteudo')

    <!-- LISTA CARRINHO -->
    <div class="tab-content">

        <?php
            if(isset($layout['carrinhoDetalhes'])){
                $carrinhoDetalhes = $layout['carrinhoDetalhes'];
                //Possui carrinho
                if(isset($carrinhoDetalhes['carrinho'])){
                    $dadosCarrinho = $carrinhoDetalhes['carrinho'];
                    $totalItens = $dadosCarrinho['totalItens'];
                    $listaCarrinho = isset($dadosCarrinho['lista'])&&count($dadosCarrinho['lista'])>0?$dadosCarrinho['lista']:[];
                    $carrinhoId = $dadosCarrinho['id'];
                }else{
                    //Não posui carrinho cadastrado
                    $totalItens = 0;
                    $listaCarrinho = [];
                    $carrinhoId = '';
                }//if / else carrinho
            }else{
                //Não posui carrinho cadastrado
                $totalItens = 0;
                $listaCarrinho = [];
                $carrinhoId = '';
            }//if / else carrinho
        ?>


        <h3>
            CARRINHO DE COMPRAS   [ <small><span id="totalItensSpan">{{ $totalItens }}</span> Item(ns) </small>]
            <a href="{{ url('/') }}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continuar comprando </a>
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

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço R$</th>
                <th>Total R$</th>
            </tr>
            </thead>
            <tbody>

            <?php
                if(count($listaCarrinho)>0){
                    foreach($listaCarrinho as $item){
                        echo '<tr id="linha_'.$item['id_lista'].'"><td><img width="60" src="'.asset($item['img']).'" alt=""/></td>';
                        echo '<td>'.$item['nome'].'</td>';
                        echo '<td><div class="input-append">
                                  <input class="span1 disabled" disabled style="max-width:34px" placeholder="'.$item['qde'].'" id="appendedInputButtons_'.$item['id_lista'].'" size="16" type="text">
                                  <button class="btn" id="btn_m_'.$item['id_lista'].'" type="button" onclick="scriptJS.acaoItem('.$carrinhoId.','.$item['id_lista'].',\'m\')"><i class="icon-minus"></i></button>
                                  <button class="btn" id="btn_p_'.$item['id_lista'].'" type="button" onclick="scriptJS.acaoItem('.$carrinhoId.','.$item['id_lista'].',\'p\')"><i class="icon-plus"></i></button>
                                  <button class="btn btn-danger" type="button" onclick="scriptJS.acaoItem('.$carrinhoId.','.$item['id_lista'].',\'c\')"><i class="icon-remove icon-white"></i></button>
                              </div></td>';
                        echo '<td><div id="preco_'.$item['id_lista'].'">'.$item['preco'].'</div></td>';
                        echo '<td><div id="precototal_'.$item['id_lista'].'">'.$item['preco_total'].'</div></td></tr>';
                    }//foreach lista itens carrinho

                    //Calculando o preco final total
                    echo '<tr><td colspan="4" style="text-align: center;">Valor Total: R$ </td>';
                    echo '<td class="label label-important"><strong><div id="precofinal">'.$dadosCarrinho['total'].'</div></strong></td></tr>';

                }else{
                    echo '<tr><td colspan="5" style="text-align: center;">
                              <br>
                                Não possui nenhum item em seu carrinho de compras!
                              <br>
                          </td></tr>';
                }//if / else lista itens
            ?>
            </tbody>
        </table>


        <a href="{{ url('/') }}" class="btn btn-large pull-left"><i class="icon-arrow-left"></i> Continuar comprando </a>

         @if($carrinhoId!='')
            <a href="{{ url('/finalizar/'.$carrinhoId) }}" class="btn btn-large pull-right">Finalizar compra <i class="icon-arrow-right"></i></a>
         @endif

    </div>


@endsection
