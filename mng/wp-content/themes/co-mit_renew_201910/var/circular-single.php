<?php
  $parent_id = $post->post_parent;
  $article_type = get_post($parent_id)->post_name;;
	circulareeconomy_breadcrumb();
?>
<div class="bg-gray bg-gray--pd">
  <div class="l-wrapper l-pc-2col">
    <div class="l-pc-2col__pro-main">
      <article class="article">
      <?php if(have_posts()): while(have_posts()): the_post();?>
        <h1 class="heading-1"><?php the_title(); ?></h1>
        <div class="circular-tags">
          <?php if ($terms = get_the_terms($post->ID, 'circular_examples_area')): ?>
          <?php foreach ( $terms as $term ): ?>
          <div class="circular-tags__place"><?php echo $term->name ?></div>
          <?php endforeach; ?>
          <?php endif; ?>
          <?php if ($terms = get_the_terms($post->ID, 'circular_examples_icon')): ?>
          <?php foreach ( $terms as $term ): ?>
          <div class="circular-tags__text"><?php echo $term->name ?></div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="sns-date-wrapper">
          <?php get_template_part("var/sns-share"); ?>
          <p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
        </div>
        <figure class="article__eyecatch">
          <?php if(has_post_thumbnail()): ?>
          <?php echo get_thumb_img("large") ?>
          <?php else: ?>
            <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="">
          <?php endif; ?>
        </figure>
        <div class="article__content">
          <?php remove_filter ('the_content', 'wpautop'); ?>
          <?php the_content(); ?>
          <?php get_template_part("var/sns-share"); ?>
          <a href="<?php echo esc_url(home_url('/')); ?>circulareconomy/<?php echo $article_type; ?>/" class="button">記事一覧へ</a>
        </div>
      </article>
      <?php endwhile; endif; ?>

      <article class="article">
        <h2 class="heading-1">あわせて読みたい</h2>
        <ul class="post-list-1">
          <?php
            $relationIdArray = array();
            if( have_rows('relation_post') ){
              while ( have_rows('relation_post') ) : the_row();
                $postId = url_to_postid( get_sub_field('relation_post_url') );
                if ( $postId == true ){
                  array_push($relationIdArray, $postId);
                }
              endwhile;
            }
          ?>
          <?php
            if ( $relationIdArray ) {
              $query_array = array(
                "post_type" => "circulareconomy",
                "post_status" => "publish",
                "posts_per_page" => 3,
                "post__in"=> $relationIdArray,
                'tax_query' => array(
                  array(
                    'taxonomy' => 'circular_article_type',
                    'field'    => 'slug',
                    'terms'    => $article_type[0]
                  ),
                ),
              );
            } else {
              $query_array = array(
                "post_type" => "circulareconomy",
                "post_status" => "publish",
                "posts_per_page" => 3,
                "post__not_in"=> array(get_the_ID()),
                'tax_query' => array(
                  array(
                    'taxonomy' => 'circular_article_type',
                    'field'    => 'slug',
                    'terms'    => array('examples', 'column')
                  )
                )
              );
            }
            $the_query = new WP_Query( $query_array );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
          ?>
          <li class="post-list-1__item">
            <a href="<?php the_permalink(); ?>">
              <div class="post-list-1__image<?php if( is_newArticle(get_the_time('U')) ): ?> new<?php endif; ?>">
                  <?php if(has_post_thumbnail()): ?>
                  <?php the_post_thumbnail(); ?>
                  <?php else: ?>
                    <img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
                  <?php endif; ?>
              </div>
              <div class="post-list-1__detail">
                <span class="post-list-1__title-2"><?php the_title(); ?></span>
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

      <?php
        $prevpost = get_adjacent_post(true, '', true, 'circular_article_type');
        $nextpost = get_adjacent_post(true, '', false, 'circular_article_type');
      ?>
      <div class="column-nav">
        <p class="column-nav__prev"><?php if ($prevpost): ?><a href="<?php echo get_permalink($prevpost->ID) ?>"><span>前の記事</span></a><?php endif; ?></p>
        <p class="column-nav__next"><?php if ($nextpost): ?><a href="<?php echo get_permalink($nextpost->ID) ?>"><span>次の記事</span></a><?php endif; ?></p>
      </div>
    </div>
    <?php get_template_part("var/column-sidebar"); ?>
  </div>
</div>