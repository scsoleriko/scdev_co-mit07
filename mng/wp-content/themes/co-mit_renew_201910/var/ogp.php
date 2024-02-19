<?php $url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>

<?php if ( is_singular('column') ): //研修ノウハウ・コラム ?>
<meta name="twitter:card" content="summary_large_image">
<meta property="og:url" content="<?php echo $url ?>">
<?php if(has_post_thumbnail()): ?>
<?php
$ogImageUrl = get_the_post_thumbnail_url();
if ( preg_match("/^http/",$ogImageUrl) ): ?>
<meta property="og:image" content="<?php echo get_the_post_thumbnail_url() ?>">
<?php else: ?>
<meta property="og:image" content="https:<?php echo get_the_post_thumbnail_url() ?>">
<?php endif; ?>
<?php else: ?>
<meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?>co-mit_renew_201910/img/ogp.png">
<?php endif; ?>
<meta property="og:title" content="<?php the_title(); ?>">
<meta property="og:description" content="研修・合宿施設検索サイト「 CO-MIT（コミット）」では研修に役立つノウハウ記事を配信。">

<?php elseif ( is_singular('facility') ): // 施設詳細 ?>
<meta name="twitter:card" content="summary_large_image">
<meta property="og:url" content="<?php echo $url ?>">
<?php if( get_field('facility_mainimage') ): ?>
<?php
$ogImageUrl = get_field('facility_mainimage');
if ( preg_match("/^http/",$ogImageUrl) ): ?>
<meta property="og:image" content="<?php echo get_field('facility_mainimage') ?>">
<?php else: ?>
<meta property="og:image" content="https:<?php echo get_field('facility_mainimage') ?>">
<?php endif; ?>
<?php else: ?>
<meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?>co-mit_renew_201910/img/ogp.png">
<?php endif; ?>
<meta property="og:title" content="<?php the_title(); ?> | CO-MIT(コミット)企業研修・宿泊研修施設">
<meta property="og:description" content="お気に入りの研修・合宿施設が見つかるかも？！CO-MIT（コミット）では新入社員研修やオフサイトミーティング・チームビルディングができる研修施設、ホテル、旅館、公共施設をご紹介。">

<?php elseif (is_page('faq')): ?>
<meta property="og:title" content="<?php the_title(); ?> | CO-MIT(コミット)企業研修・宿泊研修施設">
<meta property="og:description" content="企業研修の施設検索サイト「CO-MIT（コミット）」のよくある質問ページです。「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">

<?php elseif (is_singular('faq')): ?>
<meta property="og:title" content="<?php the_title(); ?> | CO-MIT(コミット)企業研修・宿泊研修施設">
<meta name="og:description" content="よくある質問「<?php echo get_the_title(); ?>」の質問に回答しています。お困りの方はこちらからご確認ください。">

<?php // ------------------------------ サーキュラーエコノミー --------------------------------------- ?>
<?php elseif ( get_post_type() === 'circulareconomy' ): ?>
  <?php $circular_ogp = 'co-mit_renew_201910/img/circulareconomy/circulareconomy-ogp.png'; ?>
  <?php $post_name = $post->post_name; ?>

  <?php if( is_post_type_archive('circulareconomy') ) :?>
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>circulareconomy/">
    <meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?><?php echo $circular_ogp; ?>">
    <meta property="og:title" content="CO-MIT流サーキュラーエコノミーを知る">
    <meta property="og:description" content="サーキュラシティ事例から、環境保全活動としてだけではなくこれからの経営戦略・事業戦略としての位置づけを学びを得るためのコンテンツ">

  <?php elseif ( $post_name === 'about' ) : ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>circulareconomy/about/">
    <meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?><?php echo $circular_ogp; ?>">
    <meta property="og:title" content="サーキュラーエコノミーとは｜CO-MIT流サーキュラーエコノミーを知る">
    <meta property="og:description" content="サーキュラーエコノミーとは？背景からビジネスモデルまで基本を解説します。">


  <?php elseif ( $post_name === 'circularcity' ) : ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>circulareconomy/circularcity/">
    <meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?><?php echo $circular_ogp; ?>">
    <meta property="og:title" content="サーキュラーシティとは｜CO-MIT流サーキュラーエコノミーを知る">
    <meta property="og:description" content="サーキュラーシティとは？〜サーキュラーエコノミーの概念をまちづくりに取り入れた新しいまちのカタチ〜を解説します。">


  <?php elseif( $post_name === 'examples' ): ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>circulareconomy/examples/">
    <meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?><?php echo $circular_ogp; ?>">
    <meta property="og:title" content="サーキュラーシティ実例一覧｜CO-MIT流サーキュラーエコノミーを知る">
    <meta property="og:description" content="サーキュラーエコノミーに取り組む先進的な地域をご紹介します。ご紹介の各地域は、視察や企業研修の場としての受け入れも行っています。">


  <?php elseif( $post_name === 'column' ): ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>circulareconomy/column/">
    <meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?><?php echo $circular_ogp; ?>">
    <meta property="og:title" content="コラム一覧｜CO-MIT流サーキュラーエコノミーを知る">
    <meta property="og:description" content="サーキュラーエコノミーの最新の動向や、サーキュラーエコノミー実現に向けて企業にとってお役立ちいただける情報をお届していきます。">

  <?php elseif( $post->post_parent !== 0 ): ?>
  <?php if(has_post_thumbnail()): ?>
    <?php
    $ogImageUrl = get_the_post_thumbnail_url();
    if ( preg_match("/^http/",$ogImageUrl) ): ?>
      <meta property="og:image" content="<?php echo get_the_post_thumbnail_url() ?>">
    <?php else: ?>
      <meta property="og:image" content="https:<?php echo get_the_post_thumbnail_url() ?>">
    <?php endif; ?>
    <?php else: ?>
      <meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?><?php echo $circular_ogp; ?>">
    <?php endif; ?>
    <?php
    $site_title = 'CO-MIT流サーキュラーエコノミーを知る';
    $parent_id = $post->post_parent;
    $parent_slug = get_post($parent_id)->post_name;
    $slug =  $post->post_name;
    $page_title = get_the_title();
    ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>circulareconomy/<?php echo $parent_slug; ?>/<?php echo $slug; ?>">
    <meta property="og:title" content="<?php echo $page_title; ?>｜<?php echo $site_title; ?>">
    <meta property="og:description" content="">
  <?php endif; ?>



<?php else: //それ以外のページ ?>
<meta name="twitter:card" content="summary_large_image">
<meta property="og:url" content="https://co-mit.jp/">
<meta property="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?>co-mit_renew_201910/img/ogp.png">
<meta property="og:title" content="研修・合宿施設検索サイト「 CO-MIT（コミット）」">
<meta property="og:description" content="お気に入りの研修・合宿施設が見つかるかも？！CO-MIT（コミット）では新入社員研修やオフサイトミーティング・チームビルディングができる研修施設、ホテル、旅館、公共施設をご紹介。">

<?php endif; ?>