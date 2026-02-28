import $ from 'jquery';
// ビューポートの設定
!(function () {
  const viewport = document.querySelector('meta[name="viewport"]');
  let lastWidth = window.outerWidth;

  function switchViewport() {
    const currentWidth = window.outerWidth;
    
    // 幅が変わっていない場合はスキップ（アドレスバー出入り対策）
    if (currentWidth === lastWidth) return;
    lastWidth = currentWidth;

    const value = currentWidth > 360 
      ? "width=device-width,initial-scale=1" 
      : "width=360";
    if (viewport.getAttribute("content") !== value) {
      viewport.setAttribute("content", value);
    }
  }
  addEventListener("resize", switchViewport, false);
  switchViewport();
})();

// worksアイテムのスクロールアニメーション
$(function () {
  const $items = $(".works__item");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          $(entry.target).addClass("is-visible");
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    },
  );

  $items.each(function () {
    observer.observe(this);
  });
});



