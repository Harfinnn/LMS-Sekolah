import './navbar';
import 'flowbite';
import Typed from 'typed.js';
import './information';
import './information-upload'
import './gallery'
import './gallery-upload'
import './alert'
import './area-form'
import 'swiper/css';
import 'swiper/css/pagination';
import 'leaflet/dist/leaflet.css'; 
import initMaps from './map.init';
import './partners';

document.addEventListener("DOMContentLoaded", () => {
    const typedElement = document.getElementById("typed-text");
    const subtitle = document.getElementById("subtitle");

    if (typedElement) {
        let strings = [];

        try {
            strings = JSON.parse(typedElement.dataset.strings);
        } catch (error) {
            console.error("Format data-strings tidak valid:", error);
        }

        if (strings.length > 0) {
            new Typed("#typed-text", {
                strings: strings,
                typeSpeed: 50,
                backSpeed: 30,
                startDelay: 500,
                loop: false, 
                showCursor: true,
                cursorChar: "|",
                onComplete: () => {
                    if (subtitle) subtitle.classList.remove("opacity-0");
                },
            });
        }
    }
});

document.addEventListener('DOMContentLoaded', () => {
    initMaps();
});