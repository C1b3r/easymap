/**
 * Night mode Section
 */
const boton = document.getElementById('btn-dark-light-theme');
const configUser = window.matchMedia('(prefers-color-scheme: dark)');
const localConfig = localStorage.getItem('tema');
const htmlroot = document.getElementsByTagName('html')[0];

if (localStorage.getItem("tema") === null) {
    let colorTema;
    if (!configUser.matches) {
        //Si tenemos modo oscuro configurado, no ponemos el modo claro
        htmlroot.classList.toggle('mp-root--theme-light');
        colorTema = htmlroot.classList.contains('mp-root--theme-light') ? 'light' : 'dark';
    } else {
        htmlroot.classList.toggle('mp-root--theme-dark');
        colorTema = htmlroot.classList.contains('mp-root--theme-dark') ? 'dark' : 'light';
    }
    //Guardamos en localstorage lo elegido
    localStorage.setItem('tema', colorTema);

} else {
    if (localConfig === 'dark') {
        htmlroot.classList.toggle('mp-root--theme-dark');
        } else if (localConfig === 'light') {
            htmlroot.classList.toggle('mp-root--theme-light');
         }

        if (boton) {
            cambioBtnCambioColor(localConfig);
        }
    }


if (boton) {
    boton.addEventListener('click', () => {
        let colorTema;
        colorTema = htmlroot.classList.contains('mp-root--theme-dark') ? 'light' : 'dark';
        localStorage.setItem('tema', colorTema);
        cambioTema(colorTema);

        cambioBtnCambioColor(colorTema);

    });
}

function cambioBtnCambioColor(colorTema) {
    //Como último detalle cambiamos el icono del boton
    if (colorTema === 'light') {
        document.getElementsByClassName('btn-dark-theme')[0].style.display = "block";
        document.getElementsByClassName('btn-light-theme')[0].style.display = "none";
    } else {
        document.getElementsByClassName('btn-dark-theme')[0].style.display = "none";
        document.getElementsByClassName('btn-light-theme')[0].style.display = "block";
    }
}

function cambioTema(colorTema){
    htmlroot.classList.toggle('mp-root--theme-light');
    htmlroot.classList.toggle('mp-root--theme-dark');

}
