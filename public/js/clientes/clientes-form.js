$(document).ready(function () {
    $('#tipo_cliente').on('change', function () {
        seleccionarTipo();
    });
        // Agrega reglas de validación obligatorias
    $('form').submit(function () {
        var tipo = $('#tipo_cliente').val();
        var isValid = true;

        if (tipo === 'Persona Natural') {
            // Validación para persona natural
            if ($('#name').val() === '' || $('#last_name').val() === '') {
                isValid = false;
            }
        } else if (tipo === 'Persona Jurídica') {
            // Validación para persona jurídica
            if ($('#name').val() === '') {
                isValid = false;
            }
        }
        return isValid;
    });
    seleccionarTipo();
    function seleccionarTipo() {
        const tipo = $('#tipo_cliente').val();
        if (tipo === 'Persona Natural') {
            $('.natural').show();
            $('.juridica').show();
            $('#last_name').prop('disabled', false);
        } else if (tipo === 'Persona Jurídica') {
        $('.natural').show();
            $('.juridica').hide();
            $('#last_name').prop('disabled', true);
        }
    }
});
