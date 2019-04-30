@section('conteudo-slide-produtos')
    <div class="well well-small">
        <h4>Novos Produtos <small class="pull-right">+ Conheça nossas últimas novidades</small></h4>
        <div class="row-fluid">
            <div id="featured" class="carousel slide">
                <i class="tag"></i>
                <div class="carousel-inner">
                    <?php
                        if(isset($layout['lastProds'])){
                            $cont = 0;
                            echo '<div class="item active">';
                            foreach($layout['lastProds'] as $prod){
                                if($cont==0)
                                    echo '<ul class="thumbnails">';

                                echo '<li class="span3" style="height: 210px;"><div class="thumbnail">';
                                echo '<a href="'.url("/ver-produto/".$prod['id']).'" style="height: 120px;"><img src="'.asset($prod['img']).'" alt="" style="height: 120px;"></a>';
                                echo '<div class="caption"><h5>'.$prod['nome'].'</h5>';
                                echo '<h4 style="text-align: center;"><a class="btn" href="'.url("/ver-produto/".$prod['id']).'">+ Detalhes</a><br/><span  style="text-align: center;color: #00BCE1;">'.$prod['preco'].'</span></h4></div>';
                                echo '</div></li>';

                                $cont++;
                                if($cont%4==0){
                                    echo '</ul></div>';

                                    if(count($layout['lastProds'])>=$cont )
                                        echo '<div class="item">';

                                    $cont=0;
                                }
                            }//foreach prods
                            echo '</div>';
                        }else{
                            echo '<div>Nenhum novo produto cadastrado.</div>';
                        }//if else prods
                    ?>

                </div>
                <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featured" data-slide="next">›</a>
            </div>
        </div>
    </div>

@endsection
