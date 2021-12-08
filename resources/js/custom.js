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
}


if (boton) {
    boton.addEventListener('click', () => {
        let colorTema;
        colorTema = htmlroot.classList.contains('mp-root--theme-dark') ? 'light' : 'dark';
        localStorage.setItem('tema', colorTema);
        cambioTema(colorTema);
    });
}

function cambioTema(colorTema) {
    htmlroot.classList.toggle('mp-root--theme-light');
    htmlroot.classList.toggle('mp-root--theme-dark');

}

/** Flash message */
// setTimeout(function() {
//     let alert = document.querySelector(".flash-message-container");
//     // alert.style.opacity = '0';
//     alert.remove();
// }, 3000);

setTimeout(function() {
        let alert = document.querySelector(".flash-message-container");
        var myVar = setInterval(function() {
            //If child of container is zero, cant remove nothing else, clear timer
            if (document.querySelector(".flash-message-container").childElementCount != 0) {
                alert.removeChild(alert.childNodes[0]);
            } else {
                clearInterval(myVar);
            }

        }, 2000);

    },
    3000);