<?php
	$article_type = $post->post_name;
	circulareeconomy_breadcrumb();
?>
<div class="bg-gray bg-gray--pd">
	<div class="l-wrapper l-pc-2col">
		<div class="l-pc-2col__pro-main">
			<article class="article">
				<h2 class="heading-1"><?php the_title(); ?></h2>
				<ul class="post-list-1">
				<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$the_query = new WP_Query( array(
						'post_type' => 'circulareconomy',
						'post_parent' => get_the_ID(),
						"post_status" => "publish",
						"posts_per_page" => 12,
						'paged' => $paged,
						'order' => 'DESC',
						'tax_query' => array(
							array(
								'taxonomy' => 'circular_article_type',
								'field'    => 'slug',
								'terms'    => $article_type
							)
						)
					));
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
							<div class="post-list-1__detail">
								<span class="post-list-1__title-2"><?php the_title(); ?></span>
								<p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
							</div>
						</a>
					</li>
					<?php endwhile; endif; ?>
				</ul>
				<?php
					$GLOBALS['wp_query']->max_num_pages = $the_query->max_num_pages;
					columnPagination();
					wp_reset_postdata();
				?>
			</article>

			<?php
				//逆（視察受入情報⇔コラム）側を指定
				$article_type = ( $article_type === 'column' ) ? 'examples' : 'column';
			?>
			<article class="article">
				<h2 class="heading-1">関連記事（<?php if($article_type === 'column'): ?>コラム<?php else: ?>サーキュラーシティ実例<?php endif; ?>）</h2>
				<ul class="post-list-1">
					<?php
						$query_array = array(
							"post_type" => "circulareconomy",
							"post_status" => "publish",
							"posts_per_page" => 3,
							'tax_query' => array(
								array(
									'taxonomy' => 'circular_article_type',
									'field'    => 'slug',
									'terms'    => $article_type
								)
							)
						);
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
					<?php endwhile; endif; ?>
				</ul>
			</article>
		</div>
	<?php get_template_part("var/column-sidebar"); ?>
	</div>
</div>
