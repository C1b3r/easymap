/** Flash message */
if (document.getElementsByClassName('flash-message-container').length > 0) {
    //Evitar instanciar timers innecesarios
    if (countChildElement(".flash-message-container") > 0) {
        setTimeout(function() {
                let alert = document.querySelector(".flash-message-container");
                var myVar = setInterval(function() {
                    //If child of container is zero, cant remove nothing else, clear timer
                    if (countChildElement(".flash-message-container") != 0) {
                        alert.removeChild(alert.childNodes[0]);
                    } else {
                        clearInterval(myVar);
                    }

                }, 2000);

            },
            3000);
    }

}

function countChildElement(nameElement) {
    return document.querySelector(nameElement).childElementCount
}