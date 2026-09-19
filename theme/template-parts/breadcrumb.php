<?php if (function_exists('bcn_display')) : ?>
  <!-- breadcrumb -->
  <div class="c-breadcrumb" aria-label="パンくずリスト">
    <div class="l-inner">
    <ol class="c-breadcrumb__list">
      <?php bcn_display(); ?>
    </ol>
    </div>
  </div>
<?php endif; ?>