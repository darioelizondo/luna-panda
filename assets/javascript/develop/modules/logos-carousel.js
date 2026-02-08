import Swiper from '../libs/swiper';

export const logosCarousel = ( root = document ) => {
  const sliders = root.querySelectorAll('[data-logos-slider]');
  if (!sliders.length) return null;

  const instances = [];

  sliders.forEach((slider) => {
    const currentSlider = slider.querySelector('.logos-slider__inner.swiper');
    if (!currentSlider) return;

    let swiper = null;

    const init = () => {
      swiper = new Swiper(currentSlider, {
        speed: 3000,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        loop: true,
        slidesPerView: 2,
        spaceBetween: 24,
        breakpoints: {
            768: {
                slidesPerView: 4,
                spaceBetween: 24,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 24,
            },
            1280: {
                slidesPerView: 6,
                spaceBetween: 24,
            },
            1700: {
                slidesPerView: 7,
                spaceBetween: 24,
            },
        },
      });

      instances.push(swiper);
    };

    init();

  });

  return {
    destroy() {

      instances.forEach((swiper) => {
        if (swiper && !swiper.destroyed) {
          swiper.destroy(true, true);
        }
      });

      instances.length = 0;

    },
  };
};
