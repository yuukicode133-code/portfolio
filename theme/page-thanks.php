<?php get_header(); ?>
<main class="l-main">

  <?php get_template_part('template-parts/breadcrumb'); ?>

  <div class="p-page-header">
    <div class="l-inner">
      <h1 class="c-section-title">
        <span class="c-section-title__en p-page-header__title">thanks</span>
        <span class="c-section-title__ja">お問い合わせ完了</span>
      </h1>
    </div>
  </div>

  <!-- 進行表示: 全ステップ完了。STEP03=現在地(完了) -->
  <div class="l-inner">
    <ol class="p-contact-steps" aria-label="お問い合わせの進行状況">
      <li class="p-contact-steps__item is-done">
        <span class="p-contact-steps__num">STEP 01</span>
        <span class="p-contact-steps__label">入力<span class="u-hidden-visually"> 済</span></span>
      </li>
      <li class="p-contact-steps__item is-done">
        <span class="p-contact-steps__num">STEP 02</span>
        <span class="p-contact-steps__label">確認<span class="u-hidden-visually"> 済</span></span>
      </li>
      <li class="p-contact-steps__item is-current" aria-current="step">
        <span class="p-contact-steps__num">STEP 03</span>
        <span class="p-contact-steps__label">完了</span>
      </li>
    </ol>
  </div>

  <!-- 1. 送信完了 + 返信予告 -->
  <section class="l-section">
    <div class="l-inner">
      <div class="p-contact-thanks__completed">
        <p class="p-contact-thanks__completed-head">
          <span class="p-contact-thanks__completed-icon" aria-hidden="true"></span>
          お問い合わせを送信しました
        </p>
        <p class="p-contact-thanks__completed-text">
          このたびはお問い合わせいただき、誠にありがとうございます。<br>
          内容を確認のうえ、3営業日以内にご返信いたします。
        </p>
      </div>

      <p class="p-contact-thanks__notice" role="note">
        ご入力いただいたメールアドレスへ自動返信メールを送信しました。届かない場合は、迷惑メールフォルダをご確認のうえ、お手数ですが再度ご連絡ください。
      </p>
    </div>
  </section>

  <!-- 2. 次のアクション(番号なし=進行ではなく付録) -->
  <section class="l-section">
    <div class="l-inner">
      <div class="p-contact-thanks__next">
        <h2 class="p-contact-thanks__next-title">お問い合わせをいただいた皆さまへ</h2>
        <p class="p-contact-thanks__next-lead">お返事までの間に、よろしければご覧ください。</p>

        <!-- 主要アクション: 代表実績への導線。静的はサムネ枠+サンプル。
             実装時に <img alt="..."> と実URLへ -->
        <ul class="p-contact-thanks__cards">
          <li class="p-contact-thanks__card">
            <a class="p-contact-thanks__card-link" href="<?php echo esc_url( home_url( '/about/' ) ); ?>#about-this-site">
              <img class="p-contact-thanks__card-thumb" src="<?php echo get_template_directory_uri() ?>/img/portfolio.webp"
                   alt="ポートフォリオサイトのサムネイル画像" width="480" height="300" loading="lazy">
              <span class="p-contact-thanks__card-label">WordPress</span>
              <h3 class="p-contact-thanks__card-title">ポートフォリオサイト</h3>
              <span class="p-contact-thanks__card-more">詳細を見る</span>
            </a>
          </li>

          <?php 
           $green_img = get_the_post_thumbnail_url(46, 'full');
           $green_title = get_the_title(46);
           $green_url = get_the_permalink(46);
          ?>
          <li class="p-contact-thanks__card">
            <a class="p-contact-thanks__card-link" href="<?php echo esc_url($green_url); ?>">
              <img class="p-contact-thanks__card-thumb" src="<?php echo esc_url($green_img); ?>"
                   alt="<?php echo esc_html($green_title); ?>のサムネイル画像" width="480" height="300" loading="lazy">
              <span class="p-contact-thanks__card-label">WordPress</span>
              <h3 class="p-contact-thanks__card-title"><?php echo esc_html($green_title); ?></h3>
              <span class="p-contact-thanks__card-more">詳細を見る</span>
            </a>
          </li>

          <?php 
           $green_img = get_the_post_thumbnail_url(32, 'full');
           $green_title = get_the_title(32);
           $green_url = get_the_permalink(32);
          ?>
          <li class="p-contact-thanks__card">
            <a class="p-contact-thanks__card-link" href="<?php echo esc_url($green_url); ?>">
              <img class="p-contact-thanks__card-thumb" src="<?php echo esc_url($green_img); ?>"
                   alt="<?php echo esc_html($green_title); ?>のサムネイル画像" width="480" height="300" loading="lazy">
              <span class="p-contact-thanks__card-label">LP</span>
              <h3 class="p-contact-thanks__card-title"><?php echo esc_html($green_title); ?></h3>
              <span class="p-contact-thanks__card-more">詳細を見る</span>
            </a>
          </li>
        </ul>

        <div class="p-contact-thanks__deeper">
          <h3 class="p-contact-thanks__deeper-title">より深く知りたい方へ</h3>
          <ul class="p-contact-thanks__deeper-links">
            <li>
              <a class="p-contact-thanks__link-card" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">
                <span class="p-contact-thanks__link-card-label">ABOUT</span>
                <h4 class="p-contact-thanks__link-card-title">私について</h4>
                <p class="p-contact-thanks__link-card-desc">経歴・スキル・姿勢など、詳しい自己紹介</p>
                <span class="p-contact-thanks__link-card-more">Aboutページへ</span>
              </a>
            </li>
            <li>
              <a class="p-contact-thanks__link-card" href="<?php echo esc_url( home_url( '/about/' ) ); ?>#ai">
                <span class="p-contact-thanks__link-card-label">AI USAGE</span>
                <h4 class="p-contact-thanks__link-card-title">AIへの取り組み</h4>
                <p class="p-contact-thanks__link-card-desc">AIをコーディングや学習にどう活用しているか</p>
                <span class="p-contact-thanks__link-card-more">該当セクションへ</span>
              </a>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </section>

</main>
<?php get_footer(); ?>