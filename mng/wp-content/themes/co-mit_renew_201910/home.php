
<?php get_header(); ?>
<?php

$is_mobile_device = is_mobile();
$thumb_size = $is_mobile_device ? "medium" : "large";

?>

<div class="home-fv">
	<div class="home-fv__wrapper">
    <div class="home-fv__leftbox">
      <div class="home-fv__main">
        <h1 class="home-fv__heading"><span>施設探しのプロ目線</span>で選べる！<p>最適な研修・合宿施設が見つかる<br class="spOnly">検索サービス</p></h1>
      </div>
      <div class="search js-pulldown-filter">
        <div class="pulldown-wrapper">
          <select name="" id="" class="search__select search__select--area">
            <option value=""></option>
            <option value="hokkaido_tohoku">北海道・東北</option>
            <option value="hokuriku_koshinetsu">北陸・甲信越</option>
            <option value="kanto">関東</option>
            <option value="chubu_tokai">中部・東海</option>
            <option value="kansai">関西</option>
            <option value="chugoku_shikoku">中国・四国</option>
            <option value="kyushu_okinawa">九州・沖縄</option>
          </select>
        </div>
        <div class="pulldown-wrapper">
          <select name="" id="" class="search__select search__select--people">
            <option value=""></option>
            <option value="1">20名未満</option>
            <option value="20">20～49名</option>
            <option value="50">50～99名</option>
            <option value="100">100～199名</option>
            <option value="200">200名以上</option>
          </select>
        </div>


        <a class="button button--search" href="/facility/">施設を探す</a>
        <div class="search__area">
          <p>エリアから探す</p>
          <ul>
            <li><a href="/?post_type=facility&s=&cat_area%5B%5D=tokyo&facility_capa=&facility_fee=">東京</a></li>
            <li><a href="/?post_type=facility&s=&cat_area%5B%5D=kanagawa&facility_capa=&facility_fee=">神奈川</a></li>
            <li><a href="/?post_type=facility&s=&cat_area%5B%5D=chiba&facility_capa=&facility_fee=">千葉</a></li>
            <li><a href="/?post_type=facility&s=&cat_area%5B%5D=osaka&facility_capa=&facility_fee=">大阪</a></li>
            <li><a href="/area/kanto/">関東</a></li>
            <li><a href="/area/kansai/">関西 </a></li>
            <li><a href="/area/chubu_tokai/">中部・東海 </a></li>
            <li><a href="/area/hokkaido_tohoku/">北海道・東北 </a></li>
            <li><a href="/area/hokuriku_koshinetsu/">北陸・甲信越 </a></li>
            <li><a href="/area/chugoku_shikoku/">中国・四国 </a></li>
            <li><a href="/area/kyushu_okinawa/">九州・沖縄</a></li>
        </div>
      </div>
    </div>
    <div class="home-fv__slider">
      <?php
        $args = array(
            'posts_per_page'   => -1,
            'order'            => 'ASC',
            'orderby'          => 'meta_value_num',
            'meta_key'         => 'top-slide-order',
            'post_type'        => 'top-slide',
            'post_status'      => 'publish',
        );
        $the_query = new WP_Query( $args );
      ?>

      <h2 class="home-fv__heading2">利用シーンから探す</h2>
      <div class="home-fv__mainslider">
        <div class="swiper-wrapper">
          <?php
          if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) :  $the_query->the_post();
            $topaSlideLinkTarget = in_array('blank',(array)get_field("top-slide-link-target"));
            $target = '';
            if ( $topaSlideLinkTarget) $target = 'target="_blank"'; 
						if ($is_mobile_device):
							$slide_img = get_field('top-slide-img-sp'); 
						else:
							$slide_img = get_field('top-slide-img'); 
						endif;
          ?>
          <?php if(empty(get_field('top-slide-link'))): ?>
          <div class="swiper-slide"><img src="<?php echo $slide_img ?>"><p class="slide-text"><?php the_field('top-slide-text-sp'); ?></p></div>
          <?php else: ?>
          <div class="swiper-slide"><a href="<?php the_field('top-slide-link'); ?>" <?php echo $target; ?>><img src="<?php echo $slide_img; ?>"><p class="slide-text"><?php the_field('top-slide-text-sp'); ?></p></a></div>
          <?php endif; ?>
          <?php
            endwhile; endif;
          ?>
        </div>
      </div>
      <div class="home-fv__mainslider-thumb">
        <div class="swiper-wrapper">
          <?php
          $cnt = 1;
          if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) :  $the_query->the_post();
            $topaSlideLinkTarget = in_array('blank',(array)get_field("top-slide-link-target"));
            $target = '';
            if ( $topaSlideLinkTarget) $target = 'target="_blank"'; 
          ?>
            <div class="swiper-slide"><a data-slide-index="<?php echo $cnt; ?>" href="<?php the_field('top-slide-link'); ?>" <?php echo $target; ?>><img src="<?php the_field('top-slide-img'); ?>"></a></div>
          <?php
              $cnt++;
            endwhile; endif;
          ?>
        </div>
        <div class="fv-button-prev"></div>
        <div class="fv-button-next"></div>
      </div>
    </div>
	</div>
</div>

<div class="fixed-side-btn js-fixed-btn-01 is-show">
	<a href="<?php echo esc_url(home_url('/')); ?>consult">
		<p><span>まるっとお任せ</span><span>専門家に相談する</span></p>
	</a>
</div>

<div class="chat">
	<a href="/consult/" class="chat__info" style="display:none;">
		<span class="chat__label">お任せ!</span>
		<span class="chat__text">施設探しのプロが<br>あなたの施設探しをお手伝い</span>
	</a>
	<a href="/consult/" class="chat__button" style="display:none;"><img src="/co-mit_renew_201910/img/icon_chat.svg" alt="相談する"></a>
</div>

<div class="smartbar">
	<div class="l-wrapper smartbar__wrapper">
		<p class="header-logo header-logo-comi"><img src="/co-mit_renew_201910/img/logo_color.png" srcset="/co-mit_renew_201910/img/logo_color.png 1x, /co-mit_renew_201910/img/logo_color@2x.png 2x" alt="CO-MIT"></p>
		<div class="smartbar__content">
			<div class="search search--bar js-pulldown-filter search--bar-2" >
				<select name="" id="" class="search__select search__select--area  search__select search__select--area-width">
					<option value=""></option>
					<option value="hokkaido_tohoku">北海道・東北</option>
					<option value="hokuriku_koshinetsu">北陸・甲信越</option>
					<option value="kanto">関東</option>
					<option value="chubu_tokai">中部・東海</option>
					<option value="kansai">関西</option>
					<option value="chugoku_shikoku">中国・四国</option>
					<option value="kyushu_okinawa">九州・沖縄</option>
				</select>
				<select name="" id="" class="search__select search__select--people search__select--people-width">
					<option value=""></option>
					<option value="1">20名未満</option>
					<option value="20">20～49名</option>
					<option value="50">50～99名</option>
					<option value="100">100～199名</option>
					<option value="200">200名以上</option>
				</select>

				    <a class="button button--sm-search" href="/facility/">施設を探す</a>
          <!-- </div> -->

            <div class="navi__favorite-2">

              <a href="/favorite" class="sp-favorite__btn js-favorite-sp-btn pc-favorite__btn-1">
                <i class="icon-favarite"></i>
                <span>検討リスト（0）</span>
              </a>
            </div>
          <!-- </div> -->

        <!-- </div> -->

    </div>

			<!-- </div> -->
			<a href="#" class="sp-menu-btn sp-menu-btn--pc"><span>メニューを開く</span><span></span><span></span></a>
		</div>
	</div>
</div>

	<div class="home-content swiper-root">
    <div class="swiper-frame">
		<div class="banner-swiper-button-prev pc-only"></div>
		<div class="banner-swiper-button-next pc-only"></div>
    <div class="swiper-container--banner">
	    <div class="swiper-wrapper">

				<?php
					$args = array(
							'posts_per_page'   => 5,
							'orderby'          => 'DESC',
							'post_type'        => 'top-banner',
							'post_status'      => 'publish',
					);
					$the_query = new WP_Query( $args );

					if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) :  $the_query->the_post();
				?>
				<?php
					$topBannerPC = get_field("top-banner-pc");
					$topBannerSP = get_field("top-banner-sp");
					$topBannerLink = get_field("top-banner-link");
					$topBannerLinkTarget = in_array('blank',(array)get_field("top-banner-link-target"));
					$topBannerAlt = get_field("top-banner-alt");
				?>
				<div class="banner-1 swiper-slide">
					<?php if( $topBannerLink ): ?>
					<a class="top-banner-link" href="<?php echo $topBannerLink; ?>" <?php if($topBannerLinkTarget) { echo 'target="_blank"'; } ?>>
					<?php endif; ?>
					<?php if( $topBannerSP ): ?>
						<img src="<?php echo $topBannerPC ?>" alt="<?php if($topBannerAlt) { echo $topBannerAlt; } ?>" class="pc-only" width="100%" height="100%">
						<img src="<?php echo $topBannerSP ?>" alt="<?php if($topBannerAlt) { echo $topBannerAlt; } ?>" class="sp-only" width="100%" height="100%">
					<?php else: ?>
						<img src="<?php echo $topBannerPC ?>" alt="<?php if($topBannerAlt) { echo $topBannerAlt; } ?>">
					<?php endif; ?>
					<?php if( $topBannerLink ): ?>
					</a>
					<?php endif; ?>
				</div>
				<?php
					endwhile; endif;
					wp_reset_postdata();
				?>
			</div>
			<div class="swiper-pagination"></div>
		</div>
		</div>

	</div>

	<div class="l-wrapper">
	<?php
		// 指定日数以内の投稿にNEWマークを表示する
		$days = 31;
		$today = date_i18n('U');
	?>

	<div class="home-content js-fixed-btn-01__end">
		<div class="heading-6">
			<span class="heading-6__sub">RECOMMEND</span>
			<h2 class="heading-6__main">新人研修でオススメの研修施設</h2>
		</div>
		<div class="l-wide swiper-reccomend">
			<div class="swiper-container swiper-container--facility">
				<div class="swiper-wrapper">

				<?php
					$the_query = new WP_Query( array(
						"post_type" => "facility",
						"post_status" => "publish",
						"feature" => "new-member",
						'orderby' => 'rand',
						"posts_per_page" => 5
					));
					if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
				?>
					<section class="swiper-slide facility-list-2">
						<div class="facility-list-2__inner">
							<div class="facility-list-2__content">
								<a href="<?php the_permalink(); ?>"></a>
								<div class="facility-list-2__sub">
									<?php
										$attachment_id = get_field('facility_listimage');
									?>
									<div class="facility-list-2__image">
										<picture>
											<img src="<?php echo wp_get_attachment_image_url($attachment_id,$thumb_size); ?>" alt="<?php the_title() ?>" width="361px" height="227px">
										</picture>
									</div>
									<?php
										// 指定日数以内の投稿にNEWマークを表示する
										$entry_day = get_the_time('U');
										$keika = date('U',($today - $entry_day)) / 86400;
									?>
									<?php if ( $days > $keika ): ?><p class="facility-list-2__new"><img src="/co-mit_renew_201910/img/icon_new.png"></p><?php endif; ?>
									<?php if( get_field('facility_360url') ): ?><p class="facility-list-2__360"><img src="/co-mit_renew_201910/img/icon_360.png" alt="" width="100%" height="100%"></p><?php endif; ?>
									<p class="facility-list-2__label"><?php the_field('facility_area'); ?></p>
									<!--
									<ul class="facility-list-2__tag">
										<?php
										$tags = get_the_terms($post->ID, "feature");
										$tag_count_ = 0;
										foreach ($tags as $tag) {
											echo "<li>".$tag -> name."</li>";
											if ($tag_count_ == 2) { break; }
											$tag_count_++;
										}
										?>
									</ul>
									-->
								</div>
								<div class="facility-list-2__main">
									<div class="facility-list-2__info">
										<span class="facility-list-2__area"><?php the_field('facility_icon'); ?></span>
									</div>
									<h3 class="facility-list-2__name"><?php the_title() ?></h3>
									<p class="facility-list-2__text"><?php echo nl2br(get_field('facility_pr_short')); ?></p>
									<div class="facility-list-2__favorite js-favorite" data-facility-id="<?php the_ID(); ?>">
										<p class="facility-list-2__favorite__text"><span>検討リストに追加する</span><span>検討リスト解除</span></p>
									</div>
								</div>
							</div>
							<div class="facility-list-2__favorite-2 js-favorite" data-facility-id="<?php the_ID(); ?>">
								<p class="facility-list-2__favorite-2__text"><span>検討リストに追加する</span><span>検討リスト解除</span></p>
							</div>
						</div>
					</section>
				<?php endwhile; endif; ?>
				 <div class="swiper-slide facility-list-2__more"><a href="<?php echo esc_url(home_url('/')); ?>?post_type=facility&s=&post_tag%5B%5D=new-member">もっと見る</a></div>
				</div>
			</div>
			<div class="swiper-button-next"></div>
		</div>
	</div>

	<div class="home-content">
		<div class="heading-6">
			<span class="heading-6__sub">RECOMMEND</span>
				<h2 class="heading-6__main">BBQができる研修施設</h2>
		</div>
		<div class="l-wide swiper-reccomend02">
			<div class="swiper-container swiper-container--facility-02">
				<div class="swiper-wrapper">

				<?php
					$the_query = new WP_Query( array(
						"post_type" => "facility",
						"post_status" => "publish",
						"feature" => "BBQ",
						'orderby' => 'rand',
						"posts_per_page" => 5
					));
					if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
				?>

					<section class="swiper-slide facility-list-2">
						<div class="facility-list-2__inner swiper-slide__height02">
							<div class="facility-list-2__content">
								<a href="<?php the_permalink(); ?>"></a>
								<div class="facility-list-2__sub">
									<?php
										$attachment_id = get_field('facility_listimage');
									?>
									<div class="facility-list-2__image">
										<picture>
											<img src="<?php echo wp_get_attachment_image_url($attachment_id,$thumb_size); ?>" alt="<?php the_title() ?>" width="361px" height="227px">
										</picture>
									</div>
									<?php
										// 指定日数以内の投稿にNEWマークを表示する
										$entry_day = get_the_time('U');
										$keika = date('U',($today - $entry_day)) / 86400;
									?>
									<?php if ( $days > $keika ): ?><p class="facility-list-2__new"><img src="/co-mit_renew_201910/img/icon_new.png"></p><?php endif; ?>
									<?php if( get_field('facility_360url') ): ?><p class="facility-list-2__360"><img src="/co-mit_renew_201910/img/icon_360.png" alt="" width="100%" height="100%"></p><?php endif; ?>
									<p class="facility-list-2__label"><?php the_field('facility_area'); ?></p>
									<!--
									<ul class="facility-list-2__tag">
										<?php
										$tags = get_the_terms($post->ID, "feature");
										$tag_count_ = 0;
										foreach ($tags as $tag) {
											echo "<li>".$tag -> name."</li>";
											if ($tag_count_ == 2) { break; }
											$tag_count_++;
										}
										?>
									</ul>
									-->
								</div>
								<div class="facility-list-2__main">
								<div class="facility-list-2__info">
									<span class="facility-list-2__area"><?php the_field('facility_icon'); ?></span>
								</div>
								<h3 class="facility-list-2__name"><?php the_title() ?></h3>
								<p class="facility-list-2__text"><?php echo nl2br(get_field('facility_pr_short')); ?></p>
								<div class="facility-list-2__favorite js-favorite" data-facility-id="<?php the_ID(); ?>">
									<p class="facility-list-2__favorite__text"><span>検討リストに追加する</span><span>検討リスト解除</span></p>
								</div>
							</div>
							</div>
							<div class="facility-list-2__favorite-2 js-favorite" data-facility-id="<?php the_ID(); ?>">
								<p class="facility-list-2__favorite-2__text"><span>検討リストに追加する</span><span>検討リスト解除</span></p>
							</div>
						</div>
				</section>
				<?php endwhile; endif; ?>
					<div class="swiper-slide facility-list-2__more"><a href="<?php echo esc_url(home_url('/')); ?>?post_type=facility&s=&post_tag%5B%5D=bbq">もっと見る</a></div>
				</div>
			</div>
		<div class="swiper-button-next-02"></div>
		</div>
	</div>

	<div class="home-content">
		<div class="heading-6">
			<span class="heading-6__sub">RECOMMEND</span>
				<h2 class="heading-6__main">360°パノラマビューで見る研修施設</h2>
		</div>
		<div class="l-wide swiper-reccomend03">
			<div class="swiper-container swiper-container--facility-03">
				<div class="swiper-wrapper">

				<?php
					$the_query = new WP_Query( array(
						"post_type" => "facility",
						"post_status" => "publish",
						"feature" => "360",
						'orderby' => 'rand',
						"posts_per_page" => 5
					));
					if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
				?>

					<section class="swiper-slide facility-list-2">
						<div class="facility-list-2__inner swiper-slide__height02">
							<div class="facility-list-2__content">
								<a href="<?php the_permalink(); ?>"></a>
								<div class="facility-list-2__sub">
									<?php
										$attachment_id = get_field('facility_listimage');
									?>
									<div class="facility-list-2__image">
										<picture>
											<img src="<?php echo wp_get_attachment_image_url($attachment_id,$thumb_size); ?>" alt="<?php the_title() ?>" width="361px" height="227px">
										</picture>
									</div>
									<?php
										// 指定日数以内の投稿にNEWマークを表示する
										$entry_day = get_the_time('U');
										$keika = date('U',($today - $entry_day)) / 86400;
									?>
									<?php if ( $days > $keika ): ?><p class="facility-list-2__new"><img src="/co-mit_renew_201910/img/icon_new.png"></p><?php endif; ?>
									<?php if( get_field('facility_360url') ): ?><p class="facility-list-2__360"><img src="/co-mit_renew_201910/img/icon_360.png" alt="" width="100%" height="100%"></p><?php endif; ?>
									<p class="facility-list-2__label"><?php the_field('facility_area'); ?></p>
									<!--
									<ul class="facility-list-2__tag">
										<?php
										$tags = get_the_terms($post->ID, "feature");
										$tag_count_ = 0;
										foreach ($tags as $tag) {
											echo "<li>".$tag -> name."</li>";
											if ($tag_count_ == 2) { break; }
											$tag_count_++;
										}
										?>
									</ul>
									-->
								</div>
								<div class="facility-list-2__main">
									<div class="facility-list-2__info">
										<span class="facility-list-2__area"><?php the_field('facility_icon'); ?></span>
									</div>
									<h3 class="facility-list-2__name"><?php the_title() ?></h3>
									<p class="facility-list-2__text"><?php echo nl2br(get_field('facility_pr_short')); ?></p>
									<div class="facility-list-2__favorite js-favorite" data-facility-id="<?php the_ID(); ?>">
										<p class="facility-list-2__favorite__text"><span>検討リストに追加する</span><span>検討リスト解除</span></p>
									</div>
								</div>
							</div>
							<div class="facility-list-2__favorite-2 js-favorite" data-facility-id="<?php the_ID(); ?>">
								<p class="facility-list-2__favorite-2__text"><span>検討リストに追加する</span><span>検討リスト解除</span></p>
							</div>
						</div>
				</section>
				<?php endwhile; endif; ?>
					<div class="swiper-slide facility-list-2__more"><a href="<?php echo esc_url(home_url('/')); ?>?post_type=facility&s=&post_tag%5B%5D=360">もっと見る</a></div>
				</div>
			</div>
		<div class="swiper-button-next-03"></div>
		</div>
	</div>

	<div class="home-content">
		<div class="heading-6">
			<span class="heading-6__sub">SEARCH</span>
			<h2 class="heading-6__main">目的から探す</h2>
		</div>
		<ul class="purpose-2">
			<li class="purpose-2__item">
				<a href="<?php echo esc_url(home_url('/')); ?>purpose/concent/">
					<div class="purpose-2__image">
						<picture>
							<img src="/co-mit_renew_201910/img/ph_purpose01.jpg" alt="集中できる環境で効果的かつ効率的に学びたい" width="180px" height="180px">
						</picture>
					</div>
					<div class="purpose-2__main">
						<p class="purpose-2__heading">集中できる環境で<br>効果的かつ効率的に学びたい</p>
						<p class="purpose-2__text">新入社員研修／内定者研修／リーダー研修／リスキリング　など</p>
					</div>
				</a>
			</li>
			<li class="purpose-2__item">
				<a href="<?php echo esc_url(home_url('/')); ?>purpose/motivate/">
					<div class="purpose-2__image">
						<picture>
							<img src="/co-mit_renew_201910/img/ph_purpose02.jpg" alt="モチベーションが上がる環境で能力開発や自己成長に繋げたい" width="180px" height="180px">
						</picture>
					</div>
					<div class="purpose-2__main">
						<p class="purpose-2__heading">モチベーションが上がる環境で<br>能力開発や自己成長に繋げたい</p>
						<p class="purpose-2__text">マネジメント研修／コーチング／役員研修／幹部研修／意識改革／キャリア開発／アンガーマネジメント研修　など</p>
					</div>
				</a>
			</li>
			<li class="purpose-2__item">
				<a href="<?php echo esc_url(home_url('/')); ?>purpose/environment/">
					<div class="purpose-2__image">
						<picture>
							<img src="/co-mit_renew_201910/img/ph_purpose03.jpg" alt="いつもと違った環境でビジネスの成功に貢献したい" width="180px" height="180px">
						</picture>
					</div>
					<div class="purpose-2__main">
						<p class="purpose-2__heading">いつもと違った環境で<br>ビジネスの成功に貢献したい</p>
						<p class="purpose-2__text">キックオフミーティング／ビジョンメイキング／開発合宿　など</p>
					</div>
				</a>
			</li>
			<li class="purpose-2__item">
				<a href="<?php echo esc_url(home_url('/')); ?>purpose/incentive/">
					<div class="purpose-2__image">
						<picture>
							<img src="/co-mit_renew_201910/img/ph_purpose04_sp.jpg" alt="会社や組織、チームで相互理解する時間を作りたい" width="180px" height="180px">
						</picture>
					</div>
					<div class="purpose-2__main">
						<p class="purpose-2__heading">会社や組織、チームで<br>相互理解する時間を作りたい</p>
						<p class="purpose-2__text">オフサイトミーティング／チームビルディング／ワーケーション／越境学習／インセンティブ旅行（報奨旅行）　など</p>
					</div>
				</a>
			</li>
		</ul>
	</div>
	<div class="home-content" id="hotel-type">	
		<div class="heading-6">
		<span class="heading-6__sub">SEARCH</span>
			<h2 class="heading-6__main">宿タイプから探す</h2>
		</div>

		<?php if( is_mobile() ){ ?>
		<div id="slider-search-type">
		<?php } ?>

		<ul class="search-type-list swiper-wrapper">
			<li class="swiper-slide"> 
				<a href="/?post_type=facility&s=&facility_capa=&facility_fee=&cat_hotel%5B%5D=resort_hotel" target="_blank"> <img src="/co-mit_renew_201910/img/search_resort_hotel.jpg" alt="">
        	<p class="post__title">リゾートホテル</p>
        </a>
			</li>
			<li class="swiper-slide"> 
				<a href="/?post_type=facility&s=&facility_capa=&facility_fee=&cat_hotel%5B%5D=city_hotel" target="_blank"> <img src="/co-mit_renew_201910/img/search_city_hotel.jpg" alt="">
        	<p class="post__title">シティホテル</p>
        </a>
			</li>
			<li class="swiper-slide"> 
				<a href="/?post_type=facility&s=&facility_capa=&facility_fee=&cat_hotel%5B%5D=business_hotel" target="_blank"> <img src="/co-mit_renew_201910/img/search_business_hotel.jpg" alt="">
        	<p class="post__title">ビジネス型ホテル</p>
        </a>
			</li>
			<li class="swiper-slide"> 
				<a href="/?post_type=facility&s=&facility_capa=&facility_fee=&cat_hotel%5B%5D=ryokan" target="_blank"> <img src="/co-mit_renew_201910/img/search_ryokan.jpg" alt="">
        	<p class="post__title">旅館</p>
        </a>
			</li>
			<li class="swiper-slide"> 
				<a href="/?post_type=facility&s=&facility_capa=&facility_fee=&cat_hotel%5B%5D=training_center" target="_blank"> <img src="/co-mit_renew_201910/img/search_training_center.jpg" alt="">
        	<p class="post__title">研修センター</p>
        </a>
			</li>
			<li class="swiper-slide"> 
				<a href="/?post_type=facility&s=&facility_capa=&facility_fee=&cat_hotel%5B%5D=outdoor_facilities" target="_blank"> <img src="/co-mit_renew_201910/img/search_outdoor.jpg" alt="">
        	<p class="post__title">アウトドア施設</p>
        </a>
			</li>
			<li class="swiper-slide"> 
				<a href="/?post_type=facility&s=&facility_capa=&facility_fee=&cat_hotel%5B%5D=public" target="_blank"> <img src="/co-mit_renew_201910/img/search_public.jpg" alt="">
        	<p class="post__title">公共施設</p>
        </a>
			</li>
			<li class="swiper-slide"> 
				<a href="/?post_type=facility&s=&facility_capa=&facility_fee=&cat_hotel%5B%5D=etc" target="_blank"> <img src="/co-mit_renew_201910/img/search_etc.jpg" alt="">
        	<p class="post__title">その他</p>
        </a>
			</li>
		</ul>
		<?php if( is_mobile() ){ ?>
		</div>
		<?php } ?>

	</div>

	<div class="home-content">
		<div class="heading-6">
			<span class="heading-6__sub">COLUMN</span>
			<h2 class="heading-6__main">研修ノウハウ・コラム</h2>
			<p class="heading-6__text">研修のプロが教える研修合宿のノウハウや、人事総務の方に役立つ知っておきたい労務管理情報をご紹介</p>
		</div>
		<div class="l-wide">
			<div id="slider-blog" class="swiper-container swiper-container--blog">
				<div class="swiper-wrapper">
<!-- ▼ loop ▼ -->
				<?php
					$the_query = new WP_Query( array(
						"post_type" => "column",
						"post_status" => "publish",
						"posts_per_page" => 5,
						"tax_query" => array(
							array(
								"taxonomy" => "category_column",
								"field" => "slug",
								"terms" => array("special_content"),
								"operator" => "NOT IN"
							)
						)
					));
					if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
				?>

					<section class="swiper-slide blog-list-1">
						<div class="blog-list-1__inner">
							<a href="<?php the_permalink(); ?>"></a>
							<div class="blog-list-1__sub">
								<div class="blog-list-1__image">
									<?php
										$post_id = get_the_ID();
									?>
									<?php if( $attachment_id ): ?>
										<picture>
											<img src="<?php echo get_the_post_thumbnail_url($post_id,$thumb_size); ?>" alt="" width="100%" height="100%">
										</picture>
									<?php endif; ?>
								</div>
							</div>
							<div class="blog-list-1__main">
								<h3 class="blog-list-1__title"><?php the_title(); ?></h3>
								<?php if( get_field('column_lead') ) : ?>
								<p class="blog-list-1__text"><?php echo get_field('column_lead'); ?></p>
								<?php endif; ?>
								<div class="blog-list-1__date">
									<?php
										$column_cat = get_the_terms($post_id, "category_column")[0];
										if (isset($column_cat)) :
									?>
									<div class="blog-list-1__tax">
										<div class="blog-list-1__tax-inner"><span class="icon-tag"></span><?php echo $column_cat->name; ?>	</div>
									</div>
									<?php endif; ?>
									<p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
								</div>
							</div>
						</div>
					</section>
				<?php endwhile; endif; ?>
				<div class="swiper-slide facility-list-2__more"><a href="<?php echo esc_url(home_url('/')); ?>column/">もっと見る</a></div>
				</div>
			</div>
			<div id="slider-blog-next" class="swiper-button-next-04"></div>
			<?php wp_reset_query(); ?>
		</div>
	</div>

	<div class="home-content">
		<div class="heading-6">
			<span class="heading-6__sub">SPECIAL</span>
			<h2 class="heading-6__main">特集</h2>
		</div>
    <ul class="special-banner">
      <?php
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'top-special-banner',
            'post_status'      => 'publish',
            'meta_key' => 'order_num', //カスタムフィールド名
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        );
        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) :  $the_query->the_post();
      ?>
      <?php
        $special_img = get_field("top-banner-img");
        $special_link = get_field("top-banner-link");
        $special_target = in_array('blank',(array)get_field("top-banner-link-target"));
      ?>
        <li>
          <a href="<?php echo $special_link; ?>" <?php if($special_target) { echo 'target="_blank"'; } ?>>
            <img src="<?php echo $special_img ?>">
          </a>
        </li>
      <?php
        endwhile; endif;
        wp_reset_postdata();
      ?>
    </ul>
    <a href="/category_column/special_content/" class="button">特集一覧はこちら</a>
    <?php /*
		<div class="l-wide js-autoheight">
			<div id="slider-special" class="swiper-container swiper-container--blog">
				<div class="swiper-wrapper">
<!-- ▼ loop ▼ -->
				<?php
					$the_query = new WP_Query( array(
						"post_type" => "column",
						"post_status" => "publish",
						"posts_per_page" => 5,
						"tax_query" => array(
							array(
								"taxonomy" => "category_column",
								"field" => "slug",
								"terms" => array("special_content"),
								"operator" => "IN"
							)
						)
					));
					if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
				?>

					<section class="swiper-slide blog-list-1">
						<div class="blog-list-1__inner js-autoheight-target">
							<a href="<?php the_permalink(); ?>"></a>
							<div class="blog-list-1__sub">
								<div class="blog-list-1__image">
									<?php
										$post_id = get_the_ID();
									?>
									<?php if( $attachment_id ): ?>
										<picture>
											<img src="<?php echo get_the_post_thumbnail_url($post_id,$thumb_size); ?>" alt="" width="100%" height="100%">
										</picture>
									<?php endif; ?>
								</div>
							</div>
							<div class="blog-list-1__main">
								<h3 class="blog-list-1__title"><?php the_title(); ?></h3>
								<div class="blog-list-1__date">
									<?php
										$column_cat = get_the_terms($post_id, "category_column")[0];
										if (isset($column_cat)) :
									?>
									<div class="blog-list-1__tax">
										<div class="blog-list-1__tax-inner"><span class="icon-tag"></span><?php echo $column_cat->name; ?>	</div>
									</div>
									<?php endif; ?>
									<p class="date"><span class="icon-clock"></span><?php the_time('Y.n.j'); ?></p>
								</div>
							</div>
						</div>
					</section>
				<?php endwhile; endif; ?>
				<div class="swiper-slide js-autoheight-target facility-list-2__more"><a href="<?php echo esc_url(home_url('/')); ?>/category_column/special_content/">もっと見る</a></div>
				</div>
			</div>
			<div id="slider-special-next" class="swiper-button-next-04 js-autoheight-target"></div>
			<?php wp_reset_query(); ?>
		</div>
    */ ?>
	</div>
</div>

<div class="home-news">
	<div class="l-wrapper">
		<h2 class="home-news__heading">お知らせ</h2>
		<div class="home-news__main">
			<ul class="news-list-1">

				<?php
					$the_query = new WP_Query( array(
						"post_type" => "post",
						"post_status" => "publish",
						"posts_per_page" => 10
					));
					if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
				?>
							<li class="news-list-1__item">
								<div class="news-list-1__item__left">
									<span class="news-list-1__date"><?php the_date('Y.m.d', '<time> ', ' </time>'); ?></span>
								</div>
								<?php $cat = get_the_category($post->ID); ?>
								<?php if ($cat): ?>
								<?php
									$catColor = "";
									if ( $cat[0]->slug == 'feature' ) { $catColor = "color-feature"; }
									if ( $cat[0]->slug == 'event' ) { $catColor = "color-event"; }
									if ( $cat[0]->slug == 'notice' ) { $catColor = "color-notice"; }
									if ( $cat[0]->slug == 'add' ) { $catColor = "color-add"; }
									if ( $cat[0]->slug == 'add-column' ) { $catColor = "color-add-column"; }
								?>
								<div class="news-list-1__item__center">
									<p class="news-list-1__item__cat news-list-1__item__cat--<?php echo $catColor ?>"><?php echo (@$cat[0] ? $cat[0]->name : ""); ?></p>
								</div>
								<?php endif; ?>
								<div class="news-list-1__item__right">
									<span class="news-list-1__title"><?php the_title(); ?></span>
									<span class="news-list-1__text"><?php echo nl2br(the_content()); ?></span>
								</div>
							</li>
							<?php endwhile;?>
					<?php else : ?>
				<?php endif; ?>

			</ul>
		</div>
	</div>
</div>


<?php get_footer(); ?>
