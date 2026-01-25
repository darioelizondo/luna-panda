// app.js
import './loader';
import './page-transition';

// Modules UI
import { mainSlider } from './modules/main-slider';
// import initTabs from './modules/tabs';
// import initForms from './modules/forms';

function init(root = document) {
  mainSlider(root);
  // initTabs(root);
  // initForms(root);
}

// (Optional) cleanup if you need to destroy events/listeners
function destroy(root = document) {
  // ScrollTrigger.getAll().forEach(t => t.kill());
}

window.App = { init, destroy };

// First load
document.addEventListener('DOMContentLoaded', () => {
  window.App.init(document);
});