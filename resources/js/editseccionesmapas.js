var parametroUrl = window.location.hash.substring(1);
// Seleccionar todos los elementos con la clase "nav-link-tab"
const tabs = document.querySelectorAll('.nav-link-tab');

// Agregar un controlador de eventos "click" a cada elemento
tabs.forEach(tab => {
  tab.addEventListener('click', event => {
    // Obtener el elemento de pestaña correspondiente
    const tabElement = tab.getAttribute("href").substring(1);

    // Activar la pestaña correspondiente
    activateTab(tab);

    // Cargar el contenido correspondiente en cada clic
    cargarContenido(tabElement);
  });
});



if (parametroUrl == '') {
    cargarTab();
} else {
    cargarTab(window.location.hash.substring(1));
}

function cargarTab(tab = '') { 
    //Si esta vacio, que cargue el primero obligatoriamente
    if (tab === '') {
        let tab = document.querySelector('ul#myTab > li > a');
        cargarContenido(tab.getAttribute("href").substring(1));
        activateTab(tab);
    } else {
        if(elemento = document.getElementById(tab+'-tab')){
            cargarContenido(tab);
            activateTab(elemento);
        }
       
    }
}

function cargarContenido(urltab) {
    const divTarget = document.getElementById('resultTab');
    divTarget.innerHTML = ''; //limpiamos antes de pintar
    divTarget.classList.add('show', 'active'); //activamos la sección de resultados si esta no existe
    addSpinner(divTarget);
    // Realizamos la llamada a la API utilizando la función fetch
    fetchData(urltab)
    .then(data => {
        
        if(data.Message === MESSAGE_TYPES.ERROR){
            divTarget.innerHTML = '<p class="text-center mt-3">'+MESSAGE_TYPES.MESSAGE_ERROR+'</p>';
            return;
        }
        // console.log(data);
        // return
        renderFetch(divTarget,data);

    });

}
/*
Custom url si es true entonces coge la url tal cual
*/
function fetchData(url,customurl = false, options = { headers: {'X-Requested-With': 'XMLHttpRequest'} }) {

    if(!customurl){
         // Seleccionar la etiqueta meta por su nombre
         const metaUrl = document.querySelector('meta[name="url"]');

         // Obtener el valor de la meta etiqueta
         const uri = metaUrl.getAttribute('content');
         url = uri + url;
    }
    return fetch(url, options)
      .then(response => response.json())
      .catch(error => console.error(error));
  }
  

function enviarContenido(urltab){
    const metaUrl = document.querySelector('meta[name="url"]').getAttribute('content');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    fetch(metaUrl+urltab, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrfToken
        },
        body: JSON.stringify({
            // datos a enviar en el cuerpo de la solicitud
        })
        })
        .then(response => response.json())
        .then(data => {
        // procesar los datos de la respuesta
        })
        .catch(error => {
        console.error('Ha ocurrido un error:', error);
    });
}

function activateTab(tab) {
    try {
        const tabs = document.querySelectorAll('.nav-tabs .nav-link');
  
        tabs.forEach(tab => {
          tab.classList.remove('active');
        });
      
        tab.classList.add('active');
    } catch (error) {
        
    }
}

function renderFetch(target,data){
    const firstContainer = document.createElement(data.type);
    //Comprobamos si hay más información que poner al contenedor padre
    if (data.attributes && typeof data.attributes === 'object') {
        
        for (const attribute in data.attributes) {
            if (data.attributes.hasOwnProperty(attribute)) {
              const value = data.attributes[attribute];
              firstContainer.setAttribute(attribute, value);
            }
          }
    }
    

    //Comprobamos que hay información de los nodos hijo y es un array   
    if (data.childValues && Array.isArray(data.childValues)) {
        data.childValues.forEach(function(child) {
            const childElement = document.createElement(child.type);
          
            // Recorrer los atributos del hijo
            Object.entries(child.attributes).forEach(([attribute, value]) => {
              childElement.setAttribute(attribute, value);
            });
          
            // Asignar el valor del hijo
            childElement.innerHTML = child.value;
          
            // Agregar el hijo al contenedor padre
            firstContainer.appendChild(childElement);
          });
    }
    target.innerHTML = ''; //limpiamos antes de pintar
    target.appendChild(firstContainer);
}
  

function addSpinner(element){

    const divContainer = document.createElement('div');
    divContainer.classList.add('d-flex');
    divContainer.classList.add('justify-content-center');
    divContainer.classList.add('mt-4');

    const spinnerDiv = document.createElement('div');
    spinnerDiv.classList.add('spinner-border');
    spinnerDiv.setAttribute('role', 'status');

    const spinnerText = document.createElement('span');
    spinnerText.classList.add('visually-hidden');
    spinnerText.textContent = 'Loading...';

    // Agregar el elemento span al elemento div
    spinnerDiv.appendChild(spinnerText);
    divContainer.appendChild(spinnerDiv);

    // Agregar el elemento div al contenedor
    element.appendChild(divContainer);

}