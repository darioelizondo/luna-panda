import barba from './libs/barba';
import gsap from './libs/gsap';

const pageTransition = () => {

  const wrapper = document.querySelector('[data-barba="wrapper"]');
  const container = document.querySelector('[data-barba="container"]');

  if (!wrapper || !container) {
    console.warn('[Barba] wrapper/container not found. Skipping Barba init.');
    return;
  }
  
  // 1) Definimos la transición (solo animación)
  barba.init({
    transitions: [
      {
        name: 'fade',

        leave({ current }) {
          return gsap.to(current.container, {
            opacity: 0,
            position: "absolute",
            left: 0,
            top: 0,            
            duration: 0.5,
            ease: 'power1.out',
          });
        },

        enter({ next }) {
          gsap.set(next.container, { opacity: 0 });
        //   gsap.set(next.container, { position: "absolute", left: 0, top: 0, width: "100%" });

          return gsap.to(next.container, {
            opacity: 1,
            duration: 0.5,
            ease: 'power1.out',
          });
        },
      },
    ],
  });

  // 2) Hooks (lógica del sitio): más confiable que onComplete
  barba.hooks.enter(() => {
    window.scrollTo(0, 0);
  });

  barba.hooks.beforeLeave(({ current }) => {
    window.App?.destroy?.(current.container);
  });

  barba.hooks.afterEnter(({ next }) => {
    // ✅ re-init de scripts dependientes del DOM
    window.App?.init?.(next.container);
  });
};

document.addEventListener('DOMContentLoaded', pageTransition);