// modules/home-hero-snap.js
import gsap from './../libs/gsap';

export const createHomeHeroSnap = (root = document, opts = {}) => {
  const {
    heroSelector = '[data-hero]',
    nextSelector = '[data-projects-home]',
    duration = 0.65,
    threshold = 0.18,
    ease = 'power2.out',
    desktopBreakpoint = 1024,

    // Trackpad-friendly intent
    intentDelta = 35,     // más sensible (antes 60)
    intentResetMs = 180,  // ventana un poco mayor

    // Anti-rebote post-snap
    cooldownMs = 220,
  } = opts;

  const hero = root.querySelector(heroSelector);
  const next = root.querySelector(nextSelector);
  if (!hero || !next) return null;

  const mediaQuery = window.matchMedia(`(min-width: ${desktopBreakpoint}px)`);

  let isEnabled = mediaQuery.matches;
  let locked = false;
  let tween = null;

  // acumulador de intención (un gesto)
  let accDelta = 0;
  let accTimer = null;

  // cooldown para cortar inercia residual del trackpad
  let cooldownUntil = 0;

  const killTween = () => {
    if (tween) {
      tween.kill();
      tween = null;
    }
  };

  const resetIntent = () => {
    accDelta = 0;
    if (accTimer) {
      clearTimeout(accTimer);
      accTimer = null;
    }
  };

  // --- Scroll lock (bloquea INPUT, no overflow hidden) ---
  const lockOptions = { passive: false, capture: true };

  const preventAll = (e) => {
    e.preventDefault();
    e.stopPropagation();
    if (typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
  };

  const preventKeys = (e) => {
    const keys = ['ArrowUp', 'ArrowDown', 'PageUp', 'PageDown', 'Home', 'End', ' ', 'Spacebar'];
    if (keys.includes(e.key)) {
      e.preventDefault();
      e.stopPropagation();
      if (typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
    }
  };

  const lockScroll = () => {
    window.addEventListener('wheel', preventAll, lockOptions);
    window.addEventListener('touchmove', preventAll, lockOptions);
    window.addEventListener('keydown', preventKeys, lockOptions);
  };

  const unlockScroll = () => {
    window.removeEventListener('wheel', preventAll, lockOptions);
    window.removeEventListener('touchmove', preventAll, lockOptions);
    window.removeEventListener('keydown', preventKeys, lockOptions);
  };

  const getNextTop = () => {
    const y = window.scrollY;
    return next.getBoundingClientRect().top + y;
  };

  const shouldSnap = (dir) => {
    const y = window.scrollY;
    const vh = window.innerHeight;
    const nextTop = getNextTop();

    const inHeroZone = y < vh * (1 - threshold);

    if (dir === 'down' && inHeroZone) {
      return { target: nextTop };
    }

    const nearSecondStart = y > nextTop - vh * threshold && y < nextTop + vh * threshold;

    if (dir === 'up' && nearSecondStart) {
      return { target: 0 };
    }

    return null;
  };

  const scrollToY = (targetY) => {
    locked = true;
    lockScroll();
    killTween();
    resetIntent();

    const state = { y: window.scrollY };

    tween = gsap.to(state, {
      y: targetY,
      duration,
      ease,
      overwrite: true,
      onUpdate: () => {
        window.scrollTo(0, state.y);
      },
      onComplete: () => {
        locked = false;
        cooldownUntil = Date.now() + cooldownMs; // anti-rebote
        unlockScroll();
        killTween();
      },
      onInterrupt: () => {
        locked = false;
        cooldownUntil = Date.now() + cooldownMs; // anti-rebote
        unlockScroll();
        killTween();
      },
    });
  };

  const onWheel = (e) => {
    if (!isEnabled) return;

    // Si estamos en cooldown (inercia residual del trackpad), bloqueamos y listo
    if (Date.now() < cooldownUntil) {
      e.preventDefault();
      return;
    }

    // si estamos lockeados, bloquea nativo
    if (locked) {
      e.preventDefault();
      return;
    }

    // Detectar "trackpad-ish": deltaMode 0 + deltaY chico
    const isTrackpad = e.deltaMode === 0 && Math.abs(e.deltaY) < 50;
    const deltaThreshold = isTrackpad ? 28 : intentDelta;

    // acumular intención (trackpad manda deltas chicos)
    accDelta += e.deltaY;

    // resetea el acumulador si el gesto se corta
    if (accTimer) clearTimeout(accTimer);
    accTimer = setTimeout(() => {
      resetIntent();
    }, intentResetMs);

    const goingDown = accDelta > 0;
    const dir = goingDown ? 'down' : 'up';

    // Si todavía no pasó el umbral de intención, no dispares
    if (Math.abs(accDelta) < deltaThreshold) return;

    const decision = shouldSnap(dir);

    if (decision) {
      e.preventDefault();
      scrollToY(decision.target);
    } else {
      // si acumuló pero no aplica snap, reseteamos para no "enganchar" tarde
      resetIntent();
    }
  };

  const handleBreakpointChange = (e) => {
    isEnabled = e.matches;

    if (!isEnabled) {
      killTween();
      locked = false;
      cooldownUntil = 0;
      unlockScroll();
      resetIntent();
    }
  };

  mediaQuery.addEventListener('change', handleBreakpointChange);
  window.addEventListener('wheel', onWheel, { passive: false });

  return {
    destroy() {
      killTween();
      locked = false;
      cooldownUntil = 0;
      unlockScroll();
      resetIntent();
      mediaQuery.removeEventListener('change', handleBreakpointChange);
      window.removeEventListener('wheel', onWheel);
    },
  };
};