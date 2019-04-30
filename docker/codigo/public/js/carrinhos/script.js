var scriptJS = {
    acaoItem : function(idCarrinho,idLista,acao){
        //acao => p = Add 1 item / m => remove 1 item / c => cancela/exclui tods o item

        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: top.baseURL+'/ajax-carrinho-item',
            dataType: "json",
            data: {
                id_carrinho : idCarrinho,
                id          : idLista,
                acao        : acao
            },
            success: function (data) {
                var erro =data.erro;

                if(erro===0){
                    //Atualiza os campos html
                    switch (data.acao) {
                        case 'm':
                            $('#totalItensSpan').html(data.itensCarrinho);
                            $('#appendedInputButtons_'+data.id).val(data.qde);
                            $('#precototal_'+data.id).html(data.valorLista);
                            $('#precofinal').html(data.valorTotal);
                        break
                        case 'p':
                            $('#totalItensSpan').html(data.itensCarrinho);
                            $('#appendedInputButtons_'+data.id).val(data.qde);
                            $('#precototal_'+data.id).html(data.valorLista);
                            $('#precofinal').html(data.valorTotal);
                        break
                        case 'c':
                            $('#totalItensSpan').html(data.itensCarrinho);
                            $('#precofinal').html(data.valorTotal);
                            $('#linha_'+data.id).remove();
                        break
                    }//switch acao


                    if(data.valorTotal=='0,00')
                        window.location.href =top.baseURL+'/carrinho';
                    else
                        console.log('Vl Total: '+data.valorTotal);

                }//if erro

            }//success ajax
        });//AJAX
    },//acao itens
    manterEndereco : function(){
        var enderecoAtual = $('#enderecoAtual').val();
        $('#endereco').val(enderecoAtual);
    },
    cadastraEndereco : function(){
        var idcarrinho = $('#pedido').val();
        var endereco   = $('#endereco').val();

        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: top.baseURL+'/ajax-carrinho-atualiza-endereco',
            dataType: "json",
            data: {
                id          : idcarrinho,
                endereco    : endereco
            },
            success: function (data) {
                var erro = data.erro;

                if(erro==0){
                    $('#enderecoAtual').val(data.endereco);
                    alert('Endereço atualizado com sucesso!');
                }else{
                    alert('Endereço não atualizado!')
                }
            }//success
        });//AJAX
    },
    finalizaPedido : function(){
        var idcarrinho = $('#pedido').val();
        var endereco   = $('#endereco').val();

        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: top.baseURL+'/ajax-carrinho-finaliza-pedido',
            dataType: "json",
            data: {
                id          : idcarrinho,
                endereco    : endereco
            },
            success: function (data) {
                var erro = data.erro;

                if(erro==0){
                    window.location.href =top.baseURL+'/pagar/'+data.id;
                }else{
                    alert('Falha ao finalizar pedido!')
                }
            }//success
        });//AJAX
    },
};//JS
