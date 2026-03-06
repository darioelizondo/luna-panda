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

  // Guardamos el path del siguiente destino, que sí suele estar disponible antes del leave
  let pendingNextPath = '';
  let pendingNextNamespace = '';

  const wait = (s) => new Promise((r) => setTimeout(r, s * 1000));
  const isMobileHeaderMode = () => window.matchMedia('(max-width: 767px)').matches;

  const normalizePath = (path = '') => {
    if (!path) return '/';
    try {
      const url = new URL(path, window.location.origin);
      let pathname = url.pathname || '/';
      pathname = pathname.replace(/\/+$/, '');
      return pathname === '' ? '/' : pathname;
    } catch (e) {
      let pathname = path.split('?')[0].split('#')[0] || '/';
      pathname = pathname.replace(/\/+$/, '');
      return pathname === '' ? '/' : pathname;
    }
  };

  const isHomePath = (path = '') => {
    return normalizePath(path) === '/lunapanda';
  };

  const isContactPath = (path = '') => {
    // Si tu slug cambiara, ajustá esta parte.
    return normalizePath(path) === '/lunapanda/contact';
  };

  const getNamespace = (view) => {
    if (!view) return 'default';

    if (view.namespace) return view.namespace;

    if (view.container?.dataset?.barbaNamespace) {
      return view.container.dataset.barbaNamespace;
    }

    if (typeof view.html === 'string') {
      const match = view.html.match(/data-barba-namespace=["']([^"']+)["']/i);
      if (match && match[1]) return match[1];
    }

    return 'default';
  };

  /**
   * Reglas de expansión por namespace
   * - home: expandido siempre
   * - contact: expandido solo en desktop
   * - resto: compacto
   */
  const shouldExpandHeader = (namespace) => {
    if (namespace === 'home') return true;
    if (namespace === 'contact' && !isMobileHeaderMode()) return true;
    return false;
  };

  /**
   * Reglas de expansión por path/namespace de destino.
   * Esto se usa en leave(), donde el namespace puede no estar listo.
   */
  const shouldExpandTarget = ({ namespace = '', path = '' } = {}) => {
    // Si namespace está disponible, usamos eso primero
    if (namespace) {
      if (namespace === 'home') return true;
      if (namespace === 'contact' && !isMobileHeaderMode()) return true;
    }

    // Fallback por path
    if (isHomePath(path)) return true;
    if (isContactPath(path) && !isMobileHeaderMode()) return true;

    return false;
  };

  /**
   * Solo Home responde al scroll para expandir/compactar.
   * Contact desktop queda expandido fijo.
   */
  const shouldBindHeaderScroll = (namespace) => {
    return namespace === 'home';
  };

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
      duration: 0.1,
      threshold: 0.9,
    });
  };

  const applyHeaderStateByNamespace = (
    namespace,
    { animateExpandOnEnter = false } = {}
  ) => {
    cleanupScroll?.();
    cleanupScroll = null;

    const shouldExpand = shouldExpandHeader(namespace);
    const bindScroll = shouldBindHeaderScroll(namespace);

    if (shouldExpand) {
      if (animateExpandOnEnter) {
        headerCtrl?.setCompact(true, { immediate: true });
        headerCtrl?.setCompact(false, { immediate: false });
      } else {
        headerCtrl?.setCompact(false, { immediate: true });
      }
    } else {
      headerCtrl?.setCompact(true, { immediate: true });
    }

    if (bindScroll) {
      cleanupScroll = bindHeaderToScroll(headerCtrl, 40, { allowExpandOnTop: true });
    }
  };

  const initHeaderOnce = () => {
    if (headerCtrl) return;

    headerCtrl = createHeaderController();

    const initialNs = container.getAttribute('data-barba-namespace') || 'default';
    applyHeaderStateByNamespace(initialNs, { animateExpandOnEnter: false });
    applyHomeSnapByNamespace(initialNs);
  };

  initHeaderOnce();

  const runLogoIntroOnce = () => {
    if (runLogoIntroOnce._played) return;
    runLogoIntroOnce._played = true;

    const ns = container.getAttribute('data-barba-namespace') || 'default';
    const shouldExpand = shouldExpandHeader(ns);

    headerCtrl?.setCompact(!shouldExpand, { immediate: true });

    const tl = playLogoIntro();

    const applyFinalState = () => {
      headerCtrl?.setCompact(!shouldExpandHeader(ns), { immediate: true });
    };

    if (tl) tl.eventCallback('onComplete', applyFinalState);
    else applyFinalState();
  };

  if (window.__LOADER_DONE__) runLogoIntroOnce();
  else window.addEventListener('loader:done', runLogoIntroOnce, { once: true });

  barba.init({
    transitions: [
      {
        name: 'fade',

        before(data) {
          pendingNextPath = data?.next?.url?.path || '';
          pendingNextNamespace = getNamespace(data?.next);
        },

        beforeEnter(data) {
          const activeClass = 'current_page_item';
          document.querySelectorAll('.menu-item').forEach((item) => item.classList.remove(activeClass));

          const nextPath = data.next.url.path;
          const nextItemLink = document.querySelector(`.menu-item a[href*="${nextPath}"]`);
          if (nextItemLink) nextItemLink.parentElement.classList.add(activeClass);
        },

        leave: async ({ current }) => {
          homeSnap?.destroy?.();
          homeSnap = null;

          cleanupScroll?.();
          cleanupScroll = null;

          const leavingNs = getNamespace(current);

          const leavingExpanded = shouldExpandHeader(leavingNs);
          const nextExpanded = shouldExpandTarget({
            namespace: pendingNextNamespace,
            path: pendingNextPath,
          });

          /**
           * Casos:
           * - expandido -> expandido : NO hacer nada
           * - expandido -> compacto  : compactar animado
           * - compacto -> expandido  : no hacer nada acá
           * - compacto -> compacto   : asegurar compacto inmediato
           */
          if (leavingExpanded && !nextExpanded) {
            headerCtrl?.setCompact(true, { immediate: false });
            await wait(0.18);
          } else if (!leavingExpanded && !nextExpanded) {
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
          return gsap.to(next.container, {
            opacity: 1,
            duration: 0.5,
            ease: 'power1.out',
          });
        },
      },
    ],
  });

  barba.hooks.once(({ next }) => {
    window.App?.init?.(next.container);

    const ns = getNamespace(next);
    applyHeaderStateByNamespace(ns, { animateExpandOnEnter: false });
    applyHomeSnapByNamespace(ns);
  });

  barba.hooks.beforeLeave(({ current }) => {
    homeSnap?.destroy?.();
    homeSnap = null;

    window.App?.destroy?.(current.container);
  });

  barba.hooks.afterEnter(({ next, current }) => {
    window.App?.init?.(next.container);

    const ns = getNamespace(next);
    const prevNs = getNamespace(current);

    const prevExpanded = shouldExpandHeader(prevNs);
    const nextExpanded = shouldExpandHeader(ns);

    // Solo animar expansión si venimos de compacta a expandida
    const animateExpandOnEnter = !prevExpanded && nextExpanded;

    applyHeaderStateByNamespace(ns, { animateExpandOnEnter });
    applyHomeSnapByNamespace(ns);

    pendingNextPath = '';
    pendingNextNamespace = '';
  });
};

document.addEventListener('DOMContentLoaded', AppBarba);