import { gsap } from 'gsap';

const menuToggle = document.getElementById('menu-toggle');
const drawerClose = document.getElementById('drawer-close');
const drawer = document.getElementById('drawer');
const blobSvg = drawer.querySelector('.drawer__blob');
const blobPath = document.getElementById('drawer-blob-path');
const navLinks = document.querySelectorAll('.drawer__nav-link');

const isSP = window.matchMedia('(max-width: 767px)').matches;

/**
 * 三角関数でSVGパスを動的生成
 * viewBox="0 0 100 100" 座標系（ハンバーガーボタン起点: 95, 5）
 * @param {number} progress  - 展開度合い（0: 初期点, 1: 全画面）
 * @param {number} waveOffset - 波のオフセット（うねり変化）
 */
function generateInkPath(progress, waveOffset) {
  const N = 12;
  const cx = 100; // ハンバーガーボタンのx位置（%）
  const cy = 0;  // ハンバーガーボタンのy位置（%）
  const maxRadius = 105; // 全コーナーをカバーするのに十分な最大半径

  // 各点の座標を計算
  const pts = new Array(N);
  for (let i = 0; i < N; i++) {
    const angle = (i / N) * Math.PI * 2;
    // 輪郭のうねり（wave）: 角度と waveOffset で変化
    const wave = Math.sin(angle * 3.5 + waveOffset) * progress * 24;
    // 重力バイアス: 下方向への広がりを上方向より大きく
    const gravity = Math.sin(angle - Math.PI * 0.5) * progress * 12;
    const r = progress * maxRadius + wave + gravity;
    pts[i] = [cx + Math.cos(angle) * r, cy + Math.sin(angle) * r];
  }

  // 中間点を制御点・アンカーとする二次ベジェで滑らかな閉曲線を生成
  const last = pts[N - 1];
  const sx = (last[0] + pts[0][0]) / 2;
  const sy = (last[1] + pts[0][1]) / 2;
  const parts = [`M ${sx.toFixed(1)} ${sy.toFixed(1)}`];

  for (let i = 0; i < N; i++) {
    const p = pts[i];
    const next = pts[(i + 1) % N];
    const mx = (p[0] + next[0]) / 2;
    const my = (p[1] + next[1]) / 2;
    parts.push(`Q ${p[0].toFixed(1)} ${p[1].toFixed(1)} ${mx.toFixed(1)} ${my.toFixed(1)}`);
  }
  parts.push('Z');

  return parts.join(' ');
}

const tl = gsap.timeline({ paused: true });

if (isSP) {
  // SP: シンプルな円形拡大（低スペック端末向けフォールバック）
  blobSvg.style.display = 'none';
  gsap.set(drawer, {
    backgroundColor: '#51733f',
    clipPath: 'circle(0% at calc(100% - 40px) 40px)',
  });

  tl.to(drawer, {
    clipPath: 'circle(150% at calc(100% - 40px) 40px)',
    visibility: 'visible',
    duration: 1.0,
    ease: 'power3.inOut',
  });
} else {
  // PC: 三角関数による液体blobアニメーション
  const state = { progress: 0, waveOffset: 0 };

  // 初期状態をセット（progress=0 で全点が起点に収束）
  blobPath.setAttribute('d', generateInkPath(0, 0));

  tl
    .set(drawer, { visibility: 'visible' })
    .to(state, {
      progress: 1,
      waveOffset: 6,
      duration: 1.2,
      ease: 'power3.inOut',
      onUpdate() {
        blobPath.setAttribute('d', generateInkPath(state.progress, state.waveOffset));
      },
    });
}

// ナビリンクのフェードイン（SP/PC共通）
tl.to(navLinks, {
  opacity: 1,
  y: 0,
  duration: 0.4,
  stagger: 0.08,
  ease: 'power2.out',
});

// 開く
menuToggle.addEventListener('click', () => {
  document.body.style.overflow = 'hidden';
  drawer.setAttribute('aria-hidden', 'false');
  tl.play();
});

// 閉じる（逆再生 — 右上に吸い込まれるように収縮）
drawerClose.addEventListener('click', () => {
  tl.reverse();
  tl.eventCallback('onReverseComplete', () => {
    document.body.style.overflow = '';
    drawer.setAttribute('aria-hidden', 'true');
  });
});

// ドロワー内リンクをクリックしたら閉じる
navLinks.forEach((link) => {
  link.addEventListener('click', () => {
    drawerClose.click();
  });
});
