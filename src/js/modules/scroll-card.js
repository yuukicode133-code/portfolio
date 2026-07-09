import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

// ============================================================
// .p-top-works__card のスクロール連動アニメーション
// ============================================================
(function () {
  "use strict";

  const cardWrappers = gsap.utils.toArray(".p-top-works__card-link");

  cardWrappers.forEach((wrapper, i) => {
    const card = wrapper.querySelector(".p-top-works__card");

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
    // ② 最後のカード以外:次のカードが来たら縮む
    // ============================
    if (i < cardWrappers.length - 1) {
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


// ============================================================
// .p-top-works-section の --card-height を「全カードの最大自然高さ」に同期
// ============================================================
// 目的:
//   全カードの高さを揃えて、手前カードの下端の透明領域から
//   後ろカードが透けて見える現象を防ぐ。--card-height は他にも
//   title height, button height, sticky-top, margin-bottom など
//   多数の計算式から参照されているため、これを一括同期する。
//
// フィードバックループ対策(重要):
//   .p-top-works__card には min-height: var(--card-height) を指定しているため、
//   JS が単純に高さを測定すると「min-height で押し広げられた値」を
//   読んでしまい、一度大きな値が入ると下がれなくなる。
//   → 測定の直前に min-height を一時的に "0" で打ち消し、
//     カードの自然な content 高さを測定する。
//     測定後に min-height を元に戻す(CSS変数経由の指定に戻す)。
//
// 測定値について:
//   getBoundingClientRect().height は transform の影響を受ける
//   (GSAP の scale 0.95 が掛かっているカードは小さく見える)。
//   offsetHeight は transform を無視した layout 高さを返すので
//   こちらを使う。
//
// 仕組み:
//   1) 全 .p-top-works__card の min-height を一時的に "0" にする
//   2) 各カードの offsetHeight(自然高さ)を測り、最大値を算出
//   3) min-height のインライン指定をクリア(CSS の指定に戻す)
//   4) .p-top-works-section の --card-height をその最大値で更新
//   5) CSS のカスケードにより参照先(min-height 含む)が再計算
//   6) ScrollTrigger は高さ変化を自動検知しないので明示的に refresh
//
// メディアクエリ非依存:
//   ブラウザは画面幅に応じた clamp 値ですでに描画しているので、
//   JS は描画結果を読むだけ。インラインスタイルは詳細度最高なので
//   SCSS のメディアクエリ定義は上書きされる。
// ============================================================
(function syncCardHeight() {
  const section = document.querySelector(".p-top-works-section");
  const cards = document.querySelectorAll(".p-top-works__card");
  if (!section || cards.length === 0) return;

  // ResizeObserver のコールバック内で min-height を変更すると
  // それ自体が ResizeObserver を発火させて無限ループに繋がる可能性がある。
  // → isUpdating フラグで自分が起こした再描画を無視する
  let isUpdating = false;

  const updateHeight = () => {
    if (isUpdating) return;
    isUpdating = true;

    // min-height による押し広げを打ち消して自然な高さを測る
    cards.forEach((card) => {
      card.style.minHeight = "0";
    });

    // offsetHeight: transform の影響を受けない layout 上の高さ
    let maxHeight = 0;
    cards.forEach((card) => {
      const h = card.offsetHeight;
      if (h > maxHeight) maxHeight = h;
    });

    // min-height のインライン指定を解除して SCSS の指定(var(--card-height))に戻す
    cards.forEach((card) => {
      card.style.minHeight = "";
    });

    section.style.setProperty("--card-height", `${maxHeight}px`);
    ScrollTrigger.refresh();

    // 自分の min-height 操作による ResizeObserver 発火を捨てるため
    // 次フレームでフラグを下ろす
    requestAnimationFrame(() => {
      isUpdating = false;
    });
  };

  // ResizeObserver: 要素自身のサイズ変化を監視
  // ・ウィンドウリサイズ
  // ・フォント読み込みによる文字幅変化
  // ・コンテンツ変更による高さ変化
  // のいずれにも反応する。全カードを監視対象に登録。
  const ro = new ResizeObserver(updateHeight);
  cards.forEach((card) => ro.observe(card));

  // Web フォント読み込み完了後にもう一度同期
  if (document.fonts) {
    document.fonts.ready.then(updateHeight);
  }
})();