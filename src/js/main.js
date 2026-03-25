import $ from 'jquery';
// import { gsap } from 'gsap';
// import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Google Fonts
import "@fontsource/red-hat-display/400.css";
import "@fontsource/red-hat-display/700.css";
import "@fontsource/zen-kaku-gothic-new/400.css";
import "@fontsource/zen-kaku-gothic-new/700.css";

// Font Awesome
import "@fortawesome/fontawesome-free/css/fontawesome.css"; // コア
import "@fortawesome/fontawesome-free/css/solid.css";       // fa-solid
import "@fortawesome/fontawesome-free/css/brands.css";      // fa-brands

// gsap.registerPlugin(ScrollTrigger);

/* ================================
   カスタムカーソル
================================ */
(function() {
    'use strict';
  
    // タッチデバイスではカスタムカーソルを無効化
    if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
      return;
    }
  
    // カーソル要素を作成
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    document.body.appendChild(cursor);
  
    // ドット要素を作成
    const dot = document.createElement('div');
    dot.className = 'cursor-dot';
    document.body.appendChild(dot);

    const dot2 = document.createElement('div');
    dot2.className = 'cursor-dot2';
    document.body.appendChild(dot2);

    const dot3 = document.createElement('div');
    dot3.className = 'cursor-dot3';
    document.body.appendChild(dot3);

    const cursorParts = [cursor, dot, dot2, dot3];
  
    // マウス位置とカーソル位置
    let mouseX = 0;
    let mouseY = 0;
    let cursorX = 0;
    let cursorY = 0;
  
    // 追従速度
    const speed = 0.15;
  
    // マウス移動を監視
    document.addEventListener('mousemove', (e) => {
      mouseX = e.clientX;
      mouseY = e.clientY;
  
      // ドットは即座に追従
      dot.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
      // dot2.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
      // dot3.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
    });
  
    // ホバー対象の要素
    const hoverTargets = 'a, button, [role="button"], input[type="submit"], input[type="button"]';
  
    // ホバー状態の管理
    document.addEventListener('mouseover', (e) => {
      if (e.target.closest(hoverTargets)) {
        cursor.classList.add('is-hover');
        dot.classList.add('is-hover');
        // dot2.classList.add('is-hover');
        // dot3.classList.add('is-hover');
      }
    });
  
    document.addEventListener('mouseout', (e) => {
      if (e.target.closest(hoverTargets)) {
        cursor.classList.remove('is-hover');
        dot.classList.remove('is-hover');
        // dot2.classList.remove('is-hover');
        // dot3.classList.remove('is-hover');
      }
    });
  
    // 画面外に出たら非表示
    document.addEventListener('mouseleave', () => {
      cursor.classList.add('is-hidden');
      dot.classList.add('is-hidden');
      // dot2.classList.add('is-hidden');
      // dot3.classList.add('is-hidden');
    });
  
    document.addEventListener('mouseenter', () => {
      cursor.classList.remove('is-hidden');
      dot.classList.remove('is-hidden');
      // dot2.classList.remove('is-hidden');
      // dot3.classList.remove('is-hidden');
    });
  
    // アニメーションループ（custom-cursorの遅延追従）
    function animate() {
      cursorX += (mouseX - cursorX) * speed;
      cursorY += (mouseY - cursorY) * speed;
  
      cursor.style.transform = `translate(${cursorX}px, ${cursorY}px)`;

      requestAnimationFrame(animate);
    }
  
    animate();
  })();