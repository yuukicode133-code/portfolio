<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no,address=no,email=no">
  <script>
    document.documentElement.classList.add("js");
  </script>

  
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header class="l-header">
    <div class="l-inner p-header">
      <?php if (is_front_page()): ?>
        <h1 class="p-header__logo-heading">
          <a href="<?php echo home_url('/'); ?>" class="p-header__logo-link" aria-label="yuuki portfolio ホームへ">
            <span>yuuk</span><span class="p-header__logo-accent">i</span><span>&nbsp;portfolio</span>
          </a>
        </h1>
      <?php else: ?>
        <a href="<?php echo home_url('/'); ?>" class="p-header__logo-link" aria-label="yuuki portfolio — ホームへ">
          <span>yuuk</span><span class="p-header__logo-accent">i</span><span>&nbsp;portfolio</span>
        </a>
      <?php endif; ?>
      <nav
        id="global-nav"
        class="p-header__nav"
        aria-label="グローバルナビゲーション">
        <ul class="p-header__nav-list">
        <li class="p-header__nav-item">
          <a href="<?php echo esc_url( home_url( '/works/' ) ); ?>" class="p-header__nav-link">制作実績</a>
        </li>
        <li class="p-header__nav-item">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>#service" class="p-header__nav-link">できること</a>
        </li>
        <li class="p-header__nav-item">
          <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="p-header__nav-link">私について</a>
        </li>
        <li class="p-header__nav-item">
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="p-header__nav-link">お問い合わせ</a>
        </li>
      </ul>
      </nav>

      <button
        type="button"
        class="p-header__hamburger"
        aria-label="メニューを開く"
        aria-expanded="false"
        aria-controls="global-nav">
        <span class="p-header__hamburger-bar"></span>
        <span class="p-header__hamburger-bar"></span>
        <span class="p-header__hamburger-bar"></span>
      </button>
    </div>
  </header>