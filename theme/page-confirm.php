<?php get_header(); ?>
<main class="l-main">
  <nav class="c-breadcrumb" aria-label="パンくず">
    <div class="l-inner">
      <ol class="c-breadcrumb__list">
        <li class="c-breadcrumb__item">
          <a class="c-breadcrumb__link" href="/">ホーム</a>
        </li>
        <li class="c-breadcrumb__item" aria-current="page">
          <span class="c-breadcrumb__current">お問い合わせ</span>
        </li>
      </ol>
    </div>
  </nav>

  <div class="p-page-header">
    <div class="l-inner">
      <h1 class="c-section-title">
          <span class="c-section-title__en p-page-header__title">confirm</span>
          <span class="c-section-title__ja">入力内容のご確認</span>
        </h1>
      <p class="p-page-header__lead">送信前の最終確認です。内容をご確認のうえ、よろしければ送信してください。<br />修正が必要な場合は「修正する」から入力画面に戻れます。</p>
    </div>
  </div>

  <!-- 進行表示: STEP01=完了 / STEP02=現在地 / STEP03=未到達 -->
  <div class="l-inner">
    <ol class="p-contact-steps" aria-label="お問い合わせの進行状況">
      <li class="p-contact-steps__item is-done">
        <span class="p-contact-steps__num">STEP 01</span>
        <span class="p-contact-steps__label">入力<span class="u-hidden-visually"> 済</span></span>
      </li>
      <li class="p-contact-steps__item is-current" aria-current="step">
        <span class="p-contact-steps__num">STEP 02</span>
        <span class="p-contact-steps__label">確認</span>
      </li>
      <li class="p-contact-steps__item">
        <span class="p-contact-steps__num">STEP 03</span>
        <span class="p-contact-steps__label">完了</span>
      </li>
    </ol>
  </div>

  <section class="l-section p-contact-confirm">
    <div class="l-inner">
      <div class="p-contact-confirm-wrapper">
        <h2 class="p-contact-confirm__title">ご入力いただいた内容</h2>
        <p class="p-contact-confirm__note">内容をご確認のうえ、ページ下部の「送信する」ボタンからお進みください。</p>

        <!-- 確認フローも <form>。送信=submit、修正=入力ページへ戻る遷移。
             静的の値はサンプル。CF7 + Multi-Step Forms 移行時、
             各 dd の値はプラグインが前ステップの入力値を出力する仕組みに差し替え -->
        <?php echo do_shortcode('[contact-form-7 id="06833be" html_class="p-contact-confirm__form" title="確認用"]'); ?>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
