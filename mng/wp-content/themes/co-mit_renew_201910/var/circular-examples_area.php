<?php
  $taxonomy = 'circular_examples_area';
	$terms = get_the_terms($post->ID, $taxonomy);
  $term_id = $terms[0]->term_id;
?>
<div class="feature">
  <div class="feature-head"><img src="/co-mit_renew_201910/img/circulareconomy/icon_point_check.png" alt="">このエリアの特徴</div>

  <p class="feature-title">■エリアの特徴</p>
  <p><?php echo get_field('feature1',$taxonomy.'_'.$term_id); ?></p>

  <p class="feature-title">■このエリアで学べる事、得られること</p>
  <p><?php echo get_field('feature2',$taxonomy.'_'.$term_id); ?></p>

  <p class="feature-title">■こんな方におすすめ</p>
  <p><?php echo get_field('feature3',$taxonomy.'_'.$term_id); ?></p>
</div>