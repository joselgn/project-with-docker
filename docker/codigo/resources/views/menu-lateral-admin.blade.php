@section('conteudo-menu-lateral')

    <!-- CATEGORIAS -->
    <div class="well well-small pagination-centered">
        <h3 class="label label-warning ">MENU DE ADMINISTRADOR</h3>
    </div>

    <ul class="nav nav-tabs nav-stacked">
        <li class="subMenu open"><a> Meu Perfil  <i class="icon-arrow-right"></i> </a>
            <ul>
                <?php
                    echo '<li><a href="#"><i class="icon-user"></i>'.$dadosPessoais['nome'].'</a></li>';
                    echo '<li><a href="#"><i class="icon-envelope"></i>'.$dadosPessoais['email'].'</a></li>';
                ?>
            </ul>
        </li>
        <li class="subMenu"><a> Menu Usuarios  <i class="icon-arrow-right"></i> </a>
            <ul style="display:none">
                <li><a href="{{ url('/usuario') }}"><i class="icon-save"></i> Adicionar Usuario</a></li>
                <li><a href="{{ url('/lista-usuarios') }}"><i class="icon-list"></i> Visualizar Usuarios</a></li>
            </ul>
        </li>
        <li class="subMenu"><a> Menu Categoria  <i class="icon-arrow-right"></i> </a>
            <ul style="display:none">
                <li><a href="{{ url('/categoria') }}"><i class="icon-save"></i> Adicionar Categoria</a></li>
                <li><a href="{{ url('/lista-categoria') }}"><i class="icon-list"></i> Visualizar Categorias</a></li>
            </ul>
        </li>
        <li class="subMenu"><a> Menu Produtos  <i class="icon-arrow-right"></i> </a>
            <ul style="display:none">
                <li><a href="{{ url('/caracteristica') }}"><i class="icon-save"></i> Adicionar Caracter&iacute;sticas</a></li>
                <li><a href="{{ url('/lista-caracteristicas') }}"><i class="icon-list"></i> Visualizar Caracter&iacute;sticas</a></li>
                <li><a href="{{ url('/produto') }}"><i class="icon-save"></i> Adicionar Produto</a></li>
                <li><a href="{{ url('/lista-produtos') }}"><i class="icon-list"></i> Visualizar Produtos</a></li>
            </ul>
        </li>
        <li class="subMenu"><a> Menu Pedidos  <i class="icon-arrow-right"></i> </a>
            <ul style="display:none">
                <li><a href="{{ url('/home') }}"><i class="icon-list"></i> Gerenciar Pedidos </a></li>
            </ul>
        </li>

        <li><a href="{{ url('/home') }}">IN&Iacute;CIO <i class="icon-arrow-right"></i> </a></li>
    </ul>
    <!-- CATEGORIAS END -->


@endsection
