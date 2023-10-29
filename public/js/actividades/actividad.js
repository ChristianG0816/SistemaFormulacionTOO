toastr.options = {
    "closeButton": true,
    "progressBar": true
};
$(document).ready(function() {
    $('#select-estado-actividad').on('change', function () {
        console.log("cambio");
        $("#group-boton-guardar").show();
    });
    //Método para enviar la solicitud de editar
    $(document).on('click', '#boton-editar-actividad', function () {
        var id = $("#id_actividad").val();
        var $form = $('#actividad-form-actualizar');
        var formData = $form.serialize();
        console.log(formData);
        $.ajax({
            type: 'PATCH',
            data: formData,
            url: $form.attr('action'),
            success: function (response) {
                $.ajax({
                    type: 'GET',
                    url: "/actividades/show/" + id,
                    success: function (response) {
                        var elementoActualizable = $(response).find('#informacion-actividad-modal');
                        $('#informacion-actividad-modal').html(elementoActualizable.html());
                        toastr.success('Actividad actualizada con éxito.');
                        $("#group-boton-guardar").hide();
                    }
                });
            },
            error: function (xhr, status, error) {
                toastr.error('Ocurrió un error al actualizar la actividad.' +error);
            }
        });
    });    
});