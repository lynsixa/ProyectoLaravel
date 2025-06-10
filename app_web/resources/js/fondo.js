// public/js/fondo.js

let currentIndex = 0;
const images = [
    '/Img/IMG_5081.JPG',
    '/Img/DSC06494.jpg',
    '/Img/IMG_5105.JPG'
];

function changeBackground() {
    document.body.style.backgroundImage = `url('${images[currentIndex]}')`;
    currentIndex = (currentIndex + 1) % images.length;
}

// Cambia el fondo cada 2 segundos
setInterval(changeBackground, 2000);
changeBackground();
