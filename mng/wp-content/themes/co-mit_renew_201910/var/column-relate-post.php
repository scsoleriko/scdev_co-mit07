      <article class="article">
        <h2 class="heading-1">あわせて読みたい</h2>
        <ul class="post-list-1">
          <?php
            $relationIdArray = array();
            if( have_rows('relation_column') ){
              while ( have_rows('relation_column') ) : the_row();
                $postId = url_to_postid( get_sub_field('relation_column_id') );
                if ( $postId == true ){
                  array_push($relationIdArray, $postId);
                }
              endwhile;
            }
          ?>
          <?php
            if ( $relationIdArray ) {
              $query_array = array(
                "post_type" => "column",
                "post_status" => "publish",
                "posts_per_page" => 3,
                "post__in"=> $relationIdArray
              );
            } else {
              $query_array = array(
                "post_type" => "column",
                "post_status" => "publish",
                "posts_per_page" => 3,
                "post__not_in"=> array(get_the_ID())
              );
            }
            $the_query = new WP_Query( $query_array );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
          ?>
          <li class="post-list-1__item">
            <a href="<?php the_permalink(); ?>">
              <div class="post-list-1__image">
                  <?php if(has_post_thumbnail()): ?>
                  <?php the_post_thumbnail(); ?>
                  <?php else: ?>
                    <img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
                  <?php endif; ?>
              </div>
              <div class="post-list-1__detail">
                <span class="post-list-1__title"><?php the_title(); ?></span>
                <p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
              </div>
            </a>
          </li>
          <?php
            endwhile; endif;
            wp_reset_postdata();
          ?>
        </ul>
      </article>
