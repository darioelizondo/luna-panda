import gsap from './../libs/gsap';
import ScrollTrigger from './../libs/ScrollTrigger';

gsap.registerPlugin( ScrollTrigger );

export const createHeaderController = () => {

    const header = document.querySelector( '.js-header' );
    const logo = document.querySelector( '.js-logo' );
    // const isotype = document.querySelector( '.js-isotype' );
    const logotype = document.querySelector( '.js-logotype' );
    const caption = gsap.utils.toArray( '.js-caption' );
    const menu = gsap.utils.toArray( '.js-menu' );

    if ( !header ) return null;

    
    gsap.set( header, { top: '100px', transformOrigin: 'left center' } );
    gsap.set( logo, { scale: 1, transformOrigin: 'left center' } );
    gsap.set( caption, { autoAlpha: 1, y: 0, pointerEvents: 'auto' } );
    gsap.set( menu, { scale: 1, transformOrigin: 'left center' } );

    if ( logotype ) gsap.set( logotype, { autoAlpha: 1 } );

    let isCompact = false;
    let tlCompact = null;

    const mm = gsap.matchMedia();

    const buildTimeline = () => {

        // Kill previous timeline if it exists (due to breakpoint changes)
        tlCompact?.kill();

        tlCompact = gsap.timeline( { paused: true, defaults: { ease: 'power2.out' } } );

        tlCompact
            .to( caption, {
                autoAlpha: 0,
                y: -6,
                duration: 0.2,
                stagger: 0.03,
                onComplete: () => caption.forEach( el => ( el.style.pointerEvents = 'none' ) ),
            }, 0)
            

        return tlCompact;
        
    };


    // Desktop: Shrinking everything together
    mm.add( '(min-width: 768px)', () => {

        const tl = buildTimeline();

        tl
        .to( logo, {
            scale: 0.20, duration: 0.25
        }, 0)
        .to( menu, {
            // scale: 0.75,
            y: -265,
            paddingLeft: '0px',
            duration: 0.2,
            stagger: 0.03,
            onStart: () => menu.forEach( el => ( el.style.pointerEvents = 'auto') ),
        }, 0.05);

        // Just in case, we've made sure the text is visible on desktop.
        if ( logotype ) tl.set( logotype, { autoAlpha: 1, clearProps: 'width' }, 0);

        // If you were already compact, reapply the unanimated state
        if ( isCompact ) tl.progress( 1 ).pause();

        return () => {};
    });

    // Mobile: Hide logo (text) when compacting
    mm.add( '(max-width: 767px)', () => {

        const tl = buildTimeline();

        tl
        .to( logo, {
            scale: 0.55, duration: 0.25
        }, 0 )
        .to( menu, {
            scale: 0.85,
            x: 75,
            y: -247,
            duration: 0.25,
            stagger: 0.03,
            onStart: () => menu.forEach( el => ( el.style.pointerEvents = 'auto') ),
        }, 0.05)
        .to( header, {
            top: '20px',
            duration: 0.25,
        }, 0.10 );

        // Hide ONLY the logotype on mobile
        if ( logotype ) {
            tl.to( logotype, {
                autoAlpha: 0,
                duration: 0.2,
                onComplete: () => ( logotype.style.pointerEvents = 'none' ),
            }, 0 );
        }

        if ( isCompact ) tl.progress(1).pause();

        return () => {};

    });

    const setCompact = ( next, { immediate = false } = {}) => {

        if ( next === isCompact ) return;
        isCompact = next;

        if (!tlCompact) return;

        if (immediate) {
        tlCompact.progress(next ? 1 : 0).pause();

        // Restore logo pointer-events if we return to expanded
        if ( !next && document.querySelector( '.js-logotype' )) {
            document.querySelector( '.js-logotype' ).style.pointerEvents = 'auto';
        }
        return;
        }

        next ? tlCompact.play() : tlCompact.reverse();
    }

    const kill = () => {
        tlCompact?.kill();
        mm.kill();
    }

    return {
        setCompact,
        isCompact: () => isCompact,
        kill
    };
    
};