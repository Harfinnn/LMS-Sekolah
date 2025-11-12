import Swiper from 'swiper/bundle';

document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper(".swiperInformation", {
        slidesPerView: 1,
        spaceBetween: 20,
        breakpoints: {
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 4 },
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        loop: true,
    });
});

