$(document).ready(function () {
    var $id_actividad_comentario = $("#id_actividad").val();
    $('#enviar-formulario').click(function (e) {
        e.preventDefault();
        var $form = $('#comentario-form-agregar');
        var formData = $form.serialize();
        $.ajax({
            type: 'POST',
            data: formData,
            url: $form.attr('action'),
            success: function (response) {
                var textarea = document.querySelector('textarea[name="linea_comentario_comentario"]');
                textarea.value = '';
                $.ajax({
                    type: 'GET',
                    url: "/actividades/show/" + $id_actividad_comentario,
                    success: function (response) {
                        var elementoActualizable = $(response).find('#lista-comentarios');
                        $('#lista-comentarios').html(elementoActualizable.html());
                        toastr.success('Comentario creado con éxito.');
                    }
                });
            },
            error: function (xhr, status, error) {
                toastr.error('Ocurrió en error al agregar el comentario.');
            }
        });
    });
    $('#lista-comentarios').on('click', 'a[data-comentario-id-eliminar]', function (e) {
        e.preventDefault();
        var comentarioId = $(this).data('comentario-id-eliminar');
        var $form = $('#comentario-form-eliminar' + comentarioId);
        var formData = $form.serialize();
        $.ajax({
            type: 'POST',
            data: formData,
            url: $form.attr('action'),
            success: function (response) {
                $.ajax({
                    type: 'GET',
                    url: "/actividades/show/" + $id_actividad_comentario,
                    success: function (response) {
                        var elementoActualizable = $(response).find('#lista-comentarios');
                        $('#lista-comentarios').html(elementoActualizable.html());
                        toastr.success('Comentario eliminado con éxito.');
                    }
                });
            },
            error: function (xhr, status, error) {
                toastr.error('Ocurrió un error al eliminar el comentario.');
            }
        });
    });
    $('#lista-comentarios').on('click', 'a[data-comentario-id-editar]', function (e) {
        e.preventDefault();
        var comentarioId = $(this).data('comentario-id-editar');
        $("#parrafo-comentario"+comentarioId).hide();
        $("#linea-comentario"+comentarioId).show();
        $("#edi"+comentarioId).hide();
        $("#del"+comentarioId).hide();
        $("#upd"+comentarioId).show();
        $("#cal"+comentarioId).show();
    });
    $('#lista-comentarios').on('click', 'a[data-comentario-id-cancelar]', function (e) {
        e.preventDefault();
        var comentarioId = $(this).data('comentario-id-cancelar');
        $("#parrafo-comentario"+comentarioId).show();
        $("#linea-comentario"+comentarioId).hide();
        $("#edi"+comentarioId).show();
        $("#del"+comentarioId).show();
        $("#upd"+comentarioId).hide();
        $("#cal"+comentarioId).hide();
    });
    $('#lista-comentarios').on('click', 'a[data-comentario-id-actualizar]', function (e) {
        e.preventDefault();
        var comentarioId = $(this).data('comentario-id-actualizar');
        var $form = $('#comentario-form-actualizar' + comentarioId);
        var formData = $form.serialize();
        $.ajax({
            type: 'POST',
            data: formData,
            url: $form.attr('action'),
            success: function (response) {
                $.ajax({
                    type: 'GET',
                    url: "/actividades/show/" + $id_actividad_comentario,
                    success: function (response) {
                        var elementoActualizable = $(response).find('#lista-comentarios');
                        $('#lista-comentarios').html(elementoActualizable.html());
                        toastr.success('Comentario actualizado con éxito.');
                    }
                });
            },
            error: function (xhr, status, error) {
                toastr.error('Ocurrió un error al actualizar el comentario.');
            }
        });
    });
});