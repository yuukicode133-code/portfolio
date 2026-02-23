import $ from 'jquery';

// DOM要素の参照
const $loadingScreen = $('#loading-screen');
const $clipRect = $('#clip-rect');
const $cursorLine = $('#cursor-line');
const $statusText = $('#status-text');
const $progressFill = $('#progress-fill');
const $progressPercentage = $('#progress-percentage');

// ステータステキストの段階
const STATUS_MESSAGES = [
  'Mixing pigments',
  'Binding resin',
  'Setting paper',
  'Curing ink',
  'Complete'
];

// easeInOutQuad イージング関数
function easeInOutQuad(t) {
  return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
}

// ローディングアニメーション
function startLoadingAnimation(onComplete) {
  const duration = 1500; // 1.5秒（0.2s〜1.7s）
  const startTime = performance.now();
  const svgWidth = 700; // viewBoxの幅

  // カーソル線を表示
  $cursorLine.css('opacity', 0.6);

  function animate(currentTime) {
    const elapsed = currentTime - startTime;
    const rawProgress = Math.min(elapsed / duration, 1);
    const progress = easeInOutQuad(rawProgress);

    // clipPathの幅を更新
    const clipWidth = progress * svgWidth;
    $clipRect.attr('width', clipWidth);

    // カーソル線の位置を更新
    $cursorLine.attr('x1', clipWidth);
    $cursorLine.attr('x2', clipWidth);

    // プログレスバーを更新
    const percentage = Math.floor(progress * 100);
    $progressFill.css('width', `${percentage}%`);
    $progressPercentage.text(`${percentage}%`);

    // ステータステキストを更新
    const statusIndex = Math.min(Math.floor(progress * 4), STATUS_MESSAGES.length - 2);
    $statusText.text(STATUS_MESSAGES[statusIndex]);

    if (rawProgress < 1) {
      requestAnimationFrame(animate);
    } else {
      // 完了
      $statusText.text('Complete');
      $cursorLine.css('opacity', 0);

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
      console.log('Loading complete — main content ready');
    });
  }, 200);
});
