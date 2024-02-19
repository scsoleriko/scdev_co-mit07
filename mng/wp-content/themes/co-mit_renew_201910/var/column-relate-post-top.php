      <?php
        $recommendFacility = get_field('recommend-facility');
        $query_array = array(
          "post_type" => "facility",
          "post_status" => "publish",
          'tax_query' => array( 
            array( 
              'taxonomy' => 'feature', 
              'field'    => 'slug', 
              'terms'    => $recommendFacility,
              'operator' => 'IN'
            ) 
          ),
          'orderby' => 'rand',
          "posts_per_page" => 9999
        );
        $the_query = new WP_Query( $query_array );
        if ( $recommendFacility && $the_query->have_posts() ) {
      ?>
      <article class="article">
        <h2 class="heading-1">良く見られている施設</h2>
        <div class="swiper-container-2__wrap">
          <div class="swiper-container-2 swiper-container--column">
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
                      $tags = get_the_terms($post->ID, "feature");
                      $tag_count_ = 0;
                      foreach ($tags as $tag) {
                        echo "<li>".$tag -> name."</li>";
                        if ($tag_count_ == 2) { break; }
                        $tag_count_++;
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
          <div class="swiper-button-prev-column"></div>
          <div class="swiper-button-next-column"></div>
        </div>
      </article>
    <?php } wp_reset_postdata(); ?>