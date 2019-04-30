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
        </div>

        <!-- GRID CATEGORIAS -->
        <div id="grid-categoria"></div>

    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            //Monta Grid
            catJS.grid();
        });
    </script>

@endsection
