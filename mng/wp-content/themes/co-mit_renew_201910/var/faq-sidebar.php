<div class="l-pc-2col__pro-side">
	<div class="side-post-wrap">
		<h2 class="heading-1">質問カテゴリー</h2>
    <ul class="faq-cat-list-1">
      <?php
        $taxonomy_name = 'faq_category';
        $post_type = 'faq';
        $args = array(
            'orderby' => 'ID',
            'order' => 'asc',
            'hierarchical' => false
            );
        $taxonomys = get_terms( $taxonomy_name, $args);

        if(!is_wp_error($taxonomys) && count($taxonomys)):
            foreach($taxonomys as $taxonomy):
            $url = get_term_link($taxonomy->slug, $taxonomy_name);
      ?>
      <li><a class="anchor" href="<?php echo esc_url(home_url()); ?>/faq/#<?php echo $taxonomy->slug; ?>"><?php echo esc_html($taxonomy->name); ?> (<?php echo $taxonomy->count; ?>)</a></li>
      <?php
        endforeach;
        endif;
      ?>
    </ul>
	</div>
</div>