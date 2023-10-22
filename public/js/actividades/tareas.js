toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function() {
    var id_actividad_tarea = $('#id_actividad').val();
    var tableTareas = $('#tabla-tareas').DataTable({
        ajax: '/tareas/data/'+id_actividad_tarea,
        processing: true,
        serverSide: true,
        order: [[1, 'asc']],
        lengthMenu: [[5, 25, 50, 100, -1], [5, 25, 50, 100, 'Todos']], // Opciones de selección para mostrar registros por página
        pageLength: 5, // Cantidad de registros por página por defecto
        columns: [
            { data: 'nombre', title: 'Nombre', width: '30%' },
            {
                data: 'finalizada',
                title: 'Estado Tarea',
                width: '10%',
                render: function (data, type, row) {
                    if (data === null) {
                        return '<span class="badge badge-danger">Sin Iniciar</span>';
                    } else if (data) {
                        return '<span class="badge badge-success">Finalizada</span>';
                    } else {
                        return '<span class="badge badge-warning">En Proceso</span>';
                    }
                }
            },
            {
                data: null,
                title: 'Acciones',
                sortable: false,
                searchable: false,
                width: '20%',
                render: function (data, type, row) {
                    
                    var actionsHtml = '';

                    /*if(hasPrivilegeEditarActividad === true){*/
                    actionsHtml += '<button id="type="button" class="btn btn-outline-info editarModalTarea-btn btn-sm ml-1" data-id="' + row.id + '" ';
                    actionsHtml += 'data-cod="' + row.id + '">';
                    actionsHtml += 'Editar</button>';
                    /*}
                    
                    if(hasPrivilegeEliminarActividad === true){*/
                    actionsHtml += '<button type="button" class="btn btn-outline-danger eliminarModalTarea-btn btn-sm ml-1" data-id="' + row.id + '" ';
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
    tableTareas.columns.adjust();

    // Método para agregar la tarea
    $('#agregarTareaBtn').click(function (e) {
        e.preventDefault();
        var $form = $('#tarea-form-agregar');
        var formData = $form.serialize();
        $.ajax({
            type: 'POST',
            data: formData,
            url: $form.attr('action'),
            success: function (response) {
                $("#nombre-tarea").val("");
                $("#finalizada-tarea").val(0);
                $("#agregarTareaModal").modal('hide');
                tableTareas.ajax.reload(null, false);
                $.ajax({
                    type: 'GET',
                    url: "/actividades/show/" + id_actividad_tarea,
                    success: function (response) {
                        var elementoActualizable = $(response).find('#informacion-actividad-modal');
                        $('#informacion-actividad-modal').html(elementoActualizable.html());
                    }
                });
                toastr.success('Tarea agregada con éxito.');
            },
            error: function (xhr, status, error) {
                toastr.error('Ocurrió en error al agregar la tarea.');
            }
        });
    });

    // Método para mostrar el modal de editar
    $(document).on('click', '.editarModalTarea-btn', function () {
        var id = $(this).data('id');
        var modal = $('#editarTareaModal');
        var editarBtn = modal.find('#editarTareaBtn');
        editarBtn.data('id', id);
        $.ajax({
            type: 'GET',
            url: '/tareas/' + id + '/edit',
            dataType: 'json',
            success: function(data) {
                $("#nombre-tarea-editar").val(data.nombre);
                if (data.finalizada === null) {
                    $("#finalizada-tarea-editar").val();
                }else if (data.finalizada === true) {
                    $("#finalizada-tarea-editar").val(1);
                } else {
                    $("#finalizada-tarea-editar").val(0);
                }
                modal.modal('show');
            }
        });
    });

    // Método para editar la tarea
    $('#editarTareaBtn').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var $form = $('#tarea-form-editar');
        var formData = $form.serialize();
        $.ajax({
            type: 'PATCH',
            data: formData,
            url: '/tareas/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("#editarTareaModal").modal('hide');
                tableTareas.ajax.reload(null, false);
                $.ajax({
                    type: 'GET',
                    url: "/actividades/show/" + id_actividad_tarea,
                    success: function (response) {
                        var elementoActualizable = $(response).find('#informacion-actividad-modal');
                        $('#informacion-actividad-modal').html(elementoActualizable.html());
                    }
                });
                toastr.success('Tarea editada con éxito.');
            },
            error: function (xhr, status, error) {
                toastr.error('Ocurrió un error al editar la tarea.');
            }
        });
    });
    
   
    // Método para mostrar el modal de eliminación
    $(document).on('click', '.eliminarModalTarea-btn', function () {
        var id = $(this).data('id');
        var modal = $('#confirmarEliminarModalTarea');
        var eliminarBtn = modal.find('#eliminarTareaBtn');
        eliminarBtn.data('id', id);
        modal.modal('show');
    });
   
   
   //Método para enviar la solicitud de eliminar
    $(document).on('click', '#eliminarTareaBtn', function () {
        var id = $(this).data('id');
        var modal = $('#confirmarEliminarModalTarea');
        $.ajax({
            url: '/tareas/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                modal.modal('hide');
                tableTareas.ajax.reload(null, false);
                $.ajax({
                    type: 'GET',
                    url: "/actividades/show/" + id_actividad_tarea,
                    success: function (response) {
                        var elementoActualizable = $(response).find('#informacion-actividad-modal');
                        $('#informacion-actividad-modal').html(elementoActualizable.html());
                    }
                });
                toastr.success('Tarea eliminada con éxito.');
            },
            error: function (error) {
                modal.modal('hide');
                tableTareas.ajax.reload(null, false);
                toastr.error('Ocurrió un error al eliminar la tarea.');
            }
        });
    });    
});