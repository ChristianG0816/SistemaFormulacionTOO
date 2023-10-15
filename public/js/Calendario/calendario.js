document.addEventListener('DOMContentLoaded', function() {

    //Selecciono el formulario
    let formulario = document.querySelector("#actividades");

    var calendarEl = document.getElementById('calendario');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      
      initialView: 'dayGridMonth',
      locale:"es",

      headerToolbar:{
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
      },
      
      //Recuperar las actividades en el calendario [las de azul]
      //events: baseUrl + "/calendario/mostrar",

      //al momento de presionar la actividad con esto se mostrara la información
      eventClick:function(info){
        var actividad = info.event;
        //console.log(info.event.id);
        //console.log(info.event.title); 

        axios.post(baseUrl + "/calendario/consultar/"+info.event.id).
        then(
          (respuesta) =>{
            console.log(respuesta.data); // Agregar esta línea para depurar
            
            //pinto los elementos en el formulario
            //nombre es de la base de datos no del parseo en el controlador.
            formulario.title.value = respuesta.data.nombre;
            formulario.start.value = respuesta.data.fecha_inicio;
            formulario.end.value = respuesta.data.fecha_fin;

            $("#actividad").modal("show");
          }
        ).catch(
          error=>{
            if(error.response){
              console.log(error.response.data);
            }
          }
        )
      }

    });

    //servira en caso que se quiera agregar un evento
    function enviarDator(url){
      const datos = new FormData(formulario);
      const nuevaURL = baseUrl+url;

      axios.post(nuevaURL,datos).
      then(
        (respuesta) =>{
          calendar.refetchEvents();
          $("actividad").modal("hide");
        }
      ).catch(
        error=>{if(error.response){console.log(error.response.data)}}
      )
    }

    // Cargar todas las actividades por defecto
    cargarActividadesPorProyecto(0);

    function cargarActividadesPorProyecto(proyectoId) {
      calendar.removeAllEvents(); // Limpia los eventos existentes
  
      // Si proyectoId es 0, obtén todas las actividades
      if (proyectoId === 0) {
          axios.get(baseUrl + "/calendario/mostrar/0")
              .then(function (response) {
                  const actividades = response.data;
                  calendar.addEventSource(actividades);
              })
              .catch(function (error) {
                  console.log(error);
              });
      } else {
          // Si proyectoId no es 0, obtén las actividades del proyecto específico
          axios.get(baseUrl + "/calendario/mostrar/" + proyectoId)
              .then(function (response) {
                  const actividades = response.data;
                  calendar.addEventSource(actividades);
              })
              .catch(function (error) {
                  console.log(error);
              });
      }
  }
  
  // Escucha cambios en el select de proyecto
  const proyectoSelect = document.querySelector('#proyectoSelect');
  proyectoSelect.addEventListener('change', function() {
      const proyectoId = proyectoSelect.value;
      cargarActividadesPorProyecto(proyectoId);
  });


    calendar.render();
  });