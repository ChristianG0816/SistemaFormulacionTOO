$(document).ready(function() {
    var id_proyecto = $('#id_proyecto').data('id-proyecto');
    var table = $('#tabla-actividades').DataTable({
        ajax: '/actividades/data/'+id_proyecto,
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        dom: "<'row w-100'<'col-sm-12 mb-4'B>>" +
             "<'row w-100'<'col-sm-6'l><'col-sm-6'f>>" +
             "<'row w-100'<'col-sm-12 my-4'tr>>" +
             "<'row w-100'<'col-sm-5'i><'col-sm-7'p>>",
        lengthMenu: [[5, 25, 50, 100, -1], [5, 25, 50, 100, 'Todos']], // Opciones de selección para mostrar registros por página
        pageLength: 5, // Cantidad de registros por página por defecto
        buttons: [
            {
                extend: 'copy',
                text: 'Copiar',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5] // Índices de las columnas que se copiarán
                }
            },
            {
                extend: 'excel',
                text: 'Exportar a Excel',
                title: 'Actividades del proyecto', // Título del reporte en Excel
                filename: 'Actividades ' + getCurrentDateTime(), // Nombre del archivo Excel
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5] // Índices de las columnas que se exportarán
                }
            },
            {
                extend: 'pdf',
                text: 'Exportar a PDF',
                title: 'Actividades del proyecto', // Título del reporte en PDF
                filename: 'Actividades ' + getCurrentDateTime(), // Nombre del archivo PDF
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5] // Índices de las columnas que se exportarán
                },
                customize: function (doc) {
                  doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ],
        columns: [
            { data: 'nombre', title: 'Nombre', width: '30%' },
            { data: 'prioridad', title: 'Prioridad', width: '5%' },
            { data: 'fecha_inicio', title: 'Fecha Inicio', width: '10%' },
            { data: 'fecha_fin', title: 'Fecha Fin', width: '10%' },
            { data: 'responsabilidades', title: 'Responsabilidades', width: '15%' },
            { data: 'estado_actividad.nombre', title: 'Estado Actividad', width: '10%' },
            {
                data: null,
                title: 'Acciones',
                sortable: false,
                searchable: false,
                width: '20%',
                render: function (data, type, row) {
                    
                    var actionsHtml = '';
                    
                    //if(hasPrivilegeVerActividad === true){
                        actionsHtml = '<a class="btn btn-outline-secondary btn-sm" href="/actividades/show/'+row.id+'">Mostrar</a>';
                    /*}

                    if(hasPrivilegeEditarActividad === true){*/
                        actionsHtml += '<a class="btn btn-outline-info btn-sm ml-1" href="/actividades/'+row.id+'/edit">Editar</a>';
                    /*}
                    
                    if(hasPrivilegeEliminarActividad === true){*/
                    actionsHtml += '<button type="button" class="btn btn-outline-danger eliminarModal-btn btn-sm ml-1" data-id="' + row.id + '" ';
                    actionsHtml += 'data-cod="' + row.id + '">';
                    actionsHtml += 'Eliminar</button>';
                   //}
                    
                    return actionsHtml || '';
                }
            }
        ],
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "copyTitle": "Copiar al portapapeles",
                copySuccess: {
                  _: "%d filas copiadas al portapapeles",
                  1: "1 fila copiada al portapapeles"
                }
            }
        },
        search: {
            return: true
        }
    });
    table.columns.adjust();
    $('.dt-buttons').hide();
    $('#export-pdf').on('click', function() {
        table.button('.buttons-pdf').trigger();
    });
    $('#export-excel').on('click', function() {
        table.button('.buttons-excel').trigger();
    });
    $('#export-copy').on('click', function() {
        table.button('.buttons-copy').trigger();
    });
    // Función para obtener la fecha y hora actual en formato deseado
    function getCurrentDateTime() {
        var date = new Date();
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        var hours = String(date.getHours()).padStart(2, '0');
        var minutes = String(date.getMinutes()).padStart(2, '0');
        var seconds = String(date.getSeconds()).padStart(2, '0');

        return year + month + day + '_' + hours + minutes + seconds;
    }
   
   // Método para mostrar el modal de eliminación
    $(document).on('click', '.eliminarModal-btn', function () {
        var id = $(this).data('id');
        var modal = $('#confirmarEliminarModal');
        var tituloModal = modal.find('.modal-title');
        var cuerpoModal = modal.find('.modal-body');
        var eliminarBtn = modal.find('#eliminarActividadBtn');
        tituloModal.text('Confirmar eliminación');
        cuerpoModal.html('<strong>¿Estás seguro de eliminar la actividad seleccionada?</strong><br>Ten en cuenta que se eliminarán \n\
        los datos relacionados a la actividad');
        eliminarBtn.data('id', id);
        modal.modal('show');
    });
   
   
   //Método para enviar la solicitud de eliminar
    $(document).on('click', '#eliminarActividadBtn', function () {
        var id = $(this).data('id');
        var modal = $('#confirmarEliminarModal');
        $.ajax({
            url: '/actividades/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                modal.modal('hide');
                var table = $('#tabla-actividades').DataTable();
                table.ajax.reload(null, false);
            },
            error: function (error) {
                modal.modal('hide');
                var table = $('#tabla-actividades').DataTable();
                table.ajax.reload(null, false);
            }
        });
    });    
});