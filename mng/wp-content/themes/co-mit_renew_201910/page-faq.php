<?php get_header(); ?>

<div class="bg-gray bg-gray--pd">
	<div class="l-wrapper l-pc-2col">
		<div class="l-pc-2col__pro-main">
			<article class="article">
  			<h1 class="heading-1">よくある質問</h1>
        <?php
          $taxonomy_name = 'faq_category';
          $post_type = 'faq';
          $args = array(
              'orderby' => 'ID',
              'order' => 'ASC',
              'hierarchical' => false
              );
          $taxonomys = get_terms( $taxonomy_name, $args);

          if(!is_wp_error($taxonomys) && count($taxonomys)):
              foreach($taxonomys as $taxonomy):
              $url = get_term_link($taxonomy->slug, $taxonomy_name);
              $tax_posts = get_posts( array(
                  'post_type' => $post_type,
                  'posts_per_page' => 999, // 表示させたい記事数
                  'tax_query' => array(
                      array(
                          'taxonomy' => $taxonomy_name,
                          'terms' => array( $taxonomy->slug ),
                          'field' => 'slug',
                          'include_children' => true,
                          'operator' => 'IN',
                          )
                      )
                  ));
                  if( $tax_posts ) {
            ?>
          <h2 id="<?php echo $taxonomy->slug; ?>" class="heading-2"><?php echo esc_html($taxonomy->name); ?></h2>
          <dl class="faq-list">
            <?php foreach($tax_posts as $tax_post): ?>
            <dt class="faq-list__question">
              <a href="<?php the_permalink( $tax_post->ID); ?>"><p><?php echo get_field("question", $tax_post->ID); ?></p></a>
            </dt>
            <?php endforeach; wp_reset_postdata(); ?>
          </dl>
        <?php
          }
          endforeach;
          endif;
        ?>
      </article>
    </div>
    <?php get_template_part("var/faq-sidebar"); ?>
  </div>
</div>
<?php get_footer(); ?>