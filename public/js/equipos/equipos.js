toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function(){
    // Inicializar el DataTable con AJAX
    var table = $('#tableEquipo').DataTable({
        ajax: '/equipos/list/' + proyectoId, // Agrega el proyectoId a la URL
        processing: true,
        serverSide: true,
        dom: "<'row w-100'<'col-sm-6'l><'col-sm-6'f>>" +
             "<'row w-100'<'col-sm-12 my-4'tr>>" +
             "<'row w-100'<'col-sm-5'i><'col-sm-7'p>>",
        lengthMenu: [[5, 25, 50, 100, -1], [5, 25, 50, 100, 'Todos']], // Opciones de selección para mostrar registros por página
        pageLength: 5, // Cantidad de registros por página por defecto
        columns: [
            {data: 'usuario_name'},
            {data: 'usuario_email'},
            {data: 'telefono'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
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

    $('#agregarMiembroModal').on('show.bs.modal', function (event) {
        var modal = $(this);

        // Agregar la opción "Seleccione un miembro del equipo"
        var select = modal.find('#miembroSelect');
        select.empty(); // Limpia cualquier opción previa
        select.append($('<option>', {
            value: '',
            text: 'Seleccione un miembro del equipo'
        }));

        // Realiza una solicitud Ajax para obtener los miembros disponibles
        $.ajax({
            url: '/equipos/nolist/' + proyectoId, // Reemplaza 'proyectoId' con el valor correcto
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Llena el select con los datos de los miembros disponibles
                $.each(data, function (index, member) {
                    select.append($('<option>', {
                        value: member.id,
                        text: member.full_name // Ajusta esto para reflejar el campo que deseas mostrar en el select
                    }));
                });
            },
            error: function (error) {
                toastr.error('Error al obtener los miembros disponibles');
            }
        });
    });

    $('#agregarMiembroModal').on('hide.bs.modal', function (event) {
        // Restablece el valor del select cuando se cierra el modal
        var modal = $(this);
        var select = modal.find('#miembroSelect');
        select.val('');
        $('#nombreMiembro').text("");
        $('#correoMiembro').text("");
        $('#telefonoMiembro').text("");
    });

    $('#miembroSelect').change(function () {
        var selectedMiembro = $('#miembroSelect').val();
    
        if (selectedMiembro !== '') {
            // Realiza una solicitud Ajax para obtener los detalles del miembro seleccionado
            $.ajax({
                url: '/equipos/detalle/' + selectedMiembro,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Actualiza los campos de nombre, correo y teléfono en el modal
                    $('#nombreMiembro').text(data.full_name); // Utiliza el nuevo campo 'full_name'
                    $('#correoMiembro').text(data.usuario.email); // Utiliza la relación 'usuario' para obtener el correo
                    $('#telefonoMiembro').text(data.persona.telefono); // Ajusta el campo según tu estructura de datos
                },
                error: function (error) {
                    toastr.error('Error al obtener los detalles del miembro');
                }
            });
        } else {
            // Si no se selecciona ningún miembro, borra los campos en el modal
            $('#nombreMiembro').text("");
            $('#correoMiembro').text("");
            $('#telefonoMiembro').text("");
        }
    });    

    $('#agregarMiembroBtn').click(function () {
        var selectedMiembro = $('#miembroSelect').val();
        // Verifica si se seleccionó un miembro
        if (selectedMiembro !== '') {
            // Realiza una solicitud Ajax para agregar el miembro al equipo
            $.ajax({
                url: '/equipos/crear', // URL para agregar el miembro
                method: 'POST', // Utiliza el método POST para enviar datos al servidor
                dataType: 'json',
                data: {
                    _token: csrfToken, // Agrega el token CSRF aquí
                    id_proyecto: proyectoId, // Reemplaza 'proyectoId' con el valor correcto
                    id_mano_obra: selectedMiembro // Envía el ID del miembro seleccionado
                },
                success: function (response) {
                    if (response.success) {
                        // Recarga el DataTable después de agregar el miembro
                        $('#tableEquipo').DataTable().ajax.reload();
                        // Cierra el modal después de agregar al miembro
                        $('#agregarMiembroModal').modal('hide');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function ( response) {
                    toastr.error(response.message);
                }
            });
        }
    });

    $('#tableEquipo').on('click', '.delete', function () {
        var id = $(this).data('id');
        $('#confirmarEliminarMiembroModal').modal('show');
        $('#eliminarEqipoBtn').data('id', id);
    });

    // Manejador de eventos para el botón "Eliminar" dentro del modal
    $('#eliminarEqipoBtn').on('click', function () {
        var id = $(this).data('id');
        
        // Realiza la solicitud AJAX para eliminar el registro
        $.ajax({
        url: '/equipos/eliminar',
        method: 'POST',
        data: { 
            _token: csrfToken, 
            id_proyecto: parseInt(proyectoId),
            id_mano_obra: parseInt(id)
        },
        success: function (response) {
            if (response.success) {
            $('#tableEquipo').DataTable().ajax.reload();
            toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
        error: function (response) {
            toastr.error(response.message);
        }
        });
        $('#confirmarEliminarMiembroModal').modal('hide');
    });


});
