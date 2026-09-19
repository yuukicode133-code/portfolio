<?php
/**
 * Template part: pagination.php
 * ページネーション表示用テンプレートパーツ
 */

// 現在のページ番号を取得
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// 総ページ数を取得
global $wp_query;
$max_page = $wp_query->max_num_pages;

$settings = array(
    'range' => 1,                       // 現在ページの前後に表示するページ数
    'show_first_last' => true,          // 最初/最後へのボタンを表示するか
    'first_last_threshold' => 3,       // 何ページ以上で最初/最後ボタンを表示するか
    'show_dots' => true,                // 省略記号（…）を表示するか
    'prev_text' => '&lt;',              // 前ページのテキスト
    'next_text' => '&gt;',              // 次ページのテキスト
    'first_text' => '<<',          // 最初ページのテキスト
    'last_text' => '>>',           // 最後ページのテキスト
    'dots_text' => '…',                 // 省略記号のテキスト
    'container_class' => 'p-works__pagination',        // コンテナのクラス
    'list_class' => 'p-works__pagination-list',       // リストのクラス
    'item_class' => 'p-works__page',                // アイテムのクラス
    'current_class' => 'is-current',                  // 現在ページのクラス
    'dots_class' => 'dots',                       // 省略記号のクラス
    'first_class' => 'page-first',                // 最初ページのクラス
    'last_class' => 'page-last',                  // 最後ページのクラス
    'prev_class' => '',  // 前ページのクラス
    'next_class' => '', // 次ページのクラス
    'show_single_page' => true,                   // 1ページのみの場合も表示するか
    'end_size' => 1,                              // 最初と最後に表示するページ数
);

// 1ページのみの場合の処理
if ($max_page <= 1) {
    if ($settings['show_single_page']) {
        ?>
        <div class="<?php echo esc_attr($settings['container_class']); ?>">
            <div class="<?php echo esc_attr($settings['list_class']); ?>">
                <span class="<?php echo esc_attr($settings['item_class'] . ' ' . $settings['current_class']); ?>">1</span>
            </div>
        </div>
        <?php
    }
    return;
}

// 2ページ以上の場合の処理
?>
<div class="<?php echo esc_attr($settings['container_class']); ?>">
    <div class="<?php echo esc_attr($settings['list_class']); ?>">
        <?php
        // 最初へボタン（条件付き表示）
        if ($settings['show_first_last'] && $max_page > $settings['first_last_threshold'] && $paged > 1) {
            echo '<a href="' . get_pagenum_link(1) . '" class="' . esc_attr($settings['item_class'] . ' ' . $settings['first_class']) . '" title="最初のページへ"><span>' . $settings['first_text'] . '</span></a>';
        }

        // 前のページリンク
        if ($paged > 1) {
            echo '<a href="' . get_pagenum_link($paged - 1) . '" class="' . esc_attr($settings['item_class'] . ' ' . $settings['prev_class']) . '" title="前のページへ"><span>' . $settings['prev_text'] . '</span></a>';
        }

        // ページ番号表示ロジック
        $start_page = max(1, $paged - $settings['range']);
        $end_page = min($max_page, $paged + $settings['range']);

        // 最初のページを表示（範囲外の場合）
        if ($start_page > $settings['end_size']) {
            for ($i = 1; $i <= $settings['end_size']; $i++) {
                echo '<a href="' . get_pagenum_link($i) . '" class="' . esc_attr($settings['item_class']) . '">' . $i . '</a>';
            }
            if ($settings['show_dots'] && $start_page > $settings['end_size'] + 1) {
                echo '<span class="' . esc_attr($settings['item_class'] . ' ' . $settings['dots_class']) . '">' . $settings['dots_text'] . '</span>';
            }
        }

        // 現在のページ周辺を表示
        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $paged) {
                echo '<span class="' . esc_attr($settings['item_class'] . ' ' . $settings['current_class']) . '">' . $i . '</span>';
            } else {
                echo '<a href="' . get_pagenum_link($i) . '" class="' . esc_attr($settings['item_class']) . '">' . $i . '</a>';
            }
        }

        // 最後のページを表示（範囲外の場合）
        if ($end_page < $max_page - $settings['end_size'] + 1) {
            if ($settings['show_dots'] && $end_page < $max_page - $settings['end_size']) {
                echo '<span class="' . esc_attr($settings['item_class'] . ' ' . $settings['dots_class']) . '">' . $settings['dots_text'] . '</span>';
            }
            for ($i = $max_page - $settings['end_size'] + 1; $i <= $max_page; $i++) {
                echo '<a href="' . get_pagenum_link($i) . '" class="' . esc_attr($settings['item_class']) . '">' . $i . '</a>';
            }
        }

        // 次のページリンク
        if ($paged < $max_page) {
            echo '<a href="' . get_pagenum_link($paged + 1) . '" class="' . esc_attr($settings['item_class'] . ' ' . $settings['next_class']) . '" title="次のページへ"><span>' . $settings['next_text'] . '</span></a>';
        }

        // 最後へボタン（条件付き表示）
        if ($settings['show_first_last'] && $max_page > $settings['first_last_threshold'] && $paged < $max_page) {
            echo '<a href="' . get_pagenum_link($max_page) . '" class="' . esc_attr($settings['item_class'] . ' ' . $settings['last_class']) . '" title="最後のページへ"><span>' . $settings['last_text'] . '</span></a>';
        }
        ?>
    </div>
</div>