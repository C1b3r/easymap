var parametroUrl = window.location.hash.substring(1);
if (parametroUrl == '') {
    cargarTab();
} else {
    cargarTab(window.location.hash.substring(1));
}

function cargarTab(tab = '') { 
    //Si esta vacio, que cargue el primero obligatoriamente
    if (tab === '') {
        let tab = document.querySelector('a[primerTab]');
        cargarContenido(tab.hash.substring(1))
    } else {
        cargarContenido(tab)
    }

}

function cargarContenido(urltab) {
    // Seleccionar la etiqueta meta por su nombre
    const metaUrl = document.querySelector('meta[name="url"]');

    // Obtener el valor de la meta etiqueta
    const url = metaUrl.getAttribute('content');
    // Realizamos la llamada a la API utilizando la función fetch
    fetch(url + urltab)
    .then(response => response.json()) // Convertimos la respuesta a JSON
    .then(data => {
    // Obtenemos los datos del JSON
    const titulo = data.titulo;
    const descripcion = data.descripcion;

    // Creamos un nuevo elemento de título
    const tituloElemento = document.createElement('h2');
    tituloElemento.textContent = titulo;

    // Creamos un nuevo elemento de descripción
    const descripcionElemento = document.createElement('p');
    descripcionElemento.textContent = descripcion;

    // Añadimos los elementos al contenedor de la sección
    const contenedor = document.querySelector('.seccion');
    contenedor.appendChild(tituloElemento);
    contenedor.appendChild(descripcionElemento);
    })
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