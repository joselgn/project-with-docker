@extends('welcome')
@extends('menu-lateral');

@section('scripts')
    <script type="text/javascript" src="{{ asset('') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

        });//$.function
    </script>
@endsection

@section('conteudo')

    @if(session()->has('error'))
        <?php
            if($error==1){
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

    <div class="row">

        <?php
        if(isset($dadosRegistro)){
            echo '<div id="gallery" class="span3">';
            echo '<a href="'.asset($dadosRegistro->url_imagem).'" title="'.$dadosRegistro->nome.'"><img src="'.asset($dadosRegistro->url_imagem).'" style="width:100%" alt="'.$dadosRegistro->nome.'"/></a></div>';
            echo '<div class="span6"><h3>'.$dadosRegistro->nome.'</h3><hr class="soft"/>';
            echo '<a href="'.url("/comprar/".$dadosRegistro->id).'" class="btn btn-large btn-primary pull-right"> Comprar <i class=" icon-shopping-cart"></i></a>';
            echo '<hr class="soft"/><label class="btn btn-large btn-success disabled"><span>R$ '.$dadosRegistro->preco.'</span></label>';
            echo '<p>'.$dadosRegistro->descricao.'</p> <br class="clr"/><hr class="soft"/>';
            echo '<a href="'.url("/").'" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Voltar as compras </a></div>';

        }else{
                    echo '<div style="text-align:center;">Dados do registro não encontrados ou registro inexistente.<br><br><br><a href="'.url("/").'" class="btn btn-large"><i class="icon-arrow-left"></i> Voltar as compras </a></div>';
            }//if / else dados registro
        ?>

    </div>


@endsection
