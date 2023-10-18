toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function() {
    var table = $('#tabla-notificaciones').DataTable({
        ajax: '/notificaciones/data/',
        processing: true,
        serverSide: true,
        //order por fecha y hora
        order: [ [2, 'desc'], [3, 'desc'] ],
        dom: "<'row w-100'<'col-sm-6'l><'col-sm-6'f>>" +
             "<'row w-100'<'col-sm-12 my-4'tr>>" +
             "<'row w-100'<'col-sm-5'i><'col-sm-7'p>>",
        lengthMenu: [[5, 25, 50, 100, -1], [5, 25, 50, 100, 'Todos']], // Opciones de selección para mostrar registros por página
        pageLength: 5, // Cantidad de registros por página por defecto
        columns: [
            { data: 'tipo', title: 'Notificación' },
            { data: 'descripcion', title: 'Mensaje' },
            { data: 'fecha', title: 'Fecha' },
            { data: 'hora', title: 'Hora' },
            { data: 'leida', title: 'Leída' },
            { data: 'acciones', name:'acciones', orderable: false, searchable: false }
        ],
        columnDefs: [
            { width: '15%', targets: 0 }, // Ancho del 15% para la primera columna
            { width: '35%', targets: 1 }, // Ancho del 30% para la segunda columna (Mensaje)
            { width: '10%', targets: 2 }, // Ancho del 15% para la tercera columna (Fecha)
            { width: '10%', targets: 3 }, // Ancho del 10% para la cuarta columna (Hora)
            { width: '10%', targets: 4 }, // Ancho del 10% para la quinta columna (Leída)
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

    $('#tabla-notificaciones').on('click', '.eliminar-notificacion', function () {
        var id = $(this).data('id');
        $('#confirmarEliminarNotificacionModal').modal('show');
        $('#eliminarNotificacion').data('id', id);
    });
    
    $('#eliminarNotificacion').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/notificaciones/eliminar/' + id,
            method: 'POST',
            data: {
                _token: csrfToken, // Agrega el token CSRF aquí
            },
            beforeSend: function() {
                $('#eliminarNotificacion').text('Eliminando...');
            },
            success: function(response) {
                // Obtén una instancia del _AdminLTE_NavbarNotification.
                let nLink = new _AdminLTE_NavbarNotification("my-notification");
                $.ajax({
                    url: "/notificaciones/get"
                })
                .done((data) => {
                    // Invoca el método update en la instancia para actualizar la notificación.
                    nLink.update(data);
                    let dropdown = $("#my-notification").find(".adminlte-dropdown-content");
                    dropdown.html(data.dropdown);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                });
                setTimeout(function() {
                    $('#confirmarEliminarNotificacionModal').modal('hide');
                    $('#eliminarNotificacion').text('Eliminar');
                    $('#tabla-notificaciones').DataTable().ajax.reload();
                    toastr.success(response.success);
                }, 500);
            },
            error: function(response) {
                toastr.error(response.error);
            }
        });
    });

    $('#tabla-notificaciones').on('click', '.marcar-leida-notificacion', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/notificaciones/marcar_leida/' + id,
            method: 'POST',
            data: {
                _token: csrfToken, // Agrega el token CSRF aquí
            },
            success: function(response) {
                // Obtén una instancia del _AdminLTE_NavbarNotification.
                let nLink = new _AdminLTE_NavbarNotification("my-notification");
                $.ajax({
                    url: "/notificaciones/get"
                })
                .done((data) => {
                    // Invoca el método update en la instancia para actualizar la notificación.
                    nLink.update(data);
                    let dropdown = $("#my-notification").find(".adminlte-dropdown-content");
                    dropdown.html(data.dropdown);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                });
                setTimeout(function() {
                    $('#tabla-notificaciones').DataTable().ajax.reload();
                    toastr.success(response.success);
                }, 500);
            },
            error: function(response) {
                toastr.error(response.error);
            }
        });
    });

    $('#marcarTodas').on('click', function() {
        $.ajax({
            url: '/notificaciones/marcar_leida',
            method: 'POST',
            data: {
                _token: csrfToken, // Agrega el token CSRF aquí
            },
            success: function(response) {
                // Obtén una instancia del _AdminLTE_NavbarNotification.
                let nLink = new _AdminLTE_NavbarNotification("my-notification");
                $.ajax({
                    url: "/notificaciones/get"
                })
                .done((data) => {
                    // Invoca el método update en la instancia para actualizar la notificación.
                    nLink.update(data);
                    let dropdown = $("#my-notification").find(".adminlte-dropdown-content");
                    dropdown.html(data.dropdown);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                });
                setTimeout(function() {
                    $('#tabla-notificaciones').DataTable().ajax.reload();
                    if (response.success) {
                        toastr.success(response.success);
                    } else {
                        toastr.error(response.error);
                    }
                }, 500);
            },
            error: function(response) {
                toastr.error(response.error);
            }
        });
    });

    $('#eliminarTodas').on('click', function() {
        $('#confirmarEliminarTodasNotificacionModal').modal('show');
    });

    $('#eliminarTodasNotificacion').on('click', function() {
        $.ajax({
            url: '/notificaciones/eliminar',
            method: 'POST',
            data: {
                _token: csrfToken, // Agrega el token CSRF aquí
            },
            success: function(response) {
                // Obtén una instancia del _AdminLTE_NavbarNotification.
                let nLink = new _AdminLTE_NavbarNotification("my-notification");
                $.ajax({
                    url: "/notificaciones/get"
                })
                .done((data) => {
                    // Invoca el método update en la instancia para actualizar la notificación.
                    nLink.update(data);
                    let dropdown = $("#my-notification").find(".adminlte-dropdown-content");
                    dropdown.html(data.dropdown);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                });

                setTimeout(function() {
                    $('#tabla-notificaciones').DataTable().ajax.reload();
                    $('#confirmarEliminarTodasNotificacionModal').modal('hide');
                    if (response.success) {
                        toastr.success(response.success);
                    } else {
                        toastr.error(response.error);
                    }
                }, 500);
            },
            error: function(response) {
                toastr.error(response.error);
            }
        });
    });
    
});
