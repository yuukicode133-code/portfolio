import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

(function () {
  "use strict";

  const cardWrappers = gsap.utils.toArray(".p-works__card-wrapper");

  cardWrappers.forEach((wrapper, i) => {
    const card = wrapper.querySelector(".p-works__card");

    // ============================
    // ① カードの出現アニメーション
    // ============================
    gsap.fromTo(
      card,
      { y: 40 },
      {
        y: 0,
        duration: 0.6,
        ease: "power2.out",
        scrollTrigger: {
          trigger: wrapper,
          start: "top 80%",
          toggleActions: "play none none none",
        },
      }
    );

    // ============================
    // ② 最後のカード以外：次のカードが来たら縮む
    // ============================
    if (i < cardWrappers.length - 1) {
      // 次の card-wrapper をトリガーにする
      const nextWrapper = cardWrappers[i + 1];

      gsap.to(card, {
        scale: 0.95,
        opacity: 0.6,
        scrollTrigger: {
          trigger: nextWrapper,
          start: "top bottom",   // 次のwrapperの上端が画面下端に来たら開始
          end: "top center",     // 次のwrapperの上端が画面中央に来たら完了
          scrub: true,           // ★ スクロール量に連動して滑らかに変化
        },
      });
    }
  });
})();

function syncLeftHeight() {
  const left = document.querySelector('.p-works__left');
  const wrapper = document.querySelector('.p-works__card-wrapper');
  const card = document.querySelector('.p-works__card');
  if (!left || !wrapper || !card) return;

  // wrapper(100svh) からカード実高さを引いた = 1枚あたりの余白
  const gap = wrapper.offsetHeight - card.offsetHeight;

  // カード枚数分の余白（最後の1枚は固定で止まるので除外してもよい）
  const wrappers = document.querySelectorAll('.p-works__card-wrapper');
  left.style.marginBottom = gap + 'px';

  ScrollTrigger.refresh();
}

syncLeftHeight();
window.addEventListener('resize', syncLeftHeight);