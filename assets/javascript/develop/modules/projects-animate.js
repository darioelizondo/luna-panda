// modules/projects-animate.js
import gsap from '../libs/gsap';

export function animateProjectItems(rootEl, items = null, opts = {}) {
  if (!rootEl) return;

  const reduceMotion =
    window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduceMotion) return;

  const {
    selector = '.project-item',
    y = 18,
    duration = 0.55,
    stagger = 0.06,
    ease = 'power2.out',
    scaleFrom = 0.985,
  } = opts;

  const nodes = items
    ? Array.from(items)
    : Array.from(rootEl.querySelectorAll(selector));

  if (!nodes.length) return;

  // Kill previous tweens
  gsap.killTweensOf(nodes);

  // Set initial vars (no toca transform directamente)
  gsap.set(nodes, {
    '--reveal-opacity': 0,
    '--reveal-y': `${y}px`,
    '--reveal-scale': scaleFrom,
    filter: 'blur(6px)',
  });

  gsap.to(nodes, {
    '--reveal-opacity': 1,
    '--reveal-y': '0px',
    '--reveal-scale': 1,
    filter: 'blur(0px)',
    duration,
    ease,
    stagger,
    // Deja limpio
    onComplete: () => {
      nodes.forEach((el) => {
        el.style.removeProperty('--reveal-opacity');
        el.style.removeProperty('--reveal-y');
        el.style.removeProperty('--reveal-scale');
      });
    },
  });
}
