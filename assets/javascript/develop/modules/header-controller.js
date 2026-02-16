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

    // Mobile: Hide logo (text) when compacting
    // mm.add( '(max-width: 767px)', () => {

    //     const tl = buildTimeline();

    //     tl
    //     .to( logo, {
    //         scale: 0.55,
    //         y: -35,
    //         duration: 0.25
    //     }, 0 )
    //     .to( menu, {
    //         scale: 0.85,
    //         x: 75,
    //         y: -290,
    //         duration: 0.25,
    //         stagger: 0.03,
    //         onStart: () => menu.forEach( el => ( el.style.pointerEvents = 'auto') ),
    //     }, 0.05)
    //     .to( header, {
    //         top: '20px',
    //         duration: 0.25,
    //     }, 0.10 );

    //     // Hide ONLY the logotype on mobile
    //     if ( logotype ) {
    //         tl.to( logotype, {
    //             autoAlpha: 0,
    //             duration: 0.2,
    //             onComplete: () => ( logotype.style.pointerEvents = 'none' ),
    //         }, 0 );
    //     }

    //     if ( isCompact ) tl.progress(1).pause();

    //     return () => {};

    // });

    mm.add( '(max-width: 767px)', () => {

        const tl = buildTimeline();

        tl
        .to( logo, {
            scale: 0.55,
            y: -30,
            duration: 0.25
        }, 0 )
        .to( menu, {
            scale: 0.85,
            y: -240,
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


    // Desktop: Max 1280px an min 1024px
    mm.add( '(min-width: 1024px)', () => {

        const tl = buildTimeline();

        tl
        .to( logo, {
            scale: 0.25,
            y: -170,
            duration: 0.25
        }, 0)
        .to( menu, {
            // scale: 0.75,
            y: -370,
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

    // Desktop: Max 1350px an min 1170px
    mm.add( '(min-width: 1170px)', () => {

        const tl = buildTimeline();

        tl
        .to( logo, {
            scale: 0.25,
            y: -130,
            duration: 0.25
        }, 0)
        .to( menu, {
            // scale: 0.75,
            y: -280,
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

    // Desktop: Max 1440px an min 1350px
    mm.add( '(min-width: 1350px)', () => {

        const tl = buildTimeline();

        tl
        .to( logo, {
            scale: 0.20,
            y: -195,
            duration: 0.25
        }, 0)
        .to( menu, {
            // scale: 0.75,
            y: -415,
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

    
    // Desktop: Max 1700px an min 1440px
    mm.add( '(min-width: 1440px)', () => {

        const tl = buildTimeline();

        tl
        .to( logo, {
            scale: 0.20,
            y: -210,
            duration: 0.25
        }, 0)
        .to( menu, {
            // scale: 0.75,
            y: -450,
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


    // Desktop: +1700px
    mm.add( '(min-width: 1700px)', () => {

        const tl = buildTimeline();

        tl
        .to( logo, {
            scale: 0.20,
            y: -230,
            duration: 0.25
        }, 0)
        .to( menu, {
            // scale: 0.75,
            y: -500,
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