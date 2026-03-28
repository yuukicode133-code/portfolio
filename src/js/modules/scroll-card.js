import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

/* ================================
   スクロール連動カード表示
================================ */
(function() {
    'use strict';
  
    // ① 対象のカード要素を全て取得
    const cards = gsap.utils.toArray('.p-works__card');
  
    // ② 初期状態を GSAPで設定（CSSに書いてもOK）
    gsap.set(cards, {
      opacity: 0,
      y: 30,         // 30px下にずらす
    });
  
    // ③ ScrollTrigger.batch で一括監視
    ScrollTrigger.batch(cards, {
      // カードの上端が viewport の85%地点に来たら発火
      start: 'top 85%',
  
      onEnter: (batch) => {
        // batch = 同時に画面に入ったカードの配列
        gsap.to(batch, {
          opacity: 1,
          y: 0,
          duration: 0.6,
          ease: 'power2.out',
          stagger: 0.15,    // 0.15秒ずつずらして表示
        });
      },
  
      // 一度表示したら監視を外す（再スクロールで消えない）
      once: true,
    });
  })();