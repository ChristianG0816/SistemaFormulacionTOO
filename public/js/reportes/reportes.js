toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function() {
    var table = $('#tabla-reportes').DataTable({
        ajax: '/reportes/data/',
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
                  columns: [0, 1, 3, 4, 5, 6] // Índices de las columnas que se copiarán
                }
            },
            {
                extend: 'excel',
                text: 'Exportar a Excel',
                title: 'Reporte Proyectos', // Título del reporte en Excel
                filename: 'Reporte de Proyectos ' + getCurrentDateTime(), // Nombre del archivo Excel
                exportOptions: {
                  columns: [0, 1, 3, 4, 5, 6] // Índices de las columnas que se exportarán
                }
            },
            {
                extend: 'pdf',
                text: 'Exportar a PDF',
                title: 'Reporte Proyectos', // Título del reporte en PDF
                filename: 'Reporte de Proyectos ' + getCurrentDateTime(), // Nombre del archivo PDF
                exportOptions: {
                  columns: [0, 1, 3, 4, 5, 6] // Índices de las columnas que se exportarán
                },
                customize: function (doc) {
                  doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ],
        columns: [
            { data: 'nombre', title: 'Nombre Proyecto', width: '20%' },
            { data: 'estado_proyecto.nombre', title: 'Estado', width: '8%'},
            { data: 'fecha_inicio', title: 'Fecha Inicio', width: '8%' },
            { data: 'fecha_fin', title: 'Fecha Fin', width: '8%' },
            { data: 'cliente_nombre', title: 'Cliente', width: '20%' },
            { data: 'gerente_proyecto_nombre', title: 'Gerente de Proyecto', width: '20%' },
            { data: 'presupuesto', title: 'Presupuesto', width: '10%' },
            {
                data: null,
                title: 'Acciones',
                sortable: false,
                searchable: false,
                width: '10%',
                render: function (data, type, row) {
                    
                    var actionsHtml = '';
                    if(canVerInformeGastos){
                        actionsHtml += '<a class="btn btn-outline-warning btn-sm ml-1 gastos-btn" href="/reportes/'+row.id+'/informe-gastos">Informe de Gastos</a>';
                    }
                    
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
    // Método para generar backup de proyecto
    $(document).on('click', '.gastos-btn', function () {
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                table.ajax.reload();
            },
            error: function (error) {
                table.ajax.reload();
            }
        });
    });
});

