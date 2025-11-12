import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

let swiperInstance = null;

function initSwiper() {
    if (window.innerWidth < 768 && !swiperInstance) {
        swiperInstance = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 15,
            centeredSlides: true,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    } else if (window.innerWidth >= 768 && swiperInstance) {
        swiperInstance.destroy(true, true);
        swiperInstance = null;
    }
}

// Jalankan pertama kali setelah halaman siap
document.addEventListener("DOMContentLoaded", initSwiper);

// Jalankan ulang setiap kali ukuran layar berubah
window.addEventListener("resize", () => {
    initSwiper();
});
