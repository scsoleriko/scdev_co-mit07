<?php /*
  <?php
    if ( is_singular('facility') ){
      $tags = get_the_terms($post->ID, "feature");
      $tag_count_ = 0;
      foreach ($tags as $tag) {
        $terms_slug[] = $tag -> slug;
        $tag_count_++;
      }
      $query_array = array(
        "post_type" => "facility",
        "post_status" => "publish",
        'tax_query' => array(
          array(
            'taxonomy' => 'feature',
            'field'    => 'slug',
            'terms'    => $terms_slug,
          )
        ),
        'orderby' => 'rand',
        "posts_per_page" => 9999
      );
    }else{
      $query_array = array(
        "post_type" => "facility",
        "post_status" => "publish",
        "post_parent" => 0,
        "orderby" => "rand",
        "posts_per_page" => 9999
      );
    }
    $the_query = new WP_Query( $query_array );
    if ( $the_query->have_posts() ) {
  ?>

      <article class="article">
        <h2 class="heading-1">良く見られている施設</h2>
        <div class="swiper-container-2__wrap">
          <divid="recommend-facility"  class="swiper-container-2 swiper-container--facility_post">
            <div class="swiper-wrapper">
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
              <section class="swiper-slide facility-list-3">
                  <a href="<?php the_permalink(); ?>"></a>
                  <div class="facility-list-3__sub">
                    <?php
                      $attachment_id = get_field('facility_listimage');
                    ?>
                    <div class="facility-list-3__image">
                      <img src="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" alt="">
                    </div>
                    <?php if( get_field('facility_360url') ): ?><p class="facility-list-3__360"><img src="/co-mit_renew_201910/img/icon_360.png" alt=""></p><?php endif; ?>
                    <ul class="facility-list-3__tag">
                      <?php
                      if ( !is_singular('facility') ){
                        $tags = get_the_terms($post->ID, "feature");
                      }
                      $tag_count_ = 0;
                      if ($tags != null && is_array($tags)) {
                      foreach ($tags as $tag) {
                        echo "<li>".$tag -> name."</li>";
                        if ($tag_count_ == 2) { break; }
                        $tag_count_++;
                      }
                      }else{
                        echo "<li>".$tags -> name."</li>";
                      }
                      ?>
                    </ul>
                  </div>
                  <div class="facility-list-3__main">
                    <div class="facility-list-3__info">
                      <span class="facility-list-3__area"><?php the_field('facility_area'); ?></span>
                    </div>
                    <h3 class="facility-list-3__name"><?php the_title() ?></h3>
                    <p class="facility-list-3__text"><?php echo nl2br(get_field('facility_pr_short')); ?></p>
                  </div>
              </section>
            <?php endwhile; ?>
            </div>
          </div>
          <div class="swiper-button-prev-column recommend-facility-prev"></div>
          <div class="swiper-button-next-column recommend-facility-next"></div>
        </div>
      </article>
    <?php } wp_reset_postdata(); ?>

*/ ?>



<article class="article">
	<h2 class="heading-1">この施設を見ている人はこの施設も見ています</h2>
	<div class="swiper-container-2__wrap" id="facility">
		<div id="recommend-facility" class="swiper-container-2 swiper-container--facility_post">
			<div class="swiper-wrapper">

			<?php
				$parent_id = $post->post_parent;
				if ( isset($parent_id) ){
					$id = get_post_field( 'post_name', $parent_id );
				} else {
					$id = get_post( get_the_ID() )->post_name;
				}
				$xml_url = 'https://r6.snva.jp/api/recommend/rule/?k=O1Dq8VN3M8QBH&tmpl=1&lang_type=xml&output_type=2&format_type=2&id[]=' . $id;
				$xml = simplexml_load_file($xml_url);
				foreach($xml->items->item as $item){
				echo '<section class="swiper-slide facility-list-3">', PHP_EOL;
				 echo '<a href="' . str_replace("https://co-mit.jp", "", $item->url) . '" onclick="apiSetCtr(\'' . $item->item_code . '\', \'1\', this, \'O1Dq8VN3M8QBH\');return false;"></a>', PHP_EOL;
				 echo '<div class="facility-list-3__sub">', PHP_EOL;
				  echo '<div class="facility-list-3__image">';
				  if (empty($item->img_url)){
					echo '<img src="/img/naviplus_noimage.jpg" alt="' . $item->name . '">' . '</div>', PHP_EOL;
				  } else {
					echo '<img src="' . $item->img_url . '" alt="' . $item->name . '">' . '</div>', PHP_EOL;
				  }
				  $tags = explode(":", $item->category);
				  $search = '#360°パノラマビュー';
				  $key = in_array($search, $tags);
				  if ($key){
					echo '<p class="facility-list-3__360"><img src="/co-mit_renew_201910/img/icon_360.png" alt="360°パノラマビュー"></p>';
				  }
				  echo '<ul class="facility-list-3__tag">', PHP_EOL;
				  $i = 0;
				  foreach($tags as $tag){
				 	  if($i >= 3){
						  break;
					  }
					  if(strpos( $tag, "#" ) === 0){
						  echo '<li>' . $tag . '</li>', PHP_EOL;
						  $i++;
					  }
				  }
				  echo '</ul>', PHP_EOL;
				 echo '</div>', PHP_EOL;
				 echo '<div class="facility-list-3__main">', PHP_EOL;
				  echo '<div class="facility-list-3__info">' . '<span class="facility-list-3__area">' . $item->area . '</span>' . '</div>', PHP_EOL;
				  echo '<h3 class="facility-list-3__name">' . $item->name . '</h3>', PHP_EOL;
				  echo '<p class="facility-list-3__text">' . $item->comment . '</p>', PHP_EOL;
				 echo '</div>', PHP_EOL;
				echo '</section>', PHP_EOL;
				}
			?>

			</div>
		</div>
          <div class="swiper-button-prev-column recommend-facility-prev"></div>
          <div class="swiper-button-next-column recommend-facility-next"></div>
        </div>
</article>
