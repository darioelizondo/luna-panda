import gsap from './../libs/gsap';
import ScrollTrigger from './../libs/ScrollTrigger';

gsap.registerPlugin( ScrollTrigger );

/**
 * AllowExpandOnTop:
 * - true: al volver arriba (leaveBack) vuelve expanded (ideal HOME)
 * - false: nunca vuelve expanded por scroll (ideal INNER)
 */
export const bindHeaderToScroll = ( headerCtrl, threshold = 40, { allowExpandOnTop = true } = {} ) => {
    
    if ( !headerCtrl ) return null;

    const st = ScrollTrigger.create({
        start: threshold,
        end: threshold + 1,
        onEnter: () => headerCtrl.setCompact( true ),
        onLeaveBack: () => {
            if ( allowExpandOnTop ) headerCtrl.setCompact( false );
        },
    });

    return () => st.kill();
  
};

