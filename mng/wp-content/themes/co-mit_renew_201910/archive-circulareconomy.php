<?php get_header(); ?>

<section class="circular-fv">
	<picture class="fv-img">
		<source srcset="/co-mit_renew_201910/img/circulareconomy/circular-fv__sp.jpg" media="(max-width: 768px)">
		<img src="/co-mit_renew_201910/img/circulareconomy/circular-fv.jpg">
	</picture>
	<div class="l-wrapper">
		<div class="logo">
			<img src="/co-mit_renew_201910/img/circulareconomy/logo-circular_white.png" alt="CO-MIT流 サーキュラーエコノミーを知る"></div>
		<h1>
			環境保全活動としてだけではなく<br>
			これからの経営戦略・事業戦略としての位置づけに
		</h1>
		<h2>全国での<strong><ruby>取り組み事例<rt>サーキュラーエコノミー</rt></ruby></strong>から<strong>学びを得る</strong></h2>
	</div>
	<div class="wrap">
		<!-- <img src="/co-mit_renew_201910/img/circulareconomy/businessworkation.png" alt=""> -->
		<div class="businessworkcation">
			<p>ビジネス創出型<br>ワーケーション</p>
			<p class="box">特集</p>
		</div>  
	</div>
	<div class="notice">※本企画はサーキュラーエコノミー／サーキュラーシティ支援企業の<a href="https://circledesign.co.jp/ja/" target="_blank">サークルデザイン株式会社</a>の監修により制作</div>
</section>

<div class="l-body--facility_archive">
	<div class="bg-gray--pd">
		<div class="l-wrapper">
			<div>
				<article class="article" id="examples">
					<h2 class="heading-4">サーキュラーエコノミー実例（視察受入情報）</h2>
					<p class="sub-text">サーキュラーエコノミーに取り組む先進的な地域をご紹介します。ご紹介の各地域は、視察や企業研修の場としての受け入れも行っています。</p>
					<ul class="post-list-1 mb35">
					<?php
						$the_query = new WP_Query( array(
							'post_type' => 'circulareconomy',
							'order' => 'DESC',
							"post_status" => "publish",
							"posts_per_page" => 3,
							'tax_query' => array(
								array(
									'taxonomy' => 'circular_article_type',
									'field'    => 'slug',
									'terms'    => 'examples'
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
					<a href="/circulareconomy/examples/" class="button">実例をもっと見る</a>
				</article>

				<article class="article" id="column">
					<h2 class="heading-4">コラム</h2>
					<p class="sub-text">サーキュラーエコノミーの最新の動向や、サーキュラーエコノミー実現に向けて企業にとってお役立ちいただける情報をお届していきます。</p>
					<ul class="post-list-1 mb35">
					<?php
						$the_query = new WP_Query( array(
							'post_type' => 'circulareconomy',
							'order' => 'DESC',
							"post_status" => "publish",
							"posts_per_page" => 3,
							'tax_query' => array(
								array(
									'taxonomy' => 'circular_article_type',
									'field'    => 'slug',
									'terms'    => 'column'
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
							<div class="post-list-1__detail">
								<span class="post-list-1__title-2"><?php the_title(); ?></span>
								<p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
							</div>
						</a>
					</li>
					<?php endwhile; endif; ?>
					</ul>
					<a href="/circulareconomy/column/" class="button">記事をもっと見る</a>
				</article>

				<?php
					$the_query = new WP_Query( array(
						'post_type' => 'seminar',
						'order' => 'DESC',
						"post_status" => "publish",
						"posts_per_page" => 3,
					));
					if ( $the_query->have_posts() ) :
				?>
				<article class="article" id="seminar">
					<h2 class="heading-4">セミナー情報</h2>
					<p class="sub-text">編集部でピックアップした、サーキュラーエコノミーに関するセミナーやイベント情報をお届けします。（イベント主催者からの情報も募集しています）</p>
					<ul class="post-list-1">
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<li class="post-list-1__item">
							<a href="<?php the_field('url'); ?>" target="_blank">
								<div class="post-list-1__image<?php if( is_newArticle(get_the_time('U')) ): ?> new<?php endif; ?>">
									<?php if(has_post_thumbnail()): ?>
									<?php the_post_thumbnail(); ?>
									<?php else: ?>
										<img src="<?php echo get_the_post_thumbnail_url('medium') ?>" alt="">
									<?php endif; ?>
								</div>
								<div class="post-list-1__detail">
									<p class="seminar-date">セミナー日程：<?php the_field('datetime'); ?>～</p>
									<span class="post-list-1__title-2"><?php the_title(); ?></span>
									<p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
								</div>
							</a>
						</li>
						<?php endwhile;?>
					</ul>
				</article>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<section class="workation">
		<div class="l-wrapper"> <img src="/co-mit_renew_201910/img/circulareconomy/workation_logo.png" alt="">
			<p class="workation__text">CO-MITがおすすめする<br class="sp-only">ワーケーションプログラムを<br class="sp-only">もっと知りたい方はこちら！<br>モニターツアー参加者募集中のプログラムも<br class="sp-only">ご紹介しています。</p>
			<a href="/workation-portal/" class="workation__link" target="_blank">
				<div class="workation__hoverbox"></div>
				<img src="/co-mit_renew_201910/img/circulareconomy/workation_button.png" alt="">
			</a> 
		</div>
	</section>

	<section class="pr" id="accept">
		<div class="l-wrapper">
			<p class="home__h1">視察受入地の方へ</p>
			<p class="home__h2"><span>CO-MITワーケーションで<br class="sp-only">取り組みをPRしませんか？</span></p>
			<p class="section__text">
				サーキュラーエコノミーをテーマにした視察型ワーケーション造成で関係人口創出を。<br>
				すでに実施中またはこれから実施予定のプログラムがございましたら、まずはお気軽にご相談ください。</p>
			<div class="button-area"><a href="/contact/#contact" class="button" target="_blank">問い合わせする</a> </div>
		</div>
	</section>

<?php get_footer(); ?>
