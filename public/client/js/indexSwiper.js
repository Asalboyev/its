var partnersSwiper = new Swiper(".parntersSwiper", {
    breakpoints: {
        600: {
            slidesPerView: 2.3,
            spaceBetween: 14,
        },
        768: {
            slidesPerView: 3.5,
            spaceBetween: 24,
        },
        1024: {
            slidesPerView: 4.5,
            spaceBetween: 24,
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 24,
        },
    },
    slidesPerView: 1,
    spaceBetween: 8,
    loop: true,
    autoplay: {
        delay: 1800,
        disableOnInteraction: false,
    },
    speed: 1200,
    navigation: {
        nextEl: ".nextBtn",
        prevEl: ".prevBtn",
    },
    centeredSlides: true
});

var developmentsSwiper = new Swiper(".developmentsSwiper", {
    breakpoints: {
        600: {
            slidesPerView: 1.8,
            spaceBetween: 14,
        },
        768: {
            slidesPerView: 2.6,
            spaceBetween: 24,
        },
    },
    slidesPerView: 1,
    spaceBetween: 16,
    autoplay: {
        delay: 1800,
        disableOnInteraction: false,
    },
    speed: 2000,
    loop: true,
})