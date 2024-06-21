<?php // ------------------------------ TOP --------------------------------------- ?>
<?php if ( is_home() || is_front_page() ) : ?>
<title>CO-MIT(コミット) - 研修・合宿施設検索サイト</title>
<meta name="description" content="企業研修や新入社員研修、開発合宿、オフサイトミーティングに最適な研修施設やホテルを探すならコミット。地域や人数、目的別に探せる便利な検索機能でご希望の条件に合わせた施設・研修会場が見つかります。">

<?php // ------------------------------ CO-MITの強み --------------------------------------- ?>
<?php elseif ( is_page('about') ) : ?>
<title><?php echo get_the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="企業研修の施設検索サイト「CO-MIT（コミット）」の特徴や、提供できることについて記載しております。企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">

<?php // ------------------------------ 利用規約について --------------------------------------- ?>
<?php elseif ( is_page('agreement') ) : ?>
<title><?php echo get_the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="研修・合宿施設検索サイト「CO-MIT（コミット）」の利用規約を記載しております。「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">

<?php // ------------------------------ 検討リスト--------------------------------------- ?>
<?php elseif ( is_page('favorite') ) : ?>
<title><?php echo get_the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="気になった施設は検討リストへ保存！「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">

<?php // ------------------------------ 免責事項について --------------------------------------- ?>
<?php elseif ( is_page('disclaimer') ) : ?>
<title><?php echo get_the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="企業研修の施設検索サイト「CO-MIT（コミット）」の免責事項を記載しております。「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">

<?php // ------------------------------ 404 --------------------------------------- ?>
<?php elseif (is_404()) : ?>
<title>お探しのページが見つかりませんでした ｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="お気に入りの研修・合宿施設が見つかるかも？！CO-MIT（コミット）では新入社員研修やオフサイトミーティング・チームビルディングができる研修施設、ホテル、旅館、公共施設をご紹介。">

<?php // ------------------------------ よくある質問 --------------------------------------- ?>
<?php elseif (is_page('faq')): ?>
<title><?php echo get_the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="企業研修の施設検索サイト「CO-MIT（コミット）」のよくある質問ページです。「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">
<?php elseif (is_singular('faq')): ?>
<title><?php echo get_the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="よくある質問「<?php echo get_the_title(); ?>」の質問に回答しています。お困りの方はこちらからご確認ください。">

<?php // ------------------------------ 初めての方へ --------------------------------------- ?>
<?php elseif (is_page('beginner')): ?>
<title><?php echo get_the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="企業研修の施設検索サイト「CO-MIT（コミット）」を初めてご利用の方はこちら！利用メリットや利用の流れを記載しています。企業研修や新入社員研修、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">

<?php // ------------------------------ パーソナルデータの外部送信について --------------------------------------- ?>
<?php elseif (is_page('personal_data')): ?>
<title><?php echo get_the_title(); ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
<meta name="description" content="企業研修の施設検索サイト「CO-MIT（コミット）」のパーソナルデータの外部送信についてを記載しております。「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">

<?php // ------------------------------ 施設を探す --------------------------------------- ?>
<?php elseif ( is_post_type_archive('facility') ): ?>
<?php if ( is_search() ): ?>
<?php // 検索条件からタイトルを作成 ?>
<?php
	//絞り込みの値を取得
  if(isset($_GET['cat_area'])){
    $cat_area = $_GET['cat_area'];
  }
  if(isset($_GET['facility_capa'])){
    $capa = $_GET['facility_capa'];
  }
  if(isset($_GET['post_tag'])){
    $post_tag = $_GET['post_tag'];
  }
  if(isset($_GET['cat_hotel'])){
    $cat_hotel = $_GET['cat_hotel'];
  }
  $cat_area_name = array();
  $result_cond = array();

  // 都道府県名取得
  if (!empty($cat_area)) {
		if(is_array($cat_area)) {
			foreach($cat_area as $val){
				$cat_area_name[] = get_term_by('slug',$val,"area")->name;
			}
      $result_cond[] = implode(" ", $cat_area_name);
		}else if (!empty($cat_area)) {
      $result_cond[] = get_term_by('slug',$cat_area,"area")->name;
    }
  }

  if(!empty($capa)) {
      if ($capa == "1") {
        $result_cond[] = "20名未満";
      } else if ($capa == "20") {
        $result_cond[] = "20～49名";
      } else if ($capa == "50") {
        $result_cond[] = "50～99名";
      } else if ($capa == "100") {
        $result_cond[] = "100～199名";
      } else if ($capa == "200") {
        $result_cond[] = "200名以上";
      }
  }
  if (!empty($post_tag)) {
		if(is_array($post_tag)) {
			foreach($post_tag as $val){
				$result_cond[] = get_term_by('slug',$val,"feature")->name." ";
		  }
    }
  }

  if(!empty($cat_hotel)) {
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
      }else if($val == "others"){
        $result_cond[] = "宿泊タイプその他";
      }
    }
  }

?>
<?php if ( !empty($result_cond) ): ?>
<title><?php echo implode("、", $result_cond); ?>でおすすめの研修施設一覧｜CO-MIT(コミット)研修施設検索サイト</title>
<?php else: ?>
<title>【企業研修/新入社員研修/宿泊研修】施設を探す｜CO-MIT(コミット)研修施設検索サイト</title>
<?php endif; ?>
<?php if(!empty($cat_hotel)) { ?>
  <meta name="description" content="<?php echo implode("、", $result_cond); ?>でおすすめの研修施設が見つかるかも？！研修・合宿施設検索サイト「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。">
<?php } else { ?>
  <meta name="description" content="お気に入りの研修施設が見つかるかも？！研修・合宿施設検索サイト「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。施設は随時更新中！">
<?php } ?>
<?php else: ?>
<title>【企業向け宿泊研修】施設を探す｜CO-MIT(コミット)研修施設検索サイト</title>
<meta name="description" content="お気に入りの研修施設が見つかるかも？！企業研修の施設検索サイト「CO-MIT（コミット）」では、企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。施設は随時更新中！">
<?php endif; ?>

<?php // ------------------------------ 施設を探す > エリア一覧 --------------------------------------- ?>
<?php elseif ( is_tax('area') ): ?>
<title><?php echo $term_name = single_term_title( '', false ); ?>でおすすめの研修施設一覧｜CO-MIT(コミット)研修施設検索サイト</title>
<meta name="description" content="<?php echo $term_name = single_term_title( '', false ); ?>で企業研修や新入社員研修、開発合宿、オフサイトミーティング、チームビルディングに最適な研修施設やホテルをご紹介。リゾートから都市型まで研修施設を探すならCO-MIT（コミット）で！">

<?php // ------------------------------ 施設を探す > 目的一覧 --------------------------------------- ?>
<?php elseif ( is_tax('purpose') ): ?>
<?php if ( $term == 'concent' ): ?>
<title>新入社員研修・内定者研修など集中できる環境におすすめな研修施設一覧｜CO-MIT(コミット)企業研修・宿泊研修施設</title>
<meta name="description" content="新入社員研修、内定者研修、リーダー研修など集中できる環境で効果的かつ効率的に学びたい方に最適な施設はこちら！研修・合宿施設検索サイト「CO-MIT（コミット）」では、企業研修やオフサイトミーティングなどに最適な研修施設やホテルをご紹介。">
<?php elseif ( $term == 'motivate' ): ?>
<title>役員研修・幹部研修などモチベーションが上がる環境におすすめな研修施設一覧｜CO-MIT(コミット)企業研修・宿泊研修施設</title>
<meta name="description" content="マネジメント研修、役員研修、幹部研修などモチベーションが上がる環境で能力開発や自己成長に繋げたい方に最適な施設はこちら！研修・合宿施設検索サイト「CO-MIT（コミット）」では、企業研修やオフサイトミーティングなどに最適な研修施設やホテルをご紹介。">
<?php elseif ( $term == 'environment' ): ?>
<title>ビジョンメイキング・開発合宿などいつもと違った環境におすすめな研修施設一覧｜CO-MIT(コミット)企業研修・宿泊研修施設</title>
<meta name="description" content="キックオフミーティング、開発合宿などいつもと違った環境でビジネスの成功に貢献したい方に最適な施設はこちら！研修・合宿施設検索サイト「CO-MIT（コミット）」では、企業研修やオフサイトミーティングなどに最適な研修施設やホテルをご紹介。">
<?php elseif ( $term == 'incentive' ): ?>
<title>オフサイトミーティングなど会社や組織で相互理解する環境におすすめな研修施設一覧｜CO-MIT(コミット)企業研修・宿泊研修施設</title>
<meta name="description" content="オフサイトミーティング、インセンティブ旅行（報奨旅行）など会社や組織、チームで相互理解する時間を作りたい方に最適な施設はこちら！研修・合宿施設検索サイト「CO-MIT（コミット）」では、企業研修やオフサイトミーティングなどに最適な研修施設やホテルをご紹介。">
<?php endif; ?>
<?php // ------------------------------ 施設を探す > 目的一覧 --------------------------------------- ?>
<?php elseif ( is_tax('hotel_type') ): ?>
  <title><?php echo $term_name = single_term_title( '', false ); ?>でおすすめの研修施設一覧｜CO-MIT(コミット)研修施設検索サイト</title>
<meta name="description" content="<?php echo $term_name = single_term_title( '', false ); ?>で新入社員研修やオフサイトミーティング・チームビルディングができる研修施設、ホテル、旅館、公共施設をご紹介。リゾートから都市型まで研修・合宿施設探すならCO-MIT（コミット）で！">

<?php // ------------------------------ 施設を探す > タグ一覧 --------------------------------------- ?>
<?php elseif ( is_tax('feature') ): ?>
<title><?php echo $term_name = single_term_title( '', false ); ?>でおすすめの研修施設一覧｜CO-MIT(コミット)研修施設検索サイト</title>
<meta name="description" content="<?php echo $term_name = single_term_title( '', false ); ?>で新入社員研修やオフサイトミーティング・チームビルディングができる研修施設、ホテル、旅館、公共施設をご紹介。リゾートから都市型まで研修・合宿施設探すならCO-MIT（コミット）で！">

<?php // ------------------------------ 施設詳細 --------------------------------------- ?>
<?php elseif (get_post_type() === 'facility' && is_single()): ?>
<title><?php if ( is_single() && $post->post_parent ) : ?>
<?php echo get_the_title(); ?>：<?php $parent_id = $post->post_parent; echo get_post($parent_id)->post_title;?> - <?php $parent_id = $post->post_parent; $terms = get_the_terms($parent_id, 'area'); foreach($terms as $term){ $term_name = $term->name; echo $term_name; break; }; ?>
<?php else : ?>
<?php echo get_the_title(); ?> - <?php $terms = get_the_terms($post->ID, 'area'); foreach($terms as $term){ $term_name = $term->name; echo $term_name; break; }; ?>
<?php endif; ?>｜CO-MIT(コミット)企業研修・宿泊研修施設 </title>
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

<?php // ------------------------------ 研修ノウハウ・タグ、カテゴリの記事一覧 --------------------------------------- ?>
<?php elseif ( is_tax('tag_column') ): ?>
<?php $term = get_queried_object(); ?>
<title><?php echo $term->name; ?>｜研修ノウハウ・コラム｜CO-MIT(コミット)</title>
<meta name="description" content="人事・総務・研修担当者必見！研修のプロが教える記事コンテンツの「<?php echo $term->name; ?>」タグ一覧。初心者向けの基礎知識から知っておきたい労務管理までご紹介します。">

<?php // ------------------------------ 研修ノウハウ・タグ、カテゴリの記事一覧 --------------------------------------- ?>
<?php elseif ( is_tax('category_column') ): ?>
<?php $term = get_queried_object(); ?>
<title><?php echo $term->name; ?>｜研修ノウハウ・コラム｜CO-MIT(コミット)</title>
<meta name="description" content="人事・総務・研修担当者必見！研修のプロが教える記事コンテンツの「<?php echo $term->name; ?>」カテゴリ一覧。初心者向けの基礎知識から知っておきたい労務管理までご紹介します。">

<?php // ------------------------------ 研修ノウハウ・コラム 一覧 --------------------------------------- ?>
<?php elseif ( is_post_type_archive('column') ): ?>
<title>研修ノウハウ・コラム - 「宿泊型研修」のプロが教える記事コンテンツ｜CO-MIT(コミット)</title>
<meta name="description" content="人事・総務・研修担当者必見の研修のプロが教える記事コンテンツ。初心者向けの基礎知識から知っておきたい労務管理までご紹介します。企業研修や新入社員研修、オフサイトミーティングに最適な研修施設やホテルを探すならCO-MIT（コミット）。">

<?php // ------------------------------ 研修ノウハウ・コラム 詳細 --------------------------------------- ?>
<?php elseif ( is_singular('column') ): ?>
<title><?php the_title(); ?>｜CO-MIT(コミット)</title>
<?php if( get_field('column_lead') ): ?>
<meta name="description" content="<?php echo get_field('column_lead') ?>">
<?php else: ?>
<meta name="description" content="ホテルや宿泊施設で開催されるビジネスイベントにフォーカスした”MIT”を行うためのノウハウをご紹介。｜CO-MIT(コミット) - 新入社員研修やオフサイトミーティング・チームビルディングに最適な研修施設、ホテル、旅館、公共施設を探すなら！">
<?php endif; ?>

<?php // ------------------------------ サーキュラーエコノミー --------------------------------------- ?>
<?php elseif ( get_post_type() === 'circulareconomy' ): ?>
  <?php $site_title = 'CO-MIT(コミット)企業研修・宿泊研修施設'; ?>
  <?php $post_name = $post->post_name; ?>

  <?php if( is_post_type_archive('circulareconomy') ) :?>
  <title>CO-MIT流サーキュラーエコノミーを知る｜<?php echo $site_title; ?></title>
  <meta name="description" content="サーキュラシティ事例から、環境保全活動としてだけではなくこれからの経営戦略・事業戦略としての位置づけを学びを得るためのコンテンツ「CO-MIT流サーキュラーエコノミーを知る」です。">

  <?php elseif ( $post_name === 'about' ) : ?>
  <title><?php the_title(); ?>｜<?php echo $site_title; ?></title>
  <meta name="description" content="サーキュラーエコノミーとは？背景からビジネスモデルまで基本を解説します。">

  <?php elseif ( $post_name === 'circularcity' ) : ?>
  <title><?php the_title(); ?>｜<?php echo $site_title; ?></title>
  <meta name="description" content="サーキュラーシティとは？〜サーキュラーエコノミーの概念をまちづくりに取り入れた新しいまちのカタチ〜を解説します。">

  <?php elseif( $post_name === 'examples' ): ?>
  <title>CO-MIT流サーキュラーエコノミーを知る 実例一覧｜<?php echo $site_title; ?></title>
  <meta name="description" content="サーキュラーエコノミーに取り組む先進的な地域をご紹介します。ご紹介の各地域は、視察や企業研修の場としての受け入れも行っています。">

  <?php elseif( $post_name === 'column' ): ?>
  <title>CO-MIT流サーキュラーエコノミーを知る コラム一覧｜<?php echo $site_title; ?></title>
  <meta name="description" content="サーキュラーエコノミーの最新の動向や、サーキュラーエコノミー実現に向けて企業にとってお役立ちいただける情報をお届していきます。">

  <?php elseif( $post->post_parent !== 0 ): ?>
  <?php
    $parent_id = $post->post_parent;
    $parent_slug = get_post($parent_id)->post_name;
    $page_title = get_the_title() .'｜';
    if( $parent_slug === 'examples' ):
      $page_title .= '実例｜';
    elseif( $parent_slug === 'column' ):
      $page_title .= 'コラム｜';
    endif;
  ?>
  <title><?php echo $page_title; ?>｜<?php echo $site_title; ?></title>


  <?php else: ?>
  <title>CO-MIT流サーキュラーエコノミーを知る｜<?php echo $site_title; ?></title>
  <meta name="description" content="サーキュラシティ事例から、環境保全活動としてだけではなくこれからの経営戦略・事業戦略としての位置づけを学びを得るためのコンテンツ「CO-MIT流サーキュラーエコノミーを知る」です。">
  <?php endif; ?>
<?php // ------------------------------ ギャラリーから探す --------------------------------------- ?>
<?php elseif ( is_page('gallery')): ?>
  <title>ギャラリーから探す｜CO-MIT(コミット)企業研修・宿泊研修施設</title>
  <meta name="description" content="企業研修や新入社員研修、開発合宿、オフサイトミーティングに最適な研修施設やホテルを探すならコミット。地域や人数、目的別に探せる便利な検索機能でご希望の条件に合わせた施設・研修会場が見つかります。">

<?php endif; ?>
