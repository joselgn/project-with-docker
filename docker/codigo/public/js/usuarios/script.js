var userJS = {
    grid : function(){
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'ajax-usuario-grid',
            dataType: "json",
            data: {},
            success: function (data) {
                var source = {
                    datatype: "json",
                    datafields: [
                        {name: 'nome',  type: 'string'},
                        {name: 'email', type: 'string'},
                        {name: 'ativo', type: 'string'},
                        {name: 'perfil',type: 'string'},
                        {name: 'edit',  type: 'number'}
                    ],
                    cache:false,
                    root:'Rows',
                    sort: function () {
                        // update the grid and send a request to the server.
                        $("#grid-usuarios").jqxGrid('updatebounddata', 'sort');
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

                $("#grid-usuarios").jqxGrid({
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
                            width: '30%'
                        },
                        {
                            text: 'Email',
                            columngroup: 'title',
                            datafield: 'email',
                            align: 'center',
                            cellsalign: 'left',
                            width: '25%'
                        },
                        {
                            text: 'Status',
                            columngroup: 'title',
                            datafield: 'ativo',
                            align: 'center',
                            cellsalign: 'center',
                            width: '15%'
                        },
                        {
                            text: 'Perfil',
                            columngroup: 'title',
                            datafield: 'perfil',
                            align: 'center',
                            cellsalign: 'center',
                            width: '20%'
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
                        {text: 'Lista de Usu&aacute;rios', align: 'center', name: 'title'}
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
                url: '../ajax-usuario-delete',
                dataType: "json",
                data: {
                    id : id,
                    _method:'delete'
                },
                success: function (data) {
                    var erro = data.erro;
                    var msg  = data.msg;

                    window.location='../lista-usuarios'
                }//success
            });//AJAX
        }//if confirm
    },//delete
};//JS
