toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function(){
    // Inicializar el DataTable con AJAX
    var csrfToken = $('#csrf-token').data('token');
    var actividadId = $("#actividad-id").data("id");
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
            {data: 'action', title: 'Accciones', name: 'action', orderable: false, searchable: false}
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
            url: '/recursos/disponibles/',
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
                console.log('Error al obtener los miembros disponibles:', error);
            }
        });
    });

    $('#agregarRecursoModal').on('hide.bs.modal', function (event) {
        // Restablece el valor del select cuando se cierra el modal
        var modal = $(this);
        var select = modal.find('#recursoSelect');
        select.val('');
        $('#nombreRecurso').text("");
        $('#cantidadRecurso').val('');
        $('#costoRecurso').text("");
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
                    $('#nombreRecurso').text(data.nombre);
                    $('#costoRecurso').text(data.costo);
                },
                error: function (error) {
                    console.log('Error al obtener los detalles del miembro:', error);
                }
            });
        } else {
            $('#nombreRecurso').text("");
            $('#costoRecurso').text("");
        }
    });

    $('#agregarRecursoBtn').click(function () {
        var selectedRecurso = $('#recursoSelect').val();
        var cantidadRecurso = $('#cantidadRecurso').val();
        // Verifica si se seleccionó un recurso
        if (selectedRecurso !== '') {
            console.log('entre');
            // Realiza una solicitud Ajax para agregar un recurso
            $.ajax({
                url: '/asignacionrecurso/crear', // URL para asignar el recurso
                method: 'POST', // Utiliza el método POST para enviar datos al servidor
                dataType: 'json',
                data: {
                    _token: csrfToken, // Agrega el token CSRF aquí
                    id_actividad: actividadId,
                    id_recurso: selectedRecurso,
                    cantidad: cantidadRecurso
                },
                success: function (response) {
                    if (response.success) {
                        // Recarga el DataTable después de agregar el miembro
                        $('#tableRecursosActividad').DataTable().ajax.reload();
                        //limpia la cantidad
                        $('#cantidadRecurso').val('');
                        // Cierra el modal después de agregar al miembro
                        $('#agregarRecursoModal').modal('hide');
                        toastr.success('Se ha agregado un recurso a la actividad');
                    } else {
                        console.log('Error al agregar el recurso:', response.message);
                    }
                },
                error: function (error) {
                    console.log('Error al agregar el recurso:', error);
                }
            });
        }
    });

    $('#tableRecursosActividad').on('click', '.delete', function () {
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
                        toastr.success('Se ha eliminado un recurso de la actividad');
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