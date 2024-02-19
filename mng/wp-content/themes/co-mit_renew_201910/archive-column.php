<?php get_header(); ?>

<div class="bg-gray bg-gray--pd">
	<div class="l-wrapper l-pc-2col">
		<div class="l-pc-2col__pro-main">
			<article class="article">

			<h1 class="heading-1">プロ目線 コンテンツ一覧</h1>
				<figure class="article__eyecatch">
		<?php if(is_mobile()): ?>
					<img src="/co-mit_renew_201910/img/sp_co-mit_column.jpg" alt="人事・総務・研修担当者必見!! 研修ノウハウ・コラム 宿泊研修のプロが教える記事コンテンツ">
		<?php else: ?>
					<img src="/co-mit_renew_201910/img/pc_co-mit_column.jpg" alt="人事・総務・研修担当者必見!! 研修ノウハウ・コラム 宿泊研修のプロが教える記事コンテンツ">
		<?php endif; ?>
				</figure>
				<div class="article__content">
					<!-- <div class="the_content">
						<p>リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。</p>
						<p>リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。リード文がここに入ります。</p>
					</div> -->
					<div class="list-box">
						<h2 class="list-box__heading list-box__heading--content"><span>新着記事</span></h2>
						<div class="list-box__content">
							<ul class="post-list-top-1">
				<?php
				$the_query = new WP_Query( array(
					"post_type" => "column",
					"post_status" => "publish",
					"posts_per_page" => 4,
				));
				if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
				?>
					<li class="post-list-top-1__item">
						<a href="<?php the_permalink(); ?>">
							<div class="post-list-top-1__image">
								<?php if(has_post_thumbnail()): ?>
								<?php the_post_thumbnail(); ?>
								<?php else: ?>
									<img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
								<?php endif; ?>
							</div>
							<div class="post-list-top-1__detail">
								<span class="post-list-top-1__title-2"><?php the_title(); ?></span>
								<p class="date"><span class="icon-clock"><?php the_time('Y.n.j'); ?></span></p>
							</div>
					</a></li>
			<?php endwhile; endif; ?>
							</ul>
						</div>
					</div>
					<a href="/category_column/new_posts/" class="button">新着記事一覧を見る</a>
				</div>
			</article>

	<?php get_template_part("var/column-cat-post"); ?>
	<?php get_template_part("var/column-relate-post-top"); ?>
		</div>
	<?php get_template_part("var/column-sidebar"); ?>
	</div>
</div>


<div class="search-now">
	<h2 class="section-title">
		<span class="section-title-en">SEARCH NOW</span>
		<i class="st-icon-search"></i>
		<span class="section-title-ja">CO-MITで施設探しをしてみませんか？</span>
	</h2>
	<p class="search-now__text">CO-MITは“研修合宿のプロが選んだ、厳選された会場を「プロ目線で検索できる」”<br>研修合宿施設の検索サイトです。</p>
	<a href="/facility/" class="button">施設を検索してみる</a>
</div>

<?php get_footer(); ?>
