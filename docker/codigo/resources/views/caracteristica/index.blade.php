@extends('welcome')
@extends('menu-lateral-admin');

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/caracteristicas/script.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            //Monta Grid
            scriptJS.grid();
        });
    </script>
@endsection

@section('conteudo')

    <div class="container">
        <!-- TITLE -->
        <div class="well well-small pagination-centered">
            <h3 class="themeTitle">Controle de Caracter&iacute;sticas</h3>
        </div>

        <!-- GRID -->
        <div id="grid-lista"></div>

    </div>

@endsection
