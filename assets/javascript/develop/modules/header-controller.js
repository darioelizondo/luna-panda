import gsap from './../libs/gsap';
import ScrollTrigger from './../libs/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export const createHeaderController = () => {
  const header = document.querySelector('.js-header');
  const logo = document.querySelector('.js-logo');
  const logotype = document.querySelector('.js-logotype');
  const caption = gsap.utils.toArray('.js-caption');
  const menu = gsap.utils.toArray('.js-menu');

  if (!header) return null;

  gsap.set(header, { top: '100px', transformOrigin: 'left center' });
  gsap.set(logo, { scale: 1, transformOrigin: 'left center' });
  gsap.set(caption, { autoAlpha: 1, y: 0, pointerEvents: 'auto' });
  gsap.set(menu, { scale: 1, transformOrigin: 'left center' });
  if (logotype) gsap.set(logotype, { autoAlpha: 1 });

  let isCompact = false;
  let tlCompact = null;

  const mm = gsap.matchMedia();

  const buildTimeline = () => {
    tlCompact?.kill();

    tlCompact = gsap.timeline({ paused: true, defaults: { ease: 'power2.out' } });

    tlCompact.to(
      caption,
      {
        autoAlpha: 0,
        y: -6,
        duration: 0.2,
        stagger: 0.03,
        onComplete: () => caption.forEach((el) => (el.style.pointerEvents = 'none')),
      },
      0
    );

    return tlCompact;
  };

  mm.add('(max-width: 767px)', () => {
    const tl = buildTimeline();

    tl.to(
      logo,
      {
        scale: 0.55,
        y: -30,
        duration: 0.25,
      },
      0
    )
      .to(
        menu,
        {
          scale: 0.85,
          y: -252,
          x: -46,
          duration: 0.25,
          stagger: 0.03,
          onStart: () => menu.forEach((el) => (el.style.pointerEvents = 'auto')),
        },
        0.05
      )
      .to(
        header,
        {
          top: '20px',
          duration: 0.25,
        },
        0.1
      );

    if (logotype) {
      tl.to(
        logotype,
        {
          autoAlpha: 0,
          duration: 0.2,
          onComplete: () => (logotype.style.pointerEvents = 'none'),
        },
        0
      );
    }

    if (isCompact) tl.progress(1).pause();
    return () => {};
  });

  const desktopDefs = [
    { mq: '(min-width: 1024px)', logo: { scale: 0.25, y: -170 }, menu: { y: -320 } },
    { mq: '(min-width: 1170px)', logo: { scale: 0.25, y: -130 }, menu: { y: -280 } },
    { mq: '(min-width: 1350px)', logo: { scale: 0.2, y: -195 }, menu: { y: -370 } },
    { mq: '(min-width: 1440px)', logo: { scale: 0.2, y: -210 }, menu: { y: -450 } },
    { mq: '(min-width: 1700px)', logo: { scale: 0.2, y: -230 }, menu: { y: -500 } },
  ];

  desktopDefs.forEach(({ mq, logo: l, menu: m }) => {
    mm.add(mq, () => {
      const tl = buildTimeline();

      tl.to(
        logo,
        {
          ...l,
          duration: 0.25,
        },
        0
      ).to(
        menu,
        {
          y: m.y,
          paddingLeft: '0px',
          duration: 0.2,
          stagger: 0.03,
          onStart: () => menu.forEach((el) => (el.style.pointerEvents = 'auto')),
        },
        0.05
      );

      if (logotype) tl.set(logotype, { autoAlpha: 1, clearProps: 'width' }, 0);

      if (isCompact) tl.progress(1).pause();
      return () => {};
    });
  });

  const setCompact = (next, { immediate = false } = {}) => {
    if (!tlCompact) return null;

    // Si ya está en ese estado, no hagas nada (esto evita doble animación)
    if (next === isCompact) return tlCompact;

    isCompact = next;

    // Si hay una animación en curso, la pausamos para evitar “doble play/reverse”
    tlCompact.pause();

    if (immediate) {
      tlCompact.progress(next ? 1 : 0).pause();

      // Restore logotype pointer-events if expanded
      if (!next && logotype) {
        logotype.style.pointerEvents = 'auto';
      }
      return tlCompact;
    }

    next ? tlCompact.play() : tlCompact.reverse();
    return tlCompact;
  };

  const kill = () => {
    tlCompact?.kill();
    mm.kill();
  };

  return {
    setCompact,
    isCompact: () => isCompact,
    kill,
  };
};
