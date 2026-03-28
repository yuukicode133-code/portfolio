import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

if (!prefersReduced) {
  ScrollTrigger.matchMedia({
    // ▼▼▼ 768px以上（PC/タブレット）のときだけ有効
    "(min-width: 768px)": function () {
        gsap.to(".p-fv__blob", {
            x: "-30vw",       // 現在位置から左へ（中央方向へ）
            y: "5vh",
            scale: 2,
            scrollTrigger: {
              trigger: ".p-fv-section",
              start: "top top",
              end: "bottom top",
              scrub: true,
            },
          });

          gsap.to(".p-fv__blob-accent", {
            x: "30vw",
            y: "-25vh",
            scale: 1.5,
            scrollTrigger: {
              trigger: ".p-fv-section",
              start: "top top",
              end: "bottom top",
              scrub: true,
            },
          });

          gsap.to(".p-fv__blob-mint", {
            x: "-50vw",
            y: "20vh",
            scale: 1.3,
            scrollTrigger: {
              trigger: ".p-fv-section",
              start: "top top",
              end: "bottom top",
              scrub: true,
            },
          });
    },
  });
}
