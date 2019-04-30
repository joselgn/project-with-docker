@section('conteudo-menu-lateral')

    <!-- BOTAO ACESSO AO CARRINHO DE COMPRAS -->
    @if (Route::has('login'))
        @auth
            <?php
                $urlRedirect  = 'home';
                if(isset($layout['linkCarrinho'])){
                    $dadosLink = $layout['linkCarrinho'];
                    $idCarrinho = '/'.$dadosLink['id'];
                    $totalParcial = $dadosLink['totalParcial'];
                }else{
                    $idCarrinho='';
                    $totalParcial = '0,00';
                }
            ?>
            <div class="well well-small"><a id="myCart" href="{{ url('/carrinho'.$idCarrinho) }}">
                    <img src="{{ asset('libraries/bootstrap-shop/themes/images/ico-cart.png') }}" alt="cart"> Meu Carrinho <br/>
                    <span class="badge badge-warning pull-right">Total Parcial: R$ {{ $totalParcial }}</span></a>
            </div>
        @endauth
    @endif

    <!-- CATEGORIAS -->
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        <li style="cursor: pointer;"><a  href="{{ url('/') }}">Todas as Categorias<i class="icon-link"></i></a></li>

        <?php
            $url = isset($urlRedirect) ? $urlRedirect : 'menu';

            $menu = $layout['menu'];
            if(count($menu)>0){
                foreach($menu as $item){
                    if(count($item['submenu'])>0){
                        echo '<li class="subMenu" style="cursor: pointer;"><a>'.$item["nome"].'<i class="icon-chevron-down"></i></a>';
                            //Percorre submenus
                            echo '<ul style="display:none">';
                            echo '<li><a href="'.url('/'.$url.'/'.$item['id']).'"><i class="icon-chevron-right"></i>Todos desta Categoria<i class="icon-link"></i></a></li>';
                            foreach ($item["submenu"] as $submenu){
                                    echo '<li><a href="'.url('/'.$url.'/'.$submenu['id']).'"><i class="icon-chevron-right"></i>'.$submenu["nome"].'<i class="icon-link"></i></a></li>';
                            }//foreach submenu
                            echo '</ul>';
                        echo '</li>';//fecha menu
                    }else{
                        echo '<li><a href="'.url('/'.$url.'/'.$item['id']).'">'.$item["nome"].'<i class="icon-link"></i></a></li>';
                    }//if / else submenu
                }//foreach
            }else{
                echo '<li><a href="'.url('/').'">Sem categorias cadastradas <i class="icon-link"></i></li>';
            }//if / else categorias
        ?>
    </ul>
    <!-- CATEGORIAS END -->


@endsection
