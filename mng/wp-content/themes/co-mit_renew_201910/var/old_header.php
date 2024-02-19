<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

<?php if ( is_404() ) {
	echo '<meta name="robots" content="noindex,nofollow">';
}?>

<?php // 投稿タイプを指定して親の投稿一覧を表示
	if (! (isset($term)) ) { $term = null; }
	$post_type_slug = 'facility'; // 投稿タイプのスラッグを指定
	$args = array(
		'post_type' => $post_type_slug, // 投稿タイプを指定
		'taxonomy' => 'area',
		'term' => $term,
		'post_parent' => 0 // 親を持たない投稿を取得
	);
	$meta_query = new WP_Query($args);
?>
<?php if( $meta_query->have_posts() || is_tax('feature') ): ?>
<?php else: ?>
<meta name="robots" content="noindex,nofollow">
<?php endif; ?>
<?php if( is_home() || is_front_page() ) : ?><?php else: ?>
<?php if(is_category(1) || in_category(1)) : ?><meta name="robots" content="noindex,nofollow"><?php endif; ?>
<?php endif; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
<?php if ( is_home() || is_front_page() ) : ?>
    <title>CO-MIT(コミット) - 研修・合宿施設検索サイト</title>
    <meta name="description" content="新入社員研修やオフサイトミーティング・チームビルディングに最適な研修施設、ホテル、旅館、公共施設を探すならコミットで！ご希望の条件に合わせた施設・研修会場をお探しいただけます。">
    <meta property="og:title" content="CO-MIT(コミット) - 研修・合宿施設検索サイト">
    <meta property="og:description" content="新入社員研修や合宿ができる宿泊付き研修施設、ホテル、旅館、公共施設を探すならコミットで！ご希望の条件に合わせた施設・研修会場をお探しいただけます。">
    <meta property="og:url" content="https://co-mit.jp/">
    <meta property="og:site_name" content="CO-MIT(コミット) - 研修・合宿施設検索サイト">
    <meta property="og:image" content="https://co-mit.jp/img/comit_ogp.jpg">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:image:src" content="https://co-mit.jp/img/comit_ogp.jpg">
    <?php if ( is_home() ) : ?>
    <link rel="canonical" href="https://co-mit.jp/">
    <?php endif; ?>
<?php elseif ( is_page() ) : ?>
    <title><?php echo get_the_title(); ?>｜CO-MIT(コミット) </title>
    <meta name="description" content="<?php if( has_excerpt() ){ the_excerpt(); } else { ?>新入社員研修やオフサイトミーティング・チームビルディングに最適な研修施設、ホテル、旅館、公共施設を探すならコミットで！ご希望の条件に合わせた施設・研修会場をお探しいただけます。<?php }?>">
<?php elseif (is_tax('area')||is_tax('feature')): ?>
    <title><?php echo $term_name = single_term_title( '', false ); ?>で人気の研修・合宿施設一覧｜CO-MIT(コミット) </title>
    <meta name="description" content="<?php echo $term_name = single_term_title( '', false ); ?>で新入社員研修やオフサイトミーティング・チームビルディングができる研修施設、ホテル、旅館、公共施設をご紹介。リゾートから都市型まで研修・合宿施設探すならCO-MIT（コミット）で！">

    <link rel="canonical" href="<?php $term_link = get_term_link( $term, $taxonomy ); $term_link = str_replace('/facility', '', $term_link); echo $term_link; ?>">

<?php elseif ( is_post_type_archive('facility') ): ?>
    <?php if ( is_search() ): ?>
    <title>検索結果｜CO-MIT(コミット) </title>
    <meta name="robots" content="noindex,nofollow">
    <?php else: ?>
    <title>施設を探す｜CO-MIT(コミット) </title>
    <?php endif; ?>
    <meta name="description" content="お気に入りの研修・合宿施設が見つかるかも？！CO-MIT（コミット）では新入社員研修やオフサイトミーティング・チームビルディングができる研修施設、ホテル、旅館、公共施設をご紹介。施設は随時更新中！">
<?php elseif (get_post_type() === 'facility' && is_single()): ?>
    <title><?php if ( is_single() && $post->post_parent ) : ?>
<?php echo get_the_title(); ?>：<?php $parent_id = $post->post_parent; echo get_post($parent_id)->post_title;?> - <?php $parent_id = $post->post_parent; $terms = get_the_terms($parent_id, 'area'); foreach($terms as $term){ $term_name = $term->name; echo $term_name; break; }; ?>
<?php else : ?>
<?php echo get_the_title(); ?> - <?php $terms = get_the_terms($post->ID, 'area'); foreach($terms as $term){ $term_name = $term->name; echo $term_name; break; }; ?>
<?php endif; ?>｜CO-MIT(コミット) </title>
    <meta name="description" content="<?php
	if( get_field('facility_pr_deital') ){
		echo str_replace( array("\r\n","\r","\n"), '', get_field('facility_pr_deital') );
	} elseif( get_field('meeting_pr') ){
		echo str_replace( array("\r\n","\r","\n"), '', get_field('meeting_pr') );
	} elseif( get_field('lodging_pr') ){
		echo str_replace( array("\r\n","\r","\n"), '', get_field('lodging_pr') );
	} elseif( get_field('meal_pr') ){
		echo str_replace( array("\r\n","\r","\n"), '', get_field('meal_pr') );
	} elseif( get_field('service_pr') ){
		echo str_replace( array("\r\n","\r","\n"), '', get_field('service_pr') );
	} else {
		if ( get_field('edit_type') === 'アクセス・周辺情報' ) {
			$parent_id = $post->post_parent; echo get_post($parent_id)->post_title;
			echo 'へのアクセスと周辺情報について。';
		} else {
			echo '新入社員研修やオフサイトミーティング・チームビルディングができる研修施設、ホテル、旅館、公共施設を探すならコミットで！ご希望の条件に合わせた施設・研修会場をお探しいただけます。';
		}
	}?>">
<?php endif; ?>
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/img/apple-touch-icon.png" sizes="180x180">
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:300,400&amp;amp;subset=japanese" rel="stylesheet">
    <link rel="stylesheet" href="/common/css/style.css?v=1905151330">
    <link rel="stylesheet" href="/asn/css/adjust.css?v=1906271430">
    <script src="/common/js/jquery.js"></script>
    <style media="screen">

.common-header .header-top {
    background: #3E3A39;
    position: relative;
    display: none;
}
.common-header .header-main .header-nav ul li a:link, .common-header .header-main .header-nav ul li a:visited {
  text-decoration: none;
  display: none;
}
.sp-gnav-trigger {
    display: none;
}
#other-content .other-content-row {
    -js-display: flex;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -moz-justify-content: space-between;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-flex-wrap: wrap;
    -moz-box-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    display: none;
}
    </style>
<?php /*     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> */ ?>
<?php /* $url = $_SERVER['REQUEST_URI']; if(strstr($url,'/page/')==false): */ ?>
<?php /*
<script type="text/javascript">
if (window.performance) {
	console.log(performance.navigation.type);
	if (performance.navigation.type === 1) {
		var sesid = "pgsession";
		$.removeCookie(sesid);
		$.cookie(sesid, null);
		$.cookie(sesid, "", {expires: -1});
		$.cookie(sesid,"",{path:"/",expires:-1});
	}
}
</script> */ ?>
<?php /* endif; */ ?>
    <script src="/common/js/html5-shiv.js"></script>
    <script src="/common/js/flexibility.js"></script>
    <script src="/common/js/script.js?v=1905151330"></script>
    <script src="/asn/js/add.js?v=1906211420"></script>

<?php if ( get_field('edit_type') === '施設トップ' )  : ?>
<link rel="stylesheet" href="/common/css/jquery.bxslider.min.css">
<script type="text/javascript" src="/common/js/jquery.bxslider.min.js"></script>
<script type="text/javascript">
$(function(){
// slider
	$('[data-slider-main]').bxSlider({
		controls:false
	});
});
</script>
<?php endif; ?>

<?php if ( get_field('edit_type') === '会場情報' )  : ?>
<script src="/asn/fancybox/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="/asn/fancybox/jquery.fancybox.min.css">
<script type="text/javascript">
$(function() {
// accordion
	$('[data-accordion-open]').on('click', function(){
		$(this).parents('.btn-area').fadeOut('fast');
		$('[data-accordion]').slideDown('fast');
	});
});
</script>
<?php endif; ?>

<?php if ( get_field('edit_type') === '宿泊' )  : ?>
<script src="/asn/fancybox/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="/asn/fancybox/jquery.fancybox.min.css">
<?php /*<script type="text/javascript">
$(function() {
	var windowH = $(window).height();
	var windowW = $(window).width();

	if(windowW > 768) {
		var $photoList = $('[data-photo-list]').find('li');
		$photoList.each(function(){
			$(this).on({
				'mouseenter' : function(){
					$(this).find('.photo-zoom').show();
				},
				'mouseleave' : function(){
					$(this).find('.photo-zoom').hide();
				}
			});
		});
	}
});
</script> */?>
<?php endif; ?>

<?php if ( is_single() && $post->post_parent ) : ?>
<?php if ( get_field('edit_type') === 'アクセス・周辺情報' )  : ?>
<script src="//pkg.navitime.co.jp/resources/js/iframeResizer.min.js"></script>
<script type="text/javascript">
	$("document").ready(function(){
		$(".access-map iframe").load(function(){
			$(".access-map iframe").iFrameResize({checkOrigin: false});
		});
		//iframe先ページロード中にも対応
		$(".access-map iframe").triggerHandler("load");
	});
</script>
<?php endif; ?>
<?php endif; ?>


<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K8JCTJV');</script>
<!-- End Google Tag Manager -->
  </head>



<?php if ( is_home() || is_front_page() ) : ?>
	<body class="index-page">
<?php elseif (is_tax('area')): ?>
	<body class="list-page">
<?php else: ?>
	<?php
	$body_class = get_field('body_class');
	if($body_class){ ?><body class="<?php echo $body_class; ?>">
	<?php } else { ?><body>
	<?php } ?>
<?php endif; ?>



<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K8JCTJV" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="page-layout" id="layout">
      <header class="common-header">
        <div class="header-top">
          <div class="inner">
            <p class="header-top-text">研修・合宿施設検索サイト CO-MIT(コミット) | 新入社員研修やオフサイトミーティング・チームビルディングに最適な施設をご紹介</p>
          </div>
          <div class="header-top-btn pc-only">
            <p><a id="bnr_contact_pc" href="/contact/">掲載に関するお問い合わせ</a></p>
          </div>
        </div>
        <div class="header-main" data-scroll-header="">
          <div class="inner">
<?php if ( is_home() || is_front_page() ) : ?>
            <h1 class="logo"><a class="refresh" href="/"><img src="/co-mit_renew_201910/img/logo_color.png" alt="研修・合宿施設検索サイト | CO-MIT(コミット)"></a></h1>
<?php else: ?>
            <a class="logo refresh" href="/"><img src="/co-mit_renew_201910/img/logo_color.png" alt="研修・合宿施設検索サイト | CO-MIT(コミット)"></a>
<?php endif; ?>
            <nav class="header-nav">
              <ul>
                <li><a id="facility_head_pc" class="refresh" href="/facility/"><i class="icon-search"></i>施設を探す</a></li>
                <li><a id="consult_head_pc" href="/consult/"><i class="icon-balloon"></i>専門家に相談する</a></li>
              </ul>
            </nav>
          </div>
          <nav class="sp-gnav-trigger">
            <p data-sp-menu-trigger=""><span class="top"></span><span class="middle"></span><span class="bottom"></span></p>
          </nav>
        </div>
        <div class="header-height" data-header-height=""></div>
      </header>
      <div class="sp-overlay" data-sp-overlay>
        <nav class="sp-gnav-trigger">
          <p class="is_open" data-sp-closer><span class="top"></span><span class="middle"></span><span class="bottom"></span></p>
        </nav>
        <nav class="sp-gnav" data-sp-gnav>
          <ul>
            <li><a class="refresh" href="/">HOME</a></li>
            <li><a href="/about/">CO-MITの強み</a></li>
            <li><a id="facility_head_sp" class="refresh" href="/facility/">施設を探す</a></li>
            <li><a id="consult_head_sp" href="/consult/">専門家に相談する</a></li>
          </ul>
        </nav>
      </div>
      <div class="sp-contact-btn" data-sp-btn>
        <p class="btn-normal"><a id="bnr_contact_sp" href="/contact/">掲載に関するお問い合わせ</a></p>
      </div>
<?php if ( is_home() || is_front_page() ) : ?>
<?php elseif ( get_post_type() === 'facility'): ?>
      <?php custom_breadcrumb_old(); ?>
<?php else: ?>
      <nav class="topic-path">
        <ul class="inner">
          <li><a class="refresh" href="/">トップ</a></li>
          <li><?php
	if(is_category(1) || in_category(1)) {
		echo 'お探しのページが見つかりませんでした。';
	} else {
		echo get_the_title();
	}
?><?php if ( is_404() ) : ?>お探しのページが見つかりませんでした。<?php endif; ?></li>
        </ul>
      </nav>
<?php endif; ?>


<?php if (get_post_type() === 'facility' && is_single()): ?>
  <main class="facility-detail">
<?php else: ?>
  <main>
<?php endif; ?>


<?php wp_head(); ?>