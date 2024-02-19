<?php get_header(); ?>

<div class="bg-gray bg-gray--pd">
	<div class="l-wrapper l-pc-2col">
		<div class="l-pc-2col__pro-main">
			<article class="article">
      <?php if(have_posts()): while(have_posts()): the_post();?>
				<h1 class="heading-1"><?php the_title(); ?></h1>
        <div class="sns-date-wrapper">
          <ul class="sns-share">
            <script>
              var page_url = encodeURI(window.location);
              var page_title = encodeURI(document.title);
              document.writeln('<li class="sns-share__item"><a href="http://www.facebook.com/share.php?u=' + page_url + '" rel="nofollow" target="_blank"><img src="/co-mit_renew_201910/img/icon_facebook.svg" alt="Facebookでシェアする"></a></li>');
              document.writeln('<li class="sns-share__item"><a href="//twitter.com/share?url=' + page_url + '&text=' + page_title + '" target="_blank"><img src="/co-mit_renew_201910/img/icon_twitter.svg" alt="Twitterでシェアする"></a></li>');
              document.writeln('<li class="sns-share__item"><a href="https://timeline.line.me/social-plugin/share?url=' + page_url + '" target="_blank"><img src="/co-mit_renew_201910/img/icon_line.svg" alt="LINEでシェアする"></a></li>');
            </script>
          </ul>
          <p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
        </div>
        <?php
        if ($terms = get_the_terms($post->ID, 'tag_column')) {
        ?>
        <ul class="tag-list">
        <?php
            foreach ( $terms as $term ) {
        ?>
          <li><a href="<?php echo esc_url(home_url('/')); ?>tag_column/<?php echo $term->slug ?>"><?php echo $term->name ?></a></li>
        <?php
            }
        ?>
        </ul>
        <?php
        }
        ?>
				<figure class="article__eyecatch">
            <?php if(has_post_thumbnail()): ?>
  					<?php echo get_thumb_img("large") ?>
            <?php else: ?>
    					<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="">
            <?php endif; ?>
				</figure>
				<div class="article__content">
          <?php the_content(); ?>
          <ul class="sns-share">
            <script>
							var page_url = encodeURI(window.location);
							var page_title = encodeURI(document.title);
							document.writeln('<li class="sns-share__item"><a href="http://www.facebook.com/share.php?u=' + page_url + '" rel="nofollow" target="_blank"><img src="/co-mit_renew_201910/img/icon_facebook.svg" alt="Facebookでシェアする"></a></li>');
							document.writeln('<li class="sns-share__item"><a href="//twitter.com/share?url=' + page_url + '&text=' + page_title + '" target="_blank"><img src="/co-mit_renew_201910/img/icon_twitter.svg" alt="Twitterでシェアする"></a></li>');
							document.writeln('<li class="sns-share__item"><a href="https://timeline.line.me/social-plugin/share?url=' + page_url + '" target="_blank"><img src="/co-mit_renew_201910/img/icon_line.svg" alt="LINEでシェアする"></a></li>');
						</script>
          </ul>
					<a href="<?php echo esc_url(home_url('/')); ?>column/" class="button">記事一覧へ</a>
				</div>
			</article>

      <?php endwhile; endif; ?>

      <?php get_template_part("var/column-relate-post"); ?>
      <?php get_template_part("var/column-relate-cat-post"); ?> 
      <?php
        $prevpost = get_adjacent_post(false, '', true);
        $nextpost = get_adjacent_post(false, '', false);
      ?>
      <div class="column-nav">
        <p class="column-nav__prev"><?php if ($prevpost): ?><a href="<?php echo get_permalink($prevpost->ID) ?>"><span>前の記事</span></a><?php endif; ?></p>
        <p class="column-nav__next"><?php if ($nextpost): ?><a href="<?php echo get_permalink($nextpost->ID) ?>"><span>次の記事</span></a><?php endif; ?></p>
      </div>
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
