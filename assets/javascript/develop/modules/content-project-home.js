// modules/projectHomeTouchHover.js
export function projectHomeTouchHover({
  root = document,
  rootSelector = '.projects-home',
  itemSelector = '.project-item-home',
  imageSelector = '.image-project-home',
  targetSelector = '.content-project-home',
  activeClass = 'active',
  breakpoint = '(max-width: 768px)',
  exclusive = true,
} = {}) {
  const mql = window.matchMedia(breakpoint);
  const cleanupFns = new Set();

  const getItems = () =>
    Array.from(root.querySelectorAll(`${rootSelector} ${itemSelector}`));

  const clearAll = () => {
    getItems().forEach((el) => {
      el.querySelector(targetSelector)?.classList.remove(activeClass);
      el.querySelector(imageSelector)?.classList.remove(activeClass);
    });
  };

  const bind = () => {
    const items = getItems();
    if (!items.length) return;

    items.forEach((el) => {
      const target = el.querySelector(targetSelector);
      const imageTarget = el.querySelector(imageSelector);
      if (!target) return;

      const onDown = () => {
        if (exclusive) clearAll();
        target.classList.add(activeClass);
        imageTarget.classList.add(activeClass);
      };

      const onUp = () => {
        target.classList.remove(activeClass);
        imageTarget.classList.remove(activeClass);
      };
      const onCancel = () => {
        target.classList.remove(activeClass);
        imageTarget.classList.remove(activeClass);
      };

      el.addEventListener('pointerdown', onDown, { passive: true });
      el.addEventListener('pointerup', onUp, { passive: true });
      el.addEventListener('pointercancel', onCancel, { passive: true });
      el.addEventListener('pointerleave', onCancel, { passive: true });

      cleanupFns.add(() => {
        el.removeEventListener('pointerdown', onDown);
        el.removeEventListener('pointerup', onUp);
        el.removeEventListener('pointercancel', onCancel);
        el.removeEventListener('pointerleave', onCancel);
      });
    });
  };

  const unbind = () => {
    cleanupFns.forEach((fn) => fn());
    cleanupFns.clear();
    clearAll();
  };

  const applyByBreakpoint = () => (mql.matches ? bind() : unbind());
  const onMqlChange = () => applyByBreakpoint();

  const init = () => {
    // si el DOM cambia dentro del mismo container, esto asegura estado correcto
    applyByBreakpoint();

    if (mql.addEventListener) mql.addEventListener('change', onMqlChange);
    else mql.addListener(onMqlChange);
  };

  const destroy = () => {
    unbind();
    if (mql.removeEventListener) mql.removeEventListener('change', onMqlChange);
    else mql.removeListener(onMqlChange);
  };

  return { init, destroy, refresh: applyByBreakpoint };
}
