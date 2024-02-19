<?php get_header(); ?>

<div id="favorite" class="l-wrapper">
	<div class="favorite-content">
		<h2 class="section-title"><span class="section-title-en">FAVORITE</span><img src="/co-mit_renew_201910/img/icon_star.png"><span class="section-title-ja">検討リスト</span></h2>
		<?php
			//配列準備
    if(isset($_COOKIE["co-mitFavoriteList"])){
			$favoriteList = $_COOKIE["co-mitFavoriteList"];
			$favoriteList = ltrim($favoriteList, '[\"');
			$favoriteList = rtrim($favoriteList, '\"]');
			$favoriteList = str_replace('\"', '', $favoriteList);
			$favoriteList = explode(',', $favoriteList);
    }else{
        $favoriteList = [0];
    }
			$args = array(
				'posts_per_page'   => 999,
				'post_type'        => 'facility',
				'post_status'      => 'publish',
				'order'            => 'ASC',
				'post_status'      => 'publish',
				'post__in'         => $favoriteList
			);
			$the_query = new WP_Query( $args );

			if ( $the_query->have_posts() ){
		?>
		<label class="f-check-2 sp-only">
			<input type="checkbox" class="js-all-check">
			<span>まとめてチェック</span>
		</label>
		<div class="f-table">
			<div class="f-table__row">
				<div class="f-table__cell">
					<label class="f-check-2">
						<input type="checkbox" class="js-all-check">
						<span>まとめてチェック</span>
					</label>
				</div>
				<div class="f-table__cell">施設名</div>
				<div class="f-table__cell">エリア</div>
				<div class="f-table__cell">料金目安<br>（大人1人あたり）</div>
				<div class="f-table__cell">宿泊可能人数</div>
				<div class="f-table__cell">会場面積</div>
				<div class="f-table__cell">施設概要</div>
			</div>
			<?php
				while ( $the_query->have_posts() ) {
				$the_query->the_post();
			?>
			<div class="f-table__row">
				<div class="f-table__cell">
					<div class="f-table__cell__inner">
						<label>
						<input type="checkbox" class="f-check js-check-target" data-facility-id="<?php the_ID(); ?>">
						<div class="f-image"><img src="<?php
					if( $attachment_id = get_field('facility_listimage') ):
						echo wp_get_attachment_image_url($attachment_id,'medium');
					else :
						echo 'http://placehold.jp/60/00b2b0/ffffff/861x541.png?text=NOW%20PRINTING';
					endif;
				?>" alt=""></div></label>
						<div class="f-box">
							<div class="f-box__column2">
								<div class="f-box__image"><img src="<?php
					if( $attachment_id = get_field('facility_listimage') ):
						echo wp_get_attachment_image_url($attachment_id,'medium');
					else :
						echo 'http://placehold.jp/60/00b2b0/ffffff/861x541.png?text=NOW%20PRINTING';
					endif;
				?>" alt=""></div>
								<p class="f-box__title"><a href="<?php the_permalink(); ?>" target="_blank"><?php echo get_the_title(); ?></a></p>
							</div>
							<div class="f-box__inner">
								<ul class="f-box__list">
									<li><span>エリア</span><br><?php the_field('facility_area'); ?></li>
									<li><span>料金目安<span>（大人1人あたり）</span></span><br><?php if ( get_field('facility_fee')){ echo '¥'. number_format(get_field('facility_fee')) . '～'; } else { echo 'お問い合わせください'; }?></li>
									<li><span>宿泊可能人数</span><br><?php
			$group_name = get_field('facility_capa');
			if( $group_name['facility_capa_min'] || $group_name['facility_capa_max'] ):
				echo empty($group_name['facility_capa_min']) ? "" : "{$group_name['facility_capa_min']}名";
				echo '～';
				echo empty($group_name['facility_capa_max']) ? "" : number_format($group_name['facility_capa_max'])."名";
			else:
				echo 'お問い合わせください';
			endif;?></li>
									<li><span>会場面積</span><br><?php if ( get_field('facility_kaijyo') ){ echo get_field('facility_kaijyo'); } else { echo 'お問い合わせください'; }?></li>
								</ul>
								<p class="f-box__text"><span>施設概要</span><?php echo nl2br(get_field('facility_pr_short')); ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="f-table__cell"><a href="<?php the_permalink(); ?>" target="_blank"><?php echo get_the_title(); ?></a></div>
				<div class="f-table__cell"><?php the_field('facility_area'); ?></div>
				<div class="f-table__cell"><?php if ( get_field('facility_fee')){ echo '¥'. number_format(get_field('facility_fee')) . '～'; } else { echo 'お問い合わせください'; }?></div>
				<div class="f-table__cell"><?php
			$group_name = get_field('facility_capa');
			if( $group_name['facility_capa_min'] || $group_name['facility_capa_max'] ):
				echo empty($group_name['facility_capa_min']) ? "" : "{$group_name['facility_capa_min']}名";
				echo '～';
				echo empty($group_name['facility_capa_max']) ? "" : number_format($group_name['facility_capa_max'])."名";
			else:
				echo 'お問い合わせください';
			endif;?></div>
				<div class="f-table__cell"><?php if ( get_field('facility_kaijyo') ){ echo get_field('facility_kaijyo'); } else { echo 'お問い合わせください'; }?></div>
				<div class="f-table__cell"><?php echo nl2br(get_field('facility_pr_short')); ?></div>
			</div>
		<?php
			}
			wp_reset_postdata();
		?>
		</div>
		<div class="f-delete">
			<p class="js-check-delete">チェックした施設を削除</p>
		</div>
		<div class="f-balloon__outer"><p class="f-balloon">上記の会場が少しでも気になる方へ。<br class="sp-only">まずは カンタン無料問い合わせ！</p></div>
		<div class="f-submit">
			<button class="button" onclick="location.href='<?php echo esc_url(home_url('/')); ?>inquiry_multi/'"><span>まとめて問い合わせする</span></button>
		</div>
		<?php
			} else {
		?>
		<p class="f-text">施設が検討リストにありません。</p>
    <div class="favorite-list-example">
      <p class="favorite-list-example-txt favorite-list-example-txt1">
        気になる施設を検討リストに登録しておくと、<br>あとで検討リストからまとめて比較検討<br class="sp">・確認・問い合わせができます
      </p>
      <h3 class="favorite-list-example-txt favorite-list-example-txt2">
        検討リストを活用して、気になる施設にまとめて無料問い合わせ！
      </h3>
      
      <div class="favorite-list-example-box1">
      <img src="/co-mit_renew_201910/img/favorite-list-example-1.jpg" alt="" class="favorite-list-example-1 pc">
      <img src="/co-mit_renew_201910/img/favorite-list-example-sp-1.jpg" alt="" class="favorite-list-example-1 sp">
      
      <div class="favorite-list-example-com comment1">
        <p class="favorite-list-example-com1">
          自分だけの施設の気になるリストが<br class="pc">簡単に作成<br class="sp">できます！
        </p>
        <p class="favorite-list-example-com1">
          表でまとめられるので<br class="pc">確認・比較が簡単です♪
        </p>
        <p class="favorite-list-example-com1">
          また、検討リストの施設へ<br class="pc">同じ内容で問い合わせも<br class="sp">できるので<br class="pc">無駄な手間が<br class="sp">省けます。
        </p>
      </div>
      </div>
      
      <h3 class="favorite-list-example-txt favorite-list-example-txt3">
        検討リストへの追加方法
      </h3>
      
      <div class="favorite-list-example-box1">
      <div class="favorite-list-example-flex">
        <img src="/co-mit_renew_201910/img/favorite-list-example-2.jpg" alt="" class="favorite-list-example-2 pc">
        <img src="/co-mit_renew_201910/img/favorite-list-example-2-sp.jpg" alt="" class="favorite-list-example-2 sp">
        <img src="/co-mit_renew_201910/img/favorite-list-example-3.jpg" alt="" class="favorite-list-example-3 pc">
        <!-- <img src="/co-mit_renew_201910/img/favorite-list-example-sp-2.jpg" alt="" class="favorite-list-example-3 sp"> -->
      </div>
      
      <div class="favorite-list-example-com comment2 pc">
        <img src="/co-mit_renew_201910/img/icon_favorite_full.png">
        <p class="favorite-list-example-com2">
          色が点いたら<br>追加完了！
        </p>
      </div>
    
        
      <div class="favorite-list-example-com comment4 sp">
        
        <div class="favorite-list-example-flex">
          <img src="/co-mit_renew_201910/img/favorite-list-example-4-sp.jpg" alt="" class="favorite-list-example-5">
          
          <p class="favorite-list-example-com4">
            検討リスト解除に<br>なったら追加完了！
          </p>
        </div>
      </div>
      </div>
      
      <div class="favorite-list-example-box1">
        <img src="/co-mit_renew_201910/img/favorite-list-example-3.jpg" alt="" class="favorite-list-example-3 sp">
      <div class="favorite-list-example-com comment3">
        <div class="favorite-list-example-flex">
          <img src="/co-mit_renew_201910/img/favorite-list-example-4.jpg" alt="" class="favorite-list-example-4 pc">
          <p class="favorite-list-example-com4 pc">
            検討リスト追加済みに<br>なったら追加完了！
          </p>
          
          <p class="favorite-list-example-com4 sp">
            検討リストに追加しました。<br>が出たら追加完了！
          </p>
        </div>
      </div>
      </div>
    
      <h3 class="favorite-list-example-txt favorite-list-example-txt4">
        検討リストを活用して、気になる施設へらくらく問い合わせ！
      </h3>
      <a class="button favorite-list-example-btn" href="/facility/">施設を探す</a>
    
    </div>
		<?php
			}
		?>

	</div>




</div>

<?php get_footer(); ?>