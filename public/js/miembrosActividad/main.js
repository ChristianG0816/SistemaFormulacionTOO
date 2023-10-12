$(document).ready(function(){
    // Inicializar el DataTable con AJAX
    $('#tableMiembrosActividad').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/miembrosactividades/list/" + actividadId,
        "columns": [
            {data: 'usuario_name'},
            {data: 'usuario_email'},
            {data: 'costo'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
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
            url: '/miembrosactividades/nolist/' + actividadId + "/" + proyectoId,
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
                console.log('Error al obtener los miembros disponibles:', error);
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
                url: '/miembrosactividades/detalle/' + selectedMiembro,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#nombreMiembro').text(data.full_name);
                    $('#correoMiembro').text(data.mano_obra.usuario.email);
                    $('#telefonoMiembro').text(data.mano_obra.costo_servicio);
                },
                error: function (error) {
                    console.log('Error al obtener los detalles del miembro:', error);
                }
            });
        } else {
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
                url: '/miembrosactividades/crear', // URL para agregar el miembro
                method: 'POST', // Utiliza el método POST para enviar datos al servidor
                dataType: 'json',
                data: {
                    _token: csrfToken, // Agrega el token CSRF aquí
                    id_actividad: actividadId, // Reemplaza 'proyectoId' con el valor correcto
                    id_equipo_trabajo: selectedMiembro // Envía el ID del miembro seleccionado
                },
                success: function (response) {
                    if (response.success) {
                        // Recarga el DataTable después de agregar el miembro
                        $('#tableMiembrosActividad').DataTable().ajax.reload();
                        // Cierra el modal después de agregar al miembro
                        $('#agregarMiembroModal').modal('hide');
                    } else {
                        console.log('Error al agregar el miembro a la actividad:', response.message);
                    }
                },
                error: function (error) {
                    console.log('Error al agregar el miembro a la actividad:', error);
                }
            });
        }
    });

    $('#tableMiembrosActividad').on('click', '.delete', function () {
        var id = $(this).data('id');
        
        if (confirm('¿Estás seguro de eliminar este registro?')) {
            $.ajax({
                url: '/miembrosactividades/eliminar',
                method: 'POST',
                data: { 
                    _token: csrfToken, 
                    id: parseInt(id) // Convertir a entero
                },
                success: function (response) {
                    if (response.success) {
                        alert('Registro eliminado correctamente.');
                        // Actualizar la tabla después de la eliminación si es necesario
                        $('#tableMiembrosActividad').DataTable().ajax.reload();
                    } else {
                        alert('Error al eliminar el registro.');
                    }
                },
                error: function () {
                    alert('Ocurrió un error en la solicitud.');
                }
            });
        }
    });

});