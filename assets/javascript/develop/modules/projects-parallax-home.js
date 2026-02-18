import gsap from './../libs/gsap';
import ScrollTrigger from './../libs/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

let ctx = null;
let mm = null;

function prefersReducedMotion() {
  return window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;
}

function clamp(n, min, max) {
  return Math.max(min, Math.min(max, n));
}

function getStrength(item, index, mult = 1) {
  // “Auto”: distinto por item
  // - base por index (para variar)
  // - ajuste por span (items grandes se mueven menos para que no maree)
  const span = parseInt(item.dataset.span ?? "10", 10);
  const normSpan = clamp(span, 1, 10); // 1..10

  // intensidad base (px)
  // items chicos (span 1-3) => más movimiento, items grandes => menos
  const sizeFactor = 1.25 - (normSpan / 10) * 0.65; // aprox 0.6..1.2
  const indexFactor = 0.85 + (index % 5) * 0.12;    // variedad 0.85..1.33

  // dirección alternada para un look más “orgánico”
  const dir = index % 2 === 0 ? -1 : 1;

  const BASE = 12;

  return BASE * mult * sizeFactor * indexFactor * dir;
}

/**
 * Init parallax items inside a container (Barba container).
 * Returns a cleanup function.
 */
export function initProjectsParallax(container = document) {
  if (prefersReducedMotion()) return () => {};

  const scope = container.querySelector?.(".projects-home");
  if (!scope) return () => {};

  const items = scope.querySelectorAll(".project-item-home");
  if (!items.length) return () => {};

  // MatchMedia para desactivar en mobile
  mm = ScrollTrigger.matchMedia();

   // Mobile
   mm.add("(max-width: 1023px)", () => {
    // Context para poder revertir todo fácil en destroy
    ctx = gsap.context(() => {
      items.forEach((item, index) => {
        const motion = item.querySelector(".project-item-home--motion");
        if (!motion) return;

        const strength = getStrength(item, index, 2);

        // Tween “atado” al scroll con inercia via scrub
        gsap.to(motion, {
          y: strength,
          ease: "none",
          scrollTrigger: {
            trigger: item,
            start: "top bottom",
            end: "bottom top",
            scrub: 0.6, // Inercia suave
            invalidateOnRefresh: true,
          },
        });
      });
    }, scope);

    // importante: refresh luego de crear triggers
    ScrollTrigger.refresh();
  });

  // Desktop
  mm.add("(min-width: 1024px)", () => {
    // Context para poder revertir todo fácil en destroy
    ctx = gsap.context(() => {
      items.forEach((item, index) => {
        const motion = item.querySelector(".project-item-home--motion");
        if (!motion) return;

        const strength = getStrength(item, index, 8);

        // Tween “atado” al scroll con inercia via scrub
        gsap.to(motion, {
          y: strength,
          ease: "none",
          scrollTrigger: {
            trigger: item,
            start: "top bottom",
            end: "bottom top",
            scrub: 0.9, // más alto = más “inercia”
            invalidateOnRefresh: true,
          },
        });
      });
    }, scope);

    // importante: refresh luego de crear triggers
    ScrollTrigger.refresh();
  });

  // cleanup
  return () => {
    try {
      ctx?.revert();
      ctx = null;

      // mm también hay que matarlo para que no queden listeners
      mm?.kill();
      mm = null;

      // Por seguridad, matar triggers vinculados a esta sección
      ScrollTrigger.getAll().forEach((t) => {
        const trig = t.vars?.trigger;
        if (trig && scope.contains(trig)) t.kill();
      });
    } catch (e) {
      // evita que una vista rota rompa toda la navegación
      console.warn("[projectsParallax] cleanup error:", e);
    }
  };
}
