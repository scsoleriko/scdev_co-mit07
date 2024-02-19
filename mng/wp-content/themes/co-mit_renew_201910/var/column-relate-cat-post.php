<?php /*
      <article class="article">
        <h2 class="heading-1">このカテゴリーの記事を見ている人が良く読んでいる記事</h2>
        <ul class="post-list-1">
          <?php
            if (is_archive('column')){
              $term_slug = $term;
            } else {
              $tags = get_the_terms($post->ID, "category_column");
              $term_slug = $tags[0] -> slug;
            }
            $query_array = array(
              "post_type" => "column",
              "post_status" => "publish",
              "posts_per_page" => 3,
              'orderby' => 'rand',
              'tax_query' => array( 
                array( 
                  'taxonomy' => 'category_column', 
                  'field'    => 'slug', 
                  'terms'    => $term_slug
                ) 
              )
            );

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
*/
$obj = get_queried_object();
// タクソノミーの取得
$taxonomy = $obj->taxonomy;
// 記事数を取得
$count = $obj->count;

?>

<?php if ($taxonomy == "category_column" && $count > 3) : ?>
<article class="article">
	<h2 class="heading-1">このカテゴリの人気記事</h2>
	<ul class="post-list-1">
	<?php
		$taxonomy = 'category_column';
		$term = get_term_by('slug', get_query_var($taxonomy), $taxonomy);
		$xml_url = 'https://r6.snva.jp/api/recommend/rule/?k=45MRqaLbm9B2t&tmpl=3&lang_type=xml&output_type=2&format_type=2&category[]=' . $term->name;
		$xml = simplexml_load_file($xml_url);
		foreach($xml->items->item as $item){

		echo '<li class="post-list-1__item">', PHP_EOL;
			echo '<a href="' . str_replace("https://co-mit.jp", "", $item->url) . '" onclick="apiSetCtr(\'' . $item->item_code . '\', \'3\', this, \'45MRqaLbm9B2t\');return false;">', PHP_EOL;
				echo '<div class="post-list-1__image">';
				if (empty($item->img_url)){
					echo '<img src="/img/naviplus_noimage.jpg" alt="' . $item->name . '">';
				} else {
					echo '<img src="' . $item->img_url . '" alt="' . $item->name . '">';
				}
				echo '</div>', PHP_EOL;
				echo '<div class="post-list-1__detail">', PHP_EOL;
					echo '<span class="post-list-1__title">' . $item->name . '</span>', PHP_EOL;
					echo '<p class="date"><span class="icon-clock"></span>' . date('Y.n.d',strtotime($item->content_date)) . '</p>', PHP_EOL;
				echo '</div>', PHP_EOL;
			echo '</a>', PHP_EOL;
		echo '</li>', PHP_EOL;

		}
	?>
	</ul>
</article>
<?php endif; ?>

<?php if ($taxonomy == "tag_column" && $count > 3) : ?>
<article class="article">
	<h2 class="heading-1">このタグの人気記事</h2>
	<ul class="post-list-1">
	<?php
		$taxonomy = 'tag_column';
		$term = get_term_by('slug', get_query_var($taxonomy), $taxonomy);
		$xml_url = 'https://r6.snva.jp/api/recommend/rule/?k=45MRqaLbm9B2t&tmpl=3&lang_type=xml&output_type=2&format_type=2&category[]=' . $term->name;
		$xml = simplexml_load_file($xml_url);
		foreach($xml->items->item as $item){

		echo '<li class="post-list-1__item">', PHP_EOL;
			echo '<a href="' . str_replace("https://co-mit.jp", "", $item->url) . '" onclick="apiSetCtr(\'' . $item->item_code . '\', \'3\', this, \'45MRqaLbm9B2t\');return false;">', PHP_EOL;
				echo '<div class="post-list-1__image">';
				if (empty($item->img_url)){
					echo '<img src="/img/naviplus_noimage.jpg" alt="' . $item->name . '">';
				} else {
					echo '<img src="' . $item->img_url . '" alt="' . $item->name . '">';
				}
				echo '</div>', PHP_EOL;
				echo '<div class="post-list-1__detail">', PHP_EOL;
					echo '<span class="post-list-1__title">' . $item->name . '</span>', PHP_EOL;
					echo '<p class="date"><span class="icon-clock"></span>' . date('Y.n.d',strtotime($item->content_date)) . '</p>', PHP_EOL;
				echo '</div>', PHP_EOL;
			echo '</a>', PHP_EOL;
		echo '</li>', PHP_EOL;

		}
	?>
	</ul>
</article>
<?php endif; ?>

<?php if (is_single()) : ?>
<article class="article">
	<h2 class="heading-1">この記事を見た人はこの記事も見ています</h2>
	<ul class="post-list-1">
	<?php
		$id = get_post( get_the_ID() )->post_name;
		$xml_url = 'https://r6.snva.jp/api/recommend/rule/?k=45MRqaLbm9B2t&tmpl=2&lang_type=xml&output_type=2&format_type=2&id[]=' . $id;
		$xml = simplexml_load_file($xml_url);
		foreach($xml->items->item as $item){

		echo '<li class="post-list-1__item">', PHP_EOL;
			echo '<a href="' . str_replace("https://co-mit.jp", "", $item->url) . '" onclick="apiSetCtr(\'' . $item->item_code . '\', \'2\', this, \'45MRqaLbm9B2t\');return false;">', PHP_EOL;
				echo '<div class="post-list-1__image">';
				if (empty($item->img_url)){
					echo '<img src="/img/naviplus_noimage.jpg" alt="' . $item->name . '">';
				} else {
					echo '<img src="' . $item->img_url . '" alt="' . $item->name . '">';
				}
				echo '</div>', PHP_EOL;
				echo '<div class="post-list-1__detail">', PHP_EOL;
					echo '<span class="post-list-1__title">' . $item->name . '</span>', PHP_EOL;
					echo '<p class="date"><span class="icon-clock"></span>' . date('Y.n.d',strtotime($item->content_date)) . '</p>', PHP_EOL;
				echo '</div>', PHP_EOL;
			echo '</a>', PHP_EOL;
		echo '</li>', PHP_EOL;

		}
	?>
	</ul>
</article>
<?php endif; ?>

