// Función para obtener una cookie por nombre
function getCookie(nombre) {
    let nombreEQ = nombre + "=";
    let cookies = document.cookie.split(';');
    for(let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.indexOf(nombreEQ) === 0) {
            return cookie.substring(nombreEQ.length, cookie.length);
        }
    }
    return null;
}

// Función para establecer una cookie con expiración
function setCookie(nombre, valor, dias) {
    let fecha = new Date();
    fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000)); // Define los días
    let expira = "expires=" + fecha.toUTCString();
    document.cookie = nombre + "=" + valor + ";" + expira + ";path=/";
}

// Función para contar la visita si no ha sido contada en las últimas 24 horas
function contarVisita() {
    // Comprueba si ya existe la cookie 'visitaUnica'
    if (!getCookie('visitaUnica') ) {
        // Si no existe, es una visita nueva, enviamos una solicitud al servidor
        fetch('/hosting__contador__visitas__unicas.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'visita_nueva=true&h=2184222&t=1741790808&k=5a07e49e0cdd12e378dd837027df03b7&__muid='
        });

        // Establece una cookie para marcar que ya se ha contado la visita
        setCookie('visitaUnica', 'true', 1); // Expira en 1 día (24 horas)
    }
}

// Llama a la función al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    contarVisita();
});
