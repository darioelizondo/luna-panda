// modules/home-hero-snap.js
import gsap from './../libs/gsap';

export const createHomeHeroSnap = (root = document, opts = {}) => {
  const {
    heroSelector = '[data-hero]',
    nextSelector = '[data-projects-home]',
    duration = 0.65,
    threshold = 0.18,
    ease = 'power2.out',
    desktopBreakpoint = 1024, // solo desktop >= 1024px
  } = opts;

  const hero = root.querySelector(heroSelector);
  const next = root.querySelector(nextSelector);

  if (!hero || !next) return null;

  const mediaQuery = window.matchMedia(`(min-width: ${desktopBreakpoint}px)`);

  let locked = false;
  let tween = null;
  let isEnabled = mediaQuery.matches;

  const killTween = () => {
    if (tween) {
      tween.kill();
      tween = null;
    }
  };

  const scrollToY = (targetY) => {
    locked = true;

    killTween();

    const state = { y: window.scrollY };

    const emitSnapScroll = () => {
      window.dispatchEvent(new CustomEvent('home:snap:scroll', { detail: { y: window.scrollY } }));
    };

    tween = gsap.to(state, {
      y: targetY,
      duration,
      ease,
      overwrite: true,
      onUpdate: () => {
        window.scrollTo(0, state.y);
        emitSnapScroll();
      },
      onComplete: () => {
        locked = false;
        emitSnapScroll();
        killTween();
      },
      onInterrupt: () => {
        locked = false;
        emitSnapScroll();
        killTween();
      },
    });

  };

  const onWheel = (e) => {
    if (!isEnabled) return;

    if (locked) {
      e.preventDefault();
      return;
    }

    const y = window.scrollY;
    const vh = window.innerHeight;

    const nextTop = next.getBoundingClientRect().top + y;

    const inHeroZone = y < vh * (1 - threshold);

    const goingDown = e.deltaY > 0;
    const goingUp = e.deltaY < 0;

    if (inHeroZone && goingDown) {
      e.preventDefault();
      scrollToY(nextTop);
      return;
    }

    const nearSecondStart =
      y > nextTop - vh * threshold && y < nextTop + vh * threshold;

    if (nearSecondStart && goingUp) {
      e.preventDefault();
      scrollToY(0);
      return;
    }
  };

  const handleBreakpointChange = (e) => {
    isEnabled = e.matches;

    if (!isEnabled) {
      // Si pasa a mobile, liberamos todo
      killTween();
      locked = false;
    }
  };

  mediaQuery.addEventListener('change', handleBreakpointChange);

  window.addEventListener('wheel', onWheel, { passive: false });

  return {
    destroy() {
      killTween();
      mediaQuery.removeEventListener('change', handleBreakpointChange);
      window.removeEventListener('wheel', onWheel);
    },
  };
};
