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
        console.log("oscuro");
    } else {
        document.body.classList.toggle('bg-dark');
        colorTema = document.body.classList.contains('bg-dark') ? 'dark' : 'light';
        console.log("claro");
    }
    //Guardamos en localstorage lo elegido
    localStorage.setItem('tema', colorTema);
} else {
    if (localConfig === 'dark') {
        document.body.classList.toggle('bg-dark');
    } else if (localConfig === 'light') {
        document.body.classList.toggle('bg-light');
    }
}



boton.addEventListener('click', () => {
    let colorTema;
    document.body.classList.toggle('bg-light');
    document.body.classList.toggle('bg-dark');
    colorTema = document.body.classList.contains('bg-light') ? 'light' : 'dark';
    localStorage.setItem('tema', colorTema);
})