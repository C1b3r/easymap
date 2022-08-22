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

function cargarContenido(url) {
    //ajax
}