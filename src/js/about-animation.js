import $ from 'jquery';
$(document).ready(function() {
  const $aboutSection = $('.about');
  const $textCircle = $('.about__text-circle');

  if (!$aboutSection.length || !$textCircle.length) return;

  // アニメーションパラメータ
  const config = {
    initialScale: 0.05,
    maxScale: 4,        // 画面を覆うための最大scale
    startOffset: 0,     // セクション上端からどれだけ前でアニメーション開始するか
    endOffset: 0.3      // セクションのどの位置でアニメーション完了するか（0.6 = 60%地点）
  };

  // ウィンドウ幅に応じてmaxScaleを更新
  function updateConfig() {
    const windowWidth = $(window).width();
    config.maxScale = windowWidth <= 768 ? 6 : 4;
  }

  function updateCircleScale() {
    const rect = $aboutSection[0].getBoundingClientRect();
    const viewportHeight = $(window).height();
    const sectionHeight = $aboutSection.outerHeight();

    // アニメーションの開始・終了位置を計算
    // rect.top: セクション上端とビューポート上端の距離
    // 正の値 = セクションはまだ下にある
    // 負の値 = セクション上端は画面より上に行った

    const animationStart = viewportHeight * 0.7; // 画面の80%位置に来たら開始
    const animationEnd = -sectionHeight * config.endOffset; // セクションの60%がスクロールされたら完了

    // 進行度を計算（0〜1）
    const progress = (animationStart - rect.top) / (animationStart - animationEnd);
    const clampedProgress = Math.max(0, Math.min(1, progress));

    // scale値を計算
    const currentScale = config.initialScale + (config.maxScale - config.initialScale) * clampedProgress;

    // opacityを計算（最初の20%の進行で1になる）
    const opacity = Math.min(1, clampedProgress * 5);

    // スタイルを適用
    $textCircle.css({
      transform: `scale(${currentScale})`,
      opacity: opacity
    });
  }

  // スクロールイベントで更新（パフォーマンス考慮）
  let ticking = false;
  $(window).on('scroll', function() {
    if (!ticking) {
      requestAnimationFrame(function() {
        updateCircleScale();
        ticking = false;
      });
      ticking = true;
    }
  });

  // 初期状態を設定
  updateConfig();
  updateCircleScale();

  // リサイズ時も再計算
  $(window).on('resize', function() {
    updateConfig();
    updateCircleScale();
  });
});