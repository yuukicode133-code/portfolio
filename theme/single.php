<?php get_header(); ?>

<main class="l-main p-single">
  <?php get_template_part('template-parts/breadcrumb'); ?>

  <!-- ===== ヘッダー(案件名主体。番号・№ は無し)===== -->
  <header class="p-page-header">
    <div class="l-inner">
      <?php if (have_posts()): ?>
        <?php while (have_posts()) : ?>
          <?php the_post(); ?>
          <?php
          $categories = get_the_category();
          if ($categories):
          ?>
            <!-- カテゴリー(ACF: サイトの種類)。動的化時はここに出力 -->
            <p class="p-single__category">
              <?php foreach ($categories as $category) : ?>
                <?php echo esc_html($category->name); ?>
              <?php endforeach; ?>
            <?php endif; ?>
            </p>
            <!-- 案件名(ACF)。page-header の見出しサイズを流用 -->
            <h1 class="p-page-header__title p-single__title"><?php the_title(); ?></h1>
            <!-- 短い概要(ACF: 1〜2行の肩書き的短文)。詳細は下のセクションで語る -->
            <p class="p-page-header__lead"><?php echo esc_html(get_the_excerpt()); ?></p>

            <div class="p-single__actions">
              <!-- サイトを見る=枠線ボタン(c-button--secondary)。外部リンクは別タブ + a11y 明示 -->
              <?php 
              $site_url = get_field('single-url');
              if ($site_url) : ?>
                <a class="c-button c-button--secondary" href="<?php echo esc_url($site_url); ?>" target="_blank" rel="noopener">
                  サイトを見る<span class="u-hidden-visually">(新しいタブで開く)</span>
                </a>
              <?php endif; ?>
              <!-- GitHub=矢印なし → 既存の枠線ボタン(c-button--secondary) -->
              <?php $github_url = get_field('github-url');
              if ($github_url) : ?>
                <a class="c-button c-button--secondary" href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener">
                  GitHub<span class="u-hidden-visually">(新しいタブで開く)</span>
                </a>
              <?php endif; ?>
            </div>
    </div>
  <?php endwhile; ?>
<?php endif; ?>
  </header>

  <!-- ===== メインビジュアル(まず惹きつける=モックアップを大きく先頭に)===== -->
  <section class="p-single__visual" aria-labelledby="visual-title">
    <div class="l-inner">
      <h2 id="visual-title" class="u-hidden-visually">メインビジュアル</h2>

      <!-- PCメイン(ACF: 画像)。大きく1枚 -->
      <div class="p-single__mockup u-fade-up js-fade">
        <?php
        $img_pctop = get_field('img-pctop');
        $mov_pctop = get_field('mov-pctop');

        if ($img_pctop) : ?>
          <img src="<?php echo esc_url($img_pctop); ?>"
            alt="<?php the_title(); ?>のPC表示のトップページ"
            width="1600" height="1000">
        <?php elseif ($mov_pctop) : ?>
          <video src="<?php echo esc_url($mov_pctop); ?>"
            width="1600" height="1000"
            autoplay muted loop playsinline
            aria-label="<?php the_title(); ?>のPC表示のトップページ"></video>
        <?php endif; ?>
      </div>

      <!-- PC別画面 + SP(ACF: 画像 ×2)。2カラム -->
      <div class="p-single__mockup-sub">
        <div class="p-single__mockup-item u-fade-up js-fade">
          <?php
          $img_pcpage = get_field('img-pcpage');
          $mov_pcpage = get_field('mov-pcpage');

          if ($img_pcpage) : ?>
            <img src="<?php echo esc_url($img_pcpage); ?>"
              alt="<?php the_title(); ?>のPC表示の下層ページ"
              width="800" height="600">
          <?php elseif ($mov_pcpage) : ?>
            <video src="<?php echo esc_url($mov_pcpage); ?>"
              width="800" height="600"
              autoplay muted loop playsinline
              aria-label="<?php the_title(); ?>のPC表示の下層ページ"></video>
          <?php endif; ?>
        </div>
        <div class="p-single__mockup-item u-fade-up js-fade">
          <?php
          $img_sp = get_field('img-sp');
          $mov_sp = get_field('mov-sp');

          if ($img_sp) : ?>
            <img src="<?php echo esc_url($img_sp); ?>"
              alt="<?php the_title(); ?>のスマートフォン表示"
              width="600" height="900">
          <?php elseif ($mov_sp) : ?>
            <video src="<?php echo esc_url($mov_sp); ?>"
              width="600" height="900"
              autoplay muted loop playsinline
              aria-label="<?php the_title(); ?>のスマートフォン表示"></video>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== プロジェクトについて(概要=物語 + メタ=事実 を1セクションに統合)===== -->
  <section class="l-section" aria-labelledby="about-project-title">
    <div class="l-inner">
      <div class="p-single__head u-fade-up js-fade">
        <h2 class="c-section-title">
          <span class="c-section-title__en">About this project</span>
          <span id="about-project-title" class="c-section-title__ja">プロジェクトについて</span>
        </h2>
      </div>

      <!-- 詳細概要(ACF: 4〜6行)。目的・ターゲット・コンセプト・意図など -->
      <!-- <p class="p-single__overview u-fade-up js-fade">
        詳細な概要文(4〜6行)。サイトの目的、ターゲット、コンセプト、なぜこのデザインにしたのか、何を意識して作ったのかなど、プロジェクトの背景情報をここに記載します。
      </p> -->

      <!-- メタ情報(dl:項目↔値)。各値は ACF の固定フィールドから出力 -->
      <dl class="p-single__meta u-fade-up js-fade">
        <div class="p-single__meta-row">
          <dt class="p-single__meta-term">Client</dt>
          <dd class="p-single__meta-desc"><?php echo esc_html(get_field('client')); ?></dd>
        </div>
        <div class="p-single__meta-row">
          <dt class="p-single__meta-term">Scope</dt>
          <dd class="p-single__meta-desc"><?php echo esc_html(get_field('scope')); ?></dd>
        </div>
        <div class="p-single__meta-row">
          <dt class="p-single__meta-term">Stack</dt>
          <dd class="p-single__meta-desc">
            <?php $stack = get_the_tags(); ?>
            <!-- 使用技術タグ(ACF: 繰り返し = タグ)。About STACK と見た目を揃える -->
            <ul class="p-single__stack">
              <?php foreach ($stack as $item) : ?>
                <li class="p-single__stack-tag"><?php echo esc_html($item->name); ?></li>
              <?php endforeach; ?>
            </ul>
          </dd>
        </div>
        <div class="p-single__meta-row">
          <dt class="p-single__meta-term">Term</dt>
          <dd class="p-single__meta-desc"><?php echo esc_html(get_field('term'))?></dd>
        </div>
      </dl>
    </div>
  </section>

  <!-- ===== こだわりポイント(ACF: 画像+説明文の繰り返し。中身は c-point)===== -->
  <section class="l-section--sm" aria-labelledby="details-title">
    <div class="l-inner">
      <div class="p-single__head u-fade-up js-fade">
        <h2 class="c-section-title">
          <span class="c-section-title__en">Details</span>
          <span id="details-title" class="c-section-title__ja">こだわりポイント / 学んだポイント</span>
        </h2>
      </div>

      <!--
        ここが ACF 繰り返しフィールド。<li class="c-point"> の1つ = 1ペア。
        番号(01/02…)は装飾なので aria-hidden。順序の意味は <ol> が持つ。
        番号は左右交互(--right)で c-point のジグザグと呼吸を合わせる。
        画像の alt: 隣の見出し+本文が内容を担うので既定は空(装飾扱い)。
                    説明が要る図なら ACF の alt を出力して内容 alt にしてよい。
      -->
      <ol class="p-single__point-list">
        <?php get_template_part('template-parts/point'); ?>
      </ol>
    </div>
  </section>

  <!-- ===== ページ内ナビ(single専用・project層。中身は矢印リンク)===== -->
  <nav class="p-single__pager" aria-label="実績ナビゲーション">
    <div class="l-inner p-single__pager-wrapper">
      <div class="p-single__pager-grid">
        <!-- 前後は WP の previous/next_post_link に対応する枠 -->
        <?php $previous_post = get_previous_post(); ?>
        <?php if ($previous_post) : ?>
        <a class="c-arrow-link c-arrow-link--prev p-single__pager-prev" href="<?php echo get_permalink($previous_post->ID); ?>">前の実績へ</a>
        <?php endif; ?>
        <a class="c-arrow-link c-arrow-link--up p-single__pager-index" href="<?php echo esc_url( home_url( '/works/' ) ); ?>">実績一覧へ戻る</a>

        <?php $next_post = get_next_post(); ?>
        <?php if ($next_post) : ?>
        <a class="c-arrow-link c-arrow-link--next p-single__pager-next" href="<?php echo get_permalink($next_post->ID); ?>">次の実績へ</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

</main>

<?php get_footer(); ?>