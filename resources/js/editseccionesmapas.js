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
        cargarListener();
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

function renderFetch(target, data) {
    const firstContainer = createContainer(data.type);
    addAttributes(firstContainer, data.attributes);
    createChildElements(firstContainer, data.childValues);
  
    target.innerHTML = ''; // Limpiamos antes de pintar
    target.appendChild(firstContainer);
  }
  
  function createContainer(type) {
    return document.createElement(type);
  }
  
  function addAttributes(element, attributes) {
    if (attributes && typeof attributes === 'object') {
      for (const attribute in attributes) {
        if(attribute ==='innerText'){
          element.innerHTML = attributes.innerText;
          continue;
        }
        if (attributes.hasOwnProperty(attribute)) {
          const value = attributes[attribute];
          element.setAttribute(attribute, value);
        }
      }
    }
  }
  
  function createChildElements(parent, childValues) {
    if (childValues && Array.isArray(childValues)) {
      childValues.forEach(function (child) {
        const childElement = createChildElement(child.type);
        addAttributes(childElement, child.attributes);
  
        if (child.childValues && Array.isArray(child.childValues)) {
          createChildElements(childElement, child.childValues);
        }
  
        if (child.value) {
          childElement.innerHTML = child.value;
        }
  
        parent.appendChild(childElement);
      });
    }
  }
  
  
  function createChildElement(type) {
    return document.createElement(type);
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

//Lo meto aquí ya que al cargarlo por fetch, no existen y va a fallar
function cargarListener (){
  var iframecontents = document.getElementsByClassName('iframe-content');
  iframecontents[0].addEventListener('click', function(event) {
    //Lo cargo mejor en una ventana emergente que en un iframe para poder tener la info de coordenadas en cada pestaña
    let element = event.target
    const windowFeatures = "left=100,top=100,width=1109.520,height=316.190";
    const handle = window.open(
      element.getAttribute("data-src"),
      "_blank",
      windowFeatures
    );
    /*
    let iframeContainer = document.getElementById("iframe-container");
    // Obtener el atributo "data-src" del elemento actual (this)
    let element = event.target
    let iframeSrc = element.getAttribute("data-src");

    // Crear el iframe y establecer el src
    var iframe = document.createElement('iframe');
    iframe.src = iframeSrc;
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('allowfullscreen', 'true');
    iframe.style.width = '100%';
    iframe.style.height = '300px';

    // Reemplazar el div por el iframe
    iframeContainer.innerHTML = '';
    iframeContainer.appendChild(iframe);*/
  });
}