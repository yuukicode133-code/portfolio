<?php

/**
 * Vite でビルドしたアセットを読み込む
 * - 開発時（npm run dev 実行中）: Vite開発サーバーから直接読む（HMR有効）
 * - 本番時（dev停止中）: build/ のビルド済みファイルを manifest 経由で読む
 */

// Vite開発サーバーのアドレス
define('VITE_SERVER', 'http://localhost:5173');

// 開発中かどうかを判定する（Viteサーバーが出す hot ファイルの有無で見る）
function portfolio_is_vite_dev() {
  return file_exists(get_theme_file_path('build/.vite/hot'));
}

function portfolio_enqueue_assets() {

  if (portfolio_is_vite_dev()) {
// ===== 開発モード：Viteサーバーから直接読む =====

// Viteのクライアント（HMRを効かせる本体）
    wp_enqueue_script('vite-client', VITE_SERVER . '/@vite/client', [], null, false);

// ソースを直接読む（変換前の main.js / style.scss）
    wp_enqueue_script('portfolio-main', VITE_SERVER . '/js/main.js', [], null, true);
    wp_enqueue_style('portfolio-style', VITE_SERVER . '/scss/style.scss', [], null);

  } else {
// ===== 本番モード：ビルド結果を manifest 経由で読む =====

    $manifest_path = get_theme_file_path('build/.vite/manifest.json');
    $manifest = json_decode(file_get_contents($manifest_path), true);

// CSS（style.scss 由来）
    $style_file = $manifest['scss/style.scss']['file'];
    wp_enqueue_style(
      'portfolio-style',
      get_theme_file_uri('build/' . $style_file)
    );

// JS（main.js 由来）
    $main_file = $manifest['js/main.js']['file'];
    wp_enqueue_script(
      'portfolio-main',
      get_theme_file_uri('build/' . $main_file),
      [],
      null,
      true
    );

// main.js にぶら下がる CSS（@fontsource のフォント）も読む
    if (!empty($manifest['js/main.js']['css'])) {
      foreach ($manifest['js/main.js']['css'] as $i => $css_file) {
        wp_enqueue_style(
          'portfolio-main-css-' . $i,
          get_theme_file_uri('build/' . $css_file)
        );
      }
    }
  }
}
add_action('wp_enqueue_scripts', 'portfolio_enqueue_assets');

//------------------------------------------------------------------------
/**
 * 開発モードのとき、<script> に type="module" を付ける
 * （Viteのソースは ES Module なので module 指定が必須）
 */
function portfolio_module_type($tag, $handle) {
  if (!portfolio_is_vite_dev()) {
    return $tag;
  }
  if (in_array($handle, ['vite-client', 'portfolio-main'], true)) {
    $tag = str_replace('<script ', '<script type="module" ', $tag);
  }
  return $tag;
}
add_filter('script_loader_tag', 'portfolio_module_type', 10, 2);



//------------------------------------------------------------------------

function my_setup() {
  add_theme_support('post-thumbnails');
  add_theme_support('automatic-feed-links');
  add_theme_support('title-tag');
  add_post_type_support( 'page', 'excerpt' );
  add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ));
}
add_action("after_setup_theme", "my_setup");

//------------------------------------------------------------------------
/**
 * Contact Form 7 の調整
 */

// フォーム編集画面の HTML に wpautop（自動 <p> / <br> 挿入）をかけない
add_filter('wpcf7_autop_or_not', '__return_false');


// ショートコードを有効にする
add_filter('wpcf7_form_elements', 'do_shortcode');

// CF7 のフォームタグでは書けない属性を、出力 HTML に後付けする
function portfolio_cf7_add_aria($html) {
  $html = str_replace(
    'id="contact-email"',
    'id="contact-email" aria-describedby="contact-email-hint"',
    $html
  );
  return $html;
}
add_filter('wpcf7_form_elements', 'portfolio_cf7_add_aria');

// プライバシーポリシーのショートコード
add_action('init',function(){
  add_shortcode('my_privacy_policy',function(){
    return esc_url( home_url( '/privacy/' ) );
  });
});

// 実績一覧(/works/)とカテゴリーアーカイブを公開日の古い順にする
add_action('pre_get_posts', function ($query) {
  // 管理画面とサブクエリには影響させない
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  if ($query->is_home() || $query->is_category()) {
    $query->set('orderby', 'date');
    $query->set('order', 'ASC');
  }
});
// SEO関連の設定 ---------------------------------------------------------------
// カスタムタイトルの設定
add_filter('document_title_parts', 'custom_document_title_parts');
function custom_document_title_parts($title)
{

    // フロントページの場合
    if (is_front_page() && !is_home()) {
        $title['title'] = get_bloginfo('name');
        $title['tagline'] = get_bloginfo('description');
        unset($title['site']); // サイト名の重複を防ぐ

        // 投稿一覧ページ（home.php）の場合
    } elseif (is_home() && !is_front_page()) {
        $posts_page_id = get_option('page_for_posts');
        if ($posts_page_id) {
            $title['title'] = get_the_title($posts_page_id);
            $title['site'] = get_bloginfo('name');
        }
        
        // 個別投稿・固定ページの場合
    } elseif (is_single() || is_page()) {
        $title['title'] = get_the_title();
        $title['site'] = get_bloginfo('name');

        // カテゴリーページの場合
    } elseif (is_category()) {
        $title['title'] = single_cat_title('', false) . 'の記事一覧';
        $title['site'] = get_bloginfo('name');

        // それ以外（404ページ、検索結果、タグページなど）
    } else {
        // デフォルトのタイトルをそのまま使用
        if (!isset($title['site'])) {
            $title['site'] = get_bloginfo('name');
        }
    }

    return $title;
}

// フォーム送信後のページをnoindexにする　→ metaタグをスッキリさせるため
add_filter('wp_robots', function ($robots) {
  if (is_page(array('confirm', 'thanks')) || is_404()) {
    $robots['noindex'] = true;
  }
  return $robots;
});

//ogp --------------------------------------------
/**
 * ページ種別ごとのSEO/OGPデータを取得
 */
function mytheme_get_seo_meta_data()
{
    global $wp;

    $default_image = get_template_directory_uri() . '/img/portfolio.webp';
    $site_desc     = get_bloginfo('description');
    $data          = array();

    if (is_front_page()) {
        $front_id = get_option('page_on_front');

        $meta_desc = get_field('meta_description', $front_id);
        $data['meta_description'] = wp_trim_words($meta_desc ?: $site_desc, 120, '...');

        $data['ogp_title'] = get_field('og_title', $front_id) ?: get_bloginfo('name');

        $ogp_desc = get_field('ogp_description', $front_id);
        $data['ogp_description'] = wp_trim_words($ogp_desc ?: $site_desc, 120, '...');

        $data['ogp_image'] = get_field('ogp_image', $front_id) ?: $default_image;
        $data['ogp_type']  = 'website';
        $data['ogp_url']   = home_url('/');
    } elseif (is_single() || is_page()) {
        $excerpt  = get_the_excerpt();
        $fallback = '"' . get_the_title() . '"の記事です';

        $meta_desc = get_field('meta_description');
        $data['meta_description'] = $meta_desc || $excerpt
            ? wp_trim_words($meta_desc ?: $excerpt, 120, '...')
            : $fallback;

        $data['ogp_title'] = get_field('ogp_title') ?: get_the_title();

        $ogp_desc = get_field('ogp_description');
        $data['ogp_description'] = $ogp_desc || $excerpt
            ? wp_trim_words($ogp_desc ?: $excerpt, 120, '...')
            : $fallback;

        $data['ogp_image'] = get_field('ogp_image') ?: (has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : $default_image);
        $data['ogp_type']  = 'article';
        $data['ogp_url']   = get_permalink();
    } elseif (is_home()) {
        $posts_id = get_option('page_for_posts');

        $meta_desc = get_field('meta_description', $posts_id);
        $data['meta_description'] = wp_trim_words($meta_desc ?: $site_desc, 120, '...');

        $data['ogp_title'] = get_field('ogp_title', $posts_id) ?: get_bloginfo('name');

        $ogp_desc = get_field('ogp_description', $posts_id);
        $data['ogp_description'] = wp_trim_words($ogp_desc ?: $site_desc, 120, '...');

        $data['ogp_image'] = get_field('ogp_image', $posts_id) ?: $default_image;
        $data['ogp_type']  = 'website';
        $data['ogp_url']   = get_permalink($posts_id);
    } elseif (is_category()) {
        $cat_desc = category_description() ?: $site_desc;

        $data['meta_description'] = wp_trim_words($cat_desc, 120, '...');
        $data['ogp_title']         = single_cat_title('', false) . ' | ' . get_bloginfo('name');
        $data['ogp_description']   = wp_trim_words($cat_desc, 120, '...');
        $data['ogp_image']         = $default_image;
        $data['ogp_type']          = 'website';
        $data['ogp_url']           = get_category_link(get_queried_object_id());
    } else {
        $data['meta_description'] = wp_trim_words($site_desc, 120, '...');
        $data['ogp_title']         = wp_get_document_title();
        $data['ogp_description']   = wp_trim_words($site_desc, 120, '...');
        $data['ogp_image']         = $default_image;
        $data['ogp_type']          = 'website';
        $data['ogp_url']           = home_url('/' . $wp->request);
    }

    return $data;
}

/**
 * wp_head にSEO/OGPタグを出力
 */
function mytheme_output_seo_meta()
{
    $seo = mytheme_get_seo_meta_data();
    ?>
    <?php if (!empty($seo['meta_description'])) : ?>
        <meta name="description" content="<?php echo esc_attr($seo['meta_description']); ?>" />
    <?php endif; ?>

    <meta property="og:title" content="<?php echo esc_attr($seo['ogp_title']); ?>" />
    <meta property="og:description" content="<?php echo esc_attr($seo['ogp_description']); ?>" />
    <meta property="og:image" content="<?php echo esc_url($seo['ogp_image']); ?>" />
    <meta property="og:url" content="<?php echo esc_url($seo['ogp_url']); ?>" />
    <meta property="og:type" content="<?php echo esc_attr($seo['ogp_type']); ?>" />
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
    <meta property="og:locale" content="ja_JP" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo esc_attr($seo['ogp_title']); ?>" />
    <meta name="twitter:description" content="<?php echo esc_attr($seo['ogp_description']); ?>" />
    <meta name="twitter:image" content="<?php echo esc_url($seo['ogp_image']); ?>" />
    <?php
}
add_action('wp_head', 'mytheme_output_seo_meta', 5);

// 管理画面でのプレビュー表示
function add_ogp_preview_meta_box()
{
    add_meta_box(
        'ogp_preview',
        'SNSシェアプレビュー',
        'render_ogp_preview',
        array('page', 'post'),  // ← 表示したい投稿タイプを列挙
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_ogp_preview_meta_box');

function render_ogp_preview($post)
{
    $default_image = get_template_directory_uri() . '/img/portfolio.webp';
    $post_id       = $post->ID;

    // フロントページはサイト名にフォールバックするので、その挙動に合わせる
    $is_front = ((int) get_option('page_on_front') === (int) $post_id);

    // タイトル
    $title = get_field('ogp_title', $post_id);
    if (!$title) {
        $title = $is_front ? get_bloginfo('name') : get_the_title($post_id);
    }

    // 説明文（og_description → meta_description → 抜粋 の順）
    $desc = get_field('ogp_description', $post_id);
    if (!$desc) {
        $desc = get_field('meta_description', $post_id);
    }
    if (!$desc) {
        $desc = $is_front ? get_bloginfo('description') : get_the_excerpt($post_id);
    }
    $desc = wp_trim_words($desc, 120, '...');

    // 画像
    $image = get_field('ogp_image', $post_id);
    if (!$image) {
        $image = get_the_post_thumbnail_url($post_id, 'large') ?: $default_image;
    }
    ?>
    <div class="ogp-preview" style="border: 1px solid #ddd; padding: 10px;">
        <p><strong>タイトル:</strong><br><?php echo esc_html($title); ?></p>
        <p><strong>説明文:</strong><br><?php echo esc_html($desc); ?></p>
        <?php if ($image) : ?>
            <img src="<?php echo esc_url($image); ?>" style="max-width: 100%; height: auto;" alt="">
        <?php endif; ?>
    </div>
    <?php
}

//------------------------------------------------------------------------
/**
 * 構造化データの出力
 */
require_once get_theme_file_path( '/structured-data/schema-manager.php' );