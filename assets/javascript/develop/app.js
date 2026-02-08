// app.js
import './loader';
import './app-barba';

// Modules UI
import { mainSlider } from './modules/main-slider';
import { projectHomeTouchHover } from './modules/content-project-home';
import { initProjectsParallax } from './modules/projects-parallax-home';
import { logosCarousel } from './modules/logos-carousel';

const controllersMap = new WeakMap(); // key: root(container), value: controllers[]

function asController(maybe) {
  // Normaliza retornos a { destroy() }
  if (!maybe) return null;

  // Caso: El módulo devuelve { init, destroy }
  if (typeof maybe === 'object' && typeof maybe.destroy === 'function') return maybe;

  // Caso: El módulo devuelve cleanup Fn
  if (typeof maybe === 'function') return { destroy: maybe };

  return null;
}

function init(root = document) {
  const controllers = [];

  // Main slider (scoped)
  controllers.push(asController(mainSlider(root)));

  // Project Home Touch Hover (scoped)
  const touchCtrl = projectHomeTouchHover({
    root,
    breakpoint: '(max-width: 768px)',
    exclusive: true,
  });
  if (touchCtrl?.init) touchCtrl.init();
  controllers.push(asController(touchCtrl));

  // Projects parallax (scoped)
  controllers.push(asController(initProjectsParallax(root)));

  // Logo carousel
  controllers.push(asController(logosCarousel(root)));

  // Limpieza de nulls
  const cleaned = controllers.filter(Boolean);
  controllersMap.set(root, cleaned);
}

function destroy(root = document) {
  const controllers = controllersMap.get(root) || [];
  controllers.forEach((c) => c.destroy?.());
  controllersMap.delete(root);
}

window.App = { init, destroy };

// First load
document.addEventListener('DOMContentLoaded', () => {
  window.App.init(document);
});
