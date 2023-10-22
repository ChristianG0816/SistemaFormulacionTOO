toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function(){
    // Inicializar el DataTable con AJAX
    var csrfToken = $('#csrf-token').data('token');
    var actividadId = $("#actividad-id").data("id");
    var proyectoId = $("#proyecto-id").data("id");
    $('#tableRecursosActividad').DataTable({
        ajax: "/asignacionrecurso/list/" + actividadId,
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        lengthMenu: [[5, 25, 50, 100, -1], [5, 25, 50, 100, 'Todos']], // Opciones de selección para mostrar registros por página
        pageLength: 5, // Cantidad de registros por página por defecto
        columns: [
            {data: 'nombre', title: 'Nombre'},
            {data: 'cantidad', title: 'Cantidad'},
            {data: 'costo', title: 'Costo'},
            {
                data: null,
                title: 'Acciones',
                sortable: false,
                searchable: false,
                width: '25%',
                render: function (data, type, row) {
                    
                    var actionsHtml = '';

                    actionsHtml += '<button id="type="button" class="btn btn-outline-info editarModalRecurso-btn btn-sm ml-1" data-id="' + row.id + '" ';
                    actionsHtml += 'data-cod="' + row.id + '">';
                    actionsHtml += 'Editar</button>';

                    actionsHtml += '<button type="button" class="btn btn-outline-danger eliminarModalRecurso-btn btn-sm ml-1" data-id="' + row.id + '" ';
                    actionsHtml += 'data-cod="' + row.id + '">';
                    actionsHtml += 'Eliminar</button>';
                   
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
            }
        },
        search: {
            return: true
        }
    });
    //desactivado boton agregar por defecto
    $('#agregarRecursoBtn').prop('disabled', true);
    //al recargar se eliminan los valores
    $('#cantidadRecurso').val('');
    $('#costoRecurso').val("");
    $('#disponibilidadRecurso').val("");

    $('#agregarRecursoModal').on('show.bs.modal', function (event) {
        var modal = $(this);

        // Agregar la opción "Seleccione un recurso"
        var select = modal.find('#recursoSelect');
        select.empty(); // Limpia cualquier opción previa
        select.append($('<option>', {
            value: '',
            text: 'Seleccione un recurso'
        }));

        // Realiza una solicitud Ajax para obtener los recursos disponibles
        $.ajax({
            url: '/asignacionrecurso/disponibles/'+actividadId,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Llena el select con los datos de los recursos disponibles
                $.each(data, function (index, recurso) {
                    select.append($('<option>', {
                        value: recurso.id,
                        text: recurso.nombre // Ajusta esto para reflejar el campo que deseas mostrar en el select
                    }));
                });
            },
            error: function (error) {
                console.log('Error al obtener los recursos disponibles:', error);
            }
        });
    });

    // Método para mostrar el modal de eliminación
    $(document).on('click', '.eliminarModalRecurso-btn', function () {
        var id = $(this).data('id');
        var modal = $('#confirmarEliminarModalRecurso');
        var eliminarBtn = modal.find('#eliminarRecursoBtn');
        eliminarBtn.data('id', id);
        modal.modal('show');
    });

    // Método para mostrar el modal de editar
    $(document).on('click', '.editarModalRecurso-btn', function () {
        var id = $(this).data('id');
        var modal = $('#editarRecursoModal');
        var editarBtn = modal.find('#editarRecursoBtn');
        editarBtn.data('id', id);
        $.ajax({
            type: 'GET',
            url: '/asignacionrecurso/' + id + '/edit',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#nombreRecursoE').data('id', data[0].recurso.id);
                $('#nombreRecursoE').val(data[0].recurso.nombre);
                $('#disponibilidadRecursoE').val(data[0].recurso.disponibilidad);
                $('#costoRecursoE').val(data[0].recurso.costo);
                $('#cantidadRecursoE').val(data[0].cantidad);
                modal.modal('show');
            },
            error: function (error) {
                console.log('Error al obtener los detalles del recurso asignado:', error);
                toastr.error('Error al obtener los detalles del recurso asignado');
            }
        });
    });

    $('#agregarRecursoModal').on('hide.bs.modal', function (event) {
        // Restablece el valor del select cuando se cierra el modal
        var modal = $(this);
        var select = modal.find('#recursoSelect');
        select.val('');
        $('#cantidadRecurso').val('');
        $('#costoRecurso').val("");
        $('#disponibilidadRecurso').val("");
        $('#cantidadRecurso').removeClass('is-invalid');
        $('#cantidadRecurso').next().text('');
    });

    $('#editarRecursoModal').on('hide.bs.modal', function (event) {
        $('#cantidadRecursoE').removeClass('is-invalid');
        $('#cantidadRecursoE').next().text('');
    });

    $('#recursoSelect').change(function () {
        var selectedRecurso = $('#recursoSelect').val();
    
        if (selectedRecurso !== '') {
            // Realiza una solicitud Ajax para obtener los detalles del miembro seleccionado
            $.ajax({
                url: '/recursos/detalle/' + selectedRecurso,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#disponibilidadRecurso').val(data.disponibilidad);
                    $('#costoRecurso').val(data.costo);
                    $('#agregarRecursoBtn').prop('disabled', false); // Habilita el botón
                },
                error: function (error) {
                    console.log('Error al obtener los detalles del recurso:', error);
                    toastr.error('Error al obtener los detalles del recurso');
                }
            });
        } else {
            $('#costoRecurso').val("");
            $('#disponibilidadRecurso').val("");
            $('#cantidadRecurso').val('');
            $('#agregarRecursoBtn').prop('disabled', true); // Deshabilita el botón
        }
    });

    $('#agregarRecursoBtn').click(function () {
        var selectedRecurso = $('#recursoSelect').val();
        var cantidadRecurso = $('#cantidadRecurso').val();
        var costoRecurso = $('#costoRecurso').val();
        // Verifica si se seleccionó un recurso
        if (selectedRecurso !== '') {
            // Realiza una solicitud Ajax para agregar un recurso
            $.ajax({
                url: '/asignacionrecurso/crear', // URL para asignar el recurso
                method: 'POST', // Utiliza el método POST para enviar datos al servidor
                dataType: 'json',
                data: {
                    _token: csrfToken, // Agrega el token CSRF aquí
                    id_proyecto: proyectoId,
                    id_actividad: actividadId,
                    id_recurso: selectedRecurso,
                    cantidad: cantidadRecurso,
                    costo: costoRecurso
                },
                success: function (response) {
                    if (response.success) {
                        // Recarga el DataTable después de agregar el miembro
                        $('#tableRecursosActividad').DataTable().ajax.reload();
                        //limpiar campos
                        $('#cantidadRecurso').val('');
                        $('#costoRecurso').val("");
                        $('#disponibilidadRecurso').val("");
                        // Cierra el modal después de agregar al miembro
                        $('#agregarRecursoModal').modal('hide');
                        toastr.success('Se ha agregado un recurso a la actividad');
                    } else {
                        console.log('Error al agregar el recurso:', response.message);
                        toastr.error(response.message);
                    }
                },
                error: function (error) {
                    if (error.responseJSON!=undefined){
                        if(error.responseJSON.errors.cantidad){
                            $('#cantidadRecurso').addClass('is-invalid');
                            $('#cantidadRecurso').next().text(error.responseJSON.errors.cantidad[0]);
                        }
                    }else{
                        toastr.error('Error al agregar el recurso');
                        console.log(error);
                    }   
                }
            });
        }
    });

    $('#editarRecursoBtn').click(function () {
        var id = $(this).data('id');
        var cantidadRecursoE = $('#cantidadRecursoE').val();
        var idRecurso = $('#nombreRecursoE').data('id');
        $.ajax({
            url: '/asignacionrecurso/'+id, // URL para asignar el recurso
            method: 'PUT', // Utiliza el método POST para enviar datos al servidor
            dataType: 'json',
            data: {
                _token: csrfToken, // Agrega el token CSRF aquí
                id_actividad: actividadId,
                cantidad: cantidadRecursoE,
                id_recurso: idRecurso
            },
            success: function (response) {
                if (response.success) {
                    // Recarga el DataTable después de agregar el miembro
                    $('#tableRecursosActividad').DataTable().ajax.reload();
                    //limpiar campos
                    // $('#cantidadRecurso').val('');
                    // $('#costoRecurso').val("");
                    // $('#disponibilidadRecurso').val("");
                    // Cierra el modal después de agregar al miembro
                    $('#editarRecursoModal').modal('hide');
                    toastr.success('Se ha agregado un recurso a la actividad');
                } else {
                    console.log('Error al agregar el recurso:', response.message);
                    toastr.error(response.message);
                }
            },
            error: function (error) {
                if (error.responseJSON!=undefined){
                    if(error.responseJSON.errors.cantidad){
                        $('#cantidadRecursoE').addClass('is-invalid');
                        $('#cantidadRecursoE').next().text(error.responseJSON.errors.cantidad[0]);
                    }
                }else{
                    toastr.error('Error al agregar el recurso');
                    console.log(error);
                }   
            }
        });
    });

    //Método para enviar la solicitud de eliminar
    $(document).on('click', '#eliminarRecursoBtn', function () {
        var id = $(this).data('id');
        var modal = $('#confirmarEliminarModalRecurso');
        $.ajax({
            url: '/asignacionrecurso/' + id, //asignacionrecurso/{id}
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken, // Agrega el token CSRF aquí
            },
            success: function (response) {
                modal.modal('hide');
                $('#tableRecursosActividad').DataTable().ajax.reload();
                toastr.success('Recurso eliminado con éxito.');
            },
            error: function (error) {
                modal.modal('hide');
                tableTareas.ajax.reload(null, false);
                toastr.error('Ocurrió un error al eliminar.');
            }
        });
    });    
});