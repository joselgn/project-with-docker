@extends('welcome')
@extends('menu-lateral-admin');

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/usuarios/script.js') }}"></script>
@endsection

@section('conteudo')

    <div class="container">
        <!-- GRID -->
        <div class="well well-small pagination-centered">
            <h3 class="themeTitle">Controle de Usu&aacute;rios</h3>
        </div>

        <!-- GRID -->
        <div id="grid-usuarios"></div>

    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            //Monta Grid
            userJS.grid();
        });
    </script>

@endsection
