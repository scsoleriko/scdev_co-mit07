<?php get_header(); ?>


<?php
  global $comit_parent_id;
  if ( is_single() && $post->post_parent ){
    $comit_parent_id = $post->post_parent;
  }

  global $plan_type;
  $plan_type = '';
  if ( isset($comit_parent_id) ){
    $plan_type = get_field('plan',$comit_parent_id);
  } else {
    $plan_type = get_field('plan');
  }

  global $plan_type2, $incentiveFee;
  $incentiveFee = false;
  if ( isset($comit_parent_id) ){
    $plan_type2 = get_field('plan2',$comit_parent_id);
    foreach( $plan_type2 as $plan_type2_detail ) {
      if ( $plan_type2_detail == 'incentive-fee' ) {
        $incentiveFee = true;
      }
    }
  } else {
    $plan_type2 = get_field('plan2');
    foreach( $plan_type2 as $plan_type2_detail ) {
      if ( $plan_type2_detail == 'incentive-fee' ) {
        $incentiveFee = true;
      }
    }
  }

  global $comit_permalink;
  if ( isset($comit_parent_id) ){
    $comit_permalink = get_permalink($comit_parent_id);
  } else {
    $comit_permalink = get_permalink();
  }

  function get_form_url () {
    global $comit_parent_id;

    $form_url = "#";
    if ( isset($comit_parent_id) ){
      if ( get_field('facility_contact_form_url',$comit_parent_id) ){
        $form_url = get_field('facility_contact_form_url',$comit_parent_id);
      }
    } else {
      if ( get_field('facility_contact_form_url') ){
        $form_url = get_field('facility_contact_form_url');
      }
    }

    return $form_url;
  }

  function get_person_src () {
    $person_src = mt_rand(1, 2);
    return "/co-mit_renew_201910/img/img_person_0{$person_src}.jpg";
  }
?>
<?php
  // 子ページの検索
  $children = get_pages(array(
      "child_of"   => get_the_id(),
      "post_type"     => "facility",
      "post_status"   => array('publish', 'private')
  ));
  if($children){
    // 親ページの場合、子ページIDを取得して保持
    foreach($children as $child){
      if ( $child->post_title == "アクセス・周辺情報" ) {
        $child_access_id = $child->ID;
      }
    }
  }else{ 
    //子ページかつアクセスページの場合は、自身のIDを保持
    if(get_the_title() == "アクセス・周辺情報" ) {
      $child_access_id = get_the_ID();
    }else{
      //親IDを取得してから、アクセスページのIDを取得して保持
      $children = get_pages(array(
          "child_of"   => $post->post_parent,
          "post_type"     => "facility",
          "post_status"   => array('publish', 'private')
      ));
      if($children){
        // 親ページの場合、子ページIDを取得して保持
        foreach($children as $child){
          if ( $child->post_title == "アクセス・周辺情報" ) {
            $child_access_id = $child->ID;
          }
        }
      }
      
    }
    
  }
?>
<?php
  global $official_website_url;
  $official_website_url = "#";
  if ( isset($comit_parent_id) ){
    if ( get_field('facility_url',$comit_parent_id) ){
      $official_website_url = get_field('facility_url',$comit_parent_id);
    }
  } else {
    if ( get_field('facility_url') ){
      $official_website_url = get_field('facility_url');
    }
  }


  $interview_id = get_post_meta( (isset($comit_parent_id)) ? $comit_parent_id : get_the_ID(), "facility_column_relation_meta", true);
  $interview_post = "";
  if (!empty($interview_id)) {
    $interview_post = get_post($interview_id);
    $interview_post->column_lead = get_field("column_lead", $interview_id);
    $interview_post->permalink = get_permalink( $interview_id );
    $interview_post->thumbnail = get_the_post_thumbnail_url( $interview_id );
  }
?>

<?php get_template_part('var/modelcase-modal'); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>
<?php
  global $favorite_id;
  if ( isset($comit_parent_id) ){
    $favorite_id = $comit_parent_id;
  } else {
    $favorite_id = get_the_ID();
  }


function pc_fv () {
  global $comit_parent_id, $comit_permalink, $plan_type, $plan_type2, $incentiveFee, $favorite_id, $official_website_url, $post, $interview_post
  ;
?>
  <?php
    // 指定日数以内の投稿にNEWマークを表示する
    $days = 31;
    $today = date_i18n('U');
    $entry_day = get_the_time('U');
    $keika = date('U',($today - $entry_day)) / 86400;
  ?>

  <div class="l-wrapper">
    <section class="detail-name-area">
      <div class="detail-name-area__inner">
          <?php
            $parent_id = $post->post_parent;
            $description_single_class = "";
            if($plan_type == 'light') {
              $description_single_class = ' facility-overview--single';
            }elseif(get_field('facility_pro-comment_detail',$parent_id) == ""){
              $description_single_class = ' facility-overview--single';
            }
          ?>

        <?php $terms = get_the_terms($comit_parent_id,'hotel_type'); ?>
        <?php $hotel_type = $terms[0]->name; ?>
        <div class="heading-8"><?php if ( $days > $keika ): ?><span class="icon__new">NEW</span><?php endif; ?><span><?php echo $hotel_type; ?></span><h1><?php if ( isset($comit_parent_id) ){ echo get_post($comit_parent_id)->post_title; } else { echo get_the_title(); } ?></h1></div>
        <div class="favorite-button js-favorite" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リスト追加</span><span>検討リスト追加済</span></p></div>
      </div>
      <div class="facility-overview<?php echo $description_single_class; ?>" >
        <div class="facility-overview__description">
          <p><?php if ( isset($comit_parent_id) ){ echo nl2br(get_field('facility_pr_deital',$comit_parent_id)); } else { echo nl2br(get_field('facility_pr_deital')); } ?></p>
        </div>

        <?php
          if ( $parent_id ) {
            if (get_field('facility_pro-comment_detail',$parent_id)) {
        ?>
        <div class="facility-overview__voice">
        <?php if ($plan_type != 'light'): ?>
          <div class="voice voice--lg">
            <div class="voice__image voice__image--lg">
              <img src="<?php echo get_person_src(); ?>" alt="">
            </div>
            <p class="voice__text voice__text--pc-simple"><?php echo nl2br(get_field('facility_pro-comment_detail',$parent_id)); ?></p>
          </div>
        <?php endif; ?>
        </div>
        <?php
            }
          } else {
            if (get_field('facility_pro-comment_detail')) {
        ?>
        <div class="facility-overview__voice">
        <?php if ($plan_type != 'light'): ?>
          <div class="voice voice--lg">
            <div class="voice__image voice__image--lg">
              <img src="<?php echo get_person_src(); ?>" alt="">
            </div>
            <p class="voice__text voice__text--pc-simple"><?php echo nl2br(get_field('facility_pro-comment_detail')); ?></p>
          </div>
          <?php endif; ?>
        </div>
        <?php
            }
          }
        ?>
      </div>
      <?php
        if ( isset($comit_parent_id) ){
          $iid =$comit_parent_id;
        } else {
          $iid =$post->ID;
        }

        if ($terms = get_the_terms($iid, 'feature')) {
          echo '<ul class="facility-tag">';
          foreach ( $terms as $term ) {
            echo '<li><a href="';
            echo esc_url(home_url('/'));
            echo 'feature/';
            echo esc_html($term -> slug);
            echo '/">';
            echo esc_html($term -> name);
            echo '</a></li>';
          }
          echo '</ul>';
        }
      ?>

      <!-- ▼ 既存流用 ▼ -->
      <div class="detail-name-info" id="detail-name-info">
        <ul class="detail-data-list">
          <li>
            <dl>
              <dt>エリア</dt>
              <dd><?php if ( isset($comit_parent_id) ){ the_field('facility_area',$comit_parent_id); } else { the_field('facility_area'); } ?></dd>
            </dl>
          </li>
          <li>
            <dl>
              <dt>料金目安<a href="#modelcase-modal" class="js-modal-open"><img src="/co-mit_renew_201910/img/icon_question.png"></a></dt>
              <dd>
    <?php
      if ( isset($comit_parent_id) ){
        if ( get_field('facility_fee',$comit_parent_id)){
          echo '大人1名：¥'. number_format(str_replace('～','',get_field('facility_fee',$comit_parent_id))) . '～';
        } else {
          echo 'お問い合わせください';
        }
      } else {
        if ( get_field('facility_fee')){
          echo '大人1名：¥'. number_format(str_replace('～','',get_field('facility_fee'))) . '～';
        } else {
          echo 'お問い合わせください';
        }
      }
    ?>
    </dd>
            </dl>
          </li>
          <li>
            <dl>
              <dt>宿泊可能人数</dt>
              <dd>
      <?php
        if ( isset($comit_parent_id) ){
          $group_name = get_field('facility_capa',$comit_parent_id);
          if( $group_name['facility_capa_min'] || $group_name['facility_capa_max'] ):
            echo empty($group_name['facility_capa_min']) ? "" : "{$group_name['facility_capa_min']}名";
            echo '～';
            echo empty($group_name['facility_capa_max']) ? "" : number_format(str_replace('名','',$group_name['facility_capa_max']))."名";
          else:
            echo 'お問い合わせください';
          endif;
        } else {
          $group_name = get_field('facility_capa');
          if( $group_name['facility_capa_min'] || $group_name['facility_capa_max'] ):
            echo empty($group_name['facility_capa_min']) ? "" : "{$group_name['facility_capa_min']}名";
            echo '～';
            echo empty($group_name['facility_capa_max']) ? "" : number_format(str_replace('名','',$group_name['facility_capa_max']))."名";
          else:
            echo 'お問い合わせください';
          endif;
        }
      ?>
      </dd>
            </dl>
          </li>
          <li>
            <dl>
              <dt>会場面積</dt>
              <dd>
      <?php
        if ( isset($comit_parent_id) ){
          if ( get_field('facility_kaijyo',$comit_parent_id) ){
            echo get_field('facility_kaijyo',$comit_parent_id);
          } else {
            echo 'お問い合わせください';
          }
        } else {
          if ( get_field('facility_kaijyo') ){
            echo get_field('facility_kaijyo');
          } else {
            echo 'お問い合わせください';
          }
        }
      ?>
      </dd>
            </dl>
          </li>
        </ul>
      </div>
      <!-- ▲ 既存流用 ▲ -->
    </section>
  </div>
  <div class="sticky">

      <div class="detail-tabs-outer">
        <div id="tab"></div>
        <nav class="detail-tabs">
        <div class="inner">
          <ul>
            <li<?php if ( get_field('edit_type') === '施設トップ' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>"><i class="icon-detail01"></i><span class="detail-tab-text">施設<br class="sp-only">トップ</span><i class="icon-detail01 icon-detail_under"></i></a></li>
            <?php if ($plan_type != 'light'): ?>
            <li<?php if ( get_field('edit_type') === '会場情報' || get_field('edit_type') === '会場情報（簡易宿所）' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>meeting/"><i class="icon-detail02"></i><span class="detail-tab-text">会場情報</span><i class="icon-detail02 icon-detail_under"></i></a></li>
            <li<?php if ( get_field('edit_type') === '宿泊' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>lodging/"><i class="icon-detail03"></i><span class="detail-tab-text">宿泊</span><i class="icon-detail03 icon-detail_under"></i></a></li>
            <li<?php if ( get_field('edit_type') === 'お食事' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>meal/"><i class="icon-detail04"></i><span class="detail-tab-text">お食事</span><i class="icon-detail04 icon-detail_under"></i></a></li>
            <li<?php if ( get_field('edit_type') === '設備・サービス' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>service/"><i class="icon-detail05"></i><span class="detail-tab-text">設備<span class="pc-only">・</span><br class="sp-only">サービス</span><i class="icon-detail05 icon-detail_under"></i></a></li>
            <?php endif; ?>
            <li<?php if ( get_field('edit_type') === 'アクセス・周辺情報' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>access/"><i class="icon-detail06"></i><span class="detail-tab-text">アクセス<span class="pc-only">・</span><br class="sp-only">周辺情報</span><i class="icon-detail06 icon-detail_under"></i></a></li>
          </ul>
        </div>
      </nav>
      </div>

    <div class="content-area bg-gray">
      <?php if ( get_field('edit_type') === '施設トップ' )  : ?>
      <div class="normal-section facility-gallery">
        <div class="swiper-container facility-gallery__main">
          <?php if ( have_rows("facility_plan") ) : ?>
          <div id="top-plan-icon" class="pc-icon">
            <!-- PC -->
            <a class="jumpToBtn" href="#recommend-plan">お得な<br>研修プランは<br>こちら</a>
          </div>
          <?php endif; ?>
          <div class="swiper-wrapper">
            <div class="swiper-slide"><div class="swiper-slide__inner"><img src="<?php
    if( get_field('facility_mainimage') ):
      the_field('facility_mainimage');
    else :
      echo 'http://placehold.jp/80/00b2b0/ffffff/2000x850.png?text=NOW%20PRINTING';
    endif;
    ?>" /></div></div>
              <?php
      if ( get_field('facility_subimage1') ) {echo '<div class="swiper-slide"><div class="swiper-slide__inner"><img src="'. get_field('facility_subimage1') .'" /></div></div>';}
      if ( get_field('facility_subimage2') ) {echo '<div class="swiper-slide"><div class="swiper-slide__inner"><img src="'. get_field('facility_subimage2') .'" /></div></div>';}
      if ( get_field('facility_subimage3') ) {echo '<div class="swiper-slide"><div class="swiper-slide__inner"><img src="'. get_field('facility_subimage3') .'" /></div></div>';}
      if ( get_field('facility_subimage4') ) {echo '<div class="swiper-slide"><div class="swiper-slide__inner"><img src="'. get_field('facility_subimage4') .'" /></div></div>';}
    ?>
          </div>
        </div>
        <div class="swiper-container__outer">
          <div class="swiper-container facility-gallery__thumbs">
            <div class="swiper-wrapper">
              <?php
                if ( get_field('facility_mainimage') ) {echo '<div class="swiper-slide"><img src="'. get_field('facility_mainimage') .'" /></div>';}
                if ( get_field('facility_subimage1') ) {echo '<div class="swiper-slide"><img src="'. get_field('facility_subimage1') .'" /></div>';}
                if ( get_field('facility_subimage2') ) {echo '<div class="swiper-slide"><img src="'. get_field('facility_subimage2') .'" /></div>';}
                if ( get_field('facility_subimage3') ) {echo '<div class="swiper-slide"><img src="'. get_field('facility_subimage3') .'" /></div>';}
                if ( get_field('facility_subimage4') ) {echo '<div class="swiper-slide"><img src="'. get_field('facility_subimage4') .'" /></div>';}
              ?>
            </div>
          </div>
        </div>
        <?php if( get_field('facility_360url') ): ?>
        <div class="l-wrapper">
          <a class="button button--360url" href="<?php the_field('facility_360url'); ?>" target="_blank" rel="nofollow">高解像度 360度パノラマビューはこちら</a>
        </div>
        <?php endif; ?>
        <div class="l-wrapper">

          <div class="button-balloon-wrapper">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="inner">
      <?php if( get_field('facility_information') ): ?>
        <section class="normal-section">
          <div class="information">
            <h3 class="information__heading">施設からのお知らせ</h3>
            <div class="information__detail">
              <?php echo get_field('facility_information') ?>
            </div>
          </div>
        </section>
      <?php endif; ?>

      <?php
      // 繰り返しフィールドにデータがあれば表示する
      if( have_rows('facility_plan') ):
        ?>
      <section class="normal-section" id="recommend-plan">
        <h2 class="section-title">
          <span class="section-title-en">PLAN</span>
          <i class="icon-plan"></i>
          <span class="section-title-ja">研修プラン</span>
        </h2>
        <div class="recommend-plan">
            <div class="recommend-plan__main">
              <ul class="recommend-plan__list">
              <?php foreach (get_field('facility_plan') as $item) : ?>
                <li class="recommend-plan__item">
                  <div class="recommend-plan__head">
                    <div class="recommend-plan__title"><?php echo $item["facility_plan_title"]; ?></div>
                    <div class="recommend-plan__meta">

                      <?php if ($item["facility_plan_meal"] !== "非表示") : ?>
                      <div class="recommend-plan__meal"><?php echo $item["facility_plan_meal"]; ?></div>
                      <?php endif; ?>

                      <?php if ($item["facility_plan_price"] !== "0") : ?>
                      <div class="recommend-plan__price">１名：<span class=""><?php echo number_format($item["facility_plan_price"]) . '円～'; ?></span></div>
                      <?php endif; ?>
                    </div>
                    <div class="recommend-plan__inquiry pc-only">
                      <a href="<?php echo get_form_url(); ?>" target="_blank">問い合わせる</a>
                    </div>
                  </div>
                  <div class="recommend-plan__summary">
                    <?php echo $item["facility_plan_summary"]; ?>
                  </div>
                  <div class="recommend-plan__inquiry sp-only">
                    <a href="<?php echo get_form_url(); ?>" target="_blank">問い合わせる</a>
                  </div>
                </li>
              <?php endforeach; ?>
              </ul>
            </div>
          </div>
      </section>
      <?php endif; ?>

        <section class="normal-section" id="detail-point">
      <?php
        // 繰り返しフィールドにデータがあれば表示する
        if( have_rows('facility_points') ) {
          //echo '<section class="normal-section" id="detail-point">';
          echo '<h2 class="section-title"><span class="section-title-en">POINT</span><img src="/co-mit_renew_201910/img/icon_point.png"><span class="section-title-ja">魅力ポイント</span></h2>';

          $has_plan_row = have_rows('facility_plan') ;
          $has_plan_row = false;  // スライダー表示解除
          if ( $has_plan_row ) {
            echo '<div id="facility_points_slider" class="swiper-container js-autoheight" style="overflow:hidden;">';
            echo '<ul class="detail-point swiper-wrapper">';
          } else {
            echo '<ul class="detail-point">';
          }

          while ( have_rows('facility_points') ) : the_row();

            if ( $has_plan_row ) {
              echo '<li class="swiper-slide"><article>';
            } else {
              echo '<li class=""><article>';
            }

            if( get_sub_field('facility_point_image') ) {
              echo '<p class="detail-point-photo"><img src="'. get_sub_field('facility_point_image') .'" alt=""></p>';
            } else {
              echo '<p class="detail-point-photo"><img src="http://placehold.jp/40/00b2b0/ffffff/850x500.png?text=NOW%20PRINTING" alt=""></p>';
            }

            echo '<div class="detail-point-text js-autoheight-traget"><h3>'. get_sub_field('facility_point_title') .'</h3>';
            echo '<p>'. get_sub_field('facility_point_detail') .'</p>';
            echo '</div></article></li>';

          endwhile;

          echo '</ul>';
          if ( $has_plan_row ) {
            echo '<div class="swiper-pagination"></div>';
            echo '</div>';
          }

        }
        ?>
        <?php if( get_field('facility_youtube-url') ): ?>
          <a class="button button--360url fancybox-youtube" href="<?php the_field('facility_youtube-url'); ?>" >動画で施設を確認する</a>
        <?php endif; ?>
        </section>

        <section class="normal-section">
    <?php
    // 繰り返しフィールドにデータがあれば表示する
    if( have_rows('facility_activity') ):
    ?>
          <h2 class="section-title">
            <span class="section-title-en">ACTIVITY</span>
            <i class="st-icon-pin"></i>
            <span class="section-title-ja">こんなアクティビティができます</span>
          </h2>
    <?php
      while ( have_rows('facility_activity') ) : the_row();
    ?>
          <div class="activity">
            <div class="activity__image">
              <img src="<?php echo get_sub_field('facility_activity_image'); ?>" alt="">
            </div>
            <div class="activity__main">
              <h3 class="activity__heading"><?php echo get_sub_field('facility_activity_title'); ?></h3>
              <div class="activity__text">
                <p><?php echo get_sub_field('facility_activity_detail'); ?></p>
              </div>
            </div>
          </div>
    <?php
      endwhile;

    else :
    endif;
    ?>
        </section>


        <?php get_template_part('var/single-interview'); ?>

        <?php if ( have_rows('facility_points') || have_rows('facility_activity') ): ?>
        <div class="button-balloon-wrapper--last">
          <?php if($incentiveFee == true): ?>
          <p class="button-balloon">ホテル業界を知り尽くした専門家に無料で相談できます！</p>
          <a href="<?php echo esc_url(home_url('/')); ?>consult/" class="button button--lg button--orange gtm-cv-3">専門家に相談する</a>
          <?php else: ?>
          <p class="button-balloon">詳しい情報を見たい方はこちら！</p>
          <a href="<?php echo $official_website_url; ?>" class="button button--lg button--orange gtm-cv-3" target="_blank">公式サイトで詳しくみる</a>
          <?php endif; ?>
          <?php /*
          <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン無料問い合わせ！</p>
          <div class="buttons">
            <div class="buttons__item">
              <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討中の施設に</span><span>まとめて問い合わせする</span></span></span></a>
            </div>
            <div class="buttons__item">
              <a class="button button--contact" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow"><span>施設に問い合わせする</span></a>
            </div>
          </div>

          <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
          */ ?>
        </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === '会場情報' || get_field('edit_type') === '会場情報（簡易宿所）' )  : ?>
      <div class="inner">
        <section class="normal-section" id="place-info">
          <div class="section-title-area">
            <h2 class="section-title">
              <span class="section-title-en">PLACE INFO</span>
              <img src="/co-mit_renew_201910/img/icon_info.png">
              <span class="section-title-ja">会場情報</span>
            </h2>
            <?php if ( get_field('meeting_pr') ) : ?>
            <p class="section-catch"><?php echo nl2br(get_field('meeting_pr')); ?></p>
            <?php endif; ?>
          </div>
        </section>
        
        <?php if ( get_field('edit_type') === '会場情報' )  : ?>
          <section class="normal-section">
            <h2 class="heading-7 heading-7--table">表で比較</h2>
            <div class="comparison-table">
              <div class="comparison-table__head">
                <div class="comparison-table__head__cel comparison-table__head__cel--left">
                  <p>会場名</p>
                </div>
                <div class="comparison-table__head__cel">
                  <p>面積</p>
                </div>
                <div class="comparison-table__head__cel">
                  <p>天井高</p>
                </div>
                <div class="comparison-table__head__cel comparison-table__head__cel--pd0">
                  <div class="comparison-table__head__cel__col">収容人数</div>
                  <div class="comparison-table__head__cel__col">
                    <div class="comparison-table__head__cel__detail">スクール</div>
                    <div class="comparison-table__head__cel__detail">口の字</div>
                    <div class="comparison-table__head__cel__detail">島型</div>
                  </div>
                </div>
                <div class="comparison-table__head__cel comparison-table__head__cel--left">
                  <p>1日の利用料金目安</p>
                </div>
              </div>
              <?php
              // 繰り返しフィールドにデータがあれば表示する
              if( have_rows('meeting_detail') ):
                $post_count = 1;

                while ( have_rows('meeting_detail') ) : the_row();
                      if ( $post_count == 1) {
              ?>
                          <div class="comparison-table__body js-line-hidden">
              <?php
                      }
                      if ( $post_count == 6) {
              ?>
                          </div>
                          <!-- <p class="btn-area"><span class="button button--arrow-2" data-accordion02-open>会場をさらに表示</span></p> -->
                          <div class="comparison-table__body" data-accordion02 style="display:none;">
              <?php
                      }
              ?>
              <div class="comparison-table__item">
                <h3 class="comparison-table__cel comparison-table__cel--head">
                  <p><?php echo get_sub_field('meeting_name'); ?></p>
                </h3>
                <div class="comparison-table__cel">
                  <p><?php if( get_sub_field('meeting_area') ): the_sub_field('meeting_area'); else : echo '-'; endif; ?></p>
                </div>
                <div class="comparison-table__cel">
                  <p><?php if( get_sub_field('meeting_height') ): the_sub_field('meeting_height'); else : echo '-'; endif; ?></p>
                </div>
                <div class="comparison-table__cel comparison-table__cel--pd0">
                  <div class="comparison-table__cel__col">
                    <div class="comparison-table__cel__detail"><?php if( get_sub_field('meeting_capa_school') ): the_sub_field('meeting_capa_school'); else : echo '-'; endif; ?></div>
                    <div class="comparison-table__cel__detail"><?php if( get_sub_field('meeting_capa_ro') ): the_sub_field('meeting_capa_ro'); else : echo '-'; endif; ?></div>
                    <div class="comparison-table__cel__detail"><?php if( get_sub_field('meeting_capa_island') ): the_sub_field('meeting_capa_island'); else : echo '-'; endif; ?></div>
                  </div>
                </div>
                <div class="comparison-table__cel comparison-table__cel--price">
                  <p>
                    <?php if( get_sub_field('meeting_fee') ): the_sub_field('meeting_fee'); else : echo 'お問い合わせください'; endif; ?>
                    <?php
                      $_form_url = get_form_url();
                      if ($_form_url != "#") :
                    ?>
                      <a href="<?php echo $_form_url ?>">問い合わせる</a>
                    <?php endif; ?>
                  </p>
                </div>
              </div>
            <?php
              $post_count++;

              endwhile;
            ?>
            </div>

            </div>
            <?php if ( $post_count >= 6): ?>
              <p class="btn-area "><span class="button button--arrow-2" data-accordion02-open>会場をさらに表示</span></p>
            <?php endif; ?>
            <?php
            else :
            endif;
            ?>
          </section>

          <section class="normal-section">
            <h2 class="heading-7 heading-7--image">写真付きで比較</h2>
            <?php
            // 繰り返しフィールドにデータがあれば表示する
            if( have_rows('meeting_detail') ):

              $post_count = 1;

              while ( have_rows('meeting_detail') ) : the_row();

                    if ( $post_count == 1) : echo '<ul class="place-info-data">'; endif;
                    if ( $post_count == 4) : echo '</ul><p class="btn-area"><span class="button button--arrow-2" data-accordion-open>会場をさらに表示</span></p><ul class="place-info-data" data-accordion style="display:none;">'; endif;

                    echo '<li><div class="place-info-data-head">';
                    echo '<h3>'. get_sub_field('meeting_name') .'</h3>';
                    if ( get_sub_field('meeting_image') ) :
                      echo '<p class="place-info-data-photo"><a href="'. get_sub_field('meeting_image') .'" data-fancybox="gallery"><span class="photo-zoom" data-photo-zoom><i class="icon-zoom"></i></span><img src="'. get_sub_field('meeting_image') .'" alt=""></a></p>';
                    else :
                      echo '<p class="place-info-data-photo"><img src="http://placehold.jp/60/00b2b0/ffffff/850x567.png?text=NOW%20PRINTING" alt=""></p>';
                    endif;
                    echo '</div>';
                    echo '<ul class="place-info-data-list">';
                    echo '<li><dl><dt>面積</dt><dd>';
                      if( get_sub_field('meeting_area') ): the_sub_field('meeting_area'); else : echo '-'; endif;
                    echo '</dd></dl></li>';
                    echo '<li><dl><dt>天井高</dt><dd>';
                      if( get_sub_field('meeting_height') ): the_sub_field('meeting_height'); else : echo '-'; endif;
                    echo '</dd></dl></li>';
                    echo '</ul>';
                    echo '<h4>収容人数</h4><ul class="place-info-data-list">';
                    echo '<li class="with-border"><dl><dt>スクール</dt><dd>';
                      if( get_sub_field('meeting_capa_school') ): the_sub_field('meeting_capa_school'); else : echo '-'; endif;
                    echo '</dd></dl></li>';
                    echo '<li class="with-border"><dl><dt>島型</dt><dd>';
                      if( get_sub_field('meeting_capa_island') ): the_sub_field('meeting_capa_island'); else : echo '-'; endif;
                    echo '</dd></dl></li>';
                    echo '<li class="with-border"><dl><dt>口の字</dt><dd>';
                      if( get_sub_field('meeting_capa_ro') ): the_sub_field('meeting_capa_ro'); else : echo '-'; endif;
                    echo '</dd></dl></li>';
                    echo '</ul>';
                    echo '<h4>1日の利用料金目安</h4><p class="place-info-data-price">';
                      if( get_sub_field('meeting_fee') ): the_sub_field('meeting_fee'); else : echo 'お問い合わせください'; endif;
                    echo '</p>';
                    if ( get_sub_field('meeting_kaido_url') ) :
                      echo '<a href="'. get_sub_field('meeting_kaido_url') .'" class="more-btn" target="_blank">MORE<img src="/co-mit_renew_201910/img/popup_icon.png"></a>';
                    endif;
                    echo '</li>';

              $post_count++;

              endwhile;

              echo '</ul>';

            else :
            endif;
            ?>
          </section>
        <?php else: /* 会場情報（簡易宿所）*/ ?>
          <?php if( have_rows('meeting_detail_kani') ): ?>
            <?php while ( have_rows('meeting_detail_kani') ) : the_row(); ?>
              <?php if( have_rows('img_block') ): /* 画像ありブロック */ ?>
                <ul class="meeting-detail-list">
                  <?php while ( have_rows('img_block') ) : the_row(); ?>
                    <li>
                      <img src="<?php the_sub_field('meeting_image');  ?>">
                      <p class="meeting-detail-list__name"><?php the_sub_field('meeting_name');  ?></p>
                      <p class="meeting-detail-list__text"><?php the_sub_field('meeting_text_kani');  ?></p>
                    </li>
                  <?php endwhile; ?>
                </ul>
              <?php endif;?>
              <?php if( have_rows('noimg_block') ): /* 画像なしブロック */ ?>
                <ul class="meeting-detail-list">
                  <?php while ( have_rows('noimg_block') ) : the_row(); ?>
                    <li>
                      <p class="meeting-detail-list__name"><?php the_sub_field('meeting_name');  ?></p>
                      <p class="meeting-detail-list__text"><?php the_sub_field('meeting_text_kani');  ?></p>
                    </li>
                  <?php endwhile; ?>
                </ul>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endif; ?>
        <?php endif; ?>

        <section class="normal-section">
          <?php
          // 繰り返しフィールドにデータがあれば表示する
          if( have_rows('floor_images') ):
            echo'<h2 class="heading-7 heading-7--floor">フロア図</h2>';

            $post_count = 1;

            while ( have_rows('floor_images') ) : the_row();
              if ( $post_count == 1) : echo '<ul class="staying-photo-list" data-photo-list>'; endif;
              if ( get_sub_field('floor_image') ) :
                ?>
                <?php
                  $attachment_id = get_sub_field('floor_image');
                ?>
                <li><a href="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" data-fancybox="gallery"><span class="photo-zoom" data-photo-zoom><i class="icon-zoom"></i></span>
                <picture>
                  <source media="(max-width: 768px)" srcset="<?php echo wp_get_attachment_image_url($attachment_id,'medium'); ?>" >
                  <img src="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" alt="">
                </picture>
                </a></li>
                <?php
              else :
              endif;

            $post_count++;
            endwhile;
            echo '</ul>';

          else :
          endif;
          ?>
          <ul class="place-info-equipment">
            <li>
              <dl>
                <dt><img src="/co-mit_renew_201910/img/icon_wifi.png"><span class="place-info-equipment-name">設備</span></dt>
                <dd>
                  <ul>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('設備 - Wi-Fiあり', $equipment ) ) {
              echo '<li>Wi-Fiあり</li>';
            }
            if( $equipment && in_array('設備 - 会場専用回線あり', $equipment ) ) {
              echo '<li>会場専用回線あり</li>';
            }
          ?>
                  </ul>
                </dd>
              </dl>
            </li>
            <li>
              <dl>
                <dt><img src="/co-mit_renew_201910/img/icon_chair.png"><span class="place-info-equipment-name">備品</span></dt>
                <dd>
                  <ul>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('備品 - 椅子', $equipment ) ) {
              echo '<li>椅子</li>';
            }
          ?>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('備品 - テーブル', $equipment ) ) {
              echo '<li>テーブル</li>';
            }
            if( $equipment && in_array('備品 - ホワイトボード', $equipment ) ) {
              echo '<li>ホワイトボード</li>';
            }
            if( $equipment && in_array('備品 - 電源タップ（延長コード）', $equipment ) ) {
              echo '<li>電源タップ（延長コード）</li>';
            }
          ?>
                  </ul>
                </dd>
              </dl>
            </li>
            <li>
              <dl>
                <dt><img src="/co-mit_renew_201910/img/icon_onkyo.png"><span class="place-info-equipment-name">音響</span></dt>
                <dd>
                  <ul>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('音響 - 機器あり（ポータブル）', $equipment ) ) {
              if( $equipment && in_array('音響 - 機器あり（常設）', $equipment ) ) {
                echo '<li>機器あり</li>';
              } else {
                echo '<li>機器あり(ポータブル)</li>';
              }
            } else
            if( $equipment && in_array('音響 - 機器あり（常設）', $equipment ) ) {
              if( $equipment && in_array('音響 - 機器あり（ポータブル）', $equipment ) ) {
                echo '<li>機器あり</li>';
              } else {
                echo '<li>機器あり(常設)</li>';
              }
            }
          ?>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('音響 - マイク', $equipment ) ) {
              echo '<li>マイク</li>';
            }
          ?>
                  </ul>
                </dd>
              </dl>
            </li>
            <li>
              <dl>
                <dt><img src="/co-mit_renew_201910/img/icon_tv.png"><span class="place-info-equipment-name">映像</span></dt>
                <dd>
                  <ul>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('映像 - プロジェクター・スクリーン', $equipment ) ) {
              echo '<li>プロジェクター・スクリーン</li>';
            }
          ?>
                  </ul>
                </dd>
              </dl>
            </li>
          </ul>
          <div class="common-detail">
            <p class="detail-note">※詳細につきましては施設にお問い合わせください</p>
          </div>

          <?php get_template_part('var/single-interview'); ?>

          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>
        </section>

      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === '宿泊' )  : ?>
      <div class="inner">
        <section class="normal-section" id="stay-info">
          <div class="section-title-area">
            <h2 class="section-title"><span class="section-title-en">STAYING</span><img src="/co-mit_renew_201910/img/icon_stay.png"><span class="section-title-ja">宿泊</span></h2>
      <?php if ( get_field('lodging_pr') ) : ?>
            <p class="section-catch"><?php echo nl2br(get_field('lodging_pr')); ?></p>
      <?php endif; ?>
          </div>

        <?php
        // 繰り返しフィールドにデータがあれば表示する
        if( have_rows('lodging_images') ):

          $post_count = 1;

          while ( have_rows('lodging_images') ) : the_row();
            if ( $post_count == 1) : echo '<ul class="staying-photo-list" data-photo-list>'; endif;
            if ( get_sub_field('lodging_image') ) :
            ?>
            <?php
              $attachment_id = get_sub_field('lodging_image');
            ?>
            <li><a href="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" data-fancybox="gallery"><span class="photo-zoom" data-photo-zoom><i class="icon-zoom"></i></span>
            <picture>
              <source media="(max-width: 768px)" srcset="<?php echo wp_get_attachment_image_url($attachment_id,'medium'); ?>" >
              <img src="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" alt="">
            </picture>
            </a></li>
            <?php
            else :
            endif;

          $post_count++;
          endwhile;
          echo '</ul>';

        else :
        endif;
        ?>

    <?php
    // 繰り返しフィールドにデータがあれば表示する
    if( have_rows('lodging_room') ):

      echo '<div class="common-detail"><h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_room.png">部屋タイプ一覧</h3><div class="staying-type-table-wrapeer"><table class="staying-type-table"><thead><tr><th>部屋名</th><th>部屋タイプ</th><th>総収容人数</th><th>広さ（面積）</th><th>バス・トイレ</th><th>インターネット</th><th>総室数</th></tr></thead>';

      $post_count = 1;

      while ( have_rows('lodging_room') ) : the_row();

        if ($post_count == 1){
          echo '<tbody class="js-line-hidden">';
        }

        if ($post_count == 6){
          echo '</tbody>';
          echo '<tbody data-accordion03 style="display:none;">';
        }

        echo '<tr><th>'. get_sub_field('lodging_room_name') .'</th>';
        echo '<td>'. get_sub_field('lodging_room_type') .'</td>';
        echo '<td>';
          if( get_sub_field('lodging_room_capa') ): the_sub_field('lodging_room_capa'); else : echo '-'; endif;
        echo '</td>';
        echo '<td>';
          if( get_sub_field('lodging_room_large') ): the_sub_field('lodging_room_large'); else : echo '-'; endif;
        echo '</td>';
        echo '<td>'. get_sub_field('lodging_room_bath') .'</td>';
        echo '<td>'. get_sub_field('lodging_room_net') .'</td>';
        echo '<td>';
          if( get_sub_field('lodging_room_amount') ): the_sub_field('lodging_room_amount'); else : echo '-'; endif;
        echo '</td></tr>';

        $post_count++;

      endwhile;

      if ( $post_count > 6 ){
        echo '</tbody></table></div>';
        echo '<p class="btn-area"><span class="button button--arrow-2" data-accordion03-open>もっと見る</span></p></div>';
      } else {
        echo '</tbody></table></div></div>';
      }

    else :
    endif;
    ?>

          <div class="common-detail">
            <h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_amenity.png">アメニティ・部屋備品</h3>
            <ul class="staying-amenity-list">
              <li>
                <dl>
                  <?php $equipment = get_field('lodging_equipment');?>
                  <dt>バスタオル</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('バスタオル', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>フェイスタオル</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('フェイスタオル', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>部屋着</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('部屋着', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>浴衣</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('浴衣', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>シャンプー</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('シャンプー', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>ボディソープ(石鹸)</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('ボディソープ（石鹸）', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>ヘアブラシ</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('ヘアブラシ', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>                  
                </dl>
              </li>
              <li>
                <dl>
                  <dt>カミソリ</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('カミソリ', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>                  
                </dl>
              </li>
              <li>
                <dl>
                  <dt>歯ブラシ</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('歯ブラシ', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>                  
                </dl>
              </li>
              <li>
                <dl>
                  <dt>ドライヤー</dt>
                  <dd><img src="/co-mit_renew_201910/img/icon_<?php if (! ($equipment && in_array('ドライヤー', $equipment)) ) {echo 'no';}else{echo 'ok'; }?>.png"></dd>                  
                </dl>
              </li>
            </ul>
          <p class="detail-note">※詳細につきましては施設にお問い合わせください</p>
          </div>

          <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>

        </section>
      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === 'お食事' )  : ?>
      <div class="inner">
        <section class="normal-section" id="meal-info">
          <div class="section-title-area">
            <h2 class="section-title"><span class="section-title-en">MEAL</span><img src="/co-mit_renew_201910/img/icon_meal.png"><span class="section-title-ja">お食事</span></h2>
            <?php if ( get_field('meal_main_img') ) : ?>
              <img class="section-mainimg" src="<?php the_field('meal_main_img'); ?>">
            <?php endif; ?>
              <?php if ( get_field('meal_pr') ) : ?>
                    <p class="section-catch"><?php echo nl2br(get_field('meal_pr')); ?></p>
            <?php endif; ?>
          </div>

       <div class="common-detail">
      <?php
      // 繰り返しフィールドにデータがあれば表示する
      if( have_rows('meal') ):

        echo '<ul class="meal-list">';

        while ( have_rows('meal') ) : the_row();
          echo '<li><article class="meal-list-row">';
          if ( get_sub_field('meal_image') ) :
            echo '<p class="meal-list-photo"><img src="'. get_sub_field('meal_image') .'" alt=""></p>';
          else :
            echo '<p class="meal-list-photo"><img src="http://placehold.jp/60/00b2b0/ffffff/1082x544.png?text=NOW%20PRINTING" alt=""></p>';
          endif;
          echo '<div class="meal-list-detail">';
          echo '<h3>'. get_sub_field('meal_detail_title') .'</h3>';
          if ( get_sub_field('meal_detail') ) :
            echo '<p>'. get_sub_field('meal_detail') .'</p>';
          endif;
          echo '<table class="meal-list-table"><tr><th>料金</th><td>';
            if( get_sub_field('meal_fee') ): the_sub_field('meal_fee'); else : echo '-'; endif;
          echo '</td></tr>';
          echo '<th>時間</th><td>';
            if( get_sub_field('meal_time') ): the_sub_field('meal_time'); else : echo '-'; endif;
          echo '</td></tr>';
          echo '<th>形式</th><td>';
            if( get_sub_field('meal_style') ): the_sub_field('meal_style'); else : echo '-'; endif;
          echo '</td></tr>';
          echo '</table></div></article></li>';
        endwhile;

        echo '</ul>';

      else :
      endif;
      ?>

    <?php if ( get_field('meal_supper') ) : ?>
    <ul class="meal-sub-list">
                <li>
                  <dl>
                    <dt>夜食</dt>
                    <dd><?php echo nl2br(get_field('meal_supper')); ?></dd>
                  </dl>
                </li>
              </ul>
    <?php endif; ?>
       </div>

           <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>
        </section>
      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === '設備・サービス' )  : ?>
      <div class="inner">
        <section class="normal-section" id="service-info">
          <div class="section-title-area">
            <h2 class="section-title"><span class="section-title-en">FACILITY &amp; SERVICE</span><img src="/co-mit_renew_201910/img/icon_setsubi.png"><span class="section-title-ja">設備・サービス</span></h2>
      <?php if ( get_field('service_pr') ) : ?>
                <p class="section-catch"><?php echo nl2br(get_field('service_pr')); ?></p>
      <?php endif; ?>
          </div>

    <?php if ( get_field('service_head') || get_field('service_text') ) : ?>
              <div class="service-area-row">
                <div class="service-area-photo">
                  <?php
                  // 繰り返しフィールドにデータがあれば表示する
                  if( have_rows('service_images') ): ?>
                    <div class="swiper slider">
                      <div class="swiper-wrapper">
                      <?php while ( have_rows('service_images') ) : the_row();
                        // echo '<p><img src="'. get_sub_field('service_image') .'" alt=""></p>'; 
                      ?>
                      <!-- スライダー -->
                        <div class="swiper-slide">
                          <img src="<?php the_sub_field('service_image') ?>" alt="" />
                        </div>
                      <?php endwhile; ?>
                      </div>
                    </div>
                    <!-- サムネイル -->
                    <div class="swiper slider-thumbnail">
                      <div class="swiper-wrapper">
                        <?php while ( have_rows('service_images') ) : the_row(); ?>
                        <div class="swiper-slide">
                          <img src="<?php the_sub_field('service_image') ?>" alt="" />
                        </div>
                        <?php endwhile; ?>
                      </div>
                    </div>
                  <?php else :
                    if ( get_field('service_head') ) :
                      echo '<p><img src="http://placehold.jp/60/00b2b0/ffffff/854x502.png?text=NOW%20PRINTING" alt=""></p>';
                    endif;
                  endif;
                  ?>
            </div>
    <?php if ( get_field('service_head') || get_field('service_text') ) : ?>
            <div class="service-area-text">
                  <?php if ( get_field('service_head') ) : ?><h3><?php echo nl2br(get_field('service_head')); ?></h3><?php endif; ?>
                  <?php if ( get_field('service_text') ) : ?><p><?php echo nl2br(get_field('service_text')); ?></p><?php endif; ?>
            </div>
    <?php endif; ?>
          </div>
      <?php endif; ?>
      
      <?php $rental = get_field('equipment_rental'); ?>
      <?php if ( $rental['equipment_text'] || $rental['rental_text'] ) : ?>
        <div class="common-detail">
          <h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_chair02.svg">備品・レンタル</h3>
          <ul class="service-list">
          <?php if ( $rental['equipment_text'] ) : ?>
            <li>
              <dl>
                <dt>備品</dt>
                <dd><?php echo nl2br($rental['equipment_text']);  ?></dd>
              </dl>
            </li>
            <?php endif; ?>
            <?php if ( $rental['rental_text']  ) : ?>
            <li>
              <dl>
                <dt>レンタル</dt>
                <dd><?php echo nl2br($rental['rental_text']);  ?></dd>
              </dl>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      <?php endif; ?>

          <div class="common-detail">
            <h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_like.png">基本サービス</h3>
            <ul class="service-list">
              <li>
                <dl>
                  <dt>付帯設備</dt>
                  <dd>
                    <ul>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('大浴場', $equipment) ) {echo '<li>大浴場</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('温泉', $equipment) ) {echo '<li>温泉</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('スパ', $equipment) ) {echo '<li>スパ</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('体育館', $equipment) ) {echo '<li>体育館</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('グラウンド', $equipment) ) {echo '<li>グラウンド</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('プール', $equipment) ) {echo '<li>プール</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('スポーツジム', $equipment) ) {echo '<li>スポーツジム</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('多目的トイレ', $equipment) ) {echo '<li>多目的トイレ</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('バリアフリー対応', $equipment) ) {echo '<li>バリアフリー対応</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('BBQスペース', $equipment) ) {echo '<li>BBQスペース</li>';}?>
                    </ul>
                  </dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>サービス</dt>
                  <dd>
                    <ul>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('ランドリー', $equipment) ) {echo '<li>ランドリー</li>';}?>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('クリーニングサービス', $equipment) ) {echo '<li>クリーニングサービス</li>';}?>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('宅配便取扱い', $equipment) ) {echo '<li>宅急便取扱い</li>';}?>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('コピーサービス', $equipment) ) {echo '<li>コピーサービス</li>';}?>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('送迎バスあり', $equipment) ) {echo '<li>送迎バスあり</li>';}?>
                    </ul>
                  </dd>
                </dl>
              </li>
            </ul>
          </div>

          <div class="common-detail">
            <h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_pin_2.svg" width='40'>アクティビティ</h3>
            <ul class="service-list">
              <li>
                <dl>
                  <dt>アクティビティ</dt>
                  <dd>
                    <ul>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ゴルフ', $equipment) ) {echo '<li>ゴルフ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('パターゴルフ', $equipment) ) {echo '<li>パターゴルフ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('レンタサイクル', $equipment) ) {echo '<li>レンタサイクル</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('プール', $equipment) ) {echo '<li>プール</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('テニス', $equipment) ) {echo '<li>テニス</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('乗馬', $equipment) ) {echo '<li>乗馬</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('アスレチック', $equipment) ) {echo '<li>アスレチック</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('BBQ', $equipment) ) {echo '<li>BBQ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('スノーボード', $equipment) ) {echo '<li>スノーボード</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('スキー', $equipment) ) {echo '<li>スキー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('スノーモービル', $equipment) ) {echo '<li>スノーモービル</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ヨガ', $equipment) ) {echo '<li>ヨガ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('フィットネス', $equipment) ) {echo '<li>フィットネス</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('カラオケ', $equipment) ) {echo '<li>カラオケ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ゲームコーナー', $equipment) ) {echo '<li>ゲームコーナー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('卓球', $equipment) ) {echo '<li>卓球</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ビリヤード', $equipment) ) {echo '<li>ビリヤード</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ダーツ', $equipment) ) {echo '<li>ダーツ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ボウリング', $equipment) ) {echo '<li>ボウリング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('シュノーケリング', $equipment) ) {echo '<li>シュノーケリング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ダイビング', $equipment) ) {echo '<li>ダイビング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('クルージング', $equipment) ) {echo '<li>クルージング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('サーフィン', $equipment) ) {echo '<li>サーフィン</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ジェットスキー', $equipment) ) {echo '<li>ジェットスキー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('パラセーリング', $equipment) ) {echo '<li>パラセーリング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('イルカ・ホエールウォッチング', $equipment) ) {echo '<li>イルカ・ホエールウォッチング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ロッククライミング・ボルダリング', $equipment) ) {echo '<li>ロッククライミング・ボルダリング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('トレッキング', $equipment) ) {echo '<li>トレッキング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('パラグライダー', $equipment) ) {echo '<li>パラグライダー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ハングライダー', $equipment) ) {echo '<li>ハングライダー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('熱気球', $equipment) ) {echo '<li>熱気球</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ラフティング', $equipment) ) {echo '<li>ラフティング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('キャニオニング', $equipment) ) {echo '<li>キャニオニング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('カヤック', $equipment) ) {echo '<li>カヤック</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('フィッシング', $equipment) ) {echo '<li>フィッシング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ものづくり体験', $equipment) ) {echo '<li>ものづくり体験</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('その他', $equipment) ) {echo '<li>その他</li>';}?>
                    </ul>
                  </dd>
                </dl>
              </li>
            </ul>
          </div>

          <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>

        </section>
      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === 'アクセス・周辺情報' )  : ?>
      <div class="inner">
        <section class="normal-section" id="service-info">
          <div class="section-title-area">
            <h2 class="section-title"><span class="section-title-en">ACCESS &amp; NEARBY INFO</span><img src="/co-mit_renew_201910/img/icon_access.png"><span class="section-title-ja">アクセス・周辺情報</span></h2>
          </div>

    <?php
      if( have_rows('facility_address',$comit_parent_id) ):
        while ( have_rows('facility_address',$comit_parent_id) ) : the_row();
          /*echo '〒';
          the_sub_field('facility_zip',$comit_parent_id);
          echo '　';
          the_sub_field('facility_pref',$comit_parent_id);
          the_sub_field('facility_city',$comit_parent_idm);
          the_sub_field('facility_street',$comit_parent_id);*/
	 $facility_address = '〒' . get_sub_field('facility_zip',$comit_parent_id) . get_sub_field('facility_pref',$comit_parent_id) . get_sub_field('facility_city',$comit_parent_id) . get_sub_field('facility_street',$comit_parent_id);
	 $facility_coord = get_field('facility_coord',$comit_parent_id);
        endwhile;
      else :
      endif;
    ?>
    <?php
      //echo '<div class="access-map"><script async src="https://static.media.cld.navitime.jp/scripts/media/biz/widget/map/tag.bundle.js?cid=B000006&amp;p1Address=';
      //echo $facility_address;
      echo '<div class="access-map"><script async src="https://static.media.cld.navitime.jp/scripts/media/biz/widget/map/tag.bundle.js?cid=B000006&amp;';
      if ( $facility_coord ):
	echo 'p1Coord=' . $facility_coord;
      else :
	echo 'p1Address=' . $facility_address;
      endif;
      echo '&amp;p1Name=';
      echo get_post($comit_parent_id)->post_title;
      echo '&amp;firstPinCenter=true&amp;showSta=true&amp;height=500px"></script></div>';
    ?>

      <?php if ( get_field('navitime_url') ) : ?>
          <?php /*<div id="navitime-loader" class="access-map"></div>*/ ?>
      <?php endif; ?>

          <div class="access-info">
            <h3 class="access-info-name"><?php echo get_post($comit_parent_id)->post_title; ?></h3>
            <div class="access-info-row">
              <div class="access-info-col">
                <dl>
                  <dt>住所</dt>
                  <dd><?php echo $facility_address; ?>
    <?php if ( get_field('largemap_url') ) : ?>（<a href="<?php echo get_field('largemap_url'); ?>" target="_blank" rel="nofollow">MAP</a>）<?php endif; ?>
      </dd>
                </dl>
    <?php if( !$incentiveFee == true): ?>
                <dl>
                  <dt>TEL</dt>
                  <dd><?php echo get_field('facility_tel',$comit_parent_id); ?></dd>
                </dl>
    <?php endif; ?>
              </div>
              <div class="access-info-col">
                <dl>
                  <dt>最寄駅</dt>
                  <dd>
      <?php
      // 繰り返しフィールドにデータがあれば表示する
      if( have_rows('station') ):
        while ( have_rows('station') ) : the_row();
          echo '<p>'. get_sub_field('station_rosen');
          if( get_sub_field('station_name') ) {
            echo '「'. get_sub_field('station_name') .'」駅</p>';
          }
        endwhile;
      else :
        echo '―';
      endif;
      ?></dd>
                </dl>
              </div>
            </div>
      <?php if ( get_field('streetview_url') ) : ?>
            <div class="btn-area">
              <p class="btn-normal"><a href="<?php echo get_field('streetview_url'); ?>" target="_blank" rel="nofollow">Googleストリートビューで見る</a></p>
            </div>
      <?php endif; ?>
          </div><!-- /access-info -->

    <?php
          // 繰り返しフィールドにデータがあれば表示する
          if( have_rows('by_train') ):
            echo '<div class="common-detail">';

            echo '<h3 class="common-detail-title">';
            echo '<img src="/co-mit_renew_201910/img/icon_train.png">電車でお越しの場合';
            if( get_field('by_train_reserve') ) {
              echo '<p class="access-list-link pc-only"><a href="';
              echo get_field('by_train_reserve');
              echo '" target="_blank" rel="nofollow"><span>サクッと簡単</span><span>新幹線の手配はこちら</span></a></p>';
            }
            echo '</h3>';

            echo '<ul class="access-list">';
            while ( have_rows('by_train') ) : the_row();
              echo '<li><dl><dt>';
              if( get_sub_field('by_train_title') ) {
                echo get_sub_field('by_train_title');
              } else {
                echo '主要駅から';
              }
              echo '</dt><dd>';
              echo get_sub_field('by_train_detail');
              echo '</dd></dl></li>';
            endwhile;
            echo '</ul>';
            if( get_field('by_train_reserve') ) {
              echo '<p class="access-list-link sp-only-2"><a href="';
              echo get_field('by_train_reserve');
              echo '" target="_blank" rel="nofollow"><span>サクッと簡単</span><span>新幹線の手配はこちら</span></a></p>';
            }
            echo '</div>';
          else :
          endif;
    ?>

    <?php if ( get_field('by_car') || have_rows('about_parking') )  : ?>
          <div class="common-detail">
            <h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_car.png">車でお越しの場合</h3>
            <ul class="access-list">
              <?php if ( get_field('by_car') ) : ?><li class="access-list-car"><?php echo get_field('by_car'); ?></li><?php endif; ?>
              <?php
              // 繰り返しフィールドにデータがあれば表示する
              if( have_rows('about_parking') ):
                while ( have_rows('about_parking') ) : the_row();
                echo '<li class="access-list-parking border-around"><h4>';
                if( get_sub_field('about_parking_title') ) {
                  echo get_sub_field('about_parking_title');
                } else {
                  echo '駐車場のご案内';
                }
                echo '</h4><p>';
                echo get_sub_field('about_parking_deital');
                echo '</p></li>';
                endwhile;
              else :
              endif;
              ?>
            </ul>
          </div>
  <?php endif; ?>
        <?php
          // 繰り返しフィールドにデータがあれば表示する
            if( have_rows('by_air') ):
              echo '<div class="common-detail">';
              echo '<h3 class="common-detail-title">';
              echo '<i class="icon-airplane"></i>飛行機でお越しの場合';
              if( get_field('by_air_reserve') ) {
                echo '<p class="access-list-link pc-only"><a href="';
                echo get_field('by_air_reserve');
                echo '" target="_blank" rel="nofollow"><span>サクッと簡単</span><span>航空券の手配はこちら</span></a></p>';
              }
              echo '</h3>';
              echo '<ul class="access-list">';
              while ( have_rows('by_air') ) : the_row();
                echo '<li><dl><dt>';
                if( get_sub_field('by_air_title') ) {
                  echo get_sub_field('by_air_title');
                } else {
                  echo '空港から';
                }
                echo '</dt><dd>';
                echo get_sub_field('by_air_detail');
                echo '</dd></dl></li>';
              endwhile;
              echo '</ul>';
              if( get_field('by_air_reserve') ) {
                echo '<p class="access-list-link sp-only-2"><a href="';
                echo get_field('by_air_reserve');
                echo '" target="_blank" rel="nofollow"><span>サクッと簡単</span><span>航空券の手配はこちら</span></a></p>';
              }
              echo '</div>';
            else :
            endif;
        ?>

        <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>

        </section>

      </div>
      <?php endif; ?>


    </div>
  </div>
<?php
}

function sp_fv () {
  global $comit_parent_id, $comit_permalink, $plan_type, $plan_type2, $incentiveFee, $favorite_id, $official_website_url, $post, $interview_post
  ;
?>
<?php
	// 指定日数以内の投稿にNEWマークを表示する
	$days = 31;
	$today = date_i18n('U');
  $entry_day = get_the_time('U');
  $keika = date('U',($today - $entry_day)) / 86400;
?>

  <div class="l-wrapper">
    <section class="detail-name-area">
      <div class="detail-name-area__inner">
        <?php $terms = get_the_terms($comit_parent_id,'hotel_type'); ?>
        <?php $hotel_type = $terms[0]->name; ?>
        <div class="heading-8"><?php if ( $days > $keika ): ?><span class="icon__new">NEW</span><?php endif; ?><span><?php echo $hotel_type; ?></span><br><h1><?php if ( isset($comit_parent_id) ){ echo get_post($comit_parent_id)->post_title; } else { echo get_the_title(); } ?></h1></div>
        <div class="favorite-button js-favorite" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リスト追加</span><span>検討リスト追加済</span></p></div>
      </div>

      <!-- ▼ 既存流用 ▼ -->
      <div class="detail-name-info" id="detail-name-info">
        <ul class="detail-data-list">
          <li>
            <dl>
              <dt>エリア</dt>
              <dd><?php if ( isset($comit_parent_id) ){ the_field('facility_area',$comit_parent_id); } else { the_field('facility_area'); } ?></dd>
            </dl>
          </li>
          <li>
            <dl>
              <dt>料金目安<a href="#modelcase-modal" class="js-modal-open"><img src="/co-mit_renew_201910/img/icon_question.png"></a></dt>
              <dd>
        <?php
          if ( isset($comit_parent_id) ){
            if ( get_field('facility_fee',$comit_parent_id)){
              echo '大人1名：¥'. number_format(str_replace('～','',get_field('facility_fee',$comit_parent_id))) . '～';
            } else {
              echo 'お問い合わせください';
            }
          } else {
            if ( get_field('facility_fee')){
              echo '大人1名：¥'. number_format(str_replace('～','',get_field('facility_fee'))) . '～';
            } else {
              echo 'お問い合わせください';
            }
          }
        ?>
        </dd>
            </dl>
          </li>
          <li>
            <dl>
              <dt>宿泊可能人数</dt>
              <dd>
          <?php
            if ( isset($comit_parent_id) ){
              $group_name = get_field('facility_capa',$comit_parent_id);
              if( $group_name['facility_capa_min'] || $group_name['facility_capa_max'] ):
                echo empty($group_name['facility_capa_min']) ? "" : "{$group_name['facility_capa_min']}名";
                echo '～';
                echo empty($group_name['facility_capa_max']) ? "" : number_format(str_replace('名','',$group_name['facility_capa_max']))."名";
              else:
                echo 'お問い合わせください';
              endif;
            } else {
              $group_name = get_field('facility_capa');
              if( $group_name['facility_capa_min'] || $group_name['facility_capa_max'] ):
                echo empty($group_name['facility_capa_min']) ? "" : "{$group_name['facility_capa_min']}名";
                echo '～';
                echo empty($group_name['facility_capa_max']) ? "" : number_format(str_replace('名','',$group_name['facility_capa_max']))."名";
              else:
                echo 'お問い合わせください';
              endif;
            }
          ?>
          </dd>
            </dl>
          </li>
          <li>
            <dl>
              <dt>会場面積</dt>
              <dd>
          <?php
            if ( isset($comit_parent_id) ){
              if ( get_field('facility_kaijyo',$comit_parent_id) ){
                echo get_field('facility_kaijyo',$comit_parent_id);
              } else {
                echo 'お問い合わせください';
              }
            } else {
              if ( get_field('facility_kaijyo') ){
                echo get_field('facility_kaijyo');
              } else {
                echo 'お問い合わせください';
              }
            }
          ?>
          </dd>
            </dl>
          </li>
        </ul>
      </div>
      <!-- ▲ 既存流用 ▲ -->
    </section>
  </div>
  <div class="sticky">

      <div class="detail-tabs-outer">
        <div id="tab"></div>
        <nav class="detail-tabs">
          <div class="inner">
            <ul>
              <li<?php if ( get_field('edit_type') === '施設トップ' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>"><i class="icon-detail01"></i><span class="detail-tab-text">施設<br class="sp-only">トップ</span><i class="icon-detail01 icon-detail_under"></i></a></li>
              <?php if ($plan_type != 'light'): ?>
              <li<?php if ( get_field('edit_type') === '会場情報' || get_field('edit_type') === '会場情報（簡易宿所）') {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>meeting/"><i class="icon-detail02"></i><span class="detail-tab-text">会場情報</span><i class="icon-detail02 icon-detail_under"></i></a></li>
              <li<?php if ( get_field('edit_type') === '宿泊' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>lodging/"><i class="icon-detail03"></i><span class="detail-tab-text">宿泊</span><i class="icon-detail03 icon-detail_under"></i></a></li>
              <li<?php if ( get_field('edit_type') === 'お食事' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>meal/"><i class="icon-detail04"></i><span class="detail-tab-text">お食事</span><i class="icon-detail04 icon-detail_under"></i></a></li>
              <li<?php if ( get_field('edit_type') === '設備・サービス' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>service/"><i class="icon-detail05"></i><span class="detail-tab-text">設備<span class="pc-only">・</span><br class="sp-only">サービス</span><i class="icon-detail05 icon-detail_under"></i></a></li>
              <?php endif; ?>
              <li<?php if ( get_field('edit_type') === 'アクセス・周辺情報' ) {echo ' class="is_active"';} ?>><a class="tabLink" href="<?php echo $comit_permalink ?>access/"><i class="icon-detail06"></i><span class="detail-tab-text">アクセス<span class="pc-only">・</span><br class="sp-only">周辺情報</span><i class="icon-detail06 icon-detail_under"></i></a></li>
            </ul>
          </div>
        </nav>
      </div>

    <div class="content-area bg-gray">
      <?php if ( get_field('edit_type') === '施設トップ' )  : ?>
      <div class="normal-section facility-gallery">
        <div class="swiper-container facility-gallery__main">
          <div class="swiper-pagination"></div>
          <div class="swiper-button-next">&gt;</div>
          <div class="swiper-button-prev">&lt;</div>
          <div class="swiper-wrapper">

            <div class="swiper-slide"><div class="swiper-slide__inner"><img src="<?php
    if( get_field('facility_mainimage') ):
      the_field('facility_mainimage');
    else :
      echo 'http://placehold.jp/80/00b2b0/ffffff/2000x850.png?text=NOW%20PRINTING';
    endif;
    ?>" /></div></div>
              <?php
      if ( get_field('facility_subimage1') ) {echo '<div class="swiper-slide"><div class="swiper-slide__inner"><img src="'. get_field('facility_subimage1') .'" /></div></div>';}
      if ( get_field('facility_subimage2') ) {echo '<div class="swiper-slide"><div class="swiper-slide__inner"><img src="'. get_field('facility_subimage2') .'" /></div></div>';}
      if ( get_field('facility_subimage3') ) {echo '<div class="swiper-slide"><div class="swiper-slide__inner"><img src="'. get_field('facility_subimage3') .'" /></div></div>';}
      if ( get_field('facility_subimage4') ) {echo '<div class="swiper-slide"><div class="swiper-slide__inner"><img src="'. get_field('facility_subimage4') .'" /></div></div>';}
    ?>
    <?php
      // 子ページの検索
    $children = get_children(array(
        "post_parent"   => get_the_id(),
        "post_type"     => "any",
        "post_status"   => "publish",
        "order"         => "ASC"
    ));
/*
    foreach($children as $child){
      if ( $child->post_title == "宿泊" ) {
        $target_id = $child->ID;
      }
      if ( $child->post_title == "アクセス・周辺情報" ) {
        $child_access_id = $child->ID;
      }
    }
    */
    ?>
          </div>
        </div>
          <?php if ( have_rows("facility_plan") ) : ?>
          <div class="l-wrapper">
            <div id="top-plan-icon">
              <!-- SP -->
              <a class="jumpToBtn" href="#recommend-plan">お得な研修プランはこちら</a>
            </div>
          </div>
          <?php endif; ?>

        <?php if( get_field('facility_360url') ): ?>
        <div class="l-wrapper">
          <a class="button button--360url" href="<?php the_field('facility_360url'); ?>" target="_blank" rel="nofollow">高解像度 360度パノラマビューはこちら</a>
        </div>
        <?php endif; ?>
        <div class="l-wrapper">
          <div class="button-balloon-wrapper">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <section class="facility_detail-section">
        <div class="inner">
          <!-- description -->
          <?php
            $parent_id = $post->post_parent;
            $description_single_class = "";
            if($plan_type == 'light') {
              $description_single_class = ' facility-overview--single';
            }elseif(get_field('facility_pro-comment_detail',$parent_id) == ""){
              $description_single_class = ' facility-overview--single';
            }
          ?>
          <div class="facility-overview<?php echo $description_single_class; ?>" >
            <div class="facility-overview__description">
              <p><?php if ( isset($comit_parent_id) ){ echo nl2br(get_field('facility_pr_deital',$comit_parent_id)); } else { echo nl2br(get_field('facility_pr_deital')); } ?></p>
            </div>

            <?php
              if ( $parent_id ) {
                if (get_field('facility_pro-comment_detail',$parent_id)) {
            ?>
            <div class="facility-overview__voice">
            <?php if ($plan_type != 'light'): ?>
              <div class="voice voice--lg">
                <div class="voice__image voice__image--lg">
                  <img src="<?php echo get_person_src(); ?>" alt="">
                </div>
                <p class="voice__text voice__text--pc-simple"><?php echo nl2br(get_field('facility_pro-comment_detail',$parent_id)); ?></p>
              </div>
            <?php endif; ?>
            </div>
            <?php
                }
              } else {
                if (get_field('facility_pro-comment_detail')) {
            ?>
            <div class="facility-overview__voice">
            <?php if ($plan_type != 'light'): ?>
              <div class="voice voice--lg">
                <div class="voice__image voice__image--lg">
                  <img src="<?php echo get_person_src(); ?>" alt="">
                </div>
                <p class="voice__text voice__text--pc-simple"><?php echo nl2br(get_field('facility_pro-comment_detail')); ?></p>
              </div>
              <?php endif; ?>
            </div>
            <?php
                }
              }
            ?>
          </div>
            <?php
              if ( isset($comit_parent_id) ){
                $iid =$comit_parent_id;
              } else {
                $iid =$post->ID;
              }

              if ($terms = get_the_terms($iid, 'feature')) {
                echo '<ul class="facility-tag">';
                foreach ( $terms as $term ) {
                  echo '<li><a href="';
                  echo esc_url(home_url('/'));
                  echo 'feature/';
                  echo esc_html($term -> slug);
                  echo '/">';
                  echo esc_html($term -> name);
                  echo '</a></li>';
                }
                echo '</ul>';
              }
            ?>
        </div>
      </section>

      <div class="inner">
      <?php if( get_field('facility_information') ): ?>
        <section class="normal-section">
          <div class="information">
            <h3 class="information__heading">施設からのお知らせ</h3>
            <div class="information__detail">
              <?php echo get_field('facility_information') ?>
            </div>
          </div>
        </section>
      <?php endif; ?>

      <?php
      // 繰り返しフィールドにデータがあれば表示する
      if( have_rows('facility_plan') ):
        ?>
      <section class="normal-section" id="recommend-plan">
        <h2 class="section-title">
          <span class="section-title-en">PLAN</span>
          <i class="icon-plan"></i>
          <span class="section-title-ja">研修プラン</span>
        </h2>
        <div class="recommend-plan">
            <div class="recommend-plan__main">
              <ul class="recommend-plan__list">
              <?php foreach (get_field('facility_plan') as $item) : ?>
                <li class="recommend-plan__item">
                  <div class="recommend-plan__head">
                    <div class="recommend-plan__title"><?php echo $item["facility_plan_title"]; ?></div>
                    <div class="recommend-plan__meta">
                    <?php if ($item["facility_plan_meal"] !== "非表示") : ?>
                      <div class="recommend-plan__meal"><?php echo $item["facility_plan_meal"]; ?></div>
                    <?php endif; ?>
                    <?php if ($item["facility_plan_price"] !== "0") : ?>
                      <div class="recommend-plan__price">１名：<span class=""><?php echo number_format(str_replace('～','',$item["facility_plan_price"])) . '円～'; ?></span></div>
                      <?php endif; ?>
                    </div>
                    <div class="recommend-plan__inquiry pc-only">
                      <a href="<?php echo get_form_url(); ?>" target="_blank">問い合わせる</a>
                    </div>
                  </div>
                  <div class="recommend-plan__summary">
                    <?php echo $item["facility_plan_summary"]; ?>
                  </div>
                  <div class="recommend-plan__inquiry sp-only">
                    <a href="<?php echo get_form_url(); ?>" target="_blank">問い合わせる</a>
                  </div>
                </li>
              <?php endforeach; ?>
              </ul>
            </div>
          </div>
      </section>
      <?php endif; ?>

        <section class="normal-section" id="detail-point">
      <?php
        // 繰り返しフィールドにデータがあれば表示する
        if( have_rows('facility_points') ) {
          //echo '<section class="normal-section" id="detail-point">';
          echo '<h2 class="section-title"><span class="section-title-en">POINT</span><img src="/co-mit_renew_201910/img/icon_point.png"><span class="section-title-ja">魅力ポイント</span></h2>';

          $has_plan_row = have_rows('facility_plan') ;
          $has_plan_row = false;  // スライダー表示解除
          if ( $has_plan_row ) {
            echo '<div id="facility_points_slider" class="swiper-container js-autoheight" style="overflow:hidden;">';
            echo '<ul class="detail-point swiper-wrapper">';
          } else {
            echo '<ul class="detail-point">';
          }

          while ( have_rows('facility_points') ) : the_row();

            if ( $has_plan_row ) {
              echo '<li class="swiper-slide"><article>';
            } else {
              echo '<li class=""><article>';
            }

            if( get_sub_field('facility_point_image') ) {
              echo '<p class="detail-point-photo"><img src="'. get_sub_field('facility_point_image') .'" alt=""></p>';
            } else {
              echo '<p class="detail-point-photo"><img src="http://placehold.jp/40/00b2b0/ffffff/850x500.png?text=NOW%20PRINTING" alt=""></p>';
            }

            echo '<div class="detail-point-text js-autoheight-target"><h3>'. get_sub_field('facility_point_title') .'</h3>';
            echo '<p>'. get_sub_field('facility_point_detail') .'</p>';
            echo '</div></article></li>';

          endwhile;

          echo '</ul>';
          if ( $has_plan_row ) {
            echo '<div class="swiper-pagination"></div>';
            echo '</div>';
          }

        }
        ?>
        <?php if( get_field('facility_youtube-url') ): ?>
          <a class="button button--360url fancybox-youtube" href="<?php the_field('facility_youtube-url'); ?>" >動画で施設を確認する</a>
        <?php endif; ?>
        </section>

        <section class="normal-section">
    <?php
    // 繰り返しフィールドにデータがあれば表示する
    if( have_rows('facility_activity') ):
    ?>
          <h2 class="section-title">
            <span class="section-title-en">ACTIVITY</span>
            <i class="st-icon-pin"></i>
            <span class="section-title-ja">こんなアクティビティができます</span>
          </h2>
    <?php
      while ( have_rows('facility_activity') ) : the_row();
    ?>
          <div class="activity">
            <div class="activity__image">
              <img src="<?php echo get_sub_field('facility_activity_image'); ?>" alt="">
            </div>
            <div class="activity__main">
              <h3 class="activity__heading"><?php echo get_sub_field('facility_activity_title'); ?></h3>
              <div class="activity__text">
                <p><?php echo get_sub_field('facility_activity_detail'); ?></p>
              </div>
            </div>
          </div>
    <?php
      endwhile;

    else :
    endif;
    ?>
        </section>

        <?php get_template_part('var/single-interview'); ?>

        <?php if ( have_rows('facility_points') || have_rows('facility_activity') ): ?>
        <div class="button-balloon-wrapper--last">
          <?php if($incentiveFee == true): ?>
          <p class="button-balloon">ホテル業界を知り尽くした専門家に無料で相談できます！</p>
          <a href="<?php echo esc_url(home_url('/')); ?>consult/" class="button button--lg button--orange gtm-cv-3">専門家に相談する</a>
          <?php else: ?>
          <p class="button-balloon">詳しい情報を見たい方はこちら！</p>
          <a href="<?php echo $official_website_url; ?>" class="button button--lg button--orange gtm-cv-3" target="_blank">公式サイトで詳しくみる</a>
          <?php endif; ?>
          <?php /*
          <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン無料問い合わせ！</p>
          <div class="buttons">
            <div class="buttons__item">
              <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討中の施設に</span><span>まとめて問い合わせする</span></span></span></a>
            </div>
            <div class="buttons__item">
              <a class="button button--contact" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow"><span>施設に問い合わせする</span></a>
            </div>
          </div>

          <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
          */ ?>
        </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === '会場情報' || get_field('edit_type') === '会場情報（簡易宿所）' )  : ?>
      <div class="inner">

        <section class="normal-section" id="place-info">
          <div class="section-title-area">
            <h2 class="section-title">
              <span class="section-title-en">PLACE INFO</span>
              <img src="/co-mit_renew_201910/img/icon_info.png">
              <span class="section-title-ja">会場情報</span>
            </h2>
            <?php if ( get_field('meeting_pr') ) : ?>
            <p class="section-catch"><?php echo nl2br(get_field('meeting_pr')); ?></p>
            <?php endif; ?>
          </div>
        </section>
        <?php if ( get_field('edit_type') === '会場情報' )  : ?>
        <section class="normal-section">
          <h2 class="heading-7 heading-7--table">表で比較</h2>
          <div class="comparison-table">
            <div class="comparison-table__head">
              <div class="comparison-table__head__cel comparison-table__head__cel--left">
                <p>会場名</p>
              </div>
              <div class="comparison-table__head__cel">
                <p>面積</p>
              </div>
              <div class="comparison-table__head__cel">
                <p>天井高</p>
              </div>
              <div class="comparison-table__head__cel comparison-table__head__cel--pd0">
                <div class="comparison-table__head__cel__col">収容人数</div>
                <div class="comparison-table__head__cel__col">
                  <div class="comparison-table__head__cel__detail">スクール</div>
                  <div class="comparison-table__head__cel__detail">口の字</div>
                  <div class="comparison-table__head__cel__detail">島型</div>
                </div>
              </div>
              <div class="comparison-table__head__cel comparison-table__head__cel--left">
                <p>1日の利用料金目安</p>
              </div>
            </div>
            <?php
            // 繰り返しフィールドにデータがあれば表示する
            if( have_rows('meeting_detail') ):
              $post_count = 1;

              while ( have_rows('meeting_detail') ) : the_row();
                    if ( $post_count == 1) {
            ?>
                        <div class="comparison-table__body js-line-hidden">
            <?php
                    }
                    if ( $post_count == 6) {
            ?>
                        </div>
                        <!-- <p class="btn-area"><span class="button button--arrow-2" data-accordion02-open>会場をさらに表示</span></p> -->
                        <div class="comparison-table__body" data-accordion02 style="display:none;">
            <?php
                    }
            ?>
            <div class="comparison-table__item">
              <h3 class="comparison-table__cel comparison-table__cel--head">
                <p><?php echo get_sub_field('meeting_name'); ?></p>
              </h3>
              <div class="comparison-table__cel">
                <p><?php if( get_sub_field('meeting_area') ): the_sub_field('meeting_area'); else : echo '-'; endif; ?></p>
              </div>
              <div class="comparison-table__cel">
                <p><?php if( get_sub_field('meeting_height') ): the_sub_field('meeting_height'); else : echo '-'; endif; ?></p>
              </div>
              <div class="comparison-table__cel comparison-table__cel--pd0">
                <div class="comparison-table__cel__col">
                  <div class="comparison-table__cel__detail"><?php if( get_sub_field('meeting_capa_school') ): the_sub_field('meeting_capa_school'); else : echo '-'; endif; ?></div>
                  <div class="comparison-table__cel__detail"><?php if( get_sub_field('meeting_capa_ro') ): the_sub_field('meeting_capa_ro'); else : echo '-'; endif; ?></div>
                  <div class="comparison-table__cel__detail"><?php if( get_sub_field('meeting_capa_island') ): the_sub_field('meeting_capa_island'); else : echo '-'; endif; ?></div>
                </div>
              </div>
              <div class="comparison-table__cel comparison-table__cel--price">
                <p>
                  <?php if( get_sub_field('meeting_fee') ): the_sub_field('meeting_fee'); else : echo 'お問い合わせください'; endif; ?>
                  <?php
                    $_form_url = get_form_url();
                    if ($_form_url != "#") :
                  ?>
                    <a href="<?php echo $_form_url ?>">問い合わせる</a>
                  <?php endif; ?>
                </p>
              </div>
            </div>
          <?php
            $post_count++;

            endwhile;
          ?>
          </div>

          </div>
          <?php if ( $post_count >= 6): ?>
            <p class="btn-area "><span class="button button--arrow-2" data-accordion02-open>会場をさらに表示</span></p>
          <?php endif; ?>
          <?php
          else :
          endif;
          ?>
        </section>

        <section class="normal-section">
          <h2 class="heading-7 heading-7--image">写真付きで比較</h2>
          <?php
          // 繰り返しフィールドにデータがあれば表示する
          if( have_rows('meeting_detail') ):

            $post_count = 1;

            while ( have_rows('meeting_detail') ) : the_row();

                  if ( $post_count == 1) : echo '<ul class="place-info-data">'; endif;
                  if ( $post_count == 4) : echo '</ul><p class="btn-area"><span class="button button--arrow-2" data-accordion-open>会場をさらに表示</span></p><ul class="place-info-data" data-accordion style="display:none;">'; endif;

                  echo '<li><div class="place-info-data-head">';
                  echo '<h3>'. get_sub_field('meeting_name') .'</h3>';
                  if ( get_sub_field('meeting_image') ) :
                    echo '<p class="place-info-data-photo"><a href="'. get_sub_field('meeting_image') .'" data-fancybox="gallery"><span class="photo-zoom" data-photo-zoom><i class="icon-zoom"></i></span><img src="'. get_sub_field('meeting_image') .'" alt=""></a></p>';
                  else :
                    echo '<p class="place-info-data-photo"><img src="http://placehold.jp/60/00b2b0/ffffff/850x567.png?text=NOW%20PRINTING" alt=""></p>';
                  endif;
                  echo '</div>';
                  echo '<ul class="place-info-data-list">';
                  echo '<li><dl><dt>面積</dt><dd>';
                    if( get_sub_field('meeting_area') ): the_sub_field('meeting_area'); else : echo '-'; endif;
                  echo '</dd></dl></li>';
                  echo '<li><dl><dt>天井高</dt><dd>';
                    if( get_sub_field('meeting_height') ): the_sub_field('meeting_height'); else : echo '-'; endif;
                  echo '</dd></dl></li>';
                  echo '</ul>';
                  echo '<h4>収容人数</h4><ul class="place-info-data-list">';
                  echo '<li class="with-border"><dl><dt>スクール</dt><dd>';
                    if( get_sub_field('meeting_capa_school') ): the_sub_field('meeting_capa_school'); else : echo '-'; endif;
                  echo '</dd></dl></li>';
                  echo '<li class="with-border"><dl><dt>島型</dt><dd>';
                    if( get_sub_field('meeting_capa_island') ): the_sub_field('meeting_capa_island'); else : echo '-'; endif;
                  echo '</dd></dl></li>';
                  echo '<li class="with-border"><dl><dt>口の字</dt><dd>';
                    if( get_sub_field('meeting_capa_ro') ): the_sub_field('meeting_capa_ro'); else : echo '-'; endif;
                  echo '</dd></dl></li>';
                  echo '</ul>';
                  echo '<h4>1日の利用料金目安</h4><p class="place-info-data-price">';
                    if( get_sub_field('meeting_fee') ): the_sub_field('meeting_fee'); else : echo 'お問い合わせください'; endif;
                  echo '</p>';
                  if ( get_sub_field('meeting_kaido_url') ) :
                    echo '<a href="'. get_sub_field('meeting_kaido_url') .'" class="more-btn" target="_blank">MORE<img src="/co-mit_renew_201910/img/popup_icon.png"></a>';
                  endif;
                  echo '</li>';

            $post_count++;

            endwhile;

            echo '</ul>';

          else :
          endif;
          ?>
        </section>
        <?php else: /* 会場情報（簡易宿所）*/ ?>
          <?php if( have_rows('meeting_detail_kani') ): ?>
            <?php while ( have_rows('meeting_detail_kani') ) : the_row(); ?>
              <?php if( have_rows('img_block') ): /* 画像ありブロック */ ?>
                <ul class="meeting-detail-list">
                  <?php while ( have_rows('img_block') ) : the_row(); ?>
                    <li>
                      <img src="<?php the_sub_field('meeting_image');  ?>">
                      <p class="meeting-detail-list__name"><?php the_sub_field('meeting_name');  ?></p>
                      <p class="meeting-detail-list__text"><?php the_sub_field('meeting_text_kani');  ?></p>
                    </li>
                  <?php endwhile; ?>
                </ul>
              <?php endif;?>
              <?php if( have_rows('noimg_block') ): /* 画像なしブロック */ ?>
                <ul class="meeting-detail-list">
                  <?php while ( have_rows('noimg_block') ) : the_row(); ?>
                    <li>
                      <p class="meeting-detail-list__name"><?php the_sub_field('meeting_name');  ?></p>
                      <p class="meeting-detail-list__text"><?php the_sub_field('meeting_text_kani');  ?></p>
                    </li>
                  <?php endwhile; ?>
                </ul>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endif; ?>
        <?php endif; ?>

        <section class="normal-section">
          <?php
          // 繰り返しフィールドにデータがあれば表示する
          if( have_rows('floor_images') ):
            echo'<h2 class="heading-7 heading-7--floor">フロア図</h2>';

            $post_count = 1;

            while ( have_rows('floor_images') ) : the_row();
              if ( $post_count == 1) : echo '<ul class="staying-photo-list" data-photo-list>'; endif;
              if ( get_sub_field('floor_image') ) :
                ?>
                <?php
                  $attachment_id = get_sub_field('floor_image');
                ?>
                <li><a href="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" data-fancybox="gallery"><span class="photo-zoom" data-photo-zoom><i class="icon-zoom"></i></span>
                <picture>
                  <source media="(max-width: 768px)" srcset="<?php echo wp_get_attachment_image_url($attachment_id,'medium'); ?>" >
                  <img src="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" alt="">
                </picture>
                </a></li>
                <?php
              else :
              endif;

            $post_count++;
            endwhile;
            echo '</ul>';

          else :
          endif;
          ?>
          <ul class="place-info-equipment">
            <li>
              <dl>
                <dt><img src="/co-mit_renew_201910/img/icon_wifi.png"><span class="place-info-equipment-name">設備</span></dt>
                <dd>
                  <ul>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('設備 - Wi-Fiあり', $equipment ) ) {
              echo '<li>Wi-Fiあり</li>';
            }
            if( $equipment && in_array('設備 - 会場専用回線あり', $equipment ) ) {
              echo '<li>会場専用回線あり</li>';
            }
          ?>
                  </ul>
                </dd>
              </dl>
            </li>
            <li>
              <dl>
                <dt><img src="/co-mit_renew_201910/img/icon_chair.png"><span class="place-info-equipment-name">備品</span></dt>
                <dd>
                  <ul>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('備品 - 椅子', $equipment ) ) {
              echo '<li>椅子</li>';
            }
          ?>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('備品 - テーブル', $equipment ) ) {
              echo '<li>テーブル</li>';
            }
            if( $equipment && in_array('備品 - ホワイトボード', $equipment ) ) {
              echo '<li>ホワイトボード</li>';
            }
            if( $equipment && in_array('備品 - 電源タップ（延長コード）', $equipment ) ) {
              echo '<li>電源タップ（延長コード）</li>';
            }
          ?>
                  </ul>
                </dd>
              </dl>
            </li>
            <li>
              <dl>
                <dt><img src="/co-mit_renew_201910/img/icon_onkyo.png"><span class="place-info-equipment-name">音響</span></dt>
                <dd>
                  <ul>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('音響 - 機器あり（ポータブル）', $equipment ) ) {
              if( $equipment && in_array('音響 - 機器あり（常設）', $equipment ) ) {
                echo '<li>機器あり</li>';
              } else {
                echo '<li>機器あり(ポータブル)</li>';
              }
            } else
            if( $equipment && in_array('音響 - 機器あり（常設）', $equipment ) ) {
              if( $equipment && in_array('音響 - 機器あり（ポータブル）', $equipment ) ) {
                echo '<li>機器あり</li>';
              } else {
                echo '<li>機器あり(常設)</li>';
              }
            }
          ?>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('音響 - マイク', $equipment ) ) {
              echo '<li>マイク</li>';
            }
          ?>
                  </ul>
                </dd>
              </dl>
            </li>
            <li>
              <dl>
                <dt><img src="/co-mit_renew_201910/img/icon_tv.png"><span class="place-info-equipment-name">映像</span></dt>
                <dd>
                  <ul>
          <?php
            $equipment = get_field('meeting_equipment');
            if( $equipment && in_array('映像 - プロジェクター・スクリーン', $equipment ) ) {
              echo '<li>プロジェクター・スクリーン</li>';
            }
          ?>
                  </ul>
                </dd>
              </dl>
            </li>
          </ul>
          <div class="common-detail">
            <p class="detail-note">※詳細につきましては施設にお問い合わせください</p>
          </div>

            <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>

        </section>

      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === '宿泊' )  : ?>
      <div class="inner">
        <section class="normal-section" id="stay-info">
          <div class="section-title-area">
            <h2 class="section-title"><span class="section-title-en">STAYING</span><img src="/co-mit_renew_201910/img/icon_stay.png"><span class="section-title-ja">宿泊</span></h2>
      <?php if ( get_field('lodging_pr') ) : ?>
            <p class="section-catch"><?php echo nl2br(get_field('lodging_pr')); ?></p>
      <?php endif; ?>
          </div>

        <?php
        // 繰り返しフィールドにデータがあれば表示する
        if( have_rows('lodging_images') ):

          $post_count = 1;

          while ( have_rows('lodging_images') ) : the_row();
            if ( $post_count == 1) : echo '<ul class="staying-photo-list" data-photo-list>'; endif;
            if ( get_sub_field('lodging_image') ) :
            ?>
            <?php
              $attachment_id = get_sub_field('lodging_image');
            ?>
            <li><a href="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" data-fancybox="gallery"><span class="photo-zoom" data-photo-zoom><i class="icon-zoom"></i></span>
            <picture>
              <source media="(max-width: 768px)" srcset="<?php echo wp_get_attachment_image_url($attachment_id,'medium'); ?>" >
              <img src="<?php echo wp_get_attachment_image_url($attachment_id,'large'); ?>" alt="">
            </picture>
            </a></li>
            <?php
            else :
            endif;

          $post_count++;
          endwhile;
          echo '</ul>';

        else :
        endif;
        ?>

    <?php
    // 繰り返しフィールドにデータがあれば表示する
    if( have_rows('lodging_room') ):

      echo '<div class="common-detail"><h3 class="common-detail-title"><i class="icon-type"></i>部屋タイプ一覧</h3><div class="staying-type-table-wrapeer"><table class="staying-type-table"><thead><tr><th>部屋名</th><th>部屋タイプ</th><th>総収容人数</th><th>広さ（面積）</th><th>バス・トイレ</th><th>インターネット</th><th>総室数</th></tr></thead>';

      $post_count = 1;

      while ( have_rows('lodging_room') ) : the_row();

        if ($post_count == 1){
          echo '<tbody class="js-line-hidden">';
        }

        if ($post_count == 6){
          echo '</tbody>';
          echo '<tbody data-accordion03 style="display:none;">';
        }

        echo '<tr><th>'. get_sub_field('lodging_room_name') .'</th>';
        echo '<td>'. get_sub_field('lodging_room_type') .'</td>';
        echo '<td>';
          if( get_sub_field('lodging_room_capa') ): the_sub_field('lodging_room_capa'); else : echo '-'; endif;
        echo '</td>';
        echo '<td>';
          if( get_sub_field('lodging_room_large') ): the_sub_field('lodging_room_large'); else : echo '-'; endif;
        echo '</td>';
        echo '<td>'. get_sub_field('lodging_room_bath') .'</td>';
        echo '<td>'. get_sub_field('lodging_room_net') .'</td>';
        echo '<td>';
          if( get_sub_field('lodging_room_amount') ): the_sub_field('lodging_room_amount'); else : echo '-'; endif;
        echo '</td></tr>';

        $post_count++;

      endwhile;

      if ( $post_count > 6 ){
        echo '</tbody></table></div>';
        echo '<p class="btn-area"><span class="button button--arrow-2" data-accordion03-open>もっと見る</span></p></div>';
      } else {
        echo '</tbody></table></div></div>';
      }

    else :
    endif;
    ?>

          <div class="common-detail">
            <h3 class="common-detail-title"><i class="icon-amenity"></i>アメニティ・部屋備品</h3>
            <ul class="staying-amenity-list">
              <li>
                <dl>
                  <dt>バスタオル</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('バスタオル', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>フェイスタオル</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('フェイスタオル', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>部屋着</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('部屋着', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>浴衣</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('浴衣', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>シャンプー</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('シャンプー', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>ボディソープ(石鹸)</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('ボディソープ（石鹸）', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>ヘアブラシ</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('ヘアブラシ', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>カミソリ</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('カミソリ', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>歯ブラシ</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('歯ブラシ', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>ドライヤー</dt>
                  <dd> <i class="icon-<?php $equipment = get_field('lodging_equipment'); if (! ($equipment && in_array('ドライヤー', $equipment)) ) {echo 'un';}?>available"></i></dd>
                </dl>
              </li>
            </ul>
          <p class="detail-note">※詳細につきましては施設にお問い合わせください</p>
          </div>

          <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>

        </section>
      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === 'お食事' )  : ?>
      <div class="inner">
        <section class="normal-section" id="meal-info">
          <div class="section-title-area">
            <h2 class="section-title"><span class="section-title-en">MEAL</span><i class="icon-detail04"></i><span class="section-title-ja">お食事</span></h2>
            <?php if ( get_field('meal_main_img') ) : ?>
              <img class="section-mainimg" src="<?php the_field('meal_main_img'); ?>">
            <?php endif; ?>
            <?php if ( get_field('meal_pr') ) : ?>
              <p class="section-catch"><?php echo nl2br(get_field('meal_pr')); ?></p>
            <?php endif; ?>
          </div>

       <div class="common-detail">
      <?php
      // 繰り返しフィールドにデータがあれば表示する
      if( have_rows('meal') ):

        echo '<ul class="meal-list">';

        while ( have_rows('meal') ) : the_row();
          echo '<li><article class="meal-list-row">';
          if ( get_sub_field('meal_image') ) :
            echo '<p class="meal-list-photo"><img src="'. get_sub_field('meal_image') .'" alt=""></p>';
          else :
            echo '<p class="meal-list-photo"><img src="http://placehold.jp/60/00b2b0/ffffff/1082x544.png?text=NOW%20PRINTING" alt=""></p>';
          endif;
          echo '<div class="meal-list-detail">';
          echo '<h3>'. get_sub_field('meal_detail_title') .'</h3>';
          if ( get_sub_field('meal_detail') ) :
            echo '<p>'. get_sub_field('meal_detail') .'</p>';
          endif;
          echo '<table class="meal-list-table"><tr><th>料金</th><td>';
            if( get_sub_field('meal_fee') ): the_sub_field('meal_fee'); else : echo '-'; endif;
          echo '</td></tr>';
          echo '<th>時間</th><td>';
            if( get_sub_field('meal_time') ): the_sub_field('meal_time'); else : echo '-'; endif;
          echo '</td></tr>';
          echo '<th>形式</th><td>';
            if( get_sub_field('meal_style') ): the_sub_field('meal_style'); else : echo '-'; endif;
          echo '</td></tr>';
          echo '</table></div></article></li>';
        endwhile;

        echo '</ul>';

      else :
      endif;
      ?>

    <?php if ( get_field('meal_supper') ) : ?>
    <ul class="meal-sub-list">
                <li>
                  <dl>
                    <dt>夜食</dt>
                    <dd><?php echo nl2br(get_field('meal_supper')); ?></dd>
                  </dl>
                </li>
              </ul>
    <?php endif; ?>
       </div>


         <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>

        </section>
      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === '設備・サービス' )  : ?>
      <div class="inner">
        <section class="normal-section" id="service-info">
          <div class="section-title-area">
            <h2 class="section-title"><span class="section-title-en">FACILITY &amp; SERVICE</span><i class="icon-detail05"></i><span class="section-title-ja">設備・サービス</span></h2>
      <?php if ( get_field('service_pr') ) : ?>
                <p class="section-catch"><?php echo nl2br(get_field('service_pr')); ?></p>
      <?php endif; ?>
          </div>

    <?php if ( get_field('service_head') || get_field('service_text') ) : ?>
              <div class="service-area-row">
                <div class="service-area-photo">
                <?php
                  // 繰り返しフィールドにデータがあれば表示する
                  if( have_rows('service_images') ): ?>
                    <div class="swiper slider">
                      <div class="swiper-wrapper">
                      <?php while ( have_rows('service_images') ) : the_row();
                        // echo '<p><img src="'. get_sub_field('service_image') .'" alt=""></p>'; 
                      ?>
                      <!-- スライダー -->
                        <div class="swiper-slide">
                          <img src="<?php the_sub_field('service_image') ?>" alt="" />
                        </div>
                      <?php endwhile; ?>
                      </div>
                    </div>
                    <!-- サムネイル -->
                    <div class="swiper slider-thumbnail">
                      <div class="swiper-wrapper">
                        <?php while ( have_rows('service_images') ) : the_row(); ?>
                        <div class="swiper-slide">
                          <img src="<?php the_sub_field('service_image') ?>" alt="" />
                        </div>
                        <?php endwhile; ?>
                      </div>
                    </div>
                  <?php else :
                    if ( get_field('service_head') ) :
                      echo '<p><img src="http://placehold.jp/60/00b2b0/ffffff/854x502.png?text=NOW%20PRINTING" alt=""></p>';
                    endif;
                  endif;
                  ?>
            </div>
    <?php if ( get_field('service_head') || get_field('service_text') ) : ?>
            <div class="service-area-text">
                  <?php if ( get_field('service_head') ) : ?><h3><?php echo nl2br(get_field('service_head')); ?></h3><?php endif; ?>
                  <?php if ( get_field('service_text') ) : ?><p><?php echo nl2br(get_field('service_text')); ?></p><?php endif; ?>
            </div>
    <?php endif; ?>
          </div>
      <?php endif; ?>
      <?php $rental = get_field('equipment_rental'); ?>
      <?php if ( $rental['equipment_text'] || $rental['rental_text'] ) : ?>
        <div class="common-detail">
          <h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_chair02.svg">備品・レンタル</h3>
          <ul class="service-list">
          <?php if ( $rental['equipment_text'] ) : ?>
            <li>
              <dl>
                <dt>備品</dt>
                <dd><?php echo nl2br($rental['equipment_text']);  ?></dd>
              </dl>
            </li>
            <?php endif; ?>
            <?php if ( $rental['rental_text']  ) : ?>
            <li>
              <dl>
                <dt>レンタル</dt>
                <dd><?php echo nl2br($rental['rental_text']);  ?></dd>
              </dl>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      <?php endif; ?>
      
          <div class="common-detail">
            <h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_like.png">基本サービス</h3>
            <ul class="service-list">
              <li>
                <dl>
                  <dt>付帯設備</dt>
                  <dd>
                    <ul>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('大浴場', $equipment) ) {echo '<li>大浴場</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('温泉', $equipment) ) {echo '<li>温泉</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('スパ', $equipment) ) {echo '<li>スパ</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('体育館', $equipment) ) {echo '<li>体育館</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('グラウンド', $equipment) ) {echo '<li>グラウンド</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('プール', $equipment) ) {echo '<li>プール</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('スポーツジム', $equipment) ) {echo '<li>スポーツジム</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('多目的トイレ', $equipment) ) {echo '<li>多目的トイレ</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('バリアフリー対応', $equipment) ) {echo '<li>バリアフリー対応</li>';}?>
      <?php $equipment = get_field('service_facilities'); if ($equipment && in_array('BBQスペース', $equipment) ) {echo '<li>BBQスペース</li>';}?>

                    </ul>
                  </dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt>サービス</dt>
                  <dd>
                    <ul>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('ランドリー', $equipment) ) {echo '<li>ランドリー</li>';}?>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('クリーニングサービス', $equipment) ) {echo '<li>クリーニングサービス</li>';}?>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('宅配便取扱い', $equipment) ) {echo '<li>宅急便取扱い</li>';}?>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('コピーサービス', $equipment) ) {echo '<li>コピーサービス</li>';}?>
        <?php $equipment = get_field('service_services'); if ($equipment && in_array('送迎バスあり', $equipment) ) {echo '<li>送迎バスあり</li>';}?>
                    </ul>
                  </dd>
                </dl>
              </li>
            </ul>
          </div>

          <div class="common-detail">
            <h3 class="common-detail-title"><img src="/co-mit_renew_201910/img/icon_pin_2.svg" width='40'>アクティビティ</h3>
            <ul class="service-list">
              <li>
                <dl>
                  <dt>アクティビティ</dt>
                  <dd>
                    <ul>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ゴルフ', $equipment) ) {echo '<li>ゴルフ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('パターゴルフ', $equipment) ) {echo '<li>パターゴルフ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('レンタサイクル', $equipment) ) {echo '<li>レンタサイクル</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('プール', $equipment) ) {echo '<li>プール</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('テニス', $equipment) ) {echo '<li>テニス</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('乗馬', $equipment) ) {echo '<li>乗馬</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('アスレチック', $equipment) ) {echo '<li>アスレチック</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('BBQ', $equipment) ) {echo '<li>BBQ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('スノーボード', $equipment) ) {echo '<li>スノーボード</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('スキー', $equipment) ) {echo '<li>スキー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('スノーモービル', $equipment) ) {echo '<li>スノーモービル</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ヨガ', $equipment) ) {echo '<li>ヨガ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('フィットネス', $equipment) ) {echo '<li>フィットネス</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('カラオケ', $equipment) ) {echo '<li>カラオケ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ゲームコーナー', $equipment) ) {echo '<li>ゲームコーナー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('卓球', $equipment) ) {echo '<li>卓球</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ビリヤード', $equipment) ) {echo '<li>ビリヤード</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ダーツ', $equipment) ) {echo '<li>ダーツ</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ボウリング', $equipment) ) {echo '<li>ボウリング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('シュノーケリング', $equipment) ) {echo '<li>シュノーケリング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ダイビング', $equipment) ) {echo '<li>ダイビング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('クルージング', $equipment) ) {echo '<li>クルージング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('サーフィン', $equipment) ) {echo '<li>サーフィン</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ジェットスキー', $equipment) ) {echo '<li>ジェットスキー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('パラセーリング', $equipment) ) {echo '<li>パラセーリング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('イルカ・ホエールウォッチング', $equipment) ) {echo '<li>イルカ・ホエールウォッチング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ロッククライミング・ボルダリング', $equipment) ) {echo '<li>ロッククライミング・ボルダリング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('トレッキング', $equipment) ) {echo '<li>トレッキング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('パラグライダー', $equipment) ) {echo '<li>パラグライダー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ハングライダー', $equipment) ) {echo '<li>ハングライダー</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('熱気球', $equipment) ) {echo '<li>熱気球</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ラフティング', $equipment) ) {echo '<li>ラフティング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('キャニオニング', $equipment) ) {echo '<li>キャニオニング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('カヤック', $equipment) ) {echo '<li>カヤック</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('フィッシング', $equipment) ) {echo '<li>フィッシング</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('ものづくり体験', $equipment) ) {echo '<li>ものづくり体験</li>';}?>
        <?php $equipment = get_field('service_activities'); if ($equipment && in_array('その他', $equipment) ) {echo '<li>その他</li>';}?>
                    </ul>
                  </dd>
                </dl>
              </li>
            </ul>
          </div>


          <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>

        </section>
      </div>
    <?php endif; ?>

    <?php if ( get_field('edit_type') === 'アクセス・周辺情報' )  : ?>
      <div class="inner">
        <section class="normal-section" id="service-info">
          <div class="section-title-area">
            <h2 class="section-title"><span class="section-title-en">ACCESS &amp; NEARBY INFO</span><i class="icon-detail06"></i><span class="section-title-ja">アクセス・周辺情報</span></h2>
          </div>

    <?php
      if( have_rows('facility_address',$comit_parent_id) ):
        while ( have_rows('facility_address',$comit_parent_id) ) : the_row();
          /*echo '〒';
          the_sub_field('facility_zip',$comit_parent_id);
          echo '　';
          the_sub_field('facility_pref',$comit_parent_id);
          the_sub_field('facility_city',$comit_parent_idm);
          the_sub_field('facility_street',$comit_parent_id);*/
	 $facility_address = '〒' . get_sub_field('facility_zip',$comit_parent_id) . get_sub_field('facility_pref',$comit_parent_id) . get_sub_field('facility_city',$comit_parent_id) . get_sub_field('facility_street',$comit_parent_id);
        endwhile;
      else :
      endif;
    ?>
    <?php
      echo '<div class="access-map"><script async src="https://static.media.cld.navitime.jp/scripts/media/biz/widget/map/tag.bundle.js?cid=B000006&amp;p1Address=';
      echo $facility_address;
      echo '&amp;p1Name=';
      echo get_post($comit_parent_id)->post_title;
      echo '&amp;firstPinCenter=true&amp;showSta=true&amp;height=400px"></script></div>';
    ?>

      <?php if ( get_field('navitime_url') ) : ?>
          <?php /*<div id="navitime-loader" class="access-map"></div>*/ ?>
      <?php endif; ?>

          <div class="access-info">
            <h3 class="access-info-name"><?php echo get_post($comit_parent_id)->post_title; ?></h3>
            <div class="access-info-row">
              <div class="access-info-col">
                <dl>
                  <dt>住所</dt>
                  <dd><?php echo $facility_address; ?><?php if ( get_field('largemap_url') ) : ?>（<a href="<?php echo get_field('largemap_url'); ?>" target="_blank" rel="nofollow">MAP</a>）<?php endif; ?></dd>
                </dl>
    <?php if( !$incentiveFee == true): ?>
                <dl>
                  <dt>TEL</dt>
                  <dd><?php echo get_field('facility_tel',$comit_parent_id); ?></dd>
                </dl>
    <?php endif; ?>
              </div>
              <div class="access-info-col">
                <dl>
                  <dt>最寄駅</dt>
                  <dd>
      <?php
      // 繰り返しフィールドにデータがあれば表示する
      if( have_rows('station') ):
        while ( have_rows('station') ) : the_row();
          echo '<p>'. get_sub_field('station_rosen');
          if( get_sub_field('station_name') ) {
            echo '「'. get_sub_field('station_name') .'」駅</p>';
          }
        endwhile;
      else :
        echo '―';
      endif;
      ?></dd>
                </dl>
              </div>
            </div>
      <?php if ( get_field('streetview_url') ) : ?>
            <div class="btn-area">
              <p class="btn-normal"><a href="<?php echo get_field('streetview_url'); ?>" target="_blank" rel="nofollow">Googleストリートビューで見る</a></p>
            </div>
      <?php endif; ?>
          </div><!-- /access-info -->

    <?php
          // 繰り返しフィールドにデータがあれば表示する
          if( have_rows('by_train') ):
            echo '<div class="common-detail">';

            echo '<h3 class="common-detail-title">';
            echo '<img src="/co-mit_renew_201910/img/icon_train.png">電車でお越しの場合';
            if( get_field('by_train_reserve') ) {
              echo '<p class="access-list-link pc-only"><a href="';
              echo get_field('by_train_reserve');
              echo '" target="_blank" rel="nofollow"><span>サクッと簡単</span><span>新幹線の手配はこちら</span></a></p>';
            }
            echo '</h3>';

            echo '<ul class="access-list">';
            while ( have_rows('by_train') ) : the_row();
              echo '<li><dl><dt>';
              if( get_sub_field('by_train_title') ) {
                echo get_sub_field('by_train_title');
              } else {
                echo '主要駅から';
              }
              echo '</dt><dd>';
              echo get_sub_field('by_train_detail');
              echo '</dd></dl></li>';
            endwhile;
            echo '</ul>';
            if( get_field('by_train_reserve') ) {
              echo '<p class="access-list-link sp-only-2"><a href="';
              echo get_field('by_train_reserve');
              echo '" target="_blank" rel="nofollow"><span>サクッと簡単</span><span>新幹線の手配はこちら</span></a></p>';
            }
            echo '</div>';
          else :
          endif;
    ?>

    <?php if ( get_field('by_car') || have_rows('about_parking') )  : ?>
          <div class="common-detail">
            <h3 class="common-detail-title"><i class="icon-car"></i>車でお越しの場合</h3>
            <ul class="access-list">
              <?php if ( get_field('by_car') ) : ?><li class="access-list-car"><?php echo get_field('by_car'); ?></li><?php endif; ?>
              <?php
              // 繰り返しフィールドにデータがあれば表示する
              if( have_rows('about_parking') ):
                while ( have_rows('about_parking') ) : the_row();
                echo '<li class="access-list-parking border-around"><h4>';
                if( get_sub_field('about_parking_title') ) {
                  echo get_sub_field('about_parking_title');
                } else {
                  echo '駐車場のご案内';
                }
                echo '</h4><p>';
                echo get_sub_field('about_parking_deital');
                echo '</p></li>';
                endwhile;
              else :
              endif;
              ?>
            </ul>
          </div>
  <?php endif; ?>
        <?php
          // 繰り返しフィールドにデータがあれば表示する
            if( have_rows('by_air') ):
              echo '<div class="common-detail">';
              echo '<h3 class="common-detail-title">';
              echo '<i class="icon-airplane"></i>飛行機でお越しの場合';
              if( get_field('by_air_reserve') ) {
                echo '<p class="access-list-link pc-only"><a href="';
                echo get_field('by_air_reserve');
                echo '" target="_blank" rel="nofollow"><span>サクッと簡単</span><span>航空券の手配はこちら</span></a></p>';
              }
              echo '</h3>';
              echo '<ul class="access-list">';
              while ( have_rows('by_air') ) : the_row();
                echo '<li><dl><dt>';
                if( get_sub_field('by_air_title') ) {
                  echo get_sub_field('by_air_title');
                } else {
                  echo '空港から';
                }
                echo '</dt><dd>';
                echo get_sub_field('by_air_detail');
                echo '</dd></dl></li>';
              endwhile;
              echo '</ul>';
              if( get_field('by_air_reserve') ) {
                echo '<p class="access-list-link sp-only-2"><a href="';
                echo get_field('by_air_reserve');
                echo '" target="_blank" rel="nofollow"><span>サクッと簡単</span><span>航空券の手配はこちら</span></a></p>';
              }
              echo '</div>';
            else :
            endif;
        ?>


                <?php get_template_part('var/single-interview'); ?>
          <div class="button-balloon-wrapper--last">
            <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
            <div class="buttons">
              <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
              <div class="buttons__item">
                <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
              </div>
            </div>
            <?php if( $incentiveFee == true): ?>
            <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
            <?php else: ?>
            <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
            <?php endif; ?>
          </div>

        </section>
      </div>
      <?php endif; ?>

    </div>
  </div>
<?php
} // sp_fv
?>

<main class="facility-detail">
<?php if (is_mobile()) :
    sp_fv();
  else:
    pc_fv();
  endif; ?>

  <section class="section detail-basic-area">
    <div class="l-pc-wrapper">
      <h2 class="section-title"><span class="section-title-en">INFORMATION</span><img src="/co-mit_renew_201910/img/icon_information.png"></i><span class="section-title-ja">施設基本情報</span></h2>
      <table class="detail-basic-table">
        <tbody>
          <tr>
            <th>営業許可</th>
            <td>
            <?php
              $eigyo_kyoka = 'ホテル・旅館営業';
              if ( isset($comit_parent_id) ){
                if ( get_field('eigyo_kyoka',$comit_parent_id) ){
                  $eigyo_kyoka = get_field('eigyo_kyoka',$comit_parent_id);
                }
              } else {
                if ( get_field('eigyo_kyoka') ){
                  $eigyo_kyoka = get_field('eigyo_kyoka');
                }
              }
              echo $eigyo_kyoka;
              echo '<br>※ホテル営業・簡易宿所営業について詳しく知りたい方は<a class="udl" href="https://co-mit.jp/column/facilitypermit/" target="_balnk">こちら</a>';
            ?>
            </td>
          </tr>
          <tr>
            <th>受付対応時間</th>
            <td>
<?php
  if ( isset($comit_parent_id) ){
    if ( get_field('facility_open',$comit_parent_id) ){
      echo get_field('facility_open',$comit_parent_id);
    } else {
      echo 'お問い合わせください';
    }
  } else {
    if ( get_field('facility_open') ){
      echo get_field('facility_open');
    } else {
      echo 'お問い合わせください';
    }
  }
?>
</td>
          </tr>
          <tr>
            <th>定休日</th>
            <td>
<?php
  if ( isset($comit_parent_id) ){
    if ( get_field('facility_holiday',$comit_parent_id) ){
      echo get_field('facility_holiday',$comit_parent_id);
    } else {
      echo 'お問い合わせください';
    }
  } else {
    if ( get_field('facility_holiday') ){
      echo get_field('facility_holiday');
    } else {
      echo 'お問い合わせください';
    }
  }
?>
</td>
          </tr>
          <tr>
            <th>ホームページ</th>
            <td>
<?php
  if ( isset($comit_parent_id) ){
    if ( get_field('facility_url',$comit_parent_id) ){
      echo '<a id="official_link_middle" href="'. get_field('facility_url',$comit_parent_id) .'" target="_blank">'. get_field('facility_url',$comit_parent_id) .'</a>';
    } else {
      echo '準備中';
    }
  } else {
    if ( get_field('facility_url') ){
      echo '<a id="official_link_middle" href="'. get_field('facility_url') .'" target="_blank">'. get_field('facility_url') .'</a>';
    } else {
      echo '準備中';
    }
  }
?>

</td>
          </tr>
          <tr>
            <th>住所</th>
            <td>
<?php
  if ( isset($comit_parent_id) ){
    if( have_rows('facility_address',$comit_parent_id) ):
      while ( have_rows('facility_address',$comit_parent_id) ) : the_row();
        echo '〒';
        the_sub_field('facility_zip',$comit_parent_id);
        echo '　';
        the_sub_field('facility_pref',$comit_parent_id);
        the_sub_field('facility_city',$comit_parent_id);
        the_sub_field('facility_street',$comit_parent_id);
      endwhile;
    else :
    endif;
  } else {
    if( have_rows('facility_address') ):
      while ( have_rows('facility_address') ) : the_row();
        echo '〒';
        the_sub_field('facility_zip');
        echo '　';
        the_sub_field('facility_pref');
        the_sub_field('facility_city');
        the_sub_field('facility_street');
      endwhile;
    else :
    endif;
  }
?>
<?php if ( isset($child_access_id) ) : ?>
<?php if ( get_field('largemap_url', $child_access_id) ) : ?>
  <br><a class="udl" href="<?php echo get_field('largemap_url', $child_access_id); ?>" target="_blank" rel="nofollow">大きな地図で確認する</a>
<?php endif; ?>
<?php endif; ?>
</td>
          </tr>
          <tr>
            <th>最寄駅</th>
            <td>
<?php
  if ( isset($comit_parent_id) ){
    if ( get_field('facility_station',$comit_parent_id) ){
      echo get_field('facility_station',$comit_parent_id);
    } else {
      echo 'お問い合わせください';
    }
  } else {
    if ( get_field('facility_station') ){
      echo get_field('facility_station');
    } else {
      echo 'お問い合わせください';
    }
  }
?>
</td>
          </tr>
<?php if( !$incentiveFee == true): ?>
          <tr>
            <th>電話番号</th>
            <td>
<?php
  if ( isset($comit_parent_id) ){
    if ( get_field('facility_tel',$comit_parent_id) ){
      echo get_field('facility_tel',$comit_parent_id);
      echo '<br>※お問い合わせの際にCO-MITを見たとお伝えいただくとスムーズです';
    } else {
      echo '準備中';
    }
  } else {
    if ( get_field('facility_tel') ){
      echo get_field('facility_tel');
      echo '<br>※お問い合わせの際にCO-MITを見たとお伝えいただくとスムーズです';
    } else {
      echo '準備中';
    }
  }
?>
</td>
          </tr>
<?php endif; ?>
<?php if( !$incentiveFee == true): ?>
          <tr>
            <th>FAX番号</th>
            <td>
<?php
  if ( isset($comit_parent_id) ){
    if ( get_field('facility_fax',$comit_parent_id) ){
      echo get_field('facility_fax',$comit_parent_id);
    } else {
      echo '準備中';
    }
  } else {
    if ( get_field('facility_fax') ){
      echo get_field('facility_fax');
    } else {
      echo '準備中';
    }
  }
?>
</td>
          </tr>
<?php endif; ?>
          <tr>
            <th>決済方法</th>
            <td>
              <ul>
<?php
  if ( isset($comit_parent_id) ){
    if( have_rows('facility_payment',$comit_parent_id) ):
      while ( have_rows('facility_payment',$comit_parent_id) ) : the_row();
        $payment_method = get_sub_field('facility_payment_method',$comit_parent_id);
        if( $payment_method && in_array('事前支払い', $payment_method ) ) {echo '<li>［○］事前支払い</li>';} else {echo '<li>［－］事前支払い</li>';}
        if( $payment_method && in_array('現地払い', $payment_method ) ) {echo '<li>［○］現地払い</li>';} else {echo '<li>［－］現地払い</li>';}
        if( $payment_method && in_array('請求書払い', $payment_method ) ) {echo '<li>［○］請求書払い</li>';} else {echo '<li>［－］請求書払い</li>';}
        if( $payment_method && in_array('カード払い', $payment_method ) ) {echo '<li>［○］カード払い</li>';} else {echo '<li>［－］カード払い</li>';}
        if( $payment_method && in_array('その他', $payment_method ) ) {echo '<li>［○］その他</li>';} else {echo '<li>［－］その他</li>';}
      endwhile;
    else :
    endif;
  } else {
    if( have_rows('facility_payment') ):
      while ( have_rows('facility_payment') ) : the_row();
        $payment_method = get_sub_field('facility_payment_method');
        if( $payment_method && in_array('事前支払い', $payment_method ) ) {echo '<li>［○］事前支払い</li>';} else {echo '<li>［－］事前支払い</li>';}
        if( $payment_method && in_array('現地払い', $payment_method ) ) {echo '<li>［○］現地払い</li>';} else {echo '<li>［－］現地払い</li>';}
        if( $payment_method && in_array('請求書払い', $payment_method ) ) {echo '<li>［○］請求書払い</li>';} else {echo '<li>［－］請求書払い</li>';}
        if( $payment_method && in_array('カード払い', $payment_method ) ) {echo '<li>［○］カード払い</li>';} else {echo '<li>［－］カード払い</li>';}
        if( $payment_method && in_array('その他', $payment_method ) ) {echo '<li>［○］その他</li>';} else {echo '<li>［－］その他</li>';}
      endwhile;
    else :
    endif;
  }
?>
              </ul>
<?php
  if ( isset($comit_parent_id) ){
    if( have_rows('facility_payment',$comit_parent_id) ):
      while ( have_rows('facility_payment',$comit_parent_id) ) : the_row();
        echo '<p>';
        the_sub_field('facility_payment_method_remarks',$comit_parent_id);
        echo '</p>';
      endwhile;
    else :
    endif;
  } else {
    if( have_rows('facility_payment') ):
      while ( have_rows('facility_payment') ) : the_row();
        echo '<p>';
        the_sub_field('facility_payment_method_remarks');
        echo '</p>';
      endwhile;
    else :
    endif;
  }
?>
            </td>
          </tr>
          <tr>
            <th>キャンセルについて</th>
            <td>
<?php
  if ( isset($comit_parent_id) ){
    if( have_rows('facility_payment',$comit_parent_id) ):
      while ( have_rows('facility_payment',$comit_parent_id) ) : the_row();
        the_sub_field('facility_payment_cancel',$comit_parent_id);
      endwhile;
    else :
    endif;
  } else {
    if( have_rows('facility_payment') ):
      while ( have_rows('facility_payment') ) : the_row();
        the_sub_field('facility_payment_cancel');
      endwhile;
    else :
    endif;
  }
?>
</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="l-wrapper">
      <div class="button-balloon-wrapper">
        <p class="button-balloon">この会場が少しでも気になる方へ。まずは カンタン問い合わせ！</p><a class="button button--contact optimize-elem-cv-btn" href="<?php echo get_form_url(); ?>" target="_blank" rel="nofollow">今すぐ施設に問い合わせる（無料）</a>
        <div class="buttons">
          <div class="buttons__item"><div class="favorite-button js-favorite optimize-elem-favorite-btn" data-facility-id="<?php echo $favorite_id ?>"><p><span>検討リストに追加する</span><span>検討リスト追加済</span></p></div></div>
          <div class="buttons__item">
            <a class="button button--contact-2 gtm-cv-1" href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank" rel="nofollow"><span><span><span>検討リストに追加した施設に</span><span>まとめて問い合わせする</span></span></span></a>
          </div>
        </div>
        <?php if( $incentiveFee == true): ?>
        <p class="button--contact__text-2">※こちらの施設は、CO-MIT予約センター経由での相談となります。</p>
        <?php else: ?>
        <p class="button--contact__text"><a class="gtm-cv-2" target="_blank" href="<?php echo $official_website_url; ?>">公式サイトで詳しい情報を見たい方はこちら</a></p>
        <?php endif; ?>
      </div>
    </div>

  </section>

</main>

<?php /*
<div class="cv-facility">
	<div class="l-wrapper">
		<ul class="cv-facility__wrap">
			<li class="cv-facility__item cv-facility__item--sm cv-facility__item--1 pc-only">
				<a href="<?php echo get_form_url(); ?>" target="_blank" class="cv-facility__button cv-facility__button--color">お問い合わせ<span class="pc-only">フォーム</span><i class="cv-facility__button__icon cv-facility__button__icon--mail"></i></a>
			</li>
			<li class="cv-facility__item cv-facility__item--sm cv-facility__item--2 pc-only">
				<a target="_blank" href="<?php echo $official_website_url; ?>" class="cv-facility__button cv-facility__button--white">公式サイト<span class="pc-only">はこちら</span><i class="cv-facility__button__icon cv-facility__button__icon--blank"></i></a>
			</li>
			<li class="cv-facility__item cv-facility__item--3">
        <?php
        $phone_number = "";
        $phone_number_text = "";
        $phone_number02 = "";
        $phone_number02_text = "";
        if ( isset($comit_parent_id) ){
          if ( get_field('facility_tel',$comit_parent_id) ){
            $phone_number = get_field('facility_tel',$comit_parent_id);
            $phone_number_text = get_field('facility_tel_text',$comit_parent_id);
            $phone_number02 = get_field('facility_tel02',$comit_parent_id);
            $phone_number02_text = get_field('facility_tel02_text',$comit_parent_id);
          }
        } else {
          if ( get_field('facility_tel') ){
            $phone_number = get_field('facility_tel');
            $phone_number_text = get_field('facility_tel_text');
            $phone_number02 = get_field('facility_tel02');
            $phone_number02_text = get_field('facility_tel02_text');
          }
        }
      ?>
      <?php if ($phone_number!="" && $phone_number02!=""): ?>
        <div class="cv-facility__tel02__outer">
          <div class="cv-facility__tel02">
            <a href="tel:<?php echo $phone_number ?>" class="cv-facility__tel02__item">
              <p class="cv-facility__tel02__number"><?php echo $phone_number ?></p>
              <p class="cv-facility__tel02__number-text"><?php echo $phone_number_text ?></p>
            </a>
            <p class="cv-facility__tel02__divider">/</p>
            <a href="tel:<?php echo $phone_number02 ?>" class="cv-facility__tel02__item">
              <p class="cv-facility__tel02__number"><?php echo $phone_number02 ?></p>
              <p class="cv-facility__tel02__number-text"><?php echo $phone_number02_text ?></p>
            </a>
          </div>
          <p class="cv-facility__tel02__text"><span class="pc-only">お問い合わせの際に</span>CO-MITを見たとお伝えいただくとスムーズです</p>
        </div>
      <?php elseif ($phone_number!=""): ?>
				<a href="tel:<?php echo $phone_number ?>" class="cv-facility__tel">
					<span class="cv-facility__tel__number"><?php echo $phone_number ?></span>
					<span class="cv-facility__tel__text"><span class="pc-only">お問い合わせの際に</span>CO-MITを見たとお伝えいただくとスムーズです</span>
				</a>
      <?php else: ?>
      <?php endif; ?>
			</li>
		</ul>
	</div>
</div>
*/ ?>

<?php endwhile; endif; ?>



<?php get_footer(); ?>
