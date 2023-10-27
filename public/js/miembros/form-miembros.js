$(document).ready(function() {
    $('#select-pais').select2();
    $('#select-departamento').select2();
    $('#select-departamento').on('change', function () {
        filtrarMunicipios();
    });
    $('#select-pais').on('change', function () {
        seleccionarPais();
    });
    seleccionarPais();
    filtrarMunicipios();
    function filtrarMunicipios() {
        const departamentoSeleccionado = $('#select-departamento').val();
        $('#select-municipio option').each(function () {
            const municipioDepartamento = $(this).data('departamento');
            if (municipioDepartamento == departamentoSeleccionado) {
                $(this).prop('disabled', false);
            } else {
                $(this).prop('disabled', true);
            }
        });
        $('#select-municipio').select2();
        $('#select-municipio').val($('#select-municipio option:not(:disabled):first').val()).trigger('change');
    }
    function seleccionarPais() {
        const paisSeleccionado = $('#select-pais').val();
        if (paisSeleccionado === '65') {
            $('#group-departamento').show();
            $('#group-municipio').show();
        } else {
            $('#group-departamento').hide();
            $('#group-municipio').hide();
            $('#select-departamento').val(null).trigger('change');
            $('#select-municipio').val(null).trigger('change');
        }
    }
});