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
        cargarContenido(tab);
    }
}

function cargarContenido(urltab) {
    const divTarget = document.getElementById('resultTab');
    // Realizamos la llamada a la API utilizando la función fetch
    fetchData(urltab)
    .then(data => {
        
        if(data.Message === MESSAGE_TYPES.ERROR){
            divTarget.innerHTML = '<p class="text-center mt-3">'+MESSAGE_TYPES.MESSAGE_ERROR+'</p>';
            divTarget.classList.add('show', 'active');
            return;
        }
        // console.log(data);
        // return
        const titulo = data.titulo;
        const descripcion = data.descripcion;
    
        // Crear los elementos y añadirlos al contenedor
        const tituloElemento = document.createElement('h2');
        tituloElemento.textContent = titulo;
        const descripcionElemento = document.createElement('p');
        descripcionElemento.textContent = descripcion;
    
        const contenedor = document.querySelector('#resultTab');
        contenedor.appendChild(tituloElemento);
        contenedor.appendChild(descripcionElemento);
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
    const tabs = document.querySelectorAll('.nav-tabs .nav-link');
  
    tabs.forEach(tab => {
      tab.classList.remove('active');
    });
  
    tab.classList.add('active');
}
  