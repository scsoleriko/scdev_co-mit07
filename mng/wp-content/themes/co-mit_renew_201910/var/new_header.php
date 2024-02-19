<!DOCTYPE html>
<html lang="ja"><head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<?php if ( is_404() ) {
	echo '<meta name="robots" content="noindex,nofollow">';
}?>

<link rel="preload" as="font" href="/common/fonts/icomoon.woff" >
<link rel="preload" as="font" href="/common/fonts/FjallaOne.woff2" >

<?php
if( ( is_home() || is_front_page() ) && is_mobile()) :
?>
<link rel="prefetch" href="/co-mit_renew_201910/img/ph_top_fv_sp.jpg" as="image">
<?php endif; ?>
<?php
if( is_home() || is_front_page()) :
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
<?php endif; ?>

<?php if ( is_archive() || is_category() || is_tax()): 
$term = get_queried_object();
endif; ?>
<?php if( is_home() || is_front_page() ) : ?><?php else: ?>
<?php if(is_category(1) || (get_post_type() == 'post' && in_category(1))) : ?><meta name="robots" content="noindex,nofollow"><?php endif; ?>
<?php endif; ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">

<?php get_template_part('var/meta-thumb'); //モバイル版Google検索のサムネイル ?>

<?php get_template_part('var/title-desc'); //titleタグとdescriptionの設定 ?>
<?php if ( is_home() ) : ?>
<link rel="canonical" href="https://co-mit.jp/">
<?php elseif (is_tax('area')||is_tax('feature')): ?>
<link rel="canonical" href="<?php $term_link = get_term_link( $term, $taxonomy ); $term_link = str_replace('/facility', '', $term_link); echo $term_link; ?>">
<?php elseif (is_archive('column')): ?>
<link rel="canonical" href="<?php echo (is_ssl() ? 'https://' : 'http://') . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>">
<?php endif; ?>

<link rel="icon" href="/img/favicon.ico" type="image/x-icon">
<?php get_template_part('var/css_manager'); //cssの設定 ?>
<?php get_template_part('var/ogp'); //ogpの設定 ?>
<?php if (is_page('faq')): ?>
<script type="application/ld+json">
{
    "@context":"http://schema.org",
    "@type":"website",
    "name":"CO-MIT(コミット) - 研修・合宿施設検索サイト",
    "inLanguage":"jp", //ウェブサイトの言語
    "publisher": {
    "@type": "Organization",
    "name": "ASNO SYSTEM",
    "logo": {
        "@type": "ImageObject",
        "url": "/co-mit_renew_201910/img/logo_color.png"
    }},
    "copyrightYear":"2022-04-01T00:00:00+0000",//コピーライトの日付
		"headline":"よくある質問｜CO-MIT(コミット)企業研修・宿泊研修施設",
    "description":"企業研修の施設検索サイト「CO-MIT（コミット）」のよくある質問ページです。「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。",
		"url":"{<?php echo get_the_permalink(); ?>}" //WP組み込み時に変換
}
</script>
<?php elseif ( is_singular('faq')): ?>
<script type="application/ld+json">
{
    "@context":"http://schema.org",
    "@type":"website",
    "name":"CO-MIT(コミット) - 研修・合宿施設検索サイト",
    "inLanguage":"jp", //ウェブサイトの言語
    "publisher": {
    "@type": "Organization",
    "name": "ASNO SYSTEM",
    "logo": {
        "@type": "ImageObject",
        "url": "/co-mit_renew_201910/img/logo_color.png"
    }},
    "copyrightYear":"2022-04-01T00:00:00+0000",//コピーライトの日付
		"headline":"<?php the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設",
    "description":"よくある質問「<?php the_title(); ?>」の質問に回答しています。お困りの方はこちらからご確認ください。",
		"url":"{<?php the_permalink(); ?>}" //WP組み込み時に変換
}
</script>
<?php endif; ?>

<?php if ( is_circulareeconomy() ): ?>
<script>
	(function(d) {
		var config = {
			kitId: 'fwe5llk',
			scriptTimeout: 3000,
			async: true
		},
		h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
	})(document);
</script>
<?php endif; ?>
  
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K8JCTJV');</script>
<!-- End Google Tag Manager -->

<?php wp_head(); ?>

</head>

<?php if (is_page('about')): ?>
<body id="new-about">
<?php elseif (is_page('agreement')): ?>
<body id="new-agreement">
<?php elseif (is_page('disclaimer')): ?>
<body id="new-disclaimer">
<?php elseif (is_404()): ?>
<body id="new-404">
<?php elseif (is_page('faq') || is_singular('faq')): ?>
<body id="new-faq">
<?php elseif (is_page('beginner')): ?>
<body id="beginner">
<?php else: ?>
<body>
<?php endif; ?>
<div class="l-body <?php
if (is_home()) :
	echo "l-body--home";
elseif (is_archive("facility")) :
	echo "l-body--facility_archive";
endif; ?>">
<?php if ( !is_circulareeconomy() ): ?>
	<header class="l-header">
		<div class="l-header__wrapper">
			<p class="header-logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="/co-mit_renew_201910/img/logo_color.png" srcset="/co-mit_renew_201910/img/logo_color.png 1x, /co-mit_renew_201910/img/logo_color@2x.png 2x" alt="研修・合宿施設検索サイト | CO-MIT(コミット)"></a></p>
			<div class="sp-favorite">
		<p class="sp-favorite__btn js-favorite-sp-btn"><i class="icon-favorite"></i><span>検討リスト</span></p>
		<div class="sp-favorite__detail js-favorite-sp-detail">
		</div>
	</div>
			<a href="#" class="sp-menu-btn"><span>メニューを開く</span><span></span><span></span></a>
			<nav class="navi navi--pc-side">			
				<div class="navi__wrapper">
          <ul class="navi__main">
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>beginner/">初めての方はこちら</a></li>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>facility/">施設を探す</a></li>
						<?php if ( is_singular('facility') ): ?>
							<?php
								$footer_consult = get_post_meta($post->ID, 'footer_consult', true);
								if ( $footer_consult && $footer_consult[0] == '「専門家に相談する」を表示する') :
							?>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>consult/">専門家に相談する</a></li>
							<?php endif; ?>
						<?php else: ?>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>consult/">専門家に相談する</a></li>
						<?php endif; ?>
            <li class="navi__main__item side-only"><a href="<?php echo esc_url(home_url('/')); ?>workation-portal/">ワーケーションポータル</a></li>
						<li class="navi__main__item side-only"><a href="<?php echo esc_url(home_url('/')); ?>offsite/">オフサイト研修のススメ</a></li>
						<li class="navi__main__item side-only"><a href="<?php echo esc_url(home_url('/')); ?>circulareconomy/">サーキュラーエコノミーを知る</a></li>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>column/">研修ノウハ<span>ウ・</span>コラム</a></li>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>events/">イベントに参加する</a></li>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>about/">CO-MITの強み</a></li>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>faq/">よくある質問</a></li>
						<li class="navi__main__item side-only navi__main__item--favorite"><a href="<?php echo esc_url(home_url('/')); ?>favorite/"><i class="icon-favorite"></i>検討リスト</a></li>
					</ul>
					<div class="navi_wrapper">
						<ul class="navi__sub">
							<li class="navi__sub__item"><a href="<?php echo esc_url(home_url('/')); ?>agreement/">利用規約</a></li>
							<li class="navi__sub__item"><a href="<?php echo esc_url(home_url('/')); ?>disclaimer/">免責事項</a></li>
							<li class="navi__sub__item"><a href="https://asno-sys.co.jp/privacy/" target="_blank">個人情報保護方針</a></li>
							<li class="navi__sub__item"><a href="https://asno-sys.co.jp/" target="_blank">運営会社</a></li>
						</ul>
						<ul class="navi__sns">
							<li class="navi__sns__item"><a href="https://www.facebook.com/kensyu.comit/" target="_blank"><img src="/co-mit_renew_201910/img/icon_facebook.png" alt="facebook"><span>「CO-MIT」Facebook公式アカウント</span></a></li>
						</ul>

            <ul class="navi__sns sns__icon-youtube-menu">
							<li class="navi__sns__item"><a href="https://www.youtube.com/channel/UChVGwQOstm2VFPvBZVng8VA" target="_blank"><img src="/co-mit_renew_201910/img/icon_youtube.jpg" alt="youtube"><span>「CO-MIT」YouTube公式アカウント</span></a></li>
            </ul>      
          </div>
        </nav>
      <nav class="navi">
				<div class="navi__wrapper">
		<div class="navi__favorite">
			<?php
			//配列準備
      if(isset( $_COOKIE["co-mitFavoriteList"])){
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
			?>
			<div class="navi__favorite__btn">
			<a href="<?php echo esc_url(home_url('/')); ?>favorite/"><i class="icon-favorite"></i><span>検討リスト（<?php echo $the_query->found_posts;?>）</span></a>
			</div>
						<div class="navi__favorite__detail">
							<div class="navi__favorite__detail__inner">
								<p class="navi__favorite__title">検討中の施設<span>（まとめて問い合わせできます）</span></p>
								<?php
								if ( $the_query->have_posts() ){
								?>
								<ul class="navi__favorite__list">
								<?php
									while ( $the_query->have_posts() ) {
									$the_query->the_post();
								?>
									<li><a href="<?php the_permalink(); ?>" target="_blank"><?php echo get_the_title(); ?></a></li>
								<?php
									}
									wp_reset_postdata();
								?>
									</ul>
									<div class="navi__favorite__btn-2"><a href="<?php echo esc_url(home_url('/')); ?>favorite/" target="_blank">すべて見る</a></div>
								<?php
								} else {
								?>
									<p class="navi__favorite__text">施設が検討リストにありません。</p>
								<?php
								}
								?>
							</div>
						</div>
					</div>
					<ul class="navi__main">
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>facility/">施設を探す</a></li>
						<?php if ( is_singular('facility') ): ?>
							<?php
								$footer_consult = get_post_meta($post->ID, 'footer_consult', true);
								if ( $footer_consult && $footer_consult[0] == '「専門家に相談する」を表示する') :	
							?>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>consult/">専門家に相談する</a></li>
							<?php endif; ?>
						<?php else: ?>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>consult/">専門家に相談する</a></li>
						<?php endif; ?>
			<?php if (is_home()): ?>
			<li class="navi__main__item side-only"><a href="<?php echo esc_url(home_url('/')); ?>events/">イベントに参加する</a></li>
			<?php endif; ?>
						<li class="navi__main__item side-only"><a href="<?php echo esc_url(home_url('/')); ?>offsite/">オフサイト研修のススメ</a></li>
						<li class="navi__main__item side-only"><a href="<?php echo esc_url(home_url('/')); ?>circulareconomy/">サーキュラーエコノミーを知る</a></li>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>column/">研修ノウハ<span>ウ・</span>コラム</a></li>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>workation-portal/">ワーケーションポータル</a></li>
						<li class="navi__main__item"><a href="<?php echo esc_url(home_url('/')); ?>beginner/">初めての方はこちら</a></li>
						<li class="navi__main__item side-only navi__main__item--favorite"><a href="<?php echo esc_url(home_url('/')); ?>favorite/"><i class="icon-favorite"></i>検討リスト</a></li>
					</ul>
					<div class="navi_wrapper">
						<ul class="navi__sub">
							<li class="navi__sub__item"><a href="<?php echo esc_url(home_url('/')); ?>agreement/">利用規約</a></li>
							<li class="navi__sub__item"><a href="<?php echo esc_url(home_url('/')); ?>disclaimer/">免責事項</a></li>
							<li class="navi__sub__item"><a href="https://asno-sys.co.jp/privacy/" target="_blank">個人情報保護方針</a></li>
							<li class="navi__sub__item"><a href="https://asno-sys.co.jp/" target="_blank">運営会社</a></li>
						</ul>
						<ul class="navi__sns">
							<li class="navi__sns__item"><a href="https://www.facebook.com/kensyu.comit/" target="_blank"><img src="/co-mit_renew_201910/img/icon_facebook.png" alt="facebook"><span>「CO-MIT」Facebook公式アカウント</span></a></li>
						</ul>

            <ul class="navi__sns sns__icon-youtube-menu">
							<li class="navi__sns__item"><a href="https://www.youtube.com/channel/UChVGwQOstm2VFPvBZVng8VA" target="_blank"><img src="/co-mit_renew_201910/img/icon_youtube.jpg" alt="youtube"><span>「CO-MIT」YouTube公式アカウント</span></a></li>
            </ul>
					</div>
				</div>
			</nav>
		</div>
	</header>
<?php else: ?>
	<?php
  //$body_id
		if ( is_post_type_archive('circulareconomy') ):
			$header_class = 'circular-top';
		else:
			$header_class = '';
		endif;
	?>
	<header class="circular-header <?php echo $header_class; ?>">
		<?php if( !is_post_type_archive('circulareconomy') ): ?>
		<div class="lower-head">
			<div class="l-wrapper">
				<a href="/circulareconomy/"><img src="/co-mit_renew_201910/img/circulareconomy/logo-circular.png" alt="CO-MIT流 サーキュラーエコノミーを知る"></a>
				<div class="businessworkcation black">
					<p>ビジネス創出型<br>ワーケーション</p>
					<p class="box">特集</p>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<a href="/circulareconomy/" class="sp-menu__logo"><img src="/co-mit_renew_201910/img/circulareconomy/logo-circular.png" alt="CO-MIT流 サーキュラーエコノミーを知る"></a>
		<div class="circular-nav-wrap">
			<div class="l-wrapper">
				<nav>
					<ul class="circular-nav">
						<li><a href="/circulareconomy/about/">サーキュラーエコノミーとは</a></li>
						<li><a href="/circulareconomy/circularcity/">サーキュラーシティとは</a></li>
						<li><a href="/circulareconomy/examples/">視察受入情報</a></li>
						<li class="comingsoon"><a href="/circulareconomy/column/">コラム</a><p>coming soon</p></li>
						<li><a href="/circulareconomy#seminar">セミナー情報</a></li>
						<li><a href="/circulareconomy#accept">視察受入地の方へ</a></li>
					</ul>
				</nav>
			</div>
		</div>
		<button type="button" class="sp-circular__btn">
			<span></span>
			<span></span>
			<span></span>
		</button>
	</header>
<?php endif; ?>

<?php if (!is_home()): ?>

<?php if ( is_post_type_archive('facility') ) : ?>
<a href="#search" class="sp-refine-btn">絞り込み検索はこちら</a>
<?php endif; ?>

<!-- ▼ breadcrumb ▼ -->
<?php if ( is_home() || is_front_page() || is_circulareeconomy() ) : ?>
<?php elseif ( get_post_type() === 'facility'): ?>
		<?php custom_breadcrumb(); ?>
<?php elseif ( is_tax( 'category_column' )): ?>
		<?php
			$taxonomy = 'category_column';
			$term = get_term_by('slug', get_query_var($taxonomy), $taxonomy);
		?>
		<div class="breadcrumb">
		<ol class="l-wrapper breadcrumb__wraper">
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>"><span>トップ</span></a></li>
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>column/"><span>研修ノウハウ・コラム</span></a></li>
			<li class="breadcrumb__item"><span>「<?php echo $term->name ?>」カテゴリの記事一覧</span></li>
		</ol>
		</div>
<?php elseif ( is_tax( 'tag_column' )): ?>
		<?php
			$taxonomy = 'tag_column';
			$term = get_term_by('slug', get_query_var($taxonomy), $taxonomy);
		?>
		<div class="breadcrumb">
		<ol class="l-wrapper breadcrumb__wraper">
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>"><span>トップ</span></a></li>
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>column/"><span>研修ノウハウ・コラム</span></a></li>
			<li class="breadcrumb__item"><span>「<?php echo $term->name ?>」タグの記事一覧</span></li>
		</ol>
		</div>
<?php elseif ( is_post_type_archive( 'column' )): ?>
		<div class="breadcrumb">
		<ol class="l-wrapper breadcrumb__wraper">
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>"><span>トップ</span></a></li>
			<li class="breadcrumb__item"><span>研修ノウハウ・コラム</span></li>
		</ol>
		</div>
<?php elseif ( is_singular( 'column' )): ?>
		<div class="breadcrumb">
		<ol class="l-wrapper breadcrumb__wraper">
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>"><span>トップ</span></a></li>
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>column/"><span>研修ノウハウ・コラム</span></a></li>
			<li class="breadcrumb__item"><span><?php echo get_the_title() ?></span></li>
		</ol>
		</div>
<?php elseif ( is_singular( 'faq' )): ?>
		<div class="breadcrumb">
		<ol class="l-wrapper breadcrumb__wraper">
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>"><span>トップ</span></a></li>
			<li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>faq/"><span>よくある質問</span></a></li>
			<li class="breadcrumb__item"><span><?php echo get_the_title() ?></span></li>
		</ol>
		</div>
<?php else: ?>
		<div class="breadcrumb">
		<ol class="l-wrapper breadcrumb__wraper">
			<li class="breadcrumb__item"><a href="/"><span>トップ</span></a></li>
			<li class="breadcrumb__item"><?php
	if(is_category(1) || in_category(1)) {
	echo 'お探しのページが見つかりませんでした。';
	} else {
	echo get_the_title();
	}
?><?php if ( is_404() ) : ?>お探しのページが見つかりませんでした。<?php endif; ?></li>
		</ol>
		</div>
<?php endif; ?>
<!-- ▲ breadcrumb ▲ -->
<?php endif; ?>