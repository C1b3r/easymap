/**
 * Night mode Section
 */
const boton = document.getElementById('btn-dark-light-theme');
const configUser = window.matchMedia('(prefers-color-scheme: dark)');
const localConfig = localStorage.getItem('tema');

if (localStorage.getItem("tema") === null) {
    let colorTema;
    if (!configUser.matches) {
        //Si tenemos modo oscuro configurado, no ponemos el modo claro
        document.body.classList.toggle('bg-light');
        colorTema = document.body.classList.contains('bg-light') ? 'light' : 'dark';
    } else {
        document.body.classList.toggle('bg-dark');
        colorTema = document.body.classList.contains('bg-dark') ? 'dark' : 'light';
    }
    //Guardamos en localstorage lo elegido
    localStorage.setItem('tema', colorTema);
    cambioFondoColor(colorTema);
    cambioTextoColor(colorTema);
    cambioBotonColor(colorTema);

} else {
    if (localConfig === 'dark') {
        document.body.classList.toggle('bg-dark');
    } else if (localConfig === 'light') {
        document.body.classList.toggle('bg-light');
    }
    cambioFondoColor(localConfig);
    cambioTextoColor(localConfig);
    cambioBotonColor(localConfig);

    if (boton) {
        cambioBtnCambioColor(localConfig);
    }
}


if (boton) {
    boton.addEventListener('click', () => {
        let colorTema;
        document.body.classList.toggle('bg-light');
        document.body.classList.toggle('bg-dark');
        colorTema = document.body.classList.contains('bg-light') ? 'light' : 'dark';
        localStorage.setItem('tema', colorTema);
        cambioFondoColor(colorTema);
        cambioTextoColor(colorTema);
        cambioBotonColor(colorTema);

        cambioBtnCambioColor(colorTema);

    });
}
/*Ej: En el caso de Light Recorro los elementos y pongo light donde tenga dark, excepto los que tenga inverso, que en ese caso tengo que agregar oscuro donde tenga light. En el caso de dark vuelvo dark donde tenga light siempre y cuando el inverso no sea true. Esto se hace de esta manera para el caso de un fondo blanco y un div oscuro, el div oscuro mantenga la visibilidad al pasarlo a oscuro */
function cambioFondoColor(colores) {
    var color = document.querySelectorAll('.bg-dark, .bg-light');

    color.forEach((color, index) => {
        const inverso = color.getAttribute('inverso');
        if (colores === "light") {
            if (inverso != "true") {
                color.classList.remove('bg-dark');
                color.classList.add('bg-light');
            } else {
                color.classList.add('bg-dark');
                color.classList.remove('bg-light');
            }
        } else {
            if (inverso != "true") {
                color.classList.add('bg-dark');
                color.classList.remove('bg-light');
            } else {
                color.classList.remove('bg-dark');
                color.classList.add('bg-light');
            }
        }

    });
}

/*En este caso, cuando sea light tengo que poner textos en oscuro siempre y cuando no sea el inverso true */

function cambioTextoColor(colores) {
    var color = document.querySelectorAll('.text-white, .text-dark');

    color.forEach((color, index) => {
        const inverso = color.getAttribute('inverso');
        if (colores === "light") {
            if (inverso != "true") {
                color.classList.add('text-dark');
                color.classList.remove('text-white');

            } else {
                color.classList.remove('text-dark');
                color.classList.add('text-white');
            }
        } else {
            if (inverso != "true") {
                color.classList.remove('text-dark');
                color.classList.add('text-white');

            } else {
                color.classList.add('text-dark');
                color.classList.remove('text-white');
            }
        }

    });
}
/* En este caso cuando sea light tengo que volver light lo que haya dark siempre y cuando no haya un inverso definido */
function cambioBotonColor(colores) {
    var color = document.querySelectorAll('.btn-outline-light, .btn-outline-dark');

    color.forEach((color, index) => {
        const inverso = color.getAttribute('inverso');
        if (colores === "light") {
            if (inverso != "true") {
                color.classList.add('btn-outline-dark');
                color.classList.remove('btn-outline-light');
            } else {
                color.classList.remove('btn-outline-dark');
                color.classList.add('btn-outline-light');
            }

        } else {
            if (inverso != "true") {
                color.classList.remove('btn-outline-dark');
                color.classList.add('btn-outline-light');
            } else {
                color.classList.add('btn-outline-dark');
                color.classList.remove('btn-outline-light');
            }
        }



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