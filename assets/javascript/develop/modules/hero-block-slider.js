import Swiper from '../libs/swiper';

export const heroBlockSlider = (root = document) => {
    const sliders = root.querySelectorAll('[data-hero-block-slider]');
    if (!sliders.length) return null;

  const instances = [];

  sliders.forEach((slider) => {
    const currentSlider = slider.querySelector('.hero-block-slider__inner.swiper');
    if (!currentSlider) return;

    let swiper = null;

    const init = () => {
      swiper = new Swiper(currentSlider, {
        speed: 1200,
        autoplay: {
          delay: 6000,
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
    slider.__heroBlockSliderTimeout = timeout;
  });

  return {
    destroy() {
      sliders.forEach((slider) => {
        // Clear timeout if it did not initialize
        if (slider.__heroBlockSliderTimeout) {
          clearTimeout(slider.__heroBlockSliderTimeout);
          delete slider.__heroBlockSliderTimeout;
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
