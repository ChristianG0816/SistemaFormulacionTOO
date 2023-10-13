toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function(){
    // Inicializar el DataTable con AJAX
    $('#tableEquipo').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/equipos/list/" + proyectoId, // Agrega el proyectoId a la URL
        "columns": [
            {data: 'usuario_name'},
            {data: 'usuario_email'},
            {data: 'telefono'},
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
                url: '/equipos/detalle/' + selectedMiembro,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Actualiza los campos de nombre, correo y teléfono en el modal
                    $('#nombreMiembro').text(data.full_name); // Utiliza el nuevo campo 'full_name'
                    $('#correoMiembro').text(data.usuario.email); // Utiliza la relación 'usuario' para obtener el correo
                    $('#telefonoMiembro').text(data.telefono); // Ajusta el campo según tu estructura de datos
                },
                error: function (error) {
                    console.log('Error al obtener los detalles del miembro:', error);
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
                        toastr.success('Se ha agregado un miembro al equipo con éxito');
                    } else {
                        console.log('Error al agregar el miembro al equipo:', response.message);
                    }
                },
                error: function (error) {
                    console.log('Error al agregar el miembro al equipo:', error);
                }
            });
        }
    });

    $('#tableEquipo').on('click', '.delete', function () {
        var id = $(this).data('id');
        
        if (confirm('¿Estás seguro de eliminar este registro?')) {
            $.ajax({
                url: '/equipos/eliminar',
                method: 'POST',
                data: { 
                    _token: csrfToken, 
                    id_proyecto: parseInt(proyectoId), // Convertir a entero
                    id_mano_obra: parseInt(id) // Convertir a entero
                },
                success: function (response) {
                    if (response.success) {
                        alert('Registro eliminado correctamente.');
                        // Actualizar la tabla después de la eliminación si es necesario
                        $('#tableEquipo').DataTable().ajax.reload();
                        toastr.success('Se ha eliminado un miembro del equipo con éxito');
                    } else {
                        alert('Error al eliminar el registro.');
                    }
                    toastr.success('Se ha eliminado un miembro del Equipo de trabajo con éxito');
                },
                error: function () {
                    alert('Ocurrió un error en la solicitud.');
                }
            });
        }
    });
});
