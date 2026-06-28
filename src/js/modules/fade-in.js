// fade-in.js
(function () {
    "use strict";
  
    // JSが動いている証として html に js クラスを付与(これで初期非表示が有効になる)
    document.documentElement.classList.add("js");
  
    const targets = document.querySelectorAll(".js-fade");
    if (targets.length === 0) return;
  
    // reduced-motion なら監視せず即表示にして終了
    const prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (prefersReduced) {
      targets.forEach((el) => el.classList.add("is-in-view"));
      return;
    }
  
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-in-view");
            observer.unobserve(entry.target); // 一度出たら監視解除(戻りで再生しない)
          }
        });
      },
      {
        threshold: 0.15,
        rootMargin: "0px 0px -10% 0px",
      }
    );
  
    targets.forEach((el) => observer.observe(el));
  })();