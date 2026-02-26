// modules/project-slider.js

import Swiper from '../libs/swiper'; 

const toInt = (v, fallback) => {
  const n = parseInt(v, 10);
  return Number.isFinite(n) ? n : fallback;
};

export const sliderBlock = (root = document) => {

  const sliders = root.querySelectorAll('[data-swiper]');

  if (!sliders.length) return null;

  const instances = [];

  sliders.forEach((el) => {

    // Evita doble init si volvés a llamar
    if (el.swiper && !el.swiper.destroyed) {
      el.swiper.destroy(true, true);
    }

    const spvMobile = toInt(el.dataset.spvMobile, 2);
    const spvDesktop = toInt(el.dataset.spvDesktop, 3);
    const spaceMobile = toInt(el.dataset.spaceMobile, 12);
    const spaceDesktop = toInt(el.dataset.spaceDesktop, 24);

    const swiper = new Swiper(el, {
      speed: 550,
      watchOverflow: true,
      slidesPerView: spvMobile,
      spaceBetween: spaceMobile,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      loop: true,

      breakpoints: {
        1024: {
          slidesPerView: spvDesktop,
          spaceBetween: spaceDesktop,
        },
      },
    });

    instances.push(swiper);

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