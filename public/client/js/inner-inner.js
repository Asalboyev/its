var swiper = new Swiper(".mySwiper", {
  // loop: true,
  spaceBetween: 8,
  slidesPerView: 5,
  freeMode: true,
  watchSlidesProgress: true,
});
var swiper2 = new Swiper(".mainImagesDiv", {
  // loop: true,
  breakpoints: {
    600: {
      slidesPerView: 1.5,
      spaceBetween: 10,
    },
    768: {
      slidesPerView: 1.8,
      spaceBetween: 10,
    },
    1024: {
      slidesPerView: 1.8,
      spaceBetween: 10,
    },
    1200: {
      slidesPerView: 2.1,
      spaceBetween: 10,
    },
    1800: {
      slidesPerView: 1.41,
      spaceBetween: 10,
    }
  },
  slidesPerView: 1,
  spaceBetween: 20,
  thumbs: {
    swiper: swiper,
  },
  centeredSlides: true,
  loop: true,
});