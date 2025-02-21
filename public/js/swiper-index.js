const container = document.querySelector(".facility-container");

var swiper = new Swiper(".swiper", {
  spaceBetween: 30,
  slidesPerView: "auto",
  loop: true,
  speed: 3000,
  freeMode: true,
  allowTouchMove: false,
  autoplay: {
    delay: 0,
  },
});

function stopAutoplay() {
  const swiperTranslate = swiper.getTranslate();
  swiper.setTranslate(swiperTranslate);
  swiper.autoplay.stop();
}

function startAutoplay() {
  swiper.slideTo(swiper.activeIndex, 4000, false);
  swiper.autoplay.start();
}

container.addEventListener("mouseenter", () => stopAutoplay());
container.addEventListener("mouseleave", () => startAutoplay());
