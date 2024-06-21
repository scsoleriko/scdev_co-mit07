<?php get_header(); ?>


<?php
	//絞り込みの値を取得
  $s = "";
  $cat = "";
  $cat_area = "";

  $cat_selected = "";
  $cat_area_selected = "";
  $args =	array();
  $args_search = array();
  $args_cat = array();
  $args_area = array();

  if(isset($_GET['s'])){
    $s = $_GET['s'];
  }
  if(isset($_GET['cat'])){
    $cat = $_GET['cat'];
  }
  if(isset($_GET['cat_area'])){
    $cat_area = $_GET['cat_area'];
  }

	//絞り込みの値をクエリ用に代入

	?>

<?php
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  $args_temp = array(
    'post_status' => 'publish',
    'post_type' => 'facility',
    'posts_per_page' => -1,
    'order'   => 'DESC',
    'orderby' => 'rand',
    's' => $s,
//    'meta_query' => $meta
  );
  
  if( !empty($cat) ) {
    if( $cat == 'room' ){
      $args_cat = array(
        'meta_key' => 'edit_type',
        'meta_value' => '宿泊',
      );
    } else if( $cat == 'hall' ){
      $args_cat = array(
        'relation' => 'OR',
        array(
          'meta_key' => 'edit_type',
          'meta_value' => '会場情報',
        ),
        array(
          'meta_key' => 'edit_type',
          'meta_value' => '会場情報（簡易宿所）',
        )

      );
    } else if( $cat == 'meal' ){
      $args_cat = array(
        'meta_key' => 'edit_type',
        'meta_value' => 'お食事',
      );
    }
  } else {
    $args_cat = array(
      'post_parent' => 0,
    );  
  }

  if( !empty($cat_area) ) {
    $args_area = array(
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy'=>'area',
          'terms'=>$cat_area,
          'field'=>'slug',
          'operator'=>'IN'
        ),
     )
    );
  }
  $args_search = array_merge($args_cat, $args_area);
  $args = array_merge($args_temp, $args_search);
  $query = get_posts($args);
 
  // 投稿タイプを指定して親の投稿一覧を表示
	//$query = array_merge($query_premium, $query_normal, $query_incentive, $query_lightplan);
  $get_num = count($query);
  $all_num = $get_num;//全件数
?>

<?php
  // エリアリストの作成
  $area = array();
  $area_array = array();
  $args_area = array_merge($args_temp, $args_cat);
  $query_area = get_posts($args_area);
  foreach( $query_area as $post ){
    setup_postdata($post);
    $img_flg = false;
    // すべて以外の場合、画像の有無をチェック
    if( $cat == 'room' ){   // 客室・設備
      // 画像
      if(have_rows('lodging_images')){
        while(have_rows('lodging_images')){ the_row();
          if ( get_sub_field('lodging_image') != '' && !empty(get_sub_field('lodging_image'))) {
            $img_flg = true;
          }
        }
      }
      
    } else if( $cat == 'hall' ){  // 会場
      // 画像
      if(have_rows('meeting_detail')){
        while(have_rows('meeting_detail')){ the_row();
          if ( get_sub_field('meeting_image') != '' && !empty(get_sub_field('meeting_image'))) {
            $img_flg = true;
          }
        }
      }
    } else if( $cat == 'meal' ){  // 食事
      // 画像
      if(have_rows('meal')){
        while(have_rows('meal')){ the_row();
          if ( get_sub_field('meal_image') != '' && !empty(get_sub_field('meal_image'))) {
            $img_flg = true;
          }
        }
      }
    } else {    // すべて
      $img_flg = true;
    }
    // 画像がなければ読み飛ばし
    if( !$img_flg ){
      continue;
    }
    // エリア取得
    $terms = get_the_terms($post->ID,'area');
    // スラッグをキーにして、重複行を削除
    if( $terms[0]->slug != '' ){
      $area = array($terms[0]->slug => array( $terms[0]->description, $terms[0]->slug, $terms[0]->name ));
      $area_array = array_merge($area_array, $area);      
    }
  }
  // 並び替え
  $sort_array = array();
  foreach ($area_array as $key => $val) {
    array_push($sort_array, $val[0]);
  }
  array_multisort($area_array, SORT_ASC, $sort_array);

?>
<?php wp_reset_postdata(); ?>
<div class="fixed-side-btn js-fixed-btn-02">
	<a href="<?php echo esc_url(home_url('/')); ?>consult">
		<p><span>まるっとお任せ</span><span>専門家に相談する</span></p>
	</a>
</div>

<div class="l-wrapper gallery">
	<h1 class="heading-4">ギャラリーから探す</h1>
  <p class="heading-text">全施設からランダムに写真を表示し、写真から施設を探すことができます。気になった写真から施設を探してみてください！</p>
  <div class="search-ui-wrapper">
    <?php
      $all_class='';
      $room_class='';
      $hall_class='';
      $meal_class='';
      $img_array = array();
      if( !empty($cat) ) {
        if( $cat == 'room' ){
          $room_class='active';
        } else if( $cat == 'hall' ){
          $hall_class='active';
        } else if( $cat == 'meal' ){
          $meal_class='active';
        }
      } else {
        $all_class='active';
      }
    ?>
    <ul class="category-list">
      <li><a href="/gallery/" class='<?php echo $all_class; ?>'>すべて</a></li>
      <li><a href="/gallery?cat=room" class='<?php echo $room_class; ?>'>客室・設備</a></li>
      <li><a href="/gallery?cat=hall" class='<?php echo $hall_class; ?>'>会場</a></li>
      <li><a href="/gallery?cat=meal" class='<?php echo $meal_class; ?>'>食事</a></li>
    </ul>
    <div class="area-list">
      <p>エリア</p> 
      <select id="selectArea" class='search__select'>
        <?php if ( $cat_area == 'all' || empty($cat_area) ){
          echo '<option value="all" selected>全国</option>';
        } else {
          echo '<option value="all" selected>全国</option>';
        }
        foreach ($area_array as $key => $var) {
          if( $cat_area == $key ){
            echo '<option value="' . $key . '" selected>' . $var[2] . '</option>';            
          } else {
            echo '<option value="' . $key . '">' . $var[2] . '</option>';            
          }
        }
        ?>
      </select>
    </div>
  </div>
</div>
<?php if($all_num > 0): ?>

	<div class="l-wrapper">

		<?php // if(have_posts()): ?>
      <ul class="gallery-list">
		<?php

      $loopcounter = 0;
      $imgcounter = 0;
      if($query): 
			foreach( $query as $post ): 
        global $post;
        setup_postdata( $post );

        ?>
        <?php
          // 画像ファイル名取得
          $img_temp = array();
          $img_array = array();
          if( !empty($cat) ) {
            if( $cat == 'room' ){   // 客室・設備
              $room_class='active';
              // 画像
              if(have_rows('lodging_images')){
                while(have_rows('lodging_images')){ the_row();
                  if ( get_sub_field('lodging_image') != '' && !empty(get_sub_field('lodging_image'))) {
                    array_push($img_array, wp_get_attachment_image_url(get_sub_field('lodging_image'),'large'));
                  }
                }
              }
              
            } else if( $cat == 'hall' ){  // 会場
              $hall_class='active';
              // 画像
              if(have_rows('meeting_detail')){
                while(have_rows('meeting_detail')){ the_row();
                  if ( get_sub_field('meeting_image') != '' && !empty(get_sub_field('meeting_image'))) {
                    array_push($img_array, get_sub_field('meeting_image'));
                  }
                }
              }
            } else if( $cat == 'meal' ){  // 食事
              $meal_class='active';
              // 画像
              if(have_rows('meal')){
                while(have_rows('meal')){ the_row();
                  if ( get_sub_field('meal_image') != '' && !empty(get_sub_field('meal_image'))) {
                    array_push($img_array, get_sub_field('meal_image'));
                  }
                }
              }
            }
          } else {
            // すべて
            $all_class='active';

            // すべての写真を取得
            array_push($img_temp, get_field('facility_mainimage'));
            array_push($img_temp, get_field('facility_subimage1'));
            array_push($img_temp, get_field('facility_subimage2'));
            array_push($img_temp, get_field('facility_subimage3'));
            array_push($img_temp, get_field('facility_subimage4'));

            // 子ページ情報取得
            $child_posts = get_posts('numberposts=-1&post_type=facility&post_parent=' . $post->ID);
            if ( $child_posts ){
              foreach ( $child_posts as $child ):
                $child_title   = apply_filters('the_title', $child->ID);
                if(get_field('edit_type', $child->ID) == '宿泊'){
                  if(have_rows('lodging_images', $child->ID)){
                    while(have_rows('lodging_images', $child->ID)){ the_row();
                      array_push($img_temp, wp_get_attachment_image_url(get_sub_field('lodging_image'),'large'));
                    }
                  }
                } else if(get_field('edit_type', $child->ID) == '会場情報' || get_field('edit_type', $child->ID) == '会場情報（簡易宿所）' ){
                  
                  if(have_rows('meeting_detail', $child->ID)){
                    while(have_rows('meeting_detail', $child->ID)){ the_row();
                      array_push($img_temp, get_sub_field('meeting_image'));
                    }
                  }    
                } else if(get_field('edit_type', $child->ID) == 'お食事'){
                  if(have_rows('meal', $child->ID)){
                    while(have_rows('meal', $child->ID)){ the_row();
                      array_push($img_temp, get_sub_field('meal_image'));
                    }
                  }    
                }
              endforeach;
            }
            
            foreach( $img_temp as $img ){
              if($img != ''){
                array_push($img_array, $img);
              }
            }
          }
    

        ?>
        <?php if ( count($img_array) > 0 ){ 
          $loopcounter++; $imgcounter++;?>
        <li class="listImage<?php echo $loopcounter; ?>">
          <a href="#facility-modal<?php echo $post->ID; ?>" class="js-facility-modal-open">
            <img src="<?php echo $img_array[array_rand($img_array, 1)]; ?>" alt="" width="100%" height="100%">
          </a>
				</li>
        
        <?php 
          $args = array(
            'cat' => $cat,
            'img_array' => $img_array
          );
          get_template_part('var/facility-modal', null,  $args); 
        ?>
        <?php } ?>
        <?php if($imgcounter >= 12){
          $imgcounter = 0;
        } ?>
        <?php if($loopcounter >= 24){
          break;
        } ?>
			<?php // endwhile; ?>
			<?php endforeach;  ?>

			<?php wp_reset_postdata(); ?>
		<?php else: ?>

		<p>申し訳ございません。ただいま準備中です。</p>
		<?php endif; ?>
    </ul>
    <div class="gallery_button_area"><a href="javascript:void();" id="btn_list_reload" class="button button--arrow">別の写真を表示</a></div>

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
<script>
window.onload = function() {
    $('html,body').animate({ scrollTop: 0 }, '0');
    // select変更時
    document.getElementById('selectArea').onchange = function() {
      // cat_areaパラメータ取得
      var url = new URL(window.location.href);
      var params = url.searchParams;
      // 遷移先URL取得
      var area = this.options[this.selectedIndex].value;
      // URLが取得できていればページ遷移
      if(area == 'all') {
        location.href = '/gallery/';
      } else {
        if(params.get('cat') != null && params.get('cat') != '' ){
          location.href = '/gallery?cat=' + params.get('cat') + '&cat_area=' + area;
        } else {
          location.href = '/gallery?cat_area=' + area;
        }
      }
    };
    document.getElementById('btn_list_reload').onclick = function() {
      location.reload();
    }
};
</script>

<?php get_footer(); ?>
