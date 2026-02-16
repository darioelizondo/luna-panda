import THREE from './libs/three';
import gsap from './libs/gsap';

const loader = () => {

    // ============================
    // Burn effect
    // ============================
    
    const loaderEl = document.querySelector('.loader');
    const canvas = document.getElementById('burn-canvas');
    const gif = document.getElementById('gif-loader');
    // const counterEl = document.querySelector('[data-loader-percent]');

    // Guards
    if (!loaderEl || !canvas) return;
    // if (!counterEl) return;

    // Asegurar que THREE existe
    if (!THREE || !THREE.WebGLRenderer) {
        console.error('THREE is not available. Check your three.js import/build.');
        return;
    }

    const counter = { value: 0 };
    const DURATION = 3750;

    // Iniciar animación de contador
    // gsap.to(counter, {
    //     value: 100,
    //     duration: DURATION / 1000,
    //     ease: 'power1.out',
    //     onUpdate: () => {
    //     counterEl.textContent = `${Math.round(counter.value)}%`;
    //     },
    // });

    // Ocultar gif una vez empieza la animación
    setTimeout( () => {
        gif.classList.add( 'hidden' );
    }, DURATION );

    setTimeout( () => {

        const renderer = new THREE.WebGLRenderer({
            canvas,
            alpha: true,
            antialias: true
        });
        
        renderer.setPixelRatio(window.devicePixelRatio || 1);
        renderer.setSize(window.innerWidth, window.innerHeight);

        const scene = new THREE.Scene();
        const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);

        // Fullscreen quad
        const geometry = new THREE.PlaneGeometry(2, 2);

        // ============================
        // SHADERS (quemado suave, blanco → negro)
        // ============================
        const vertexShader = `
        varying vec2 v_uv;
        void main() {
            v_uv = uv;
            gl_Position = vec4(position, 1.0);
        }
        `;

        // fbm noise para patrón más orgánico
        const fragmentShader = `
        precision highp float;

        varying vec2 v_uv;

        uniform float u_time;
        uniform float u_progress;
        uniform vec3 u_brandColor;

        float hash(vec2 p) {
            return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453123);
        }

        float noise(vec2 p) {
            vec2 i = floor(p);
            vec2 f = fract(p);

            float a = hash(i);
            float b = hash(i + vec2(1.0, 0.0));
            float c = hash(i + vec2(0.0, 1.0));
            float d = hash(i + vec2(1.0, 1.0));

            vec2 u = f * f * (3.0 - 2.0 * f);

            return mix(a, b, u.x) +
                (c - a) * u.y * (1.0 - u.x) +
                (d - b) * u.x * u.y;
        }

        // fbm: sumamos varias octavas de ruido para algo más orgánico
        float fbm(vec2 p) {
            float value = 0.0;
            float amplitude = 0.5;
            float frequency = 1.0;

            for (int i = 0; i < 5; i++) {
            value += amplitude * noise(p * frequency);
            frequency *= 2.0;
            amplitude *= 0.5;
            }

            return value;
        }

        void main() {
            vec2 uv = v_uv;
            vec2 p = uv * 3.0;

            // Dominio deformado para que sea más orgánico
            vec2 warp = vec2(
            fbm(p + u_time * 0.25),
            fbm(p + vec2(5.2, 1.3) + u_time * 0.2)
            );

            p += warp * 0.8;

            float n = fbm(p);
            n = smoothstep(0.0, 1.0, n);

            // threshold que va de 1 → 0 a medida que avanza el tiempo
            float threshold = 1.0 - u_progress;

            // zona quemada
            float burnt = step(threshold, n);

            // borde de quemado
            float edgeWidth = 0.08;
            float edge = smoothstep(threshold, threshold + edgeWidth, n);

            // brand color (amarillo) → negro
            vec3 black = vec3(0.0);
            vec3 color = mix(u_brandColor, black, edge);

            // donde está totalmente quemado, hacemos hueco
            if (burnt > 0.99 && edge < 0.01) {
            discard;
            }

            gl_FragColor = vec4(color, 1.0);
        }
        `;

        // Material del "papel quemándose"
        const material = new THREE.ShaderMaterial({
        uniforms: {
            u_time: { value: 0 },
            u_progress: { value: 0 },
            u_brandColor: { value: new THREE.Color('#FFA300') } // Primary color
        },
        vertexShader,
        fragmentShader,
        transparent: true
        });

        const mesh = new THREE.Mesh(geometry, material);
        scene.add(mesh);

        // ============================
        // ANIMACIÓN
        // ============================
        let start = performance.now();
        const DURATION = 3.0; // segundos

        function easeInOutCubic(x) {
        return x < 0.5
            ? 4.0 * x * x * x
            : 1.0 - Math.pow(-2.0 * x + 2.0, 3.0) / 2.0;
        }

        function animate(now) {
            const tSec = (now - start) / 1000;
            const rawProgress = Math.min(tSec / DURATION, 1.0);
            const easedProgress = easeInOutCubic(rawProgress);

            material.uniforms.u_time.value = tSec;
            material.uniforms.u_progress.value = easedProgress;

            renderer.render(scene, camera);

            if (rawProgress < 1.0) {
                requestAnimationFrame(animate);
            } else {
                loaderEl.classList.add('is-done');

                // Notify the rest of the site that the loader has finished
                window.__LOADER_DONE__ = true;
                window.dispatchEvent( new CustomEvent( 'loader:done' ) );

            }
        }

        requestAnimationFrame(animate);

        // ============================
        // RESIZE
        // ============================
        window.addEventListener('resize', () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        });

    }, 2500 );

    


};

document.addEventListener('DOMContentLoaded', loader);