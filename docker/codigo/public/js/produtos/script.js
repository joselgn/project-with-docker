var scriptJS = {
    grid : function(){
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'ajax-produto-grid',
            dataType: "json",
            data: {},
            success: function (data) {
                var source = {
                    datatype: "json",
                    datafields: [
                        {name: 'nome',  type: 'string'},
                        {name: 'ativo', type: 'string'},
                        {name: 'preco', type: 'string'},
                        {name: 'edit',  type: 'number'}
                    ],
                    cache:false,
                    root:'Rows',
                    sort: function () {
                        // update the grid and send a request to the server.
                        $("#grid-lista").jqxGrid('updatebounddata', 'sort');
                    },
                    beforeprocessing: function (data) {
                        source.totalrecords = data.TotalRows;
                    },
                    localdata: data
                };//source

                var dataAdapter = new $.jqx.dataAdapter(source,{
                        //Set the http header before calling the api.
                        beforeSend: function (jqXHR, settings) {
                            jqXHR.setRequestHeader('X-CSRF-Token',$('meta[name="csrf-token"]').attr('content')); }
                });//data adapter

                $("#grid-lista").jqxGrid({
                    width:      '100%',
                    source:     dataAdapter,
                    pageable:   true,
                    autoheight: true,
                    sortable:   true,
                    altrows:    true,
                    virtualmode:false,
                    enabletooltips: true,
                    //viewrecords:true,
                    editable:   false,
                    filterable: true,
                    //selectionmode: 'multiplecellsadvanced',
                    localization: jqxJS.traduzir(),
                    showcolumnheaderlines: true,
                    rendergridrows: function (params) {
                        return params.data;
                    },
                    columns: [
                        {
                            text: 'Nome',
                            columngroup: 'title',
                            datafield: 'nome',
                            align: 'center',
                            cellsalign: 'left',
                            width: '40%'
                        },
                        {
                            text: 'Preço',
                            columngroup: 'title',
                            datafield: 'preco',
                            align: 'center',
                            cellsalign: 'center',
                            width: '25%'
                        }, {
                            text: 'Status',
                            columngroup: 'title',
                            datafield: 'ativo',
                            align: 'center',
                            cellsalign: 'center',
                            width: '25%'
                        },
                        {
                            text: 'Editar',
                            columngroup: 'title',
                            datafield: 'edit',
                            align: 'center',
                            cellsalign: 'center',
                            width: '10%'
                        }
                    ],
                    columngroups: [
                        {text: 'LISTA', align: 'center', name: 'title'}
                    ]
                });//grid
            }//success ajax
        });//AJAX
    },//start Grid
    delete : function(){
        var id = $('#id').val();

        if(confirm('Tem certeza que deseja deletar esse item?')) {
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: top.baseURL+'/ajax-produto-delete',
                dataType: "json",
                data: {
                    id : id,
                    _method:'delete'
                },
                success: function (data) {
                    var erro = data.erro;
                    var msg  = data.msg;

                    window.location='../lista-produtos'
                }//success
            });//AJAX
        }//if confirm
    },//delete
    comboCaracteristicas : function(){
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: top.baseURL+'/ajax-caracteristica-busca',
            dataType: "json",
            data: {
                ativo : 1
            },
            success: function (data) {
                var config = {
                    datatype: "json",
                    datafields: [
                        {name: 'nome',  type: 'string'},
                        {name: 'id',    type: 'number'}
                    ],
                    //cache:false,
                    //root:'Rows',
                    localdata: data
                };//config

                var source = new $.jqx.dataAdapter(config);
                $("#comboCaracteristicas").jqxListBox({
                    source: source, multiple: true, displayMember: "nome", valueMember: "id",width: 350, height: 400});

                //Populando as combobox
                var arrCarac =$("#valuesCarac").val().split(',');
                $(arrCarac).each(function(index,id){
                    var item = $("#comboCaracteristicas").jqxListBox('getItemByValue', id);
                    $("#comboCaracteristicas").jqxListBox('selectIndex',item.index) ;
                });
            }//success
        });//Ajax
    },//Combo Caracteristicas
    comboCategorias : function(){
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: top.baseURL+'/ajax-categoria-busca',
            dataType: "json",
            data: {
                ativo : 1
            },
            success: function (data) {
                var config = {
                    datatype: "json",
                    datafields: [
                        {name: 'nome',  type: 'string'},
                        {name: 'id',    type: 'number'}
                    ],
                    //cache:false,
                    //root:'Rows',
                    localdata: data
                };//config

                var source = new $.jqx.dataAdapter(config);
                $("#comboCategorias").jqxListBox({source: source, multiple: true, displayMember: "nome", valueMember: "id", width: 350, height: 400});
                //Populando as combobox
                var arrCarac =$("#valuesCateg").val().split(',');
                $(arrCarac).each(function(index,id){
                    var item = $("#comboCategorias").jqxListBox('getItemByValue', id);
                    $("#comboCategorias").jqxListBox('selectIndex',item.index) ;
                });
            }//success
        });//Ajax
    },//Combo Caracteristicas
    readURL: function (input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#foto').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    },//imagem preview
};//JS
