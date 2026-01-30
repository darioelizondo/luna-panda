import gsap from './../libs/gsap';

export const playLogoIntro = ( { delay = 0 } = {} ) => {

  const mark = document.querySelector('.logo__isotype');
  const type = document.querySelector('.logo__logotype');
  const maskMark = document.querySelector('.js-isotype-mask');
  const maskType = document.querySelector('.js-logotype-mask');

  if ( !mark || !type || !maskMark || !maskType ) return null;

  // Initial state (inside the mask)
  gsap.set( mark, { yPercent: 110, autoAlpha: 1 } );
  gsap.set( type, { yPercent: -110, autoAlpha: 1 } );

  const tl = gsap.timeline({
    delay,
    defaults: { ease: 'power3.out' }
  });

  tl.to(mark, {
    yPercent: 0,
    duration: 0.75
  }, 0);

  tl.to(type, {
    yPercent: 0,
    duration: 0.75
  }, 0.05);

  return tl;

};