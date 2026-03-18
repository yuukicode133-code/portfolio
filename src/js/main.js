import $ from 'jquery';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

console.log('Vite is running!');
console.log('jQuery version:', $.fn.jquery);
console.log('GSAP version:', gsap.version);