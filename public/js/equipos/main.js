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
});
