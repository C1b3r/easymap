/** Flash message */
if (document.getElementsByClassName('flash-message-container').length > 0) {
    //Evitar instanciar timers innecesarios
    if (countChildElement(".flash-message-container") > 0) {
        setTimeout(function() {
                let alert = document.querySelector(".flash-message-container");
                var myVar = setInterval(function() {
                    //If child of container is zero, cant remove nothing else, clear timer
                    if (countChildElement(".flash-message-container") != 0) {
                        alert.removeChild(alert.childNodes[0]);
                    } else {
                        clearInterval(myVar);
                    }

                }, 2000);

            },
            3000);
    }

}

function countChildElement(nameElement) {
    return document.querySelector(nameElement).childElementCount
}
//document.querySelector('meta[name="csrf-token"]').content;
/*
const data = {
  type: 'input',
  name: 'nombre',
  value: 'Juan',
  placeholder: 'Nombre'
}; */

function createElementFromJSON(data) {
    // Crear el elemento correspondiente al tipo de dato
    const element = document.createElement(data.type);
  
    // Configurar los atributos
    for (const [key, value] of Object.entries(data)) {
      if (key !== 'type' && value !== '') {
        element.setAttribute(key, value);
      }
    }
  
    return element;
  }

// Función para manejar la respuesta AJAX
function handleAjaxResponse(jsonData) {
    // Crear el elemento HTML correspondiente
    var input = createInputFromJSON(jsonData);
  
    // Agregar el elemento HTML al formulario
    var form = document.getElementById('my-form');
    form.appendChild(input);
  }
//ejemplo ajax https://stackoverflow.com/questions/62102726/request-ajax-does-not-detect-ajax-request-when-using-fetch-api-to-pull-dat
  /*fetch('http://test/mapa/mapflet/test',{
   headers: {
    'X-Requested-With': 'XMLHttpRequest'
    },
  })
  .then(response => response.json())
  .then(data=> console.log(data))*/
