toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function() {
    var table = $('#tabla-usuarios').DataTable({
        ajax: '/usuarios/data/',
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        dom: 
             "<'row w-100'<'col-sm-6'l><'col-sm-6'f>>" +
             "<'row w-100'<'col-sm-12 my-4'tr>>" +
             "<'row w-100'<'col-sm-5'i><'col-sm-7'p>>",
        lengthMenu: [[5, 25, 50, 100, -1], [5, 25, 50, 100, 'Todos']], // Opciones de selección para mostrar registros por página
        pageLength: 5, // Cantidad de registros por página por defecto
        
        columns: [
            { data: 'name', title: 'Nombre', width: '25%' },
            { data: 'email', title: 'Correo', width: '25%' },
            { data: 'roles', title: 'Rol', width: '25%' },
            {
                data: null,
                title: 'Acciones',
                sortable: false,
                searchable: false,
                width: '25%',
                render: function (data, type, row) {
                    
                    var actionsHtml = '';

                    if (canEditarUsuario) {
                        actionsHtml += '<a class="btn btn-outline-info btn-sm ml-1" href="/usuarios/'+row.id+'/edit">Editar</a>';
                    }else{
                        actionsHtml += '<span class="text-muted">' + mensajeNoTienesPermiso + '</span>';
                    }

                    if(canEliminarUsuario){
                    actionsHtml += '<button type="button" class="btn btn-outline-danger eliminarModal-btn btn-sm ml-1" data-id="' + row.id + '" ';
                    actionsHtml += 'data-cod="' + row.id + '">';
                    actionsHtml += 'Eliminar</button>';
                    }else{
                        actionsHtml += '<span class="text-muted">' + mensajeNoTienesPermiso + '</span>';
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

   // Método para mostrar el modal de eliminación
    $(document).on('click', '.eliminarModal-btn', function () {
        var id = $(this).data('id');
        var modal = $('#confirmarEliminarModal');
        var tituloModal = modal.find('.modal-title');
        var cuerpoModal = modal.find('.modal-body');
        var eliminarBtn = modal.find('#eliminarUsuarioBtn');
        tituloModal.text('Confirmar eliminación');
        cuerpoModal.html('<strong>¿Estás seguro de eliminar al Usuario seleccionado?</strong><br>Ten en cuenta que se eliminarán \n\
        los datos relacionados al usuario');
        eliminarBtn.data('id', id);
        modal.modal('show');
    });
   
   //Método para enviar la solicitud de eliminar
    $(document).on('click', '#eliminarUsuarioBtn', function () {
        var id = $(this).data('id');
        var modal = $('#confirmarEliminarModal');
        $.ajax({
            url: '/usuarios/' + id,
            type: 'POST',
            data: {
                _method: 'DELETE' // Indica que es una solicitud DELETE
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                modal.modal('hide');
                var table = $('#tabla-usuarios').DataTable();
                table.ajax.reload(null, false);
                toastr.success('Se ha eliminado un usuario con éxito');
            },
            error: function (error) {
                modal.modal('hide');
                var table = $('#tabla-usuarios').DataTable();
                table.ajax.reload(null, false);
            }
        });
    });
}); 