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
 * メニューの登録
 */
function my_menu_init()
{
    register_nav_menus(
        array(
            'global' => 'ヘッダーメニュー',
            'footer' => 'フッターメニュー'
        )
    );
}
add_action('init', 'my_menu_init');