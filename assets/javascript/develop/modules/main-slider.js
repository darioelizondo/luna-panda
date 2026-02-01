import Swiper from '../libs/swiper';

export const mainSlider = ( root = document ) => {

    const mainSliders = document.querySelectorAll( '[data-main-slider]' );

    // Guards
    if ( !mainSliders ) return;

    mainSliders.forEach( ( slider ) => {

        // More guards
        if (slider.dataset.inited === 'true') return;
        slider.dataset.inited = 'true';

        const currentSlider = slider.querySelector( '.main-slider__inner.swiper' );
        // const next = slider.querySelector( '.main-slider__next' );
        // const prev = slider.querySelector( '.main-slider__prev' );

        if( currentSlider !== undefined ) {
            setTimeout( () => {
                swiper = new Swiper( currentSlider, {
                    speed: 3000,
                    autoplay: {
                        delay: 5500,
                        disableOnInteraction: false,
                    },
                    loop: true,
                    // effect: "fade",
                    watchSlidesProgress: true,
                    effect: 'creative',
                    creativeEffect: {
                        // prev: {
                        //     opacity: 0,
                        // },
                        // next: {
                        //     opacity: 0,
                        // },
                    },
                    // navigation: {
                    //     nextEl: next,
                    //     prevEl: prev,
                    // },
    
                });
            }, 3750 ) // 3750
        }

    });

};