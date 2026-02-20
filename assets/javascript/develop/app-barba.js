// app-barba.js
import barba from './libs/barba';
import gsap from './libs/gsap';

import { createHeaderController } from './modules/header-controller';
import { bindHeaderToScroll } from './modules/header-scroll';
import { playLogoIntro } from './modules/logo-intro';
import { createHomeHeroSnap } from './modules/home-hero-snap';

const AppBarba = () => {
  const wrapper = document.querySelector('[data-barba="wrapper"]');
  const container = document.querySelector('[data-barba="container"]');

  if ('scrollRestoration' in history) history.scrollRestoration = 'manual';

  const forceTop = () => window.scrollTo(0, 0);
  window.addEventListener('pageshow', forceTop);
  window.addEventListener('load', () => setTimeout(forceTop, 0));

  if (!wrapper || !container) {
    console.warn('[Barba] wrapper/container not found. Skipping Barba init.');
    return;
  }

  let headerCtrl = null;
  let cleanupScroll = null;
  let homeSnap = null;

  const scrollToTopSmooth = (duration = 0.35) => {
    const state = { y: window.scrollY };
    return gsap.to(state, {
      y: 0,
      duration,
      ease: 'power2.out',
      onUpdate: () => window.scrollTo(0, state.y),
    });
  };

  const applyHomeSnapByNamespace = (namespace) => {
    homeSnap?.destroy?.();
    homeSnap = null;

    if (namespace !== 'home') return;

    homeSnap = createHomeHeroSnap(document, {
      duration: 0.5,
      threshold: 0.18,
    });
  };

  const applyHeaderStateByNamespace = (namespace, { animateOnHomeEnter = false } = {}) => {
    cleanupScroll?.();
    cleanupScroll = null;

    const allowExpandOnTop = namespace === 'home';

    if (namespace === 'home') {
      if (animateOnHomeEnter) {
        headerCtrl?.setCompact(true, { immediate: true });
        headerCtrl?.setCompact(false, { immediate: false }); // animado
      } else {
        headerCtrl?.setCompact(false, { immediate: true });
      }
    } else {
      headerCtrl?.setCompact(true, { immediate: true });
    }

    // bind binario por scroll (RAF)
    cleanupScroll = bindHeaderToScroll(headerCtrl, 40, { allowExpandOnTop });
  };

  const initHeaderOnce = () => {
    if (headerCtrl) return;

    headerCtrl = createHeaderController();

    const initialNs = container.getAttribute('data-barba-namespace') || 'default';
    applyHeaderStateByNamespace(initialNs, { animateOnHomeEnter: false });
    applyHomeSnapByNamespace(initialNs);
  };

  initHeaderOnce();

  // Logo intro (solo primera vez)
  const runLogoIntroOnce = () => {
    if (runLogoIntroOnce._played) return;
    runLogoIntroOnce._played = true;

    const ns = container.getAttribute('data-barba-namespace') || 'default';

    // Mantener estado correcto (no “forzar home” en internas)
    headerCtrl?.setCompact(ns === 'home' ? false : true, { immediate: true });

    const tl = playLogoIntro();
    const applyFinalState = () => headerCtrl?.setCompact(ns === 'home' ? false : true, { immediate: true });

    if (tl) tl.eventCallback('onComplete', applyFinalState);
    else applyFinalState();
  };

  if (window.__LOADER_DONE__) runLogoIntroOnce();
  else window.addEventListener('loader:done', runLogoIntroOnce, { once: true });

  barba.init({
    transitions: [
      {
        name: 'fade',

        beforeEnter(data) {
          const activeClass = 'current_page_item';
          document.querySelectorAll('.menu-item').forEach((item) => item.classList.remove(activeClass));

          const nextPath = data.next.url.path;
          const nextItemLink = document.querySelector(`.menu-item a[href*="${nextPath}"]`);
          if (nextItemLink) nextItemLink.parentElement.classList.add(activeClass);
        },

        leave: async ({ current }) => {
          const wait = (s) => new Promise((r) => setTimeout(r, s * 1000));

          // matar snap
          homeSnap?.destroy?.();
          homeSnap = null;

          // desactivar header scroll
          cleanupScroll?.();
          cleanupScroll = null;

          const leavingNs =
            current?.namespace || current?.container?.dataset?.barbaNamespace || 'default';

          // animate shrink only when leaving home
          if (leavingNs === 'home') {
            headerCtrl?.setCompact(true, { immediate: false });
            await wait(0.18);
          } else {
            headerCtrl?.setCompact(true, { immediate: true });
          }

          await scrollToTopSmooth(0.35);

          await gsap.to(current.container, {
            opacity: 0,
            position: 'absolute',
            left: 0,
            top: 0,
            duration: 0.5,
            ease: 'power1.out',
          });
        },


        enter({ next }) {
          gsap.set(next.container, { opacity: 0 });
          return gsap.to(next.container, { opacity: 1, duration: 0.5, ease: 'power1.out' });
        },
      },
    ],
  });

  barba.hooks.once(({ next }) => {
    window.App?.init?.(next.container);

    const ns = next?.namespace || next?.container?.dataset?.barbaNamespace || 'default';
    applyHeaderStateByNamespace(ns, { animateOnHomeEnter: false });
    applyHomeSnapByNamespace(ns);
  });

  barba.hooks.beforeLeave(({ current }) => {
    homeSnap?.destroy?.();
    homeSnap = null;

    window.App?.destroy?.(current.container);
  });

  barba.hooks.afterEnter(({ next, current }) => {
    window.App?.init?.(next.container);

    const ns = next?.namespace || next?.container?.dataset?.barbaNamespace || 'default';
    const prevNs = current?.namespace || current?.container?.dataset?.barbaNamespace || 'default';

    const animateOnHomeEnter = prevNs !== 'home' && ns === 'home';

    applyHeaderStateByNamespace(ns, { animateOnHomeEnter });
    applyHomeSnapByNamespace(ns);
  });
};

document.addEventListener('DOMContentLoaded', AppBarba);
