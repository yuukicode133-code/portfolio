import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

// ▼▼▼ 【追加】blob のアニメーション設定値
const blobConfig = {
  pc: {
    ".p-fv__blob":        { fv: { x: -200, y: 40, scale: 2 },    works: { x: -350, y: 200, scale: 2.5 } },
    ".p-fv__blob-accent": { fv: { x: 180, y: -150, scale: 1.5 }, works: { x: 300, y: -100, scale: 1.8 } },
    ".p-fv__blob-mint":   { fv: { x: -300, y: 120, scale: 1.3 }, works: { x: -400, y: 250, scale: 1.5 } },
  },
  // tablet: { ... },  ← 後で追加可能
};

// ▼▼▼ 【追加】blob アニメーションを生成する関数
function setupBlobs(config) {
  Object.keys(config).forEach(function (selector) {
    const values = config[selector];

    // FV → Works の遷移
    gsap.to(selector, {
      ...values.fv,
      scrollTrigger: {
        trigger: ".p-fv-section",
        start: "top top",
        end: "bottom top",
        scrub: true,
      },
    });

    // Works → Service の遷移
    gsap.to(selector, {
      ...values.works,
      scrollTrigger: {
        trigger: ".p-works-section",
        start: "bottom bottom",
        end: "bottom top",
        scrub: true,
      },
    });
  });
}

// ▼▼▼ アニメーション実行（既存の if 文）
const prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

if (!prefersReduced) {
  ScrollTrigger.matchMedia({
    "(min-width: 768px)": function () {
      setupBlobs(blobConfig.pc);
    },
  });
}