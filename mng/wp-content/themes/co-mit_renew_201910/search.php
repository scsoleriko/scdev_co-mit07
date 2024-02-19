<?php get_header(); ?>


<?php
	//絞り込みの値を取得
  $s = "";
  $post_type = "";
  $cat_area = "";
  $post_tag = "";
  $fee = "";
  $capa = "";
	$cat_hotel = "";
  $cat_area_selected = "";
  $cat_hotel_selected = "";
  $post_tag_selected = "";
  $args =	array();

  if(isset($_GET['s'])){
    $s = $_GET['s'];
  }
  if(isset($_GET['post_type'])){
    $post_type = $_GET['post_type'];
  }
  if(isset($_GET['cat_area'])){
    $cat_area = $_GET['cat_area'];
  }
  if(isset($_GET['post_tag'])){
    $post_tag = $_GET['post_tag'];
  }
  if(isset($_GET['facility_fee'])){
    $fee = $_GET['facility_fee'];
  }
  if(isset($_GET['facility_capa'])){
    $capa = $_GET['facility_capa'];
  }
  if(isset($_GET['cat_hotel'])){
    $cat_hotel = $_GET['cat_hotel'];
  }

	//絞り込みの値をクエリ用に代入
	if( !empty($cat_area) ) {
		$cat_area_selected = array(
			'taxonomy'=>'area',
			'terms'=>$cat_area,
			'field'=>'slug',
			'operator'=>'IN'
		);
	}

	if( !empty($post_tag) ) { //タグの場合
		$post_tag_selected = array(
			'taxonomy'=>'feature',
			'terms'=>$post_tag,
			'field'=>'slug',
			'operator'=>'AND',
		);
	}

	$meta = array(
		"relation" => "AND",
	);

	if ( !empty($capa) ) {
		$range = array(
			"relation" => "OR",
		);

		function get_capa_range ($v) {
			$ret = array(
				"relation" => "AND",
				array(
					'key' => 'facility_capa_facility_capa_max',
					'value' => "",
					'compare' => "BETWEEN",
					'type'=>'NUMERIC'
				),
				array(
					'key' => 'facility_capa_facility_capa_min',
					'value' => "",
					'compare' => "BETWEEN",
					'type'=>'NUMERIC'
				)
			);
			if ($v == "1") {
				$ret[0]["value"] = array(1, 9999);
				$ret[1]["value"] = array(1, 19);
			} else if ($v == "20") {
				$ret[0]["value"] = array(20, 9999);
				$ret[1]["value"] = array(1, 49);
			} else if ($v == "50") {
				$ret[0]["value"] = array(50, 9999);
				$ret[1]["value"] = array(1, 99);
			} else if ($v == "100") {
				$ret[0]["value"] = array(100, 9999);
				$ret[1]["value"] = array(1, 199);
			} else if ($v == "200") {
				$ret[0]["value"] = array(200, 9999);
				$ret[1]["value"] = array(1, 9999);
			}
			return $ret;
		}

		if (!empty($capa)) {
			$range[] = get_capa_range($capa);
		}
		$meta[] = $range;
	}
	if ( !empty($fee) ) {
		$range = array(
			"relation" => "OR",
		);

		function get_fee_range ($v) {
			$ret = array(
					'key' => 'facility_fee',
					'value' => "",
					'compare' => 'BETWEEN',
					'type'=>'NUMERIC'
			);
			if ($v == "9999") {
				$ret["value"] = array(1, 9999);
			} else if ($v == "10000") {
				$ret["value"] = array(10000, 19999);
			} else if ($v == "20000") {
				$ret["value"] = array(20000, 29999);
			} else if ($v == "30000") {
				$ret["value"] = array(30000, 9999999);
			}
			return $ret;
		}

		if (!empty($fee)) {
			$range[] = get_fee_range($fee);
		}
		$meta[] = $range;
	}
	
	if( !empty($cat_hotel)){
		$range = array(
			"relation" => "OR",
		);
		
    foreach ($cat_hotel as $hotel) :
			$range[] = array(
				'key'     => 'facility_icon',
				'value'   => $hotel,
				'compare' => 'LIKE',
			);
		endforeach;
		$meta[] = $range;
	}
	?>

<?php
  // プレミアムポジション枠
  $range = array(
    "relation" => "AND",
  );
  $range[] = array(
      'key'     => 'plan2_premium_position',
      'value'   => 'enable',
      'compare' => 'LIKE',
    );
  $meta_premium = $meta;
  $meta_premium[] = $range;
  $args_premium = array( 
		'meta_value' => 'normal',
    'meta_query' => $meta_premium
  );


  // スタンダード
  $range = array(
    "relation" => "AND",
  );
  $range[] = array(
					'key'     => 'plan2',
					'value'   => 'incentive-fee',
					'compare' => 'NOT LIKE',
				);
	$range[] = array(
					'key'     => 'plan2',
					'value'   => 'lowrate',
					'compare' => 'NOT LIKE',
				);
  $range[] =array(
					'key'     => 'plan2_premium_position',
					'value'   => 'enable',
					'compare' => 'NOT LIKE',
				);
  $meta_normal = $meta;
  $meta_normal[] = $range;
  $args_normal = array( 
    'meta_value' => 'normal',
    'meta_query' => $meta_normal
  );			

  //成果報酬
  $range = array(
    "relation" => "OR",
  );
  $range[] = array(
		'key'     => 'plan2',
		'value'   => 'incentive-fee',
		'compare' => 'LIKE',
	);
  $range[] = array(
		'key'     => 'plan2',
		'value'   => 'lowrate',
		'compare' => 'LIKE',
	);
$meta_incentive = $meta;
  $meta_incentive[] = $range;
  $args_incentive = array(
    'meta_value' => 'normal',
    'meta_query' => $meta_incentive
  );

  //ライトプラン
  $range = array(
    "relation" => "AND",
  );
  $range[] = array(
					'key'     => 'plan2',
					'value'   => 'incentive-fee',
					'compare' => 'NOT LIKE',
				);
	$range[] = array(
					'key'     => 'plan2',
					'value'   => 'lowrate',
					'compare' => 'NOT LIKE',
				);				
  $meta_lightplan = $meta;
  $meta_lightplan[] = $range;
  $args_lightplan = array( 
    'meta_value' => 'light',
    'meta_query' => $meta_lightplan
  );
/*
$query = array_merge($query_premium, $query_normal, $query_incentive, $args_light_plan);
$get_num = count($query);
$all_num = $get_num;//全件数
*/
?>
<?php
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  $args_temp = array(
    'post_parent' => 0,
    'post_status' => 'publish',
    'post_type' => $post_type,
    'posts_per_page' => -1,
    'order'   => 'DESC',
    'orderby' => 'rand',
		'meta_key' => 'plan',
    'paged' => $paged,
    's' => $s,
//    'meta_query' => $meta
  );
  //タクソノミー絞り込みの場合はクエリを指定
	if( !empty($cat_area) || !empty($post_tag) ) {
     $args_search = array(
       'tax_query' => array(
         'relation' => 'AND',
         array($cat_area_selected),
         array($post_tag_selected)
      )
    );
    
    $args = array_merge($args_temp, $args_search);
	}else{
    $args = $args_temp;
  }
  
?>

<?php
  $wp_query = new WP_Query(array_merge($args, array('meta_query' => $meta)));
  $query_premium =get_posts(array_merge( $args, $args_premium));  // プレミアムポジション枠
  $query_normal = get_posts(array_merge( $args, $args_normal));  // スタンダード
  $query_incentive = get_posts(array_merge( $args, $args_incentive));  //成果報酬
  $query_lightplan = get_posts(array_merge( $args, $args_lightplan));   //ライトプラン
 
  // 投稿タイプを指定して親の投稿一覧を表示
	$query = array_merge($query_premium, $query_normal, $query_incentive, $query_lightplan);
  $get_num = count($query);
  $all_num = $get_num;//全件数
?>


<?php // 投稿タイプを指定して親の投稿一覧を表示
/*
	$query_premium = new WP_Query(array_merge( $args, $args_premium));
  $wp_query = $query_premium;
	global $wp_query;
	$get_num = $wp_query->post_count;
	$all_num = $wp_query->found_posts;//全件数
	$max_page = $wp_query->max_num_pages;
*/
?>

<?php get_template_part('var/modelcase-modal'); ?>

<div class="fixed-side-btn js-fixed-btn-02">
	<a href="<?php echo esc_url(home_url('/')); ?>consult">
		<p><span>まるっとお任せ</span><span>専門家に相談する</span></p>
	</a>
</div>

<div class="l-wrapper">
  <div class="search-number">
	<h1 class="heading-4">
	<?php
	$title_flg = false;
	if( !empty($cat_area) || !empty($post_tag) || !empty($capa) || !empty($fee) || !empty($cat_hotel) ) {
		if (
//			(is_array($cat_area) && count($cat_area) > 1) ||
			(is_array($post_tag) && count($post_tag) > 1) ||
			(is_array($capa) && count($capa) > 1) ||
			(is_array($fee) && count($fee) > 1) 
		) {
			echo '検索結果:'.$all_num.'件</h1>';
			$title_flg = true;
		}
		$result_cond = array();
		if(!$title_flg && is_array($cat_area)) {
			foreach($cat_area as $val){
				$result_cond[] = get_term_by('slug',$val,"area")->name." ";
			}
		} else if (!$title_flg && !empty($cat_area)) {
			$result_cond[] = get_term_by('slug',$cat_area,"area")->name." ";
		}

		if(!$title_flg && is_array($post_tag)) { //タグの場合
			foreach($post_tag as $val){
				$result_cond[] = get_term_by('slug',$val,"feature")->name." ";
			}
		}
		if(!$title_flg && !empty($capa)) {
				if ($capa == "1") {
					$result_cond[] = "20名未満 ";
				} else if ($capa == "20") {
					$result_cond[] = "20～49名 ";
				} else if ($capa == "50") {
					$result_cond[] = "50～99名 ";
				} else if ($capa == "100") {
					$result_cond[] = "100～199名 ";
				} else if ($capa == "200") {
					$result_cond[] = "200名以上 ";
				}
		}
		if(!$title_flg && !empty($fee)) {
				if ($fee == "9999") {
					$result_cond[] = "〜".$fee."円 ";
				} else {
					$result_cond[] = $fee."円〜 ";
				}
		}
		if(!$title_flg && !empty($cat_hotel)) {
			foreach($cat_hotel as $val){
				if($val == "resort_hotel"){
					$result_cond[] = "リゾートホテル";
				}else if($val == "city_hotel"){
					$result_cond[] = "シティホテル";
				}else if($val == "business_hotel"){
					$result_cond[] = "ビジネス型ホテル";
				}else if($val == "ryokan"){
					$result_cond[] = "旅館";
				}else if($val == "training_center"){
					$result_cond[] = "研修センター";
				}else if($val == "outdoor_facilities"){
					$result_cond[] = "アウトドア施設";
				}else if($val == "public"){
					$result_cond[] = "公共施設";
				}else if($val == "etc"){
					$result_cond[] = "宿泊タイプその他";
				}
			}
		}
		if (!$title_flg) {
			echo implode(", ", $result_cond) . "でおすすめの研修施設一覧</h1><div class='heading-4'>:".$all_num."件</div>";
		}

	?>
	<?php
	} else {
	echo '検索結果:'.$all_num.'件</h1>';
	}
	?>
    </div>
</div>
<?php if($all_num > 0): ?>
<?php get_template_part('var/comit_area'); ?>


<div class="pc-bg-gray pc-bg-gray--pd">
	<div class="l-wrapper">

		<?php // if(have_posts()): ?>
		<?php

			my_result_count(); //〇件中表示
      $loopcounter = 0;
      if($query): 
			foreach( $query as $post ): 
        $loopcounter++;
        global $post;
        setup_postdata( $post );
//			while ( have_posts() ) : the_post(); $loopcounter++;
//					if ($wp_query->current_post == 0) {
        if ($loopcounter == 1) {
				?>
					<ul class="facility-list">
				<?php } ?>

				<?php get_template_part('var/comit_list_item'); ?>

				<?php // if($loopcounter%10 == 0 && $wp_query->current_post != $wp_query->post_count - 1) { ?>
        <?php if($loopcounter%10 == 0 && $loopcounter != $get_num) { ?>
					</ul><ul class="facility-list" style="display:none; opacity:0;">

					<?php if ($loopcounter == 10) { ?>
						<?php $offsite_cls = isset($_GET["post_tag"]) && (in_array("offsite", $_GET["post_tag"], true) || in_array("team-build", $_GET["post_tag"], true))? "is-offsite" : ""; ?>
						<section class="facility-list-1 facility-list-1__banner-item <?php echo $offsite_cls; ?>">
							<div class="facility-list-1__main">
								<?php if (!empty($offsite_cls)) : ?>
									<p class="facility-list-1__name"><span class="facility-list-1__name-highlight">オフサイトミーティング目的</span>でお探しの方！本当に効果が出る研修をしていますか？<br>CO-MITでは、こだわりのオフサイト研修をご紹介しています！</p>
									<div class="buttons">
										<div class="buttons__item">
											<a class="button button--color-1" href="/offsite/">オフサイト研修のすすめ</a>
										</div>
										<div class="buttons__item">
											<a class="button button--color-2" href="/consult/" ><span>専門家に相談する</span></a>
										</div>
									</div>
								<?php else: ?>
									<p class="facility-list-1__name"><span class="facility-list-1__name-highlight">チームビルディング目的</span>でお探しの方！<br class="sp-only">専門家がオススメする施設をご紹介！</p>
									<div class="buttons">
			              <div class="buttons__item">
			                <a class="button button--color-1" href="/?post_type=facility&s=&post_tag%5B%5D=team-build">おすすめの施設をみる</a>
			              </div>
			              <div class="buttons__item">
			                <a class="button button--color-2" href="/consult/" ><span>専門家に相談する</span></a>
			              </div>
			            </div>
								<?php endif; ?>
							</div>
						</section>
					<?php } ?>
				<?php } ?>
				<?php // if ($wp_query->current_post == $wp_query->post_count - 1) { ?>
        <?php if ($loopcounter == $get_num) { ?>
					</ul>
				<?php } ?>
			<?php // endwhile; ?>
			<?php endforeach;  ?>

			<?php if ($get_num >= 10): ?>
					<a href="#" id="btn_list_more" class="button button--arrow">さらに表示</a>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		<?php else: ?>

		<p>申し訳ございません。ただいま準備中です。</p>
		<?php endif; ?>


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
