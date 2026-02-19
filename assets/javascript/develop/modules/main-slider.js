import Swiper from '../libs/swiper';

export const mainSlider = (root = document) => {
  const sliders = root.querySelectorAll('[data-main-slider]');
  if (!sliders.length) return null;

  const instances = [];

  sliders.forEach((slider) => {
    const currentSlider = slider.querySelector('.main-slider__inner.swiper');
    if (!currentSlider) return;

    let swiper = null;

    const init = () => {
      swiper = new Swiper(currentSlider, {
        speed: 1200,
        autoplay: {
          delay: 7000,
          disableOnInteraction: false,
        },
        loop: true,
        effect: 'creative',
        creativeEffect: {},
      });

      instances.push(swiper);
    };

    // Delay for "Loader animation"
    const timeout = setTimeout(init, 0); // 3750

    // We keep a reference to clear the timeout if it is destroyed before it is destroyed.
    slider.__mainSliderTimeout = timeout;
  });

  return {
    destroy() {
      sliders.forEach((slider) => {
        // Clear timeout if it did not initialize
        if (slider.__mainSliderTimeout) {
          clearTimeout(slider.__mainSliderTimeout);
          delete slider.__mainSliderTimeout;
        }
      });

      instances.forEach((swiper) => {
        if (swiper && !swiper.destroyed) {
          swiper.destroy(true, true);
        }
      });

      instances.length = 0;
    },
  };
};
