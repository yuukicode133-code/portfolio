<?php get_header(); ?>
<main class="l-main">

    <!-- 下層共通パンくず。site階層のみ示す(フォーム進行は p-contact-steps が別途持つ) -->
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

    <!-- ページヘッダー(下層共通)。装飾数字は廃止、装飾は円弧モチーフに一本化 -->
    <div class="p-page-header">
      <!-- <span class="c-arc p-page-header__arc" aria-hidden="true"></span> -->
      <div class="l-inner">
        <h1 class="c-section-title">
          <span class="c-section-title__en p-page-header__title">contact</span>
          <span class="c-section-title__ja">お問い合わせ</span>
        </h1>
        <p class="p-page-header__lead">
          ポートフォリオをご覧いただき、ありがとうございます。<br>面談のご依頼やご相談などございましたら、以下のフォームよりご連絡ください。<br>2営業日以内にご返信いたします。
        </p>
      </div>
    </div>
  
    <!-- 進行表示(機能的・数字は現在地を指すので残す)。入力ページ = STEP 01 が現在地 -->
    <div class="l-inner">
      <ol class="p-contact-steps" aria-label="お問い合わせの進行状況">
        <li class="p-contact-steps__item is-current" aria-current="step">
          <span class="p-contact-steps__num">STEP 01</span>
          <span class="p-contact-steps__label">入力</span>
        </li>
        <li class="p-contact-steps__item">
          <span class="p-contact-steps__num">STEP 02</span>
          <span class="p-contact-steps__label">確認</span>
        </li>
        <li class="p-contact-steps__item">
          <span class="p-contact-steps__num">STEP 03</span>
          <span class="p-contact-steps__label">完了</span>
        </li>
      </ol>
    </div>
  
    <!-- フォーム本体(単一セクションなので装飾数字なし) -->
    <section class="l-section p-contact-form-section">
      <div class="l-inner">
        <div class="p-contact-form-section-wrapper">
          <h2 class="p-contact-form-section__title">必要事項のご入力</h2>
          <p class="p-contact-form-section__note">
            「必須」の項目をすべてご入力のうえ、確認画面へお進みください。
          </p>
  
          <!-- 静的段階は非機能。CF7 + Multi-Step Forms 移行時に
               ステップ遷移はプラグインが処理(action/ショートコードへ差し替え) -->
          <?php echo do_shortcode('[contact-form-7 id="274fd98" title="入力用" html_class="p-contact-form"]'); ?>
        </div>
      </div>
    </section>
  
  </main>
  <?php get_footer(); ?>