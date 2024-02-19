<div class="l-pc-2col__pro-side">
	<?php
		$args = array(
				'posts_per_page'   => 5,
				'post_type'        => 'column-banner-top',
				'post_status'      => 'publish',
				'orderby'          => 'meta_value_num',
				'order'            => 'ASC',
				'post_status'      => 'publish',
				'meta_key'         => 'column-banner-number'
		);
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ){
	?>
	<div class="banner">
		<ul>
		<?php
			while ( $the_query->have_posts() ) {
			$the_query->the_post();
		?>
		<?php
			$bannerImage = get_field("column-banner");
			$bannerLink = get_field("column-banner-link");
			$bannerLinkTarget = in_array('blank',(array)get_field("column-banner-link-target"));
			$bannerAlt = get_field("column-banner-alt");
		?>
		<li>
			<?php if( $bannerLink ): ?>
			<a href="<?php echo $bannerLink; ?>" <?php if($bannerLinkTarget) { echo 'target="_blank"'; } ?>>
			<?php endif; ?>
				<img src="<?php echo $bannerImage ?>" alt="<?php if($bannerAlt) { echo $bannerAlt; } ?>">
			<?php if( $bannerLink ): ?>
			</a>
			<?php endif; ?>
		</li>
		<?php
			}
			wp_reset_postdata();
		?>
		</ul>
	</div>
	<?php
		}
	?>

	<?php if( is_archive('column') ): ?>
	<div class="side-post-wrap">
		<h2 class="heading-2 heading-2--post">人気の記事</h2>
		<div class="post-tab">
			<div class="post-tab-title">
				<p class="js-post-tab-btn is-tab-active" data-tab-number="1">最新</p>
				<p class="js-post-tab-btn" data-tab-number="2">ALL</p>
			</div>
			<div class="post-tab-bar"></div>
		</div>
		<ul class="post-list-2 js-post-tab-detail" data-tab-number="1">
			<?php
				$args = array(
					'limit' => 5,
					'post_type' => 'column',
					'range' => 'last7days'
				);
				wpp_get_mostpopular( $args );
			?>
		</ul>
		<ul class="post-list-2 js-post-tab-detail" data-tab-number="2" style="display:none;">
			<?php
				$args = array(
					'limit' => 5,
					'post_type' => 'column',
					'range' => 'all'
				);
				wpp_get_mostpopular( $args );
			?>
		</ul>
	</div>

	<div class="side-post-wrap">
		<h2 class="heading-2 heading-2--post heading-2--tag_column">関連タグ</h2>
		<ul class="post-list-3 tag_column">

			<?php // get_terms を使ったターム一覧の表示
				$taxonomy_terms = get_terms('tag_column'); // タクソノミースラッグを指定
				if(!empty($taxonomy_terms) && !is_wp_error($taxonomy_terms)) :
					foreach($taxonomy_terms as $taxonomy_term): // foreach ループの開始
			?>
			<li>
				<a href="<?php echo "/tag_column/".$taxonomy_term->slug."/"; ?>">#<?php echo $taxonomy_term->name; ?></a>
			</li>
			<?php
				endforeach; endif;
			?>
		</ul>
	</div>
	<?php else: ?>

	<?php if( !is_circulareeconomy() ): ?>
	<div class="side-post-wrap">
		<h2 class="heading-2 heading-2--tags">目的から研修施設を探す</h2>
		<ul class="post-list-3 facility-tag">

			<?php // get_terms を使ったターム一覧の表示

				$taxonomy_terms = [
					(object) ["name"=>"新人研修にオススメ","link"=>"/facility/feature/new-member/"],
					(object) ["name"=>"近くにゴルフ場がある","link"=>"/facility/feature/golf/"],
					(object) ["name"=>"360°パノラマビューが見れる","link"=>"/facility/feature/360/"],
					(object) ["name"=>"オフサイトミーティング","link"=>"/facility/feature/offsite/"],
					(object) ["name"=>"チームビルディングに最適","link"=>"/facility/feature/team-build/"],
					(object) ["name"=>"BBQができる","link"=>"/facility/feature/bbq/"],
					(object) ["name"=>"研修パックあり","link"=>"/facility/feature/include-training/"],
					(object) ["name"=>"都内からのアクセスが良い","link"=>"/facility/feature/good-access/"]
				];
				if(!empty($taxonomy_terms)) :
					foreach($taxonomy_terms as $taxonomy_term): // foreach ループの開始
			?>
			<li>
				<a href="<?php echo $taxonomy_term->link; ?>"><?php echo $taxonomy_term->name; ?></a>
			</li>
			<?php
				endforeach; endif;
			?>
		</ul>
	</div>
	<?php endif; ?>
	<div class="side-post-wrap">
		<h2 class="heading-2 heading-2--post" style="text-indent: -1.2em; margin-left: 1.2em"><?php if( !is_circulareeconomy() ): ?>その他の記事はこちら<?php else: ?>研修ノウハウ・コラム人気記事<?php endif; ?></h2>
		<ul class="post-list-2">

			<?php
				$the_query = new WP_Query( array(
					"posts_per_page"   => 5,
					"post_type" => "column",
					"post_status" => "publish",
					"post__not_in"=> array(get_the_ID())
				));
				if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
			?>
			<li class="post-list-2__item">
				<a href="<?php the_permalink(); ?>">
					<div class="post-list-2__image">
							<?php if(has_post_thumbnail()): ?>
							<?php echo get_thumb_img('medium'); ?>
							<?php else: ?>
								<img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
							<?php endif; ?>
					</div>
					<div class="post-list-2__detail">
						<span class="post-list-2__main"><?php the_title(); ?></span>
						<p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
					</div>
				</a>
			</li>
			<?php
				endwhile; endif;
				wp_reset_postdata();
			?>
		</ul>
	</div>
	<?php if( !is_circulareeconomy() ): ?>
	<div class="side-post-wrap">
		<h2 class="heading-2 heading-2--post heading-2--tag_column">関連タグ</h2>
		<ul class="post-list-3 tag_column">

			<?php // get_terms を使ったターム一覧の表示
				$taxonomy_terms = get_terms('tag_column'); // タクソノミースラッグを指定
				if(!empty($taxonomy_terms) && !is_wp_error($taxonomy_terms)) :
					foreach($taxonomy_terms as $taxonomy_term): // foreach ループの開始
			?>
			<li>
				<a href="<?php echo "/tag_column/".$taxonomy_term->slug."/"; ?>">#<?php echo $taxonomy_term->name; ?></a>
			</li>
			<?php
				endforeach; endif;
			?>
		</ul>
	</div>
	<?php endif; ?>

	<?php endif; ?>

	<?php
		$args = array(
				'posts_per_page'   => 5,
				'post_type'        => 'column-banner-bottom',
				'post_status'      => 'publish',
				'orderby'          => 'meta_value_num',
				'order'            => 'ASC',
				'post_status'      => 'publish',
				'meta_key'         => 'column-banner-number'
		);
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ){
	?>

	<div class="banner">
		<ul>
		<?php
			while ( $the_query->have_posts() ) {
			$the_query->the_post();
		?>
		<?php
			$bannerImage = get_field("column-banner");
			$bannerLink = get_field("column-banner-link");
			$bannerLinkTarget = in_array('blank',(array)get_field("column-banner-link-target"));
			$bannerAlt = get_field("column-banner-alt");
		?>
		<li>
			<?php if( $bannerLink ): ?>
			<a href="<?php echo $bannerLink; ?>" <?php if($bannerLinkTarget) { echo 'target="_blank"'; } ?>>
			<?php endif; ?>
				<img src="<?php echo $bannerImage ?>" alt="<?php if($bannerAlt) { echo $bannerAlt; } ?>">
			<?php if( $bannerLink ): ?>
			</a>
			<?php endif; ?>
		</li>
		<?php
			}
			wp_reset_postdata();
		?>
		</ul>
	</div>
	<?php
		}
	?>
</div>