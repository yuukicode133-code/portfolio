document.addEventListener('DOMContentLoaded', function() {
  const aboutSection = document.querySelector('.about');
  const textCircle = document.querySelector('.about__text-circle');
  const textContent = document.querySelector('.about__text-content');

  if (!aboutSection || !textCircle) return;

  // アニメーションパラメータ
  const config = {
    initialScale: 0.5,
    maxScale: 6,        // 画面を覆うための最大scale
    startOffset: 0,     // セクション上端からどれだけ前でアニメーション開始するか
    endOffset: 0.3    // セクションのどの位置でアニメーション完了するか（0.6 = 60%地点）
  };

  function updateCircleScale() {
    const rect = aboutSection.getBoundingClientRect();
    const viewportHeight = window.innerHeight;
    const sectionHeight = aboutSection.offsetHeight;

    // アニメーションの開始・終了位置を計算
    // rect.top: セクション上端とビューポート上端の距離
    // 正の値 = セクションはまだ下にある
    // 負の値 = セクション上端は画面より上に行った

    const animationStart = viewportHeight * 0.8; // 画面の80%位置に来たら開始
    const animationEnd = -sectionHeight * config.endOffset; // セクションの60%がスクロールされたら完了

    // 進行度を計算（0〜1）
    const progress = (animationStart - rect.top) / (animationStart - animationEnd);
    const clampedProgress = Math.max(0, Math.min(1, progress));

    // scale値を計算
    const currentScale = config.initialScale + (config.maxScale - config.initialScale) * clampedProgress;

    // opacityを計算（最初の20%の進行で1になる）
    const opacity = Math.min(1, clampedProgress * 5);

    // スタイルを適用
    textCircle.style.transform = `scale(${currentScale})`;
    textCircle.style.opacity = opacity;

    // テキストに逆scaleを適用（テキストが巨大化しないように）
    if (textContent) {
      const inverseScale = 1 / currentScale;
      textContent.style.transform = `scale(${inverseScale})`;
    }
  }

  // スクロールイベントで更新（パフォーマンス考慮）
  let ticking = false;
  window.addEventListener('scroll', function() {
    if (!ticking) {
      requestAnimationFrame(function() {
        updateCircleScale();
        ticking = false;
      });
      ticking = true;
    }
  });

  // 初期状態を設定
  updateCircleScale();

  // リサイズ時も再計算
  window.addEventListener('resize', updateCircleScale);
});
