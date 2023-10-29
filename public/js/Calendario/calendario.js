document.addEventListener("DOMContentLoaded", function () {
    //Selecciono el formulario
    let formulario = document.querySelector("#actividades");
    let formularioEvento = document.querySelector("#eventos");

    var calendarEl = document.getElementById("calendario");

    //Defino variables para mostrar Actividades
    let nombreForm = document.querySelector("#titleForm");
    let proyectoForm = document.querySelector("#proyectoForm");
    let InicioForm = document.querySelector("#fechaInicioForm");
    let FinForm = document.querySelector("#fechaFinForm");
    let estadoForm = document.querySelector("#estadoForm");
    let diaForm = document.querySelector("#diaForm");

    let proyectoId = 0; // Inicialmente se muestra todo
    

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        locale: "es",

        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth",
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

                        // Deshabilitar el campo del proyecto
                        formularioEvento.proyecto.disabled = true;

                        // Cambiar el contenido del modal
                        $modal.find(".modal-title").text("Modificar Evento");
                        $modal.find("#btnGuardar").hide();
                        $modal.find("#btnModificar, #btnEliminar").show();

                        //Limpiar mensajes de error
                        //Mensajes de error
                        $("#errorNombre").text("");
                        $("#nombre").removeClass("is-invalid");
                        $("#errorDes").text("");
                        $("#descripcion").removeClass("is-invalid");
                        $("#errorDir").text("");
                        $("#direccion").removeClass("is-invalid");
                        $("#errorFechaInicio").text("");
                        $("#fecha_inicio").removeClass("is-invalid");
                        $("#errorFechaFin").text("");
                        $("#fecha_fin").removeClass("is-invalid");
                        $("#errorHoraInicio").text("");
                        $("#hora_inicio").removeClass("is-invalid");
                        $("#errorHoraFin").text("");
                        $("#hora_fin").removeClass("is-invalid");
                        $("#errorFechaRecord").text("");
                        $("#fecha_recordatorio").removeClass("is-invalid");
                        $("#errorlink").text("");
                        $("#link_reunion").removeClass("is-invalid");

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

                        nombreForm.innerHTML = respuesta.data.nombre;
                        InicioForm.innerHTML = respuesta.data.fecha_inicio;
                        FinForm.innerHTML = respuesta.data.fecha_fin;

                    // Obtener el nombre del proyecto
                    axios.get(baseUrl + "/proyectodata/" + respuesta.data.id_proyecto)
                    .then((proyectoRespuesta) => {
                        proyectoForm.innerHTML = proyectoRespuesta.data.nombre;
                    })
                    .catch((proyectoError) => {
                        if (proyectoError.response) {
                        console.log(proyectoError.response.data);
                     }
                    });

                    //Obtener el estado de la actividad
                    axios.get(baseUrl + "/estadodata/" + respuesta.data.id_estado_actividad)
                    .then((EstadoRespuesta) => {
                        estadoForm.innerHTML = EstadoRespuesta.data.nombre;
                    })
                    .catch((EstadoError) => {
                        if (EstadoError.response) {
                        console.log(EstadoError.response.data);
                     }
                    });

                    const fechaFin = new Date(respuesta.data.fecha_fin);
                    const fechaActual = new Date();
                    const diferenciaDias = Math.floor((fechaFin - fechaActual) / (1000 * 60 * 60 * 24));

                    const dia = document.getElementById("dia");
                    const diasRestantesDiv = document.getElementById("diasRestantesDiv");

                    if ((respuesta.data.id_estado_actividad == 1 || respuesta.data.id_estado_actividad == 2) && diferenciaDias < 0) {
                        dia.textContent = "Días Vencidos:";
                        const diasVencidos = Math.floor((fechaActual - fechaFin) / (1000 * 60 * 60 * 24));
                        diaForm.innerHTML = diasVencidos;
                        diasRestantesDiv.style.display = "block"; // Asegura que el div esté visible
                    } else if (respuesta.data.id_estado_actividad == 3) {
                        diasRestantesDiv.style.display = "none"; // Oculta el div
                    } else {
                        dia.textContent = "Días Restantes:";
                        diaForm.innerHTML = diferenciaDias;
                        diasRestantesDiv.style.display = "block"; // Asegura que el div esté visible
                    }

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
                //calendar.refetchEvents();
                cargarActividadesYEventos(proyectoId);
            })
            .catch((error) => {
                if (error.response) {

                //Aqui capturo los mensajes de error y se los paso al modal.

                // Mostrar el mensaje de error para nombre
                const mensajeError = error.response.data.errors.nombre;  
                $("#errorNombre").text(mensajeError);
                $("#nombre").addClass("is-invalid"); 

                // Mostrar el mensaje de error para descripción
                const mensajeErrorDes = error.response.data.errors.descripcion;  
                $("#errorDes").text(mensajeErrorDes);
                $("#descripcion").addClass("is-invalid");

                // Mostrar el mensaje de error para direccion
                const mensajeErrorDir = error.response.data.errors.direccion;  
                $("#errorDir").text(mensajeErrorDir);
                $("#direccion").addClass("is-invalid");

                // Mostrar el mensaje de error para fechaInicio
                const mensajeErrorFechaInicio = error.response.data.errors.fecha_inicio;  
                $("#errorFechaInicio").text(mensajeErrorFechaInicio);
                $("#fecha_inicio").addClass("is-invalid");

                // Mostrar el mensaje de error para fechaFin
                const mensajeErrorFechaFin = error.response.data.errors.fecha_fin;  
                $("#errorFechaFin").text(mensajeErrorFechaFin);
                $("#fecha_fin").addClass("is-invalid");

                // Mostrar el mensaje de error para Hora Inicio
                const mensajeErrorHoraInicio = error.response.data.errors.hora_inicio;  
                $("#errorHoraInicio").text(mensajeErrorHoraInicio);
                $("#hora_inicio").addClass("is-invalid");

                // Mostrar el mensaje de error para Hora Fin
                const mensajeErrorHoraFin = error.response.data.errors.hora_fin;  
                $("#errorHoraFin").text(mensajeErrorHoraFin);
                $("#hora_fin").addClass("is-invalid");

                // Mostrar el mensaje de error para Fecha Recordatorio
                const mensajeErrorFechaRecordatorio = error.response.data.errors.fecha_recordatorio;  
                $("#errorFechaRecord").text(mensajeErrorFechaRecordatorio);
                $("#fecha_recordatorio").addClass("is-invalid");

                // Mostrar el mensaje de error para Link de reunion
                const mensajeErrorLink = error.response.data.errors.link_reunion;  
                $("#errorlink").text(mensajeErrorLink);
                $("#link_reunion").addClass("is-invalid");

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
            // Habilitar el campo del proyecto
            formularioEvento.proyecto.disabled = false;
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

            //Mensajes de error
            $("#errorNombre").text("");
            $("#nombre").removeClass("is-invalid");
            $("#errorDes").text("");
            $("#descripcion").removeClass("is-invalid");
            $("#errorDir").text("");
            $("#direccion").removeClass("is-invalid");
            $("#errorFechaInicio").text("");
            $("#fecha_inicio").removeClass("is-invalid");
            $("#errorFechaFin").text("");
            $("#fecha_fin").removeClass("is-invalid");
            $("#errorHoraInicio").text("");
            $("#hora_inicio").removeClass("is-invalid");
            $("#errorHoraFin").text("");
            $("#hora_fin").removeClass("is-invalid");
            $("#errorFechaRecord").text("");
            $("#fecha_recordatorio").removeClass("is-invalid");
            $("#errorlink").text("");
            $("#link_reunion").removeClass("is-invalid");

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

