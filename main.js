import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// GSAPの読み込み
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// 既存のJSファイルを読み込み
import './js/script.js';
import './js/about-animation.js';
import './js/contact.js';
import './js/custom-cursor.js';
import './js/modal.js';