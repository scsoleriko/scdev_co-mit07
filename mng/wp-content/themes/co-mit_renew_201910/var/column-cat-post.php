<?php
  if(is_mobile()){ $article_cnt = 4; }
  else { $article_cnt = 3; }
?>
      <article class="article">
        <h2 class="heading-1">研修合宿基礎知識<a href="<?php echo esc_url(home_url('/')); ?>category_column/base_content" class="heading-1__btn pc-only">もっと見る</a></h2>
        <ul class="post-list-1">
          <?php
            $query_array = array(
              "post_type" => "column",
              "post_status" => "publish",
              "posts_per_page" => $article_cnt ,
              'tax_query' => array(
                array(
                  'taxonomy' => 'category_column',
                  'field'    => 'slug',
                  'terms'    => 'base_content'
                )
              ),
            );
            $the_query = new WP_Query( $query_array );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
          ?>
          <li class="post-list-1__item">
            <a href="<?php the_permalink(); ?>">
              <div class="post-list-1__image">
                  <?php if(has_post_thumbnail()): ?>
                  <?php echo get_thumb_img('medium'); ?>
                  <?php else: ?>
                    <img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
                  <?php endif; ?>
              </div>
              <div class="post-list-1__detail">
                <span class="post-list-1__title-2"><?php the_title(); ?></span>
                <?php if( get_field('column_lead') && !is_mobile() ) : ?>
                <p class="post-list-1__text"><?php echo get_field('column_lead'); ?></p>
                <?php endif; ?>
                <p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
              </div>

            </a>
          </li>
          <?php
            endwhile; endif;
            wp_reset_postdata();
          ?>
        </ul>
        <div class="sp-only-2">
          <a href="<?php echo esc_url(home_url('/')); ?>category_column/base_content" class="button button--lg">もっと見る</a>
        </div>
      </article>
      <article class="article">
        <h2 class="heading-1">プロが教えるHOWTO<a href="<?php echo esc_url(home_url('/')); ?>category_column/howto_content" class="heading-1__btn pc-only">もっと見る</a></h2>
        <ul class="post-list-1">
          <?php
            $query_array = array(
              "post_type" => "column",
              "post_status" => "publish",
              "posts_per_page" => $article_cnt ,
              'tax_query' => array(
                array(
                  'taxonomy' => 'category_column',
                  'field'    => 'slug',
                  'terms'    => 'howto_content'
                )
              ),
            );
            $the_query = new WP_Query( $query_array );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
          ?>
          <li class="post-list-1__item">
            <a href="<?php the_permalink(); ?>">
              <div class="post-list-1__image">
                  <?php if(has_post_thumbnail()): ?>
                  <?php echo get_thumb_img('medium'); ?>
                  <?php else: ?>
                    <img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
                  <?php endif; ?>
              </div>
              <div class="post-list-1__detail">
                <span class="post-list-1__title-2"><?php the_title(); ?></span>
                <?php if( get_field('column_lead') && !is_mobile() ) : ?>
                <p class="post-list-1__text"><?php echo get_field('column_lead'); ?></p>
                <?php endif; ?>
                <p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
              </div>

            </a>
          </li>
          <?php
            endwhile; endif;
            wp_reset_postdata();
          ?>
        </ul>
        <div class="sp-only-2">
          <a href="<?php echo esc_url(home_url('/')); ?>category_column/howto_content" class="button button--lg">もっと見る</a>
        </div>
      </article>
      <article class="article">
        <h2 class="heading-1">知っておきたい！労務管理<a href="<?php echo esc_url(home_url('/')); ?>category_column/labor_content" class="heading-1__btn pc-only">もっと見る</a></h2>
        <ul class="post-list-1">
          <?php
            $query_array = array(
              "post_type" => "column",
              "post_status" => "publish",
              "posts_per_page" => $article_cnt ,
              'tax_query' => array(
                array(
                  'taxonomy' => 'category_column',
                  'field'    => 'slug',
                  'terms'    => 'labor_content'
                )
              ),
            );
            $the_query = new WP_Query( $query_array );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
          ?>
          <li class="post-list-1__item">
            <a href="<?php the_permalink(); ?>">
              <div class="post-list-1__image">
                  <?php if(has_post_thumbnail()): ?>
                  <?php echo get_thumb_img('medium'); ?>
                  <?php else: ?>
                    <img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
                  <?php endif; ?>
              </div>
              <div class="post-list-1__detail">
                <span class="post-list-1__title-2"><?php the_title(); ?></span>
                <?php if( get_field('column_lead') && !is_mobile() ) : ?>
                <p class="post-list-1__text"><?php echo get_field('column_lead'); ?></p>
                <?php endif; ?>
                <p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
              </div>

            </a>
          </li>
          <?php
            endwhile; endif;
            wp_reset_postdata();
          ?>
        </ul>
        <div class="sp-only-2">
          <a href="<?php echo esc_url(home_url('/')); ?>category_column/labor_content" class="button button--lg">もっと見る</a>
        </div>
      </article>
      <article class="article">
        <h2 class="heading-1">お役立ちHRコラム<a href="<?php echo esc_url(home_url('/')); ?>category_column/hr_content" class="heading-1__btn pc-only">もっと見る</a></h2>
        <ul class="post-list-1">
          <?php
            $query_array = array(
              "post_type" => "column",
              "post_status" => "publish",
              "posts_per_page" => $article_cnt ,
              'tax_query' => array(
                array(
                  'taxonomy' => 'category_column',
                  'field'    => 'slug',
                  'terms'    => 'hr_content'
                )
              ),
            );
            $the_query = new WP_Query( $query_array );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
          ?>
          <li class="post-list-1__item">
            <a href="<?php the_permalink(); ?>">
              <div class="post-list-1__image">
                  <?php if(has_post_thumbnail()): ?>
                  <?php echo get_thumb_img('medium'); ?>
                  <?php else: ?>
                    <img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
                  <?php endif; ?>
              </div>
              <div class="post-list-1__detail">
                <span class="post-list-1__title-2"><?php the_title(); ?></span>
                <?php if( get_field('column_lead') && !is_mobile() ) : ?>
                <p class="post-list-1__text"><?php echo get_field('column_lead'); ?></p>
                <?php endif; ?>
                <p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
              </div>

            </a>
          </li>
          <?php
            endwhile; endif;
            wp_reset_postdata();
          ?>
        </ul>
        <div class="sp-only-2">
          <a href="<?php echo esc_url(home_url('/')); ?>category_column/hr_content" class="button button--lg">もっと見る</a>
        </div>
      </article>
      <article class="article">
        <h2 class="heading-1">特集<a href="<?php echo esc_url(home_url('/')); ?>category_column/special_content" class="heading-1__btn pc-only">もっと見る</a></h2>
        <ul class="post-list-1">
          <?php
            $query_array = array(
              "post_type" => "column",
              "post_status" => "publish",
              "posts_per_page" => $article_cnt ,
              'tax_query' => array(
                array(
                  'taxonomy' => 'category_column',
                  'field'    => 'slug',
                  'terms'    => 'special_content'
                )
              ),
            );
            $the_query = new WP_Query( $query_array );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
          ?>
          <li class="post-list-1__item">
            <a href="<?php the_permalink(); ?>">
              <div class="post-list-1__image">
                  <?php if(has_post_thumbnail()): ?>
                  <?php echo get_thumb_img('medium'); ?>
                  <?php else: ?>
                    <img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
                  <?php endif; ?>
              </div>
              <div class="post-list-1__detail">
                <span class="post-list-1__title-2"><?php the_title(); ?></span>
                <?php if( get_field('column_lead') && !is_mobile() ) : ?>
                <p class="post-list-1__text"><?php echo get_field('column_lead'); ?></p>
                <?php endif; ?>
                <p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
              </div>

            </a>
          </li>
          <?php
            endwhile; endif;
            wp_reset_postdata();
          ?>
        </ul>
        <div class="sp-only-2">
          <a href="<?php echo esc_url(home_url('/')); ?>category_column/special_content" class="button button--lg">もっと見る</a>
        </div>
      </article>