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

  // Disable browser scroll restoration (reload + back/forward)
  if ('scrollRestoration' in history) history.scrollRestoration = 'manual';

  // Force top on normal load + BFCache restore
  const forceTop = () => window.scrollTo(0, 0);
  window.addEventListener('pageshow', forceTop); // clave para BFCache
  window.addEventListener('load', () => setTimeout(forceTop, 0)); // clave para "late restore"

  if (!wrapper || !container) {
    console.warn('[Barba] wrapper/container not found. Skipping Barba init.');
    return;
  }

  // ---------------------------
  // Header (persistent, outside the container)
  // ---------------------------
  let headerCtrl = null;
  let cleanupScroll = null;

  // Home "hero snap" controller (only on home)
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

  const initHeaderOnce = () => {
    if (headerCtrl) return;

    headerCtrl = createHeaderController();

    // Initial Bind
    cleanupScroll = bindHeaderToScroll(headerCtrl, 40, { allowExpandOnTop: true });

    // Initial state according to current namespace
    const initialNs = container.getAttribute('data-barba-namespace') || 'default';

    if (initialNs === 'home') {
      headerCtrl?.setCompact(false, { immediate: true });
    } else {
      headerCtrl?.setCompact(true, { immediate: true });
    }
  };

  const applyHeaderStateByNamespace = (namespace) => {
    cleanupScroll?.();
    const allowExpandOnTop = namespace === 'home';
    cleanupScroll = bindHeaderToScroll(headerCtrl, 40, { allowExpandOnTop });

    if (namespace === 'home') {
      headerCtrl?.setCompact(false, { immediate: true });
    } else {
      headerCtrl?.setCompact(true, { immediate: true });
    }
  };

  const applyHomeSnapByNamespace = (namespace) => {
    // Destroy previous snap (if any)
    homeSnap?.destroy?.();
    homeSnap = null;

    if (namespace !== 'home') return;

    homeSnap = createHomeHeroSnap(document, {
      duration: 0.5,
      threshold: 0.18,
    });
  };

  initHeaderOnce();

  // ---------------------------
  // Logo Intro (first load only, when the loader finishes)
  // ---------------------------
  const runLogoIntroOnce = () => {
    if (runLogoIntroOnce._played) return;
    runLogoIntroOnce._played = true;

    const ns = container.getAttribute('data-barba-namespace') || 'default';

    headerCtrl?.setCompact(false, { immediate: true });

    const tl = playLogoIntro();

    const applyFinalState = () => {
      if (ns === 'home') headerCtrl?.setCompact(false, { immediate: true });
      else headerCtrl?.setCompact(true);
    };

    if (tl) tl.eventCallback('onComplete', applyFinalState);
    else applyFinalState();
  };

  if (window.__LOADER_DONE__) {
    runLogoIntroOnce();
  } else {
    window.addEventListener('loader:done', runLogoIntroOnce, { once: true });
  }

  // ---------------------------
  // Barba Init
  // ---------------------------
  barba.init({
    transitions: [
      {
        name: 'fade',

        beforeEnter(data) {
          // Active menu item sync
          const activeClass = 'current_page_item';

          document.querySelectorAll('.menu-item').forEach((item) => {
            item.classList.remove(activeClass);
          });

          const nextPath = data.next.url.path;
          const nextItemLink = document.querySelector(`.menu-item a[href*="${nextPath}"]`);

          if (nextItemLink) {
            nextItemLink.parentElement.classList.add(activeClass);
          }
        },

        beforeLeave(data) {
          // If leaving home, compact header (animated)
          if (data?.current?.namespace === 'home') {
            headerCtrl?.setCompact(true);
          }
        },

        leave: async ({ current }) => {
          // 0) kill home snap while transitioning out
          homeSnap?.destroy?.();
          homeSnap = null;

          // 1) disable header scroll reactions during transition
          cleanupScroll?.();
          cleanupScroll = null;

          // 2) force header compact before scroll
          headerCtrl?.setCompact(true, { immediate: true });

          // 3) smooth scroll to top
          await scrollToTopSmooth(0.35);

          // 4) fade out
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

          return gsap.to(next.container, {
            opacity: 1,
            duration: 0.5,
            ease: 'power1.out',
          });
        },
      },
    ],
  });

  // ---------------------------
  // Hooks (site logic)
  // ---------------------------

  // 1) First load: init modules ONCE for the initial container
  barba.hooks.once(({ next }) => {
    // Init all scoped modules for the initial container
    window.App?.init?.(next.container);

    // Apply header state by namespace
    const ns =
      next?.namespace || next?.container?.getAttribute('data-barba-namespace') || 'default';
    applyHeaderStateByNamespace(ns);

    // Enable/disable home hero snap
    applyHomeSnapByNamespace(ns);
  });

  barba.hooks.beforeLeave(({ current }) => {
    // Kill home snap (safety)
    homeSnap?.destroy?.();
    homeSnap = null;

    // Destroy all scoped modules for the old container
    window.App?.destroy?.(current.container);
  });

  barba.hooks.afterEnter(({ next }) => {
    // Init all scoped modules for the new container
    window.App?.init?.(next.container);

    // Apply header state by namespace
    const ns =
      next?.namespace || next?.container?.getAttribute('data-barba-namespace') || 'default';
    applyHeaderStateByNamespace(ns);

    // Enable/disable home hero snap
    applyHomeSnapByNamespace(ns);
  });
};

document.addEventListener('DOMContentLoaded', AppBarba);
