<?php get_header(); ?>
<main class="l-main">

  <section class="p-404 l-section">
    <div class="l-inner">
      <div class="p-404__wrapper">
        <h1 class="p-404__title">404<span class="p-404__title-accent">page not found</span></h1>
        <p class="p-404__lead">お探しのページは見つかりませんでした。</p>

        <div class="p-404__content">
          <p class="p-404__content-lead">ページが移動または削除されたか、URLが変更された可能性があります。<br>お手数ですが、下記のリンクからお探しください。</p>
          <ul class="p-404__content-list">
            <li class="p-404__content-item">
              <a href="<?php echo home_url('/'); ?>" class="p-404__link c-arrow-link c-arrow-link--next">トップページへ戻る</a>
            </li>
            <li class="p-404__content-item">
              <a href="<?php echo home_url('/'); ?>" class="p-404__link c-arrow-link c-arrow-link--next">制作実績一覧を見る</a>
            </li>
            <li class="p-404__content-item">
              <a href="<?php echo home_url('/'); ?>" class="p-404__link c-arrow-link c-arrow-link--next">お問い合わせフォームへ</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  </main>
  <?php get_footer(); ?>