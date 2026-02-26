// modules/related-projects-carousel.js
import Swiper from '../libs/swiper';

export const relatedProjectsCarousel = (root = document) => {
  const el = root.querySelector('[data-related-projects-swiper]');
  if (!el) return null;

  let swiper = null;
  const mql = window.matchMedia('(max-width: 1023px)');

  const init = () => {
    if (swiper && !swiper.destroyed) return;

    // Por si quedó algo viejo
    if (el.swiper && !el.swiper.destroyed) {
      el.swiper.destroy(true, true);
    }

    swiper = new Swiper(el, {
      slidesPerView: 1.2,
      spaceBetween: 16,
      speed: 500,
      watchOverflow: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      loop: true,

    });
  };

  const destroy = () => {
    if (swiper && !swiper.destroyed) {
      swiper.destroy(true, true);
    }
    swiper = null;
  };

  const onChange = (e) => {
    if (e.matches) init();
    else destroy();
  };

  // init inicial según estado
  onChange(mql);

  // listener (compat)
  if (mql.addEventListener) mql.addEventListener('change', onChange);
  else mql.addListener(onChange);

  return {
    destroy() {
      destroy();
      if (mql.removeEventListener) mql.removeEventListener('change', onChange);
      else mql.removeListener(onChange);
    },
  };
};