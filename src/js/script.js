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


// LINEアプリ内ブラウザ判定
const isLINE = /Line/i.test(navigator.userAgent);

if (isLINE) {
  const banner = document.createElement('div');
  banner.style.cssText = 'position:fixed;bottom:0;left:0;right:0;background:#51733f;color:#fff;padding:16px;text-align:center;z-index:9998;font-size:13px;font-family:sans-serif;';
  banner.innerHTML = `
    <p style="color:#fff;margin:0 0 4px;">より快適にご覧いただけます</p>
    <p style="color:rgba(255,255,255,0.8);margin:0;font-size:12px;">右上の <strong>⋯</strong> → <strong>「Safariで開く」</strong> をタップ</p>
    <button style="position:absolute;top:8px;right:12px;background:none;border:none;color:#fff;font-size:20px;cursor:pointer;" onclick="this.parentElement.remove()">×</button>
  `;
  document.body.appendChild(banner);
}