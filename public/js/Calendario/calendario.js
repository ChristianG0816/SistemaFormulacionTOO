document.addEventListener("DOMContentLoaded", function () {
    //Selecciono el formulario
    let formulario = document.querySelector("#actividades");
    let formularioEvento = document.querySelector("#eventos");

    var calendarEl = document.getElementById("calendario");
    let proyectoId = 0; // Inicialmente se muestra todo
    

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        locale: "es",

        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,listWeek",
        },

        eventSources: obtenerEventSources(proyectoId),

        //al momento de presionar la actividad con esto se mostrara la información
        eventClick: function (info) {
            var evento = info.event;
            var $modal = $("#evento");

            //console.log(evento.extendedProps.tipo);
            if (evento.extendedProps.tipo === "evento") {
                axios
                    .post(baseUrl + "/calendario/consultarEvento/" + evento.id)
                    .then((respuesta) => {
                        formularioEvento.id.value = respuesta.data.id;
                        formularioEvento.nombre.value = respuesta.data.nombre;
                        formularioEvento.descripcion.value = respuesta.data.descripcion;
                        formularioEvento.direccion.value = respuesta.data.direccion;
                        formularioEvento.proyecto.value = respuesta.data.id_proyecto;
                        formularioEvento.fecha_inicio.value = respuesta.data.fecha_inicio;
                        formularioEvento.fecha_fin.value = respuesta.data.fecha_fin;
                        formularioEvento.hora_inicio.value = respuesta.data.hora_inicio;
                        formularioEvento.hora_fin.value = respuesta.data.hora_fin;
                        formularioEvento.fecha_recordatorio.value = respuesta.data.fecha_recordatorio;
                        formularioEvento.link_reunion.value =  respuesta.data.link_reunion;

                        // Cambiar el contenido del modal
                        $modal.find(".modal-title").text("Modificar Evento");
                        $modal.find("#btnGuardar").hide();
                        $modal.find("#btnModificar, #btnEliminar").show();

                        // Mostrar el modal
                        $modal.modal("show");
                    })
                    .catch((error) => {
                        if (error.response) {
                            console.log(error.response.data);
                        }
                    });
            } else if (evento.extendedProps.tipo === "actividad") {
                axios
                    .post(baseUrl + "/calendario/consultar/" + evento.id)
                    .then((respuesta) => {
                        formulario.title.value = respuesta.data.nombre;
                        formulario.start.value = respuesta.data.fecha_inicio;
                        formulario.end.value = respuesta.data.fecha_fin;
                        $("#actividad").modal("show");
                    })
                    .catch((error) => {
                        if (error.response) {
                            console.log(error.response.data);
                        }
                    });
            }
        },
    });

    //Agregar un evento
    document.getElementById("btnGuardar").addEventListener("click", function () {
            enviarDatos("/calendario/agregar");
        });

    //Eliminar un evento
    document.getElementById("btnEliminar").addEventListener("click", function () {
            enviarDatos("/calendario/eliminarEvento/" + formularioEvento.id.value);
        });

    //Modificar un evento
    document.getElementById("btnModificar").addEventListener("click", function () {
            enviarDatos("/calendario/ActualizarEvento/" + formularioEvento.id.value);
        });

    function enviarDatos(url) {
        const datos = new FormData(formularioEvento);
        const nuevaURL = baseUrl + url;

        axios
            .post(nuevaURL, datos)
            .then((respuesta) => {
                $("#evento").modal("hide");
                calendar.refetchEvents();
            })
            .catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });
    }

    // Agrega un listener al botón "Crear Evento"
    document
        .getElementById("btnCrearEvento")
        .addEventListener("click", function () {
            var $modal = $("#evento");

            // Limpiar los campos del formulario antes de mostrarlo
            formularioEvento.id.value = "";
            formularioEvento.nombre.value = "";
            formularioEvento.descripcion.value = "";
            formularioEvento.direccion.value = "";
            formularioEvento.proyecto.value = "";
            formularioEvento.fecha_inicio.value = "";
            formularioEvento.fecha_fin.value = "";
            formularioEvento.hora_inicio.value = "";
            formularioEvento.hora_fin.value = "";
            formularioEvento.fecha_recordatorio.value = "";
            formularioEvento.link_reunion.value = "";

            // Cambiar el contenido del modal
            $modal.find(".modal-title").text("Crear Evento");
            $modal.find("#btnGuardar").show();
            $modal.find("#btnModificar, #btnEliminar").hide();

            // Mostrar el modal
            $modal.modal("show");
        });

        
    // Función para obtener las fuentes de eventos según el proyecto seleccionado
    function obtenerEventSources(proyectoId) {
        const eventSources = [
            {
                url: `/calendario/mostrar/${proyectoId}`,
                display: 'block',
            },
            {
                url: `/calendario/mostrarEvento/${proyectoId}`,
                display: 'block',
            },
        ];
        //console.log("Event Sources:", eventSources);
        return eventSources;
    }

    function removeAllEvents() {
      calendar.getEventSources().forEach(function (source) {
        source.remove();
      });
    }
    
    function cargarActividadesYEventos(proyectoId) {
      removeAllEvents();
    
      const eventSources = obtenerEventSources(proyectoId);
    
      eventSources.forEach((source) => {
        axios.get(baseUrl + source.url)
          .then(function (response) {
            const eventos = response.data;
            calendar.addEventSource(eventos);
            calendar.refetchEvents();
          })
          .catch(function (error) {
            console.log(error);
          });
      });
    }

    // Escucha cambios en el select de proyecto
    const proyectoSelect = document.querySelector('#proyectoSelect');
    proyectoSelect.addEventListener('change', function() {
      const proyectoId = proyectoSelect.value;
      cargarActividadesYEventos(proyectoId);
    });

  calendar.render();
    
});

