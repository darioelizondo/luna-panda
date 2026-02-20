/**
 * allowExpandOnTop:
 * - true: en home, al volver arriba (y <= threshold) expande
 * - false: en internas, siempre compacto (aunque y=0)
 */
export const bindHeaderToScroll = (headerCtrl, threshold = 40, { allowExpandOnTop = true } = {}) => {
  if (!headerCtrl) return null;

  let raf = null;
  let last = null;

  const compute = () => {
    const y = window.scrollY || window.pageYOffset || 0;

    if (y <= threshold) {
      return allowExpandOnTop ? false : true;
    }
    return true;
  };

  const update = () => {
    raf = null;
    const next = compute();
    if (next === last) return;
    last = next;
    headerCtrl.setCompact(next);
  };

  const onScroll = () => {
    if (raf) return;
    raf = requestAnimationFrame(update);
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);

  // Estado inicial (clave para refresh + entra con Barba)
  update();

  return () => {
    window.removeEventListener('scroll', onScroll);
    window.removeEventListener('resize', onScroll);
    if (raf) cancelAnimationFrame(raf);
    raf = null;
  };
};
