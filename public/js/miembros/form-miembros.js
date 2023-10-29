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
    function filtrarDepartamentos() {
        const paisSeleccionado = $('#select-pais').val();
        $('#select-departamento option').each(function () {
            const paisDepartamento = $(this).data('pais');
            if (paisDepartamento == paisSeleccionado) {
                $(this).prop('disabled', false);
            } else {
                $(this).prop('disabled', true);
            }
        });
        $('#select-departamento').select2();
        var currentURL = window.location.href;
        var pattern = /^https?:\/\/[^/]+\/miembros\/\d+\/edit/;
        if (!pattern.test(currentURL)) {
            $('#select-departamento').val($('#select-departamento option:not(:disabled):first').val()).trigger('change');
        }
    }
    function seleccionarPais() {
        const paisSeleccionado = $('#select-pais').val();
        $.ajax({
            type: 'GET',
            url: '/miembros/verificarPais/' + paisSeleccionado,
            success: function(response) {
                if (response.encontrado) {
                    $('#group-departamento').show();
                    $('#group-municipio').show();
                    filtrarDepartamentos();
                } else {
                    $('#group-departamento').hide();
                    $('#group-municipio').hide();
                    $('#select-departamento').val(null).trigger('change');
                    $('#select-municipio').val(null).trigger('change');
                }
            },
            error: function() {
                console.log('Error el encontrar los departamentos del país.');
            }
        });
    }
});