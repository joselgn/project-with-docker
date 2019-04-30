var scriptJS = {
    grid : function(){
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'ajax-caracteristica-grid',
            dataType: "json",
            data: {},
            success: function (data) {
                var source = {
                    datatype: "json",
                    datafields: [
                        {name: 'nome',  type: 'string'},
                        {name: 'ativo', type: 'string'},
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
                            width: '55%'
                        },
                        {
                            text: 'Status',
                            columngroup: 'title',
                            datafield: 'ativo',
                            align: 'center',
                            cellsalign: 'center',
                            width: '30%'
                        },
                        {
                            text: 'Editar',
                            columngroup: 'title',
                            datafield: 'edit',
                            align: 'center',
                            cellsalign: 'center',
                            width: '15%'
                        }
                    ],
                    columngroups: [
                        {text: 'Lista de Caracter&iacute;sticas', align: 'center', name: 'title'}
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
                url: '../ajax-caracteristica-delete',
                dataType: "json",
                data: {
                    id : id,
                    _method:'delete'
                },
                success: function (data) {
                    var erro = data.erro;
                    var msg  = data.msg;

                    window.location='../lista-caracteristicas'
                }//success
            });//AJAX
        }//if confirm
    },//delete
};//JS
