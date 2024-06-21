
<?php
  $cat = $args['cat'];
  $img = '';

  if( !empty($cat) ) {
    // 親postデータを取得
    $parent_data = get_post($post->post_parent);
    $title = $parent_data->post_title;
    $post_id = $parent_data->ID;
  } else {
    $title = get_the_title();
    $post_id = $post->ID;
  }
  if( $attachment_id = get_field('facility_listimage', $post_id) ){
    $img = wp_get_attachment_image_url($attachment_id,'large');
  } else {
    $img = 'http://placehold.jp/60/00b2b0/ffffff/861x541.png?text=NOW%20PRINTING';
  }
?>
<div id="facility-modal<?php echo $post->ID; ?>" class="facility-modal">
  <div class="facility-main">
    <div class="facility-img">
      <a href="<?php the_permalink(); ?>" target="_blank">
      <img src="<?php echo $img;?>" alt="" width="100%" height="100%">
      </a>
    </div>
    <div class="facility-right">
      <div class="facility-list-1__favorite js-favorite" data-facility-id="<?php echo $post_id; ?>">
				<p class="facility-list-1__favorite__text"><span>クリックで追加</span><span>検討リスト解除</span></p>
			</div>
      <div class="facility-tag">
        <div class="facility-area"><?php the_field('facility_area', $post_id); ?></div>
        <?php $terms = get_the_terms($post_id,'hotel_type'); ?>
        <div class="facility-type"><?php echo $terms[0]->name; ?></div>
      </div>
      <div class="facility-name"><?php echo $title; ?></div>
      <div class="facility-comment">
        <?php echo the_field('facility_pr_deital', $post_id); ?>
      </div>
    </div>
  </div>
  <div class="facility-list-1__sub">
		<dl class="facility-list-1__detail"></dl>
		<dl class="facility-list-1__detail">
      <a href="<?php the_permalink(); ?>" target="_blank" class="button--arrow">施設の詳細を見る</a>
		</dl>
	</div>
  <a class="facility-list-1__favorite-2 js-favorite" data-facility-id="<?php echo $post_id; ?>">
		<p class="facility-list-1__favorite-2__text"><span>検討リストに追加する</span><span>検討リスト解除</span></p>
  </a>
</div>