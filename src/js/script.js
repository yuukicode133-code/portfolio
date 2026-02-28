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
  // 外部ブラウザで開くリンクを表示
  const banner = document.createElement('div');
  banner.innerHTML = `
    <div style="position:fixed;bottom:0;left:0;right:0;background:#51733f;color:#fff;padding:12px 16px;text-align:center;z-index:9998;font-size:14px;">
      <p style="color:#fff;margin-bottom:8px;">より快適にご覧いただくにはSafariで開いてください</p>
      <a href="${location.href}" target="_blank" rel="noopener" 
         style="color:#fff;background:#2b2b2b;padding:8px 24px;border-radius:20px;display:inline-block;text-decoration:none;font-size:13px;">
        Safariで開く
      </a>
    </div>`;
  document.body.appendChild(banner);
}