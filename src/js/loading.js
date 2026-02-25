import $ from "jquery";

//DOM要素の参照
const $loadingScreen = $("#loading-screen");
const $revealText = $("#reveal-text");
const $statusText = $("#status-text");
const $progressFill = $("#progress-fill");
const $progressPct = $("#progress-pct");

// easeInOutQuad イージング関数
function easeInOutQuad(t) {
  return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
}

// ローディングアニメーション
function startLoadingAnimation(onComplete) {
  const duration = 1500; // 1.5秒（0.2s〜1.7s）
  const startTime = performance.now();

  function animate(currentTime) {
    const elapsed = currentTime - startTime;
    const rawProgress = Math.min(elapsed / duration, 1);
    const progress = easeInOutQuad(rawProgress);

    // clip-pathでテキストリビール（右側を隠す値を100%→0%に）
    const rightInset = (1 - progress) * 100;
    $revealText.css("clip-path", `inset(0 ${rightInset}% 0 0)`);

    // プログレスバーを更新
    const percentage = Math.floor(progress * 100);
    $progressFill.css("width", `${percentage}%`);
    $progressPct.text(`${percentage}%`);

    if (rawProgress < 1) {
      requestAnimationFrame(animate);
    } else {
      // 完了
      $statusText.text("Complete");

      // 0.3秒待ってからフェードアウト
      setTimeout(() => {
        $loadingScreen.fadeOut(400, () => {
          $loadingScreen.remove();
          if (onComplete) onComplete();
        });
      }, 300);
    }
  }

  requestAnimationFrame(animate);
}

// フォント読み込み完了を待ってからアニメーション開始
document.fonts.ready.then(() => {
  // 0.2秒待ってからアニメーション開始
  setTimeout(() => {
    startLoadingAnimation(() => {
      console.log("Loading complete — main content ready");
    });
  }, 200);
});

// デバッグ用: コンソールから window.setProgress(50) で任意の%に固定
// window.setProgress = function(percent) {
//   const progress = percent / 100;
//   const rightInset = (1 - progress) * 100;

//   $revealText.css("clip-path", `inset(0 ${rightInset}% 0 0)`);
//   $progressFill.css("width", `${percent}%`);
//   $progressPct.text(`${percent}%`);

//   if (percent >= 100) {
//     $statusText.text("Complete");
//   } else {
//     $statusText.text("Loading...");
//   }
// };