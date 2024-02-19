<?php $plan_type = get_field('plan'); ?>
<?php 
$premium_class = '';
	if(!empty(get_field('plan2_premium_position'))){
		if(in_array('enable', get_field('plan2_premium_position'))){ 
			$premium_class = 'premium_frame';
		}	
	}
?>
<?php
	// 指定日数以内の投稿にNEWマークを表示する
	$days = 31;
	$today = date_i18n('U');
?>
<section class="facility-list-1 <?php echo $premium_class; ?>">
	<div class="facility-list-1__main">
		<a href="<?php the_permalink(); ?>" target="_blank">
			<?php
				// 指定日数以内の投稿にNEWマークを表示する
				$entry_day = get_the_time('U');
				$keika = date('U',($today - $entry_day)) / 86400;
			?>
			<?php if ( $days > $keika ): ?><p class="facility-list-1__new"><img src="/co-mit_renew_201910/img/icon_new.png"></p><?php endif; ?>
			<?php if( get_field('facility_360url') ): ?><p class="facility-list-1__360"><img src="/co-mit_renew_201910/img/icon_360.png" alt=""></p><?php endif; ?>

			<?php
			 $max = 4;//施設一覧サブイメージ数
			 $subImgArry = array();
			 $subDataArry = array();
			 $subImgBox = "";
			 for($counter = 1; $counter <= $max; $counter++){
				 $subImgArry []= 'facility_listsubimage'.$counter;
				 $subDataArry []= get_field('facility_listsubimage'.$counter);
			 }
			$aryFilter = array_filter($subDataArry);

			?>
			<?php if( !empty($aryFilter) ): ?>
				<div class="swiper-container facility_listimageSlide">
					<div class="swiper-wrapper">
			<?php endif; ?>

			<div class="facility-list-1__image swiper-slide">
				<img src="<?php
				if( $attachment_id = get_field('facility_listimage') ):
					echo wp_get_attachment_image_url($attachment_id,'large');
				else :
					echo 'http://placehold.jp/60/00b2b0/ffffff/861x541.png?text=NOW%20PRINTING';
				endif;
				?>" alt="" width="100%" height="100%">
			</div>

			<?php
				$filed = "";
				foreach ($subImgArry as $value){
					if( get_field($value) ){
						$filed = get_field($value);
echo <<<EOT
<div class="facility-list-1__image swiper-slide">
<img src="$filed" alt="" width="100%" height="100%">
</div>
EOT;
					}
				}
			?>

			<?php if( !empty($aryFilter) ): ?>
				</div>
					<div class="swiper-pagination"></div>
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				</div>
			<?php endif; ?>

			<p class="facility-list-1__label"><?php the_field('facility_area'); ?></p>
		</a>
		<div class="facility-list-1__content">
			<div class="facility-list-1__favorite js-favorite" data-facility-id="<?php the_ID(); ?>">
				<p class="facility-list-1__favorite__text"><span>クリックで追加</span><span>検討リスト解除</span></p>
			</div>
			<a href="<?php the_permalink(); ?>" target="_blank">
				<div class="facility-list-1__info">
					<span class="facility-list-1__icon"><?php the_field('facility_icon'); ?></span>
				</div>
				<h2 class="facility-list-1__name"><?php echo get_the_title(); ?></h2>
				<p class="facility-list-1__text"><?php echo nl2br(get_field('facility_pr_short')); ?></p>
			</a>
				<?php if ($terms = get_the_terms($post->ID, 'feature')) {
					echo '<ul class="facility-tag">';

					$count_feature = 0;
					foreach ( $terms as $term ) {
						if (is_mobile() && $count_feature === 5) break;
						elseif ( !is_mobile() && $count_feature === 12) break;

						echo '<li><a href="/feature/';
						echo esc_html($term -> slug);
						echo '/">';
						echo esc_html($term -> name);
						echo '</a></li>';
						++$count_feature;
					}
					echo '</ul>';
				}?>
			<?php if ( get_field('facility_pro-comment_list') ): ?>
			<div class="voice">
				<?php if ( $plan_type!='light' ): ?>
				<div class="voice__image">
					<?php
						global $loopcounter;
						$is_even = $loopcounter%2 === 1;
						$person_src = "/co-mit_renew_201910/img/img_person_0" . ($is_even ? "1" : "2") . ".jpg";
					?>
					<img src="<?php echo $person_src; ?>" alt="">
				</div>
				<p class="voice__text"><?php echo nl2br(get_field('facility_pro-comment_list')); ?></p>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php if ( get_field('facility_plan') ): ?>
	<div class="facility-list-1__recommend-plan">
		<?php $recommednd_plan = get_field('facility_plan')[0] ; ?>
		<div class="facility-list-1__recommend-plan__inner">
				<div class="facility-list-1__recommend-plan__head">おすすめプラン</div>
				<div class="facility-list-1__recommend-plan__content">
					<a href="<?php the_permalink(); ?>#recommend-plan" target="_blank"><?php echo $recommednd_plan["facility_plan_title"]; ?>
						<?php if ($recommednd_plan["facility_plan_price"] !== "0") : ?>
						<br class="sp-only">
						１名：<?php echo number_format($recommednd_plan["facility_plan_price"]) . '円～'; ?>
						<?php endif;?>
						&nbsp;<span class="icon-new-tab"></span>
					</a>
				</div>
		</div>
	</div>
	<?php endif; ?>
	<div class="facility-list-1__sub">
		<dl class="facility-list-1__detail">
			<dt class="facility-list-1__detail__head">エリア</dt>
			<dd class="facility-list-1__detail__content"><?php the_field('facility_area'); ?></dd>
		</dl>
		<dl class="facility-list-1__detail">
			<dt class="facility-list-1__detail__head">
				料金目安
				<a href="#modelcase-modal" class="js-modal-open"><img src="/co-mit_renew_201910/img/icon_question.png"></a>
			</dt>
			<dd class="facility-list-1__detail__content"><?php if ( get_field('facility_fee')){ echo '大人1名：¥'. number_format(str_replace('～','',get_field('facility_fee'))) . '～'; } else { echo 'お問い合わせください'; }?></dd>
		</dl>
		<dl class="facility-list-1__detail">
			<dt class="facility-list-1__detail__head">宿泊可能人数</dt>
			<dd class="facility-list-1__detail__content"><?php
			$group_name = get_field('facility_capa');
			if( $group_name['facility_capa_min'] || $group_name['facility_capa_max'] ):
				echo empty($group_name['facility_capa_min']) ? "" : "{$group_name['facility_capa_min']}名";
				echo '～';
				echo empty($group_name['facility_capa_max']) ? "" : number_format(str_replace('名','',$group_name['facility_capa_max']))."名";
			else:
				echo 'お問い合わせください';
			endif;?></dd>
		</dl>
		<dl class="facility-list-1__detail">
			<dt class="facility-list-1__detail__head">会場面積</dt>
			<dd class="facility-list-1__detail__content"><?php if ( get_field('facility_kaijyo') ){ echo get_field('facility_kaijyo'); } else { echo 'お問い合わせください'; }?></dd>
		</dl>
		<dl class="facility-list-1__detail">
      <a href="<?php the_permalink(); ?>" target="_blank" class="button--arrow">施設の詳細を見る</a>
		</dl>
	</div>
	<div class="facility-list-1__favorite-2 js-favorite" data-facility-id="<?php the_ID(); ?>">
		<p class="facility-list-1__favorite-2__text"><span>検討リストに追加する</span><span>検討リスト解除</span></p>
	</div>
</section>
