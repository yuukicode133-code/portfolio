import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

// ▼▼▼ blob のアニメーション設定値
const blobConfig = {
  pc: {
    ".p-blob-green":  { fv: { x: -200, y: 100, scale: 1 },    works: { x: -350, y: 200, scale: 0.5 } },
    ".p-blob-accent": { fv: { x: 500, y: -150, scale: 1.5 },  works: { x: 300, y: -100, scale: 1 } },
    ".p-blob-mint":   { fv: { x: -750, y: 100, scale: 0.2 },   works: { x: 350, y: 300, scale: 1.1 } },
  },
  // tablet: { ... },  ← 後で追加可能
};

// ▼▼▼ blob アニメーションを生成する関数
function setupBlobs(config) {
  Object.keys(config).forEach(function (selector) {
    const values = config[selector];

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: ".p-fv-section",
        start: "top top",
        endTrigger: ".p-works-section",
        end: "bottom top",
        scrub: true,
      },
    });

    // FV → Works の遷移
    tl.to(selector, { ...values.fv });
    // Works → Service の遷移
    tl.to(selector, { ...values.works });
  });
}

// ▼▼▼ アニメーション実行
const prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

if (!prefersReduced) {
  ScrollTrigger.matchMedia({
    "(min-width: 768px)": function () {
      setupBlobs(blobConfig.pc);
    },
  });
}