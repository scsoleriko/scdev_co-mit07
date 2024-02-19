<?php get_header(); ?>

<?php
	$taxonomy = 'tag_column';
	$term = get_term_by('slug', get_query_var($taxonomy), $taxonomy);
?>
<div class="bg-gray bg-gray--pd">
	<div class="l-wrapper l-pc-2col">
		<div class="l-pc-2col__pro-main">
			<article class="article">
			<h1 class="heading-1">「<?php echo $term->name ?>」タグの記事一覧</h1>
			<ul class="post-list-1">
			<?php
				$paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
				$query_array = array(
				"post_type" => "column",
				"post_status" => "publish",
				'posts_per_page'   => get_option('posts_per_page'),
				'tax_query' => array(
					array(
					'taxonomy' => 'tag_column',
					'field'    => 'slug',
					'terms'    => $term
					)
				),
				'paged'  =>  $paged
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
					<span class="post-list-1__title"><?php the_title(); ?></span>
					<p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
				</div>

				</a>
			</li>
			<?php
				endwhile; endif;
			?>
			</ul>
			<?php
				$GLOBALS['wp_query']->max_num_pages = $the_query->max_num_pages;
				columnPagination();
				wp_reset_postdata();
			?>
			</article>
      <?php get_template_part("var/column-relate-cat-post"); ?>
		</div>
	<?php get_template_part("var/column-sidebar"); ?>
	</div>
</div>


<div class="search-now">
	<h2 class="section-title">
		<span class="section-title-en">SEARCH NOW</span>
		<img src="/co-mit_renew_201910/img/icon_search.png">
		<span class="section-title-ja">CO-MITで施設探しをしてみませんか？</span>
	</h2>
	<p class="search-now__text">CO-MITは“研修合宿のプロが選んだ、厳選された会場を「プロ目線で検索できる」”<br>研修合宿施設の検索サイトです。</p>
	<a href="/facility/" class="button">施設を検索してみる</a>
</div>

<?php get_footer(); ?>
