const SELECTOR = '[data-before-after]';

const clamp = (value) => Math.min(100, Math.max(0, value));

class BeforeAfterImageComparison {
  constructor(element) {
    this.element = element;
    this.styleTarget = element.querySelector('.before_after_image_comparison__inner') || element;
    this.media = element.querySelector('[data-before-after-media]');
    this.range = element.querySelector('[data-before-after-range]');
    this.pointerId = null;

    this.onPointerDown = this.onPointerDown.bind(this);
    this.onPointerMove = this.onPointerMove.bind(this);
    this.onPointerUp = this.onPointerUp.bind(this);
    this.onRangeInput = this.onRangeInput.bind(this);
  }

  init() {
    if (!this.media || !this.range || this.element.dataset.beforeAfterInitialized === 'true') {
      return false;
    }

    this.element.dataset.beforeAfterInitialized = 'true';
    this.media.addEventListener('pointerdown', this.onPointerDown);
    this.media.addEventListener('pointermove', this.onPointerMove);
    this.media.addEventListener('pointerup', this.onPointerUp);
    this.media.addEventListener('pointercancel', this.onPointerUp);
    this.range.addEventListener('input', this.onRangeInput);
    this.setPosition(this.range.value);

    return true;
  }

  setPosition(value) {
    const position = clamp(Number.parseFloat(value) || 0);
    const rounded = Math.round(position * 10) / 10;

    this.styleTarget.style.setProperty('--before-after-position', `${rounded}%`);
    this.range.value = rounded;
    const afterLabel = this.element.dataset.afterLabel || 'Después';
    this.range.setAttribute('aria-valuetext', `${Math.round(rounded)}% ${afterLabel}`);
  }

  setPositionFromPointer(event) {
    const rect = this.media.getBoundingClientRect();
    if (!rect.width) return;

    this.setPosition(((event.clientX - rect.left) / rect.width) * 100);
  }

  onPointerDown(event) {
    if (event.button !== undefined && event.button !== 0) return;

    this.pointerId = event.pointerId;
    this.media.setPointerCapture?.(event.pointerId);
    this.element.classList.add('is-dragging');
    this.setPositionFromPointer(event);
  }

  onPointerMove(event) {
    if (event.pointerId !== this.pointerId) return;
    this.setPositionFromPointer(event);
  }

  onPointerUp(event) {
    if (event.pointerId !== this.pointerId) return;

    if (this.media.hasPointerCapture?.(event.pointerId)) {
      this.media.releasePointerCapture(event.pointerId);
    }
    this.pointerId = null;
    this.element.classList.remove('is-dragging');
  }

  onRangeInput(event) {
    this.setPosition(event.currentTarget.value);
  }

  destroy() {
    this.media?.removeEventListener('pointerdown', this.onPointerDown);
    this.media?.removeEventListener('pointermove', this.onPointerMove);
    this.media?.removeEventListener('pointerup', this.onPointerUp);
    this.media?.removeEventListener('pointercancel', this.onPointerUp);
    this.range?.removeEventListener('input', this.onRangeInput);
    this.element.classList.remove('is-dragging');
    delete this.element.dataset.beforeAfterInitialized;
    this.pointerId = null;
  }
}

export const beforeAfterImageComparison = (root = document) => {
  const instances = [];

  root.querySelectorAll(SELECTOR).forEach((element) => {
    const instance = new BeforeAfterImageComparison(element);
    if (instance.init()) instances.push(instance);
  });

  if (!instances.length) return null;

  return {
    destroy() {
      instances.forEach((instance) => instance.destroy());
      instances.length = 0;
    },
  };
};
