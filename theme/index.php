<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<section class="p-fv">
    <!-- 装飾レイヤー: 円弧。c-arc は見た目のみ、配置は p-fv 側で指定 -->
    <div class="c-arc p-fv__arc" aria-hidden="true">
      <div class="p-fv-arc__contents">
        <span class="p-fv__scroll" aria-hidden="true">
          <span class="p-fv__scroll-text">scroll</span>
          <span class="p-fv__scroll-line"></span>
        </span>
      </div>
    </div>

    <div class="l-inner p-fv__inner">
      <!-- 見出し: トップの主題はサイト名(ロゴ=h1)が担うため、ここは h2。
           視覚的には最も大きく最初に置き、人にとっての主役にする。
           FV はセクション番号体系の外に置くため、タグ・巨大ナンバーは持たない -->
      <h2 class="p-fv__title">デザインの意図をくみ取り、<br />丁寧にかたちにします。</h2>

      <!-- サブテキスト -->
      <p class="p-fv__lead">Webコーダーとして正社員を志望しています。<br />HTML/CSS・jQuery・WordPress・GSAPを使ったサイト制作が得意です。</p>

      <!-- scroll 誘導: 「scroll」+ 縦線(ハイライトが流れる)。CSSのみ -->
      <!-- <span class="p-fv__scroll" aria-hidden="true">
        <span class="p-fv__scroll-text">scroll</span>
        <span class="p-fv__scroll-line"></span>
      </span> -->
    </div>
  </section>

  <p>portfolio theme is active.</p>

  <?php wp_footer(); ?>
</body>
</html>