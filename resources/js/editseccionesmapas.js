var parametroUrl = window.location.hash.substring(1);
var currentId = document.getElementById('cuId').value;
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
    const divTarget = document.getElementById(urltab);
    if(checkIfLoaded(divTarget)){
      limpiaShowActivos();
      divTarget.classList.add('show', 'active','loaded');
      return;
    }
    // divTarget.innerHTML = ''; //limpiamos antes de pintar
    limpiaShowActivos(); //limpiamos los div que ya tengan los elementos de clase
    divTarget.classList.add('show', 'active','loaded'); //activamos la sección de resultados si esta no existe
    addSpinner(divTarget);
    if (urltab === 'datatable') {
      // setTimeout(cargarReferenciasDataTables, 500); //retrasamos la carga ya que tiene que pintarlo después de jquery
      setTimeout(() => {
        cargarReferenciasDataTables().then(() => {
          divTarget.innerHTML = '';
          configurarDataTable(divTarget);
        });
      }, 500); // Establecer un retraso de 500 milisegundos (medio segundo)
      return;
    }
      
    // Realizamos la llamada a la API utilizando la función fetch
    fetchData(urltab+'/'+currentId)
    .then(data => {

        if(data.Message === MESSAGE_TYPES.ERROR){
            divTarget.innerHTML = '<p class="text-center mt-3">'+MESSAGE_TYPES.MESSAGE_ERROR+'</p>';
            return;
        }
        // console.log(data);
        // return
        renderFetch(divTarget,data);
        cargarListener();
    }).catch(error => {
      // Manejar el error aquí, es un error no controlado y puede ser cualquier cosa
      console.error(error);
    
    });

}

 // Realizar la configuración y la carga de la tabla DataTables
 function configurarDataTable(divTarget) {
  // Crear la tabla y asignarle un id
  const table = document.createElement('table');
  table.id = 'miTabla'; // Asigna un id a la tabla

  // Agregar la tabla como hijo del divTarget
  divTarget.appendChild(table);

  // Configurar las opciones y configuraciones de DataTables
  const dataTableOptions = {
    columns: [
      {
        data: 'latitude',
        title: 'Latitud'
      },
      {
        data: 'longitude',
        title: 'Longitud'
      },
      {
        data: 'image_name',
        title: 'Imagen'
      },
      {
        data: 'id_spot',
        title: 'ID Spot'
      }
    ],
    "pageLength": 25,
    serverSide: true,
    ajax: {
      url: getUrl()+'cargarPuntos/'+currentId,
      type: 'POST',
      dataSrc: 'data',
      data: function (params) {
          // Aquí se establecen los parámetros de paginación
          params.page = params.start / params.length + 1; // Calcular el número de página
          params.limit = params.length; // Establecer el límite de registros por página
          return params;
      },
      error: function (xhr, textStatus, error) {
          console.error(error);
      }
  }
  };
   // Inicializar la tabla DataTables utilizando el elemento HTML de la tabla
   const miTabla = new DataTable(table, dataTableOptions);

  
}


async function cargarReferenciasDataTables() {
  // Verificar si el CSS ya está cargado
  var linkExists = document.querySelector('link[href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css"]');
  if (!linkExists) {
    await cargarScriptAsync('https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css', 'css');

    // Cargar el CSS de DataTables
   /* var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css';
    document.head.appendChild(link);*/
  }

  // Verificar si el JS ya está cargado
  var scriptExists = document.querySelector('script[src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"]');
  if (!scriptExists) {
    await cargarScriptAsync('https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js', 'script');
    // Cargar el JS de DataTables
    /*var script = document.createElement('script');
    script.src = 'https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js';
    document.body.appendChild(script);*/
  }
  return true;
}

function cargarScriptAsync(src, type) {
  return new Promise((resolve, reject) => {
    const element = document.createElement(type === 'css' ? 'link' : 'script');
    element.onload = () => {
      resolve();
    };
    element.onerror = () => {
      reject(new Error(`Error al cargar el script: ${src}`));
    };

    if (type === 'css') {
      element.rel = 'stylesheet';
      element.href = src;
    } else if (type === 'script') {
      element.src = src;
    }

    document.head.appendChild(element);
  });
}

function checkIfLoaded(element)
{
  return element.classList.contains('loaded');
}

function limpiaShowActivos()
{
  const elements = document.getElementsByClassName('show active'); // Reemplaza 'tu-selector-de-elementos' con el selector adecuado para tus elementos
  
 // Convierte la lista de elementos en un array para poder usar forEach
 const elementsArray = Array.from(elements);
  
 elementsArray.forEach(function(element) {
   element.classList.remove('show', 'active');
 });
}

//no-use, use limpiaShowActivos
function removeShowActiveClasses() {
  const elements = document.querySelectorAll('.selector-de-elementos'); // Reemplaza 'tu-selector-de-elementos' con el selector adecuado para tus elementos
  
  elements.forEach(function(element) {
    element.classList.remove('show', 'active');
  });
}
/*
Custom url si es true entonces coge la url tal cual
*/
function fetchData(url,customurl = false, options = { headers: {'X-Requested-With': 'XMLHttpRequest'} }) {

    if(!customurl){
         url = getUrl() + url;
    }
    return fetch(url, options)
      .then(response => response.json())
      .catch(error => console.error(error));
  }

function getUrl()
{
  // Seleccionar la etiqueta meta por su nombre
  const metaUrl = document.querySelector('meta[name="url"]');
  // Obtener el valor de la meta etiqueta
  const uri = metaUrl.getAttribute('content');
  return uri;
}

function enviarContenidoJSON(urltab){
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
function enviarContenidoAdjunto(urltab,formData,elements){
  const metaUrl = document.querySelector('meta[name="url"]').getAttribute('content');
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
  // Configurar las opciones de la petición Fetch
  const options = {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-Token': csrfToken
    },
    body: formData,
  };

  fetch(metaUrl+urltab, options)
  .then(response => response.json())
  .then(data => {
    if (data.Message) {
      // Se produjo un error, manejarlo adecuadamente
      console.error(data.Message);
      alert(data.Message);
      return null; // Retorna null si hay un error
    } else {
      return data.id; // Retorna el ID
    }
  })
  .then(id => {
    if (id !== null && id !== undefined) {
      elements.imagenId.value = id;
      elements.btn.innerHTML = '¡Subido!';
      elements.btn.disabled = true;
      elements.imagenInterna.required = false;
      elements.imagenExterna.required = false
    }
  })
  .catch(error => {
    console.error(error);
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
  if (iframecontents.length === 0) {
    return;
  }
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

function subirImagen(btn)
{
  let imagenInterna = document.getElementById("imgint");
  let imagenExterna = document.getElementById("imgext");
  let imagenId = document.getElementById('img_id');
  let id = document.getElementById('cuId').value;
  let imagenSubir = '';
   //si no están rellenos, mostramos alerta
  if((imagenInterna.value == null || imagenInterna.value == "") && (imagenExterna.value == null || imagenExterna.value == "") ){
    alert("No hay ninguna imagen subida");
    return;
  }
 //Si hay subida en ambas lanzamos el confirm para que acepte una u otra
  if((imagenInterna.value !== null && imagenInterna.value !== "") && (imagenExterna.value !== null && imagenExterna.value !== "") ){
    if (window.confirm("Tienes ambos campos de imagen relleno ¿Quieres quedarte con la interna?")) {
      imagenSubir = imagenInterna;
    }else{
      imagenSubir = imagenExterna;
    }
  }
  //Ahora comprobamos uno por uno en caso de que se haya subido uno u otro
  if(imagenSubir.length==0){
    //imagen interna
    if((imagenInterna.value !== null || imagenInterna.value !== "") && (imagenExterna.value == null || imagenExterna.value == "") ){
      imagenSubir = imagenInterna.files[0];
      
    }else{
      imagenSubir = imagenExterna.value;
    }
  }

  // Crear un objeto FormData y agregar los datos
  const formData = new FormData();
  formData.append('id', id);
  formData.append('imagen', imagenSubir); // Agregar el archivo al formulario
  
  enviarContenidoAdjunto('subirImagen',formData,{btn,imagenId,imagenInterna,imagenExterna});


 
 
}