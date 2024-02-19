<?php /*
          <?php
              $query_array = array(
                "post_type" => "column",
                "post_status" => "publish",
                'orderby' => 'rand',
                'tax_query' => array( 
                  array( 
                    'taxonomy' => 'category_column', 
                    'field'    => 'slug', 
                    'terms'    => 'labor_content',
                  ) 
                )
              );
            $the_query = new WP_Query( $query_array );
            if ( $the_query->have_posts() ) {
          ?>

      <article class="article">
        <h2 class="heading-1">PICK UP 人事、総務、研修担当者必見のコンテンツ</h2>
        <div class="swiper-container-2__wrap">
          <div class="swiper-container-2 swiper-container--facility_post">
            <div class="swiper-wrapper">
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
              <section class="swiper-slide facility-list-3">
                  <a href="<?php the_permalink(); ?>"></a>
                  <div class="facility-list-3__sub">
                    <div class="facility-list-3__image">
                      <?php if(has_post_thumbnail()): ?>
                      <?php the_post_thumbnail(); ?>
                      <?php else: ?>
                        <img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="facility-list-3__main">
                    <h3 class="post-list-top-1__title-2"><?php the_title() ?></h3>
                  </div>
              </section>
            <?php endwhile; ?>
            </div>
          </div>
          <div class="swiper-button-prev-column recommend-jinji-prev"></div>
          <div class="swiper-button-next-column recommend-jinji-next"></div>
        </div>
      </article>
    <?php } wp_reset_postdata(); ?>
*/ ?>



<article class="article">
	<h2 class="heading-1">PICK UP 人事、総務、研修担当者必見のコンテンツ</h2>
	<div class="swiper-container-2__wrap">
		<div id="recommend-jinji" class="swiper-container-2 swiper-container--facility_post">
			<div class="swiper-wrapper">

			<?php
				/*$parent_id = $post->post_parent;
				if ( isset($parent_id) ){
					$id = get_post_field( 'post_name', $parent_id );
				} else {
					$id = get_post( get_the_ID() )->post_name;
				}*/
				$xml_url = 'https://r6.snva.jp/api/recommend/rule/?k=45MRqaLbm9B2t&tmpl=1&lang_type=xml&output_type=2&format_type=2';
				$xml = simplexml_load_file($xml_url);
				foreach($xml->items->item as $item){
				echo '<section class="swiper-slide facility-list-3">', PHP_EOL;
				 echo '<a href="' . str_replace("https://co-mit.jp", "", $item->url) . '" onclick="apiSetCtr(\'' . $item->item_code . '\', \'1\', this, \'45MRqaLbm9B2t\');return false;"></a>', PHP_EOL;
				 echo '<div class="facility-list-3__sub">', PHP_EOL;
				  echo '<div class="facility-list-3__image">';
				  if (empty($item->img_url)){
					echo '<img src="/img/naviplus_noimage.jpg" alt="' . $item->name . '">' . '</div>', PHP_EOL;
				  } else {
					echo '<img src="' . $item->img_url . '" alt="' . $item->name . '">' . '</div>', PHP_EOL;
				  }
				 echo '</div>', PHP_EOL;
				 echo '<div class="facility-list-3__main">', PHP_EOL;
				  echo '<h3 class="post-list-top-1__title-2">' . $item->name . '</h3>', PHP_EOL;
				 echo '</div>', PHP_EOL;
				echo '</section>', PHP_EOL;
				}
			?>

			</div>
		</div>
          <div class="swiper-button-prev-column recommend-jinji-prev"></div>
          <div class="swiper-button-next-column recommend-jinji-next"></div>
        </div>
</article>