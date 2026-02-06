import barba from './libs/barba';
import gsap from './libs/gsap';
import { createHeaderController } from './modules/header-controller';
import { bindHeaderToScroll } from './modules/header-scroll';
import { playLogoIntro } from './modules/logo-intro';
import { projectHomeTouchHover } from './modules/content-project-home';

const AppBarba = () => {
  const wrapper = document.querySelector('[data-barba="wrapper"]');
  const container = document.querySelector('[data-barba="container"]');

  if (!wrapper || !container) {
    console.warn('[Barba] wrapper/container not found. Skipping Barba init.');
    return;
  }

  // Header (persistent, outside the container)
  let headerCtrl = null;
  let cleanupScroll = null;

  // Project Home Touch Hover (scoped to barba container)
  let projectHomeTouchCtrl = null;

  const initProjectHomeTouch = (rootEl) => {
    // Avoid duplicates in case something re-inits
    projectHomeTouchCtrl?.destroy?.();

    projectHomeTouchCtrl = projectHomeTouchHover({
      root: rootEl,
      breakpoint: '(max-width: 768px)',
      exclusive: true,
      // selectors default:
      // rootSelector: '.projects-home',
      // itemSelector: '.item-project-home',
      // targetSelector: '.content-project-home',
      // activeClass: 'active',
    });

    projectHomeTouchCtrl.init();
  };

  const destroyProjectHomeTouch = () => {
    projectHomeTouchCtrl?.destroy?.();
    projectHomeTouchCtrl = null;
  };

  // Helper to scroll to top smoothly
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

  initHeaderOnce();

  // ---------------------------
  // Logo Intro (first load only, when the loader finishes)
  // ---------------------------
  const runLogoIntroOnce = () => {
    if (runLogoIntroOnce._played) return;
    runLogoIntroOnce._played = true;

    // Current namespace (first load can be home or inner)
    const ns = container.getAttribute('data-barba-namespace') || 'default';

    // 1) Force expanded so that the full logo is visible during the intro (including mobile)
    headerCtrl?.setCompact(false, { immediate: true });

    // 2) Run intro
    const tl = playLogoIntro();

    // 3) Upon is complete, apply the actual status according to the page.
    const applyFinalState = () => {
      if (ns === 'home') {
        headerCtrl?.setCompact(false, { immediate: true }); // Expanded
      } else {
        headerCtrl?.setCompact(true); // Compact (smooth)
      }
    };

    if (tl) tl.eventCallback('onComplete', applyFinalState);
    else applyFinalState();
  };

  // If the loader has already finished before Barba initializes, run it anyway:
  if (window.__LOADER_DONE__) {
    runLogoIntroOnce();
  } else {
    window.addEventListener('loader:done', runLogoIntroOnce, { once: true });
  }

  const applyHeaderStateByNamespace = (namespace) => {
    // Re-bind the scroll to control if it can expand to the top
    cleanupScroll?.();
    const allowExpandOnTop = namespace === 'home';
    cleanupScroll = bindHeaderToScroll(headerCtrl, 40, { allowExpandOnTop });

    // Forced state upon entry according to page
    if (namespace === 'home') {
      headerCtrl?.setCompact(false, { immediate: true });
    } else {
      headerCtrl?.setCompact(true, { immediate: true });
    }
  };

  // Barba Init
  barba.init({
    transitions: [
      {
        name: 'fade',

        beforeEnter(data) {
          // 1. Define the class that WordPress uses for the active element
          const activeClass = 'current_page_item';

          // 2. Remove the active class from all menu items
          document.querySelectorAll('.menu-item').forEach((item) => {
            item.classList.remove(activeClass);
          });

          // 3. Get the path to the new page (e.g., /contact/)
          const nextPath = data.next.url.path;

          // 4. Find the link that matches the path and add the class to the parent (li)
          const nextItemLink = document.querySelector(`.menu-item a[href*="${nextPath}"]`);

          if (nextItemLink) {
            nextItemLink.parentElement.classList.add(activeClass);
          }
        },

        beforeLeave(data) {
          if (data?.current?.namespace === 'home') {
            headerCtrl?.setCompact(true); // Animated
          }
        },

        leave: async ({ current }) => {
          // 1) Desactivar el ScrollTrigger del header para que NO reaccione al scroll
          cleanupScroll?.();
          cleanupScroll = null;

          // 2) Forzar el header en compacto antes de scrollear (evita el “rebote” a grande)
          headerCtrl?.setCompact(true, { immediate: true });

          // 3) Scroll suave a top (así el usuario siente continuidad)
          await scrollToTopSmooth(0.35);

          // 4) Fade-out
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

  // Hooks (site logic)
  barba.hooks.beforeLeave(({ current }) => {
    // ✅ Destroy module to avoid duplicated listeners
    destroyProjectHomeTouch();

    // Your existing destroy
    window.App?.destroy?.(current.container);
  });

  barba.hooks.afterEnter(({ next }) => {
    // Re-init de scripts dependientes del DOM
    window.App?.init?.(next.container);

    // ✅ Init module scoped to the NEW container
    // (Si querés solo en Home, abajo te dejo la condición)
    initProjectHomeTouch(next.container);

    // Aplicar header según namespace nuevo (home vs inner)
    const ns =
      next?.namespace || next?.container?.getAttribute('data-barba-namespace') || 'default';
    applyHeaderStateByNamespace(ns);

    // Si querés SOLO en home:
    // if (ns === 'home') initProjectHomeTouch(next.container);
    // else destroyProjectHomeTouch();
  });
};

document.addEventListener('DOMContentLoaded', AppBarba);
