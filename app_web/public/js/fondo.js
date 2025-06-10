document.addEventListener("DOMContentLoaded", () => {
    const fondoRotativo = document.querySelectorAll('.fondo-rotativo img');
    let index = 0;

    // Función para cambiar la imagen activa
    function cambiarFondo() {
        fondoRotativo.forEach((img, i) => {
            img.classList.toggle('active', i === index);
        });
        index = (index + 1) % fondoRotativo.length;
    }

    // Cambio automático cada 5 segundos
    setInterval(cambiarFondo, 5000);

    // Evento manual con clic
    fondoRotativo.forEach((img, i) => {
        img.addEventListener('click', () => {
            index = i;
            cambiarFondo();
        });
    });

    // Iniciar con la primera imagen
    cambiarFondo();
});
