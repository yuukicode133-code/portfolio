<?php
$words = ['one', 'two', 'three'];

foreach ($words as $i => $w) :
  $point = get_field("point-{$w}");
  if (!$point) continue;

  $num   = $i + 1;
  $img   = $point["point-{$w}-img"];
  $mov   = $point["point-{$w}-mov"];
  $text  = $point["point-{$w}-text"];
  $title = $text["point-{$w}-title"];
  $main  = $text["point-{$w}-main"];

  $label = get_the_title() . 'のこだわりポイント' . $num;
  $mod   = ($i % 2 === 0) ? ' c-point__num--right' : '';
?>
  <li class="c-point u-fade-up js-fade">
    <?php if($img || $mov || $title || $main) : ?>
    <span class="c-point__num<?php echo $mod; ?>" aria-hidden="true"></span>
    <?php endif; ?>
    <div class="c-point__figure">
      <?php if ($img) : ?>
        <img class="c-point__img" src="<?php echo esc_url($img); ?>"
             alt="<?php echo esc_attr($label); ?>" width="800" height="500">
      <?php elseif ($mov) : ?>
        <video class="c-point__img" src="<?php echo esc_url($mov); ?>"
               width="800" height="500"
               autoplay muted loop playsinline
               aria-label="<?php echo esc_attr($label); ?>"></video>
      <?php endif; ?>
    </div>
    <div class="c-point__body">
      <h3 class="c-point__title"><?php echo esc_html($title); ?></h3>
      <p class="c-point__desc"><?php echo nl2br(esc_html($main)); ?></p>
    </div>
  </li>
<?php endforeach; ?>