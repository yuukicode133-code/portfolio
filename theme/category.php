<!-- ============================================================= 
     /works/  実績一覧ページ  ―― <main> リージョン
     - header / footer は既存 partial を利用(全ページ共通)
     - 装飾数字・円弧は無し(Phase 7 で全体判断)
     - 幅は既存の .l-inner(コンテンツ幅ラッパ)を想定
     - WP 化の写し先を < WP: ... >でメモ
     ============================================================= -->

     <?php get_header(); ?>
<main class="l-main">
  <?php get_template_part('template-parts/breadcrumb'); ?>

  <!-- ページヘッダー(Project層・下層共通・装飾なし) -->
  <div class="p-page-header">
    <div class="l-inner">
      <h1 class="p-page-header__title">制作実績一覧</h1>
      <p class="p-page-header__lead">
        これまでに手がけたコーポレートサイト・LP・WordPress サイトなどの制作実績です。
        使用技術やアクセシビリティ面での工夫と合わせてご覧いただけます。
      </p>
    </div>
  </div>

  <!-- Works 本体(Project完結・works専用) -->
  <section class="p-works">
    <div class="l-inner">

      <!-- カテゴリー(WP カテゴリーアーカイブへのリンク。JS フィルタではない) -->
      <!-- WP: get_categories() でループ生成。現在アーカイブは is_category() 判定で span 化 -->
      <?php
      // 現在表示しているカテゴリーを取
      $current_category = null;
      $current_category_slug = '';

      if (is_category()) {
        $current_category = get_queried_object();
        $current_category_slug = $current_category->slug;
      } elseif (is_home()) {
        $current_category_slug = 'all';
      }
      ?>
      <nav class="p-works__categories" aria-label="カテゴリーで絞り込み">

        <ul class="p-works__category-list">
          <?php 
          $home_count=wp_count_posts();
          $home_num=$home_count->publish;
 
          ?>
          <li class="p-works__category-item">
            <!-- 現在地(/works/)はリンクにしない -->
            <a class="p-works__category <?php echo ($current_category_slug === 'all' || !$current_category_slug) ? 'is-current' : ''; ?>" 
               aria-current="<?php echo ($current_category_slug === 'all' || !$current_category_slug) ? 'page' : 'false'; ?>"
               href="<?php echo esc_url( home_url( '/works/' ) ); ?>" 
               aria-label="すべてのカテゴリーを表示"
            >
              すべて<span class="p-works__category-count"><?php echo $home_num; ?>件</span>
            </a>
          </li>

          <?php
             $nav_categories = get_categories();
             foreach ($nav_categories as $nav_category) :
            $is_current = ($current_category_slug === $nav_category->slug);
          ?>
          <li class="p-works__category-item">
            <a class="p-works__category" href="<?php echo get_category_link($nav_category->term_id); ?>"
               aria-current="<?php echo $is_current ? 'page' : 'false'; ?>"
               aria-label="<?php echo esc_attr($nav_category->name); ?>カテゴリーの記事を表示">
              <?php echo $nav_category->name; ?><span class="p-works__category-count"><?php echo $nav_category->count; ?>件</span>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <!-- 実績グリッド -->
      <ul class="p-works__grid">

        <!-- WP: while ( have_posts() ) : the_post(); ここから 1 カード -->
        <?php if(have_posts()): ?>
         <?php while(have_posts()):?>
          <?php the_post(); ?>
        <li class="p-works__item u-fade-up js-fade">
          <article class="p-works__card">
            <div class="p-works__thumb">
              <!-- WP: the_post_thumbnail('works-thumb', ['class'=>'p-works__img','alt'=>'']) -->
              <!-- <img class="p-works__img" src="/assets/img/works/cafe-01.jpg" alt=""
                width="800" height="600" loading="lazy" decoding="async"> -->
              <?php the_post_thumbnail('works-thumb', ['class'=>'p-works__img','alt'=>'']); ?>
            </div>
            <div class="p-works__body">
              <!-- WP: 主カテゴリー名。category → サイト種別 -->
              <?php
                  $categories = get_the_category();
                  if ($categories):
              ?>
              <?php foreach($categories as $category): ?>
              <p class="p-works__category-label"><?php echo $category->name; ?></p>
              <?php endforeach; ?>
              <?php endif; ?>
              <h2 class="p-works__title">
                <a class="p-works__link" 
                   href="<?php the_permalink(); ?>"
                   aria-label="<?php echo esc_attr(get_the_title()); ?>の記事を読む"
                >
                   <?php the_title(); ?>
                </a>
              </h2>
              <!-- WP: get_the_tags() でループ。tag → 使用技術。c-tag を流用 -->
              <ul class="p-works__tags">
                <?php
                  $tags = get_the_tags();
                  if ($tags):
                ?>
                <?php foreach($tags as $tag): ?>
                <li><span class="c-skill"><?php echo $tag->name; ?></span></li>
                <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </div>
          </article>
        </li>
        <?php endwhile; ?>
        <?php else: ?>
        <p role="status">実績がありません。</p>
        <?php endif; ?>

      </ul>

      <!-- ページ送り(1ページでも "1" を表示) -->
      <!-- WP: paginate_links(['type'=>'list','prev_next'=>true]) の出力に置換 -->
       <?php get_template_part('template-parts/pagenation'); ?>

    </div>
  </section>
</main>
<?php get_footer(); ?>