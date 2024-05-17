<?php get_header(); ?>


<?php // 投稿タイプを指定して親の投稿一覧を表示
	if (! (isset($term)) ) { $term = null; }
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	// $comit_posts_per_page = 50;
	$comit_posts_per_page = -1;
	$post_type_slug = 'facility'; // 投稿タイプのスラッグを指定
	$taxonomies = $taxonomy_slug = get_query_var('taxonomy');
	$args_temp = array(
		//'order'   => 'DESC',
		'post_type' => $post_type_slug, // 投稿タイプを指定
		'taxonomy' => $taxonomies,
		'term' => $term,
		'posts_per_page'=> $comit_posts_per_page,
		'paged' => $paged,
		'no_found_rows' => true,
		'post_parent' => 0 // 親を持たない投稿を取得
	);

	$query_premium = get_posts(array_merge( $args_temp, array( // プレミアムポジション枠
			'meta_key' => 'plan',
			'meta_value' => 'normal',
			'orderby' => 'rand',
			'meta_query' => array(
				array(
					'key'     => 'plan2_premium_position',
					'value'   => 'enable',
					'compare' => 'LIKE',
				)
			)
	) ));
	wp_reset_postdata();

	$query_normal = get_posts(array_merge( $args_temp, array( //スタンダード
			'meta_key' => 'plan',
			'meta_value' => 'normal',
			'orderby' => 'rand',
			'meta_query' => array(
				array(
					'key'     => 'plan2',
					'value'   => 'incentive-fee',
					'compare' => 'NOT LIKE',
				),
				array(
					'key'     => 'plan2',
					'value'   => 'lowrate',
					'compare' => 'NOT LIKE',
				),
				array(
					'key'     => 'plan2_premium_position',
					'value'   => 'enable',
					'compare' => 'NOT LIKE',
				),
        'relation' => 'AND'
			)
	) ));
	wp_reset_postdata();

	$query_incentive = get_posts(array_merge( $args_temp, array( //成果報酬
			'meta_key' => 'plan',
			'meta_value' => 'normal',
			'orderby' => 'rand',
			'meta_query' => array(
				array(
					'key'     => 'plan2',
					'value'   => 'incentive-fee',
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'plan2',
					'value'   => 'lowrate',
					'compare' => 'LIKE',
				),
        'relation' => 'OR'
			)
	) ));
	wp_reset_postdata();

	$args_light_plan = get_posts(array_merge( $args_temp, array( //ライトプラン
			'meta_key' => 'plan',
			'meta_value' => 'light',
			'orderby' => 'rand',
			'meta_query' => array(
				array(
					'key'     => 'plan2',
					'value'   => 'incentive-fee',
					'compare' => 'NOT LIKE',
				),
				array(
					'key'     => 'plan2',
					'value'   => 'lowrate',
					'compare' => 'NOT LIKE',
				),
        'relation' => 'AND'
			)
	) ));

$query = array_merge($query_premium, $query_normal, $query_incentive, $args_light_plan);
$get_num = count($query);
$all_num = $get_num;//全件数
//$max_page = $query->max_num_pages;

?>

<?php get_template_part('var/modelcase-modal'); ?>


<div class="fixed-side-btn js-fixed-btn-02">
	<a href="<?php echo esc_url(home_url('/')); ?>consult">
		<p><span>まるっとお任せ</span><span>専門家に相談する</span></p>
	</a>
</div>

<div class="l-wrapper">
  <div class="search-number">
		<?php if ( is_tax('purpose') ): ?>
			<h1 class="heading-4">
				<small>
				<?php if ( $term == 'concent' ): 
						echo '新入社員研修／内定者研修／リーダー研修／リスキリング　など';
					elseif ( $term == 'motivate' ): 
						echo 'マネジメント研修／役員研修／幹部研修／キャリア開発　など';
					elseif ( $term == 'environment' ): 
						echo 'キックオフミーティング／ビジョンメイキング／開発合宿　など';
					elseif ( $term == 'incentive' ): 
						echo 'オフサイトミーティング／チームビルディング／インセンティブ旅行（報奨旅行）　など';
					endif; ?>
				</small><br>
				<?php echo $term_name = single_term_title( '', false ); ?>　におすすめな施設一覧
			</h1>
			<div class="heading-4">:<?php echo $all_num; ?>件</div>
		<?php else: ?>
 	  	<h1 class="heading-4"><?php if ( is_tax('area') || is_tax('feature') || is_tax('hotel_type')): ?><?php echo $term_name = single_term_title( '', false ); ?>で<?php endif; ?>おすすめの研修施設一覧</h1><div class="heading-4">:<?php echo $all_num; ?>件</div>
		<?php endif; ?>
  </div>
</div>

<?php if($all_num > 0): ?>
<?php get_template_part('var/comit_area'); ?>

<div class="pc-bg-gray pc-bg-gray--pd">
	<div class="l-wrapper">
    <?php if($query): 
      $loopcounter = 0;
			foreach( $query as $post ): 
        $loopcounter++;
        global $post;
        setup_postdata( $post );
				if ($loopcounter == 1) { ?>
					<ul class="facility-list">
				<?php } ?>

				<?php get_template_part('var/comit_list_item'); ?>
      
				<?php if($loopcounter%10 == 0 && $loopcounter != $get_num) { ?>
					</ul><ul class="facility-list" style="display:none; opacity:0;">
						<?php if ($loopcounter == 10) { ?>
							<section class="facility-list-1 facility-list-1__banner-item ">
								<div class="facility-list-1__main">
									<p class="facility-list-1__name"><span class="facility-list-1__name-highlight">チームビルディング目的</span>でお探しの方！<br class="sp-only">専門家がオススメする施設をご紹介！</p>
									<div class="buttons">
										<div class="buttons__item">
											<a class="button button--color-1" href="/?post_type=facility&s=&post_tag%5B%5D=team-build">おすすめの施設をみる</a>
										</div>
										<div class="buttons__item">
											<a class="button button--color-2" href="/consult/" ><span>専門家に相談する</span></a>
										</div>
									</div>
								</div>
							</section>
						<?php } ?>
				<?php } ?>
				<?php if ($loopcounter == $get_num) { ?>
					</ul>
				<?php } ?>
			<?php endforeach;  ?>

			<?php if ($get_num >= 10): ?>
      		<a href="#" id="btn_list_more" class="button button--arrow"  >さらに表示</a>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		<?php else: ?>

		<!-- <p>申し訳ございません。ただいま準備中です。</p> -->
		<?php endif; ?>

    <?php /* if($query->have_posts()): ?>
		<?php
			$pagecount = get_query_var('paged') - 1;
			$ppp   = $comit_posts_per_page;
			$count = $total = $query->post_count;
			$from  = 0;
		?>


			<?php while ($query->have_posts()): $query->the_post(); $loopcounter++; ?>
				<?php if ($query->current_post == 0) { ?>
					<ul class="facility-list">
				<?php } ?>

				<?php get_template_part('var/comit_list_item'); ?>

				<?php if($loopcounter%10 == 0 && $query->current_post != $query->post_count - 1) { ?>
					</ul><ul class="facility-list" style="display:none; opacity:0;">
						<?php if ($loopcounter == 10) { ?>
							<section class="facility-list-1 facility-list-1__banner-item ">
								<div class="facility-list-1__main">
									<p class="facility-list-1__name"><span class="facility-list-1__name-highlight">チームビルディング目的</span>でお探しの方！<br class="sp-only">専門家がオススメする施設をご紹介！</p>
									<div class="buttons">
										<div class="buttons__item">
											<a class="button button--color-1" href="/?post_type=facility&s=&post_tag%5B%5D=team-build">おすすめの施設をみる</a>
										</div>
										<div class="buttons__item">
											<a class="button button--color-2" href="/consult/" ><span>専門家に相談する</span></a>
										</div>
									</div>
								</div>
							</section>
						<?php } ?>
				<?php } ?>
				<?php if ($query->current_post == $query->post_count - 1) { ?>
					</ul>
				<?php } ?>
			<?php endwhile;  ?>

			<?php if ($get_num >= 10): ?>
      		<a href="#" id="btn_list_more" class="button button--arrow"  >さらに表示</a>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		<?php else: ?>

		<p>申し訳ございません。ただいま準備中です。</p>
		<?php endif; */?>


	</div>
</div>
<?php else : ?>
<div class="search-no">
  <?php get_template_part('var/comit_area_0'); ?>
  <div class="pc-bg-gray--pd ">
    <div class="l-wrapper">
      <h2 class="no-data"><span>施設探しでお困りの方へ</span></h2>
      <p class="text">
        研修や合宿の目的・日時・参加人数などの条件を踏まえ、<br>
        プロの視点から最適な施設及び備品等の剪定・提案・手配を進めるサービスも行っています。<br>
        お気軽にご相談ください。
      </p>
      <a href="/consult/" class="button button--lg">無料で専門家に相談する</a>
    </div>
  </div>
  <div class="pc-bg-gray--pd ">
    <div class="l-wrapper">
      <h2 class="no-data"><span>CO-MITのオススメ特集から探す</span></h2>	
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
    </div>
  </div>
</div>
<?php endif; ?>
<div class="fixed-bar">
	<div class="l-wrapper fixed-bar__inner">
		<p class="fixed-bar__text">検討リストに追加した施設に</p>
		<div class="fixed-bar__button__wrapper">
			<button class="fixed-bar__button fixed-bar__button--color" onclick="location.href='<?php echo esc_url(home_url('/')); ?>inquiry_multi/'"><span>まとめて問い合わせ<span class="pc-only">する</span></span></button>
			<a href="<?php echo esc_url(home_url('/')); ?>favorite/" class="fixed-bar__button fixed-bar__button--white"><span>検討リストを確認</span></a>
		</div>
	</div>
</div>

<?php get_footer(); ?>
