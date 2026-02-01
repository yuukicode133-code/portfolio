(function() {
  'use strict';

  // タッチデバイスではカスタムカーソルを無効化
  if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
    return;
  }

  // カーソル要素を作成
  const cursor = document.createElement('div');
  cursor.className = 'custom-cursor';
  document.body.appendChild(cursor);

  // マウス位置とカーソル位置
  let mouseX = 0;
  let mouseY = 0;
  let cursorX = 0;
  let cursorY = 0;

  // 追従速度
  const speed = 0.15;

  // マウス移動を監視
  document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
  });

  // ホバー対象の要素
  const hoverTargets = 'a, button, [role="button"], input[type="submit"], input[type="button"]';

  // ホバー状態の管理
  document.addEventListener('mouseover', (e) => {
    if (e.target.closest(hoverTargets)) {
      cursor.classList.add('is-hover');
    }
  });

  document.addEventListener('mouseout', (e) => {
    if (e.target.closest(hoverTargets)) {
      cursor.classList.remove('is-hover');
    }
  });

  // 画面外に出たらカーソルを非表示
  document.addEventListener('mouseleave', () => {
    cursor.classList.add('is-hidden');
  });

  document.addEventListener('mouseenter', () => {
    cursor.classList.remove('is-hidden');
  });

  // アニメーションループ
  function animate() {
    // 遅延追従の計算
    cursorX += (mouseX - cursorX) * speed;
    cursorY += (mouseY - cursorY) * speed;

    // カーソル位置を更新
    cursor.style.transform = `translate(${cursorX}px, ${cursorY}px)`;

    requestAnimationFrame(animate);
  }

  // アニメーション開始
  animate();

  // デフォルトカーソルを非表示にするスタイルを追加
  const style = document.createElement('style');
  style.textContent = `
    * {
      cursor: none !important;
    }

    .custom-cursor {
      position: fixed;
      top: -20px;
      left: -20px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.8);
      pointer-events: none;
      z-index: 9999;
      mix-blend-mode: difference;
      transition: width 0.3s ease, height 0.3s ease, top 0.3s ease, left 0.3s ease, background-color 0.3s ease;
      will-change: transform;
    }

    .custom-cursor.is-hover {
      width: 60px;
      height: 60px;
      top: -30px;
      left: -30px;
      background-color: rgba(0, 0, 0, 0.8);
    }

    .custom-cursor.is-hidden {
      opacity: 0;
    }
  `;
  document.head.appendChild(style);
})();
