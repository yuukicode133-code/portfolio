import $ from 'jquery';
(function($) {
  'use strict';

  // タッチデバイスではカスタムカーソルを無効化
  if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
    return;
  }

  // カーソル要素を作成
  const $cursor = $('<div>').addClass('custom-cursor');
  $('body').append($cursor);

  // マウス位置とカーソル位置
  let mouseX = 0;
  let mouseY = 0;
  let cursorX = 0;
  let cursorY = 0;

  // 追従速度
  const speed = 0.15;

  // ホバー対象の要素
  const hoverTargets = 'a,button, [role="button"], input[type="submit"], input[type="button"],input[type="text"],input[type="email"],#contact-message';

  // マウス移動を監視
  $(document).on('mousemove', function(e) {
    mouseX = e.clientX;
    mouseY = e.clientY;
  });

  // ホバー状態の管理
  $(document).on('mouseover', hoverTargets, function() {
    $cursor.addClass('is-hover');
  });

  $(document).on('mouseout', hoverTargets, function() {
    $cursor.removeClass('is-hover');
  });

  // 画面外に出たらカーソルを非表示
  $(document).on('mouseleave', function() {
    $cursor.addClass('is-hidden');
  });

  $(document).on('mouseenter', function() {
    $cursor.removeClass('is-hidden');
  });

  // アニメーションループ
  function animate() {
    // 遅延追従の計算
    cursorX += (mouseX - cursorX) * speed;
    cursorY += (mouseY - cursorY) * speed;

    // カーソル位置を更新
    $cursor.css({
      transform: 'translate(' + cursorX + 'px, ' + cursorY + 'px)'
    });

    requestAnimationFrame(animate);
  }

  // アニメーション開始
  animate();
})($);
