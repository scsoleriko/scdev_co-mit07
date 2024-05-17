<?php
include_once "var/custome-field.php";

add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );

/* ライトプランページの場合、対象外のページにアクセスしたらリダイレクト */
function light_plan_redirect() {
	global $post;
	if ( is_single() && $post->post_parent ){
		$comit_parent_id = $post->post_parent;
		$plan_type = get_field('plan',$comit_parent_id);
		if ($plan_type == 'light' && !(get_field('edit_type') === 'アクセス・周辺情報' )){
			wp_safe_redirect( home_url() );
			exit;
		}
	}
}
add_action('get_header', 'light_plan_redirect');

/* 固定ページにdiscriotion用概要絡む追加 */
add_post_type_support( 'page', 'excerpt' );

/* authorページは404リダイレクト */
add_filter( 'author_rewrite_rules', '__return_empty_array' );
function disable_author_archive() {
  $url = $_SERVER['REQUEST_URI'];
	if( isset($_GET['author']) ||
	preg_match("/^\/(author|add|event|notice|other|add\-column)\/(.*)/", $url)
  ) {
		wp_redirect( home_url( '/404.php' ) );
		exit;
	}
}
add_action('init', 'disable_author_archive');

/* 抜粋のhtmlタグ強制 */
remove_filter('the_excerpt', 'wpautop');

/**
 * 独自css
 */
function my_admin_style() {
  echo '<style>
#parent_id option.level-1 {display:none!important;}
#post-body-content input::placeholder,
#post-body-content textarea::placeholder {color: #00B2B0;}
#post-body-content .acf-field[data-name="plan"]{padding-bottom:0!important;}
#post-body-content .acf-field[data-name="plan2"]{border-top:none;}
#post-body-content .acf-field[data-name="plan2"] .acf-label label{display:none;}
  </style>'.PHP_EOL;
}
add_action('admin_print_styles', 'my_admin_style');



/**
 * カスタム投稿タイプ
 */
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'facility', [ // 投稿タイプ名の定義
		'labels' => [
			'name'          => '施設を探す', // 管理画面上で表示する投稿タイプ名
			'singular_name' => 'facility',    // カスタム投稿の識別名
		],
		'public'        => true,  // 投稿タイプをpublicにするか
	'hierarchical' => true,  // 親ページ
		'has_archive'   => true, // アーカイブ機能ON/OFF
		'menu_position' => 2,     // 管理画面上での配置場所
	'supports' => array('title', 'author', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes'),
		'show_in_rest'  => true,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
	/*'rewrite' => array(
		'slug' => '/'
	)*/
	]);
	register_post_type( 'column', [ // 投稿タイプ名の定義
		'labels' => [
			'name'          => 'プロ目線コンテンツ', // 管理画面上で表示する投稿タイプ名
			'singular_name' => 'column',    // カスタム投稿の識別名
		],
		'public'        => true,  // 投稿タイプをpublicにするか
		'has_archive'   => true, // アーカイブ機能ON/OFF
		'menu_position' => 2,     // 管理画面上での配置場所
	'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes'),
		'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
	/*'rewrite' => array(
		'slug' => '/'
	)*/
	]);
		register_post_type( 'top-slide', [ // 投稿タイプ名の定義
					'labels' => [
							'name'          => 'トップスライド', // 管理画面上で表示する投稿タイプ名
							'singular_name' => 'top-slide',    // カスタム投稿の識別名
					],
					'public'        => true,  // 投稿タイプをpublicにするか
					'hierarchical' => false,  // 親ページ
					'has_archive'   => false, // アーカイブ機能ON/OFF
					'menu_position' => 2,     // 管理画面上での配置場所
					'supports' => array('title', 'custom-fields'),
					'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
		/*'rewrite' => array(
			'slug' => '/'
		)*/
	]);
		register_post_type( 'top-banner', [ // 投稿タイプ名の定義
					'labels' => [
							'name'          => 'トップバナー', // 管理画面上で表示する投稿タイプ名
							'singular_name' => 'top-banner',    // カスタム投稿の識別名
					],
					'public'        => true,  // 投稿タイプをpublicにするか
					'hierarchical' => false,  // 親ページ
					'has_archive'   => false, // アーカイブ機能ON/OFF
					'menu_position' => 2,     // 管理画面上での配置場所
					'supports' => array('title', 'custom-fields'),
					'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
		/*'rewrite' => array(
			'slug' => '/'
		)*/
	]);
	register_post_type( 'column-banner-top', [ // 投稿タイプ名の定義
					'labels' => [
							'name'          => 'ノウハウ・コラムバナー（上部）', // 管理画面上で表示する投稿タイプ名
							'singular_name' => 'column-banner-top',    // カスタム投稿の識別名
					],
					'public'        => true,  // 投稿タイプをpublicにするか
					'hierarchical' => false,  // 親ページ
					'has_archive'   => false, // アーカイブ機能ON/OFF
					'menu_position' => 2,     // 管理画面上での配置場所
					'supports' => array('title', 'custom-fields'),
					'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
		/*'rewrite' => array(
			'slug' => '/'
		)*/
	]);
	register_post_type( 'column-banner-bottom', [ // 投稿タイプ名の定義
					'labels' => [
							'name'          => 'ノウハウ・コラムバナー（下部）', // 管理画面上で表示する投稿タイプ名
							'singular_name' => 'column-banner-bottom',    // カスタム投稿の識別名
					],
					'public'        => true,  // 投稿タイプをpublicにするか
					'hierarchical' => false,  // 親ページ
					'has_archive'   => false, // アーカイブ機能ON/OFF
					'menu_position' => 2,     // 管理画面上での配置場所
					'supports' => array('title', 'custom-fields'),
					'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
		/*'rewrite' => array(
			'slug' => '/'
		)*/
	]);
	register_post_type( 'faq', [ // 投稿タイプ名の定義
		'labels' => [
			'name'          => 'Q＆A', // 管理画面上で表示する投稿タイプ名
			'singular_name' => 'faq',    // カスタム投稿の識別名
		],
		'public'        => true,  // 投稿タイプをpublicにするか
		'has_archive'   => false, // アーカイブ機能ON/OFF
		'menu_position' => 2,     // 管理画面上での配置場所
	'supports' => array('title'),
		'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
	/*'rewrite' => array(
		'slug' => '/'
	)*/
	]);
		register_post_type( 'top-special-banner', [ // 投稿タイプ名の定義
					'labels' => [
							'name'          => 'トップ特集バナー', // 管理画面上で表示する投稿タイプ名
							'singular_name' => 'top-special-banner',    // カスタム投稿の識別名
					],
					'public'        => true,  // 投稿タイプをpublicにするか
					'hierarchical' => false,  // 親ページ
					'has_archive'   => false, // アーカイブ機能ON/OFF
					'menu_position' => 2,     // 管理画面上での配置場所
					'supports' => array('title', 'custom-fields'),
					'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
	]);

	register_post_type( 'circulareconomy', [ // 投稿タイプ名の定義
		'labels' => [
			'name'          => 'サーキュラーエコノミー', // 管理画面上で表示する投稿タイプ名
			'singular_name' => 'circulareconomy',    // カスタム投稿の識別名
		],
		'hierarchical' => true,  // 親子あり
		'public'        => true,  // 投稿タイプをpublicにするか
		'has_archive'   => true, // アーカイブ機能ON/OFF
		'menu_position' => 2,     // 管理画面上での配置場所
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes'),
		'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
	]);
	register_post_type( 'seminar', [ // 投稿タイプ名の定義
		'labels' => [
			'name'          => 'サーキュラーエコノミー＞セミナー', // 管理画面上で表示する投稿タイプ名
			'singular_name' => 'seminar',    // カスタム投稿の識別名
		],
		'hierarchical' => false,  // 親子あり
		'public'        => true,  // 投稿タイプをpublicにするか
		'has_archive'   => false, // アーカイブ機能ON/OFF
		'menu_position' => 2,     // 管理画面上での配置場所
		'supports' => array('title', 'author', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes'),
		'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
	]);
  
	flush_rewrite_rules( false );
}

//セミナー詳細なし
add_filter( 'seminar_rewrite_rules', '__return_empty_array' );

/* バナーURLの無効 */
function banner_redirect() {
		if ( is_singular('top-banner') || is_singular('column-banner-top') || is_singular('column-banner-bottom') ) {
			wp_safe_redirect( home_url() );
			exit;
		}
}
add_action( 'template_redirect', 'banner_redirect', 1);

/* カテゴリーの設定 */
register_taxonomy(
	'area', //カテゴリーの名前
	'facility', //使うカスタム投稿タイプ名
	array(
		'hierarchical' => true, //trueで親子関係使用
		'update_count_callback' => '_update_post_term_count',
		'label' => '掲載エリア管理',
		'singular_label' => '掲載エリア管理',
		'public' => true,
		'show_ui' => true
	)
);
/* タグの設定 */
register_taxonomy(
	'feature', //タグ名（任意）
	'facility', //カスタム投稿名
	array(
		'hierarchical' => false, //タグタイプの指定（階層をもたない）
		'update_count_callback' => '_update_post_term_count',
		//ダッシュボードに表示させる名前
		'label' => 'タグ管理',
		'singular_label' => 'タグ管理',
		'public' => true,
		'show_ui' => true
	)
);

/* タグの設定 */
register_taxonomy(
	'purpose', //タグ名（任意）
	'facility', //カスタム投稿名
	array(
		'hierarchical' => true, //タグタイプの指定（階層をもたない）
		'update_count_callback' => '_update_post_term_count',
		//ダッシュボードに表示させる名前
		'label' => '目的の管理',
		'singular_label' => '目的の管理',
		'public' => true,
		'show_ui' => true
	)
);
/* タグの設定 */
register_taxonomy(
	'hotel_type', //タグ名（任意）
	'facility', //カスタム投稿名
	array(
		'hierarchical' => true, //タグタイプの指定（階層をもたない）
		'update_count_callback' => '_update_post_term_count',
		//ダッシュボードに表示させる名前
		'label' => '宿タイプ管理',
		'singular_label' => '宿タイプ管理',
		'public' => true,
		'show_ui' => true
	)
);

register_taxonomy(
	'category_column', //カテゴリーの名前
	'column', //使うカスタム投稿タイプ名
	array(
		'hierarchical' => true, //trueで親子関係使用
		'update_count_callback' => '_update_post_term_count',
		'label' => 'カテゴリー',
		'singular_label' => 'カテゴリー',
		'public' => true,
		'show_ui' => true
	)
);

register_taxonomy(
	'tag_column', //カテゴリーの名前
	'column', //使うカスタム投稿タイプ名
	array(
		'hierarchical' => false, //trueで親子関係使用
		'update_count_callback' => '_update_post_term_count',
		'label' => 'タグ',
		'singular_label' => 'タグ',
		'public' => true,
		'show_ui' => true
	)
);
/* カテゴリーの設定 */
register_taxonomy(
	'faq_category', //カテゴリーの名前
	'faq', //使うカスタム投稿タイプ名
	array(
		'hierarchical' => true, //trueで親子関係使用
		'update_count_callback' => '_update_post_term_count',
		'label' => '質問カテゴリ',
		'singular_label' => '質問カテゴリ',
		'public' => true,
		'show_ui' => true
	)
);

/* サーキュラーエコノミー関連 */
register_taxonomy(
	'circular_article_type', //カテゴリーの名前
	'circulareconomy', //使うカスタム投稿タイプ名
	array(
		'hierarchical' => true, //trueで親子関係使用
		'update_count_callback' => '_update_post_term_count',
		'label' => '記事タイプ',
		'singular_label' => '記事タイプ',
		'public' => true,
		'show_ui' => true
	)
);
register_taxonomy(
	'circular_examples_area', //カテゴリーの名前
	'circulareconomy', //使うカスタム投稿タイプ名
	array(
		'hierarchical' => true, //trueで親子関係使用
		'update_count_callback' => '_update_post_term_count',
		'label' => 'エリア名',
		'singular_label' => 'エリア名',
		'public' => true,
		'show_ui' => true
	)
);
register_taxonomy(
	'circular_examples_icon', //カテゴリーの名前
	'circulareconomy', //使うカスタム投稿タイプ名
	array(
		'hierarchical' => true, //trueで親子関係使用
		'update_count_callback' => '_update_post_term_count',
		'label' => 'アイコン',
		'singular_label' => 'アイコン',
		'public' => true,
		'show_ui' => true
	)
);


/* wordpressの「抜粋」に<br>を入れる */
function get_the_excerpt_with_br($post) {
	global $post;
	$excerpt_with_br = get_the_excerpt($post->ID);
return nl2br($excerpt_with_br);
}



/* 旧パンくず */
if ( ! function_exists( 'custom_breadcrumb_old' ) ) {
	function custom_breadcrumb_old( $wp_obj = null ) {

		// トップページでは何も出力しない
		if ( is_home() || is_front_page() ) return false;

		//そのページのWPオブジェクトを取得
		$wp_obj = $wp_obj ?: get_queried_object();

		echo '<nav class="topic-path">'.  //id名などは任意で
				'<ul class="inner">'.
					'<li>'.
						'<a href="'. home_url() .'"><span>トップ</span></a>'.
					'</li>';

		if ( is_attachment() ) {

			/**
			 * 添付ファイルページ ( $wp_obj : WP_Post )
			 * ※ 添付ファイルページでは is_single() も true になるので先に分岐
			 */
			echo '<li><span>'. $wp_obj->post_title .'</span></li>';

		} elseif ( is_single() ) {

			/**
			 * 投稿ページ ( $wp_obj : WP_Post )
			 */
			$post_id    = $wp_obj->ID;
			$post_type  = $wp_obj->post_type;
			$post_title = $wp_obj->post_title;

			// カスタム投稿タイプかどうか
			if ( $post_type !== 'post' ) {

				$the_tax = "";  //そのサイトに合わせ、投稿タイプごとに分岐させて明示的に指定してもよい

				// 投稿タイプに紐づいたタクソノミーを取得 (投稿フォーマットは除く)
				$tax_array = get_object_taxonomies( $post_type, 'names');
				foreach ($tax_array as $tax_name) {
					if ( $tax_name !== 'post_format' ) {
						$the_tax = $tax_name;
						break;
					}
				}

				//カスタム投稿タイプ名の表示
				/*echo '<li>'.
						'<a href="'. get_post_type_archive_link( $post_type ) .'">'.
							'<span>'. get_post_type_object( $post_type )->label .'</span>'.
						'</a>'.
					 '</li>';*/
				echo '<li><a href="/facility/">施設を探す</a></li>';

			} else {
				$the_tax = 'category';  //通常の投稿の場合、カテゴリーを表示
			}

			// タクソノミーが紐づいていれば表示
			if ( $the_tax !== "" ) {

				$child_terms = array();   // 子を持たないタームだけを集める配列
				$parents_list = array();  // 子を持つタームだけを集める配列

				// 投稿に紐づくタームを全て取得
				$terms = get_the_terms( $post_id, $the_tax );

				if ( !empty( $terms ) ) {

					//全タームの親IDを取得
					foreach ( $terms as $term ) {
						if ( $term->parent !== 0 ) $parents_list[] = $term->parent;
					}

					//親リストに含まれないタームのみ取得
					foreach ( $terms as $term ) {
						if ( ! in_array( $term->term_id, $parents_list ) ) $child_terms[] = $term;
					}

					// 最下層のターム配列から一つだけ取得
					$term = $child_terms[0];

					if ( $term->parent !== 0 ) {

						// 親タームのIDリストを取得
						$parent_array = array_reverse( get_ancestors( $term->term_id, $the_tax ) );

						foreach ( $parent_array as $parent_id ) {
							$parent_term = get_term( $parent_id, $the_tax );
							echo '<li>'.
									'<a href="'. str_replace('/facility', '', get_term_link( $parent_id, $the_tax )) .'">'.
									  '<span>'. $parent_term->name .'</span>'.
									'</a>'.
								 '</li>';
						}
					}

					// 最下層のタームを表示
					echo '<li>'.
							'<a href="'. str_replace('/facility', '', get_term_link( $term->term_id, $the_tax )). '">'.
							  '<span>'. $term->name .'</span>'.
							'</a>'.
						 '</li>';
				}
			}

			// 親ページがあれば順番に表示
			if ( $wp_obj->post_parent !== 0 ) {
				$parent_array = array_reverse( get_post_ancestors( $post_id ) );
				foreach( $parent_array as $parent_id ) {
					echo '<li>'.
							'<a href="'. get_permalink( $parent_id ).'">'.
								'<span>'.get_the_title( $parent_id ).'</span>'.
							'</a>'.
						 '</li>';
				}
			}


			// 投稿自身の表示
			echo '<li><span>'. $post_title .'</span></li>';

		} elseif ( is_page() ) {

			/**
			 * 固定ページ ( $wp_obj : WP_Post )
			 */
			$page_id    = $wp_obj->ID;
			$page_title = $wp_obj->post_title;

			// 親ページがあれば順番に表示
			if ( $wp_obj->post_parent !== 0 ) {
				$parent_array = array_reverse( get_post_ancestors( $page_id ) );
				foreach( $parent_array as $parent_id ) {
					echo '<li>'.
							'<a href="'. get_permalink( $parent_id ).'">'.
								'<span>'.get_the_title( $parent_id ).'</span>'.
							'</a>'.
						 '</li>';
				}
			}
			// 投稿自身の表示
			echo '<li><span>'. $page_title .'</span></li>';

		} elseif ( is_post_type_archive() ) {

			/**
			 * 投稿タイプアーカイブページ ( $wp_obj : WP_Post_Type )
			 */
		if ( is_search() ){
		echo '<li><span>検索結果</span></li>';
		} else {
		echo '<li><span>'. $wp_obj->label .'</span></li>';
		}
		} elseif ( is_date() ) {

			/**
			 * 日付アーカイブ ( $wp_obj : null )
			 */
			$year  = get_query_var('year');
			$month = get_query_var('monthnum');
			$day   = get_query_var('day');

			if ( $day !== 0 ) {
				//日別アーカイブ
				echo '<li><a href="'. get_year_link( $year ).'"><span>'. $year .'年</span></a></li>'.
					 '<li><a href="'. get_month_link( $year, $month ). '"><span>'. $month .'月</span></a></li>'.
					 '<li><span>'. $day .'日</span></li>';

			} elseif ( $month !== 0 ) {
				//月別アーカイブ
				echo '<li><a href="'. get_year_link( $year ).'"><span>'.$year.'年</span></a></li>'.
					 '<li><span>'.$month . '月</span></li>';

			} else {
				//年別アーカイブ
				echo '<li><span>'.$year.'年</span></li>';

			}

		} elseif ( is_author() ) {

			/**
			 * 投稿者アーカイブ ( $wp_obj : WP_User )
			 */
			echo '<li><span>'. $wp_obj->display_name .' の執筆記事</span></li>';

		} elseif ( is_archive() ) {

			/**
			 * タームアーカイブ ( $wp_obj : WP_Term )
			 */
			$term_id   = $wp_obj->term_id;
			$term_name = $wp_obj->name;
			$tax_name  = $wp_obj->taxonomy;

			/* ここでタクソノミーに紐づくカスタム投稿タイプを出力しても良いでしょう。 */

			echo '<li><a href="/facility/">施設を探す</a></li>';

			// 親ページがあれば順番に表示
			if ( $wp_obj->parent !== 0 ) {

				$parent_array = array_reverse( get_ancestors( $term_id, $tax_name ) );
				foreach( $parent_array as $parent_id ) {
					$parent_term = get_term( $parent_id, $tax_name );
					echo '<li>'.
							'<a href="'. str_replace('/facility', '', get_term_link( $parent_id, $tax_name )) .'">'.
								'<span>'. $parent_term->name .'</span>'.
							'</a>'.
						 '</li>';
				}
			}

			// ターム自身の表示
			echo '<li>'.
					'<span>'. $term_name .'</span>'.
				'</li>';


		} elseif ( is_search() ) {

			/**
			 * 検索結果ページ
			 */
			echo '<li><span>「'. get_search_query() .'」で検索した結果</span></li>';


		} elseif ( is_404() ) {

			/**
			 * 404ページ
			 */
			echo '<li><span>お探しのページは見つかりませんでした。</span></li>';

		} else {

			/**
			 * その他のページ（無いと思うが一応）
			 */
			echo '<li><span>'. get_the_title() .'</span></li>';
		}

		echo '</ul></nav>';  // 冒頭に合わせて閉じタグ

	}
}




/* パンくず */
if ( ! function_exists( 'custom_breadcrumb' ) ) {
	function custom_breadcrumb( $wp_obj = null ) {

		// トップページでは何も出力しない
		if ( is_home() || is_front_page() ) return false;

		//そのページのWPオブジェクトを取得
		$wp_obj = $wp_obj ?: get_queried_object();

		echo '<div class="breadcrumb">'.  //id名などは任意で
				'<ol class="l-wrapper breadcrumb__wraper">'.
					'<li class="breadcrumb__item">'.
						'<a href="'. home_url() .'"><span>トップ</span></a>'.
					'</li>';

		if ( is_attachment() ) {

			/**
			 * 添付ファイルページ ( $wp_obj : WP_Post )
			 * ※ 添付ファイルページでは is_single() も true になるので先に分岐
			 */
			echo '<li class="breadcrumb__item"><span>'. $wp_obj->post_title .'</span></li>';

		} elseif ( is_single() ) {

			/**
			 * 投稿ページ ( $wp_obj : WP_Post )
			 */
			$post_id    = $wp_obj->ID;
			$post_type  = $wp_obj->post_type;
			$post_title = $wp_obj->post_title;

			// カスタム投稿タイプかどうか
			if ( $post_type !== 'post' ) {

				$the_tax = "";  //そのサイトに合わせ、投稿タイプごとに分岐させて明示的に指定してもよい

				// 投稿タイプに紐づいたタクソノミーを取得 (投稿フォーマットは除く)
				$tax_array = get_object_taxonomies( $post_type, 'names');
				foreach ($tax_array as $tax_name) {
					if ( $tax_name !== 'post_format' ) {
						$the_tax = $tax_name;
						break;
					}
				}

				//カスタム投稿タイプ名の表示
				/*echo '<li>'.
						'<a href="'. get_post_type_archive_link( $post_type ) .'">'.
							'<span>'. get_post_type_object( $post_type )->label .'</span>'.
						'</a>'.
					 '</li>';*/
				echo '<li class="breadcrumb__item"><a href="/facility/">施設を探す</a></li>';

			} else {
				$the_tax = 'category';  //通常の投稿の場合、カテゴリーを表示
			}

			// タクソノミーが紐づいていれば表示
			if ( $the_tax !== "" ) {

				$child_terms = array();   // 子を持たないタームだけを集める配列
				$parents_list = array();  // 子を持つタームだけを集める配列

				// 投稿に紐づくタームを全て取得
				$terms = get_the_terms( $post_id, $the_tax );

				if ( !empty( $terms ) ) {

					//全タームの親IDを取得
					foreach ( $terms as $term ) {
						if ( $term->parent !== 0 ) $parents_list[] = $term->parent;
					}

					//親リストに含まれないタームのみ取得
					foreach ( $terms as $term ) {
						if ( ! in_array( $term->term_id, $parents_list ) ) $child_terms[] = $term;
					}

					// 最下層のターム配列から一つだけ取得
					$term = $child_terms[0];

					if ( $term->parent !== 0 ) {

						// 親タームのIDリストを取得
						$parent_array = array_reverse( get_ancestors( $term->term_id, $the_tax ) );

						foreach ( $parent_array as $parent_id ) {
							$parent_term = get_term( $parent_id, $the_tax );
							echo '<li class="breadcrumb__item">'.
									'<a href="'. str_replace('/facility', '', get_term_link( $parent_id, $the_tax )) .'">'.
									  '<span>'. $parent_term->name .'</span>'.
									'</a>'.
								 '</li>';
						}
					}

					// 最下層のタームを表示
					echo '<li class="breadcrumb__item">'.
							'<a href="'. str_replace('/facility', '', get_term_link( $term->term_id, $the_tax )). '">'.
							  '<span>'. $term->name .'</span>'.
							'</a>'.
						 '</li>';
				}
			}

			// 親ページがあれば順番に表示
			if ( $wp_obj->post_parent !== 0 ) {
				$parent_array = array_reverse( get_post_ancestors( $post_id ) );
				foreach( $parent_array as $parent_id ) {
					echo '<li class="breadcrumb__item">'.
							'<a href="'. get_permalink( $parent_id ).'">'.
								'<span>'.get_the_title( $parent_id ).'</span>'.
							'</a>'.
						 '</li>';
				}
			}


			// 投稿自身の表示
			echo '<li class="breadcrumb__item"><span>'. $post_title .'</span></li>';

		} elseif ( is_page() ) {

			/**
			 * 固定ページ ( $wp_obj : WP_Post )
			 */
			$page_id    = $wp_obj->ID;
			$page_title = $wp_obj->post_title;

			// 親ページがあれば順番に表示
			if ( $wp_obj->post_parent !== 0 ) {
				$parent_array = array_reverse( get_post_ancestors( $page_id ) );
				foreach( $parent_array as $parent_id ) {
					echo '<li class="breadcrumb__item">'.
							'<a href="'. get_permalink( $parent_id ).'">'.
								'<span>'.get_the_title( $parent_id ).'</span>'.
							'</a>'.
						 '</li>';
				}
			}
			// 投稿自身の表示
			echo '<li class="breadcrumb__item"><span>'. $page_title .'</span></li>';

		} elseif ( is_post_type_archive() ) {

			/**
			 * 投稿タイプアーカイブページ ( $wp_obj : WP_Post_Type )
			 */
		if ( is_search() ){
		echo '<li class="breadcrumb__item"><span>検索結果</span></li>';
		} else {
		echo '<li class="breadcrumb__item"><span>'. $wp_obj->label .'</span></li>';
		}
		} elseif ( is_date() ) {

			/**
			 * 日付アーカイブ ( $wp_obj : null )
			 */
			$year  = get_query_var('year');
			$month = get_query_var('monthnum');
			$day   = get_query_var('day');

			if ( $day !== 0 ) {
				//日別アーカイブ
				echo '<li class="breadcrumb__item"><a href="'. get_year_link( $year ).'"><span>'. $year .'年</span></a></li>'.
					 '<li class="breadcrumb__item"><a href="'. get_month_link( $year, $month ). '"><span>'. $month .'月</span></a></li>'.
					 '<li class="breadcrumb__item"><span>'. $day .'日</span></li>';

			} elseif ( $month !== 0 ) {
				//月別アーカイブ
				echo '<li class="breadcrumb__item"><a href="'. get_year_link( $year ).'"><span>'.$year.'年</span></a></li>'.
					 '<li class="breadcrumb__item"><span>'.$month . '月</span></li>';

			} else {
				//年別アーカイブ
				echo '<li class="breadcrumb__item"><span>'.$year.'年</span></li>';

			}

		} elseif ( is_author() ) {

			/**
			 * 投稿者アーカイブ ( $wp_obj : WP_User )
			 */
			echo '<li class="breadcrumb__item"><span>'. $wp_obj->display_name .' の執筆記事</span></li>';

		} elseif ( is_archive() ) {

			/**
			 * タームアーカイブ ( $wp_obj : WP_Term )
			 */
			$term_id   = $wp_obj->term_id;
			$term_name = $wp_obj->name;
			$tax_name  = $wp_obj->taxonomy;

			/* ここでタクソノミーに紐づくカスタム投稿タイプを出力しても良いでしょう。 */

			echo '<li class="breadcrumb__item"><a href="/facility/">施設を探す</a></li>';

			// 親ページがあれば順番に表示
			if ( $wp_obj->parent !== 0 ) {

				$parent_array = array_reverse( get_ancestors( $term_id, $tax_name ) );
				foreach( $parent_array as $parent_id ) {
					$parent_term = get_term( $parent_id, $tax_name );
					if ( $parent_term->name == '目的') { continue; }
					echo '<li class="breadcrumb__item">'.
							'<a href="'. str_replace('/facility', '', get_term_link( $parent_id, $tax_name )) .'">'.
								'<span>'. $parent_term->name .'</span>'.
							'</a>'.
						 '</li>';
				}
			}

			// ターム自身の表示
			echo '<li class="breadcrumb__item">'.
					'<span>'. $term_name .'</span>'.
				'</li>';


		} elseif ( is_search() ) {

			/**
			 * 検索結果ページ
			 */
			echo '<li class="breadcrumb__item"><span>「'. get_search_query() .'」で検索した結果</span></li>';


		} elseif ( is_404() ) {

			/**
			 * 404ページ
			 */
			echo '<li class="breadcrumb__item"><span>お探しのページは見つかりませんでした。</span></li>';

		} else {

			/**
			 * その他のページ（無いと思うが一応）
			 */
			echo '<li class="breadcrumb__item"><span>'. get_the_title() .'</span></li>';
		}

		echo '</ol></div>';  // 冒頭に合わせて閉じタグ

	}
}



/* 404表示されない対処
https://ja.wordpress.org/support/topic/%E3%83%9A%E3%83%BC%E3%82%B8%E3%83%B3%E3%82%B0%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6%EF%BC%9A%E8%A8%98%E4%BA%8B%E3%81%8C%E3%81%AA%E3%81%84%E3%83%9A%E3%83%BC%E3%82%B8%E7%9B%AE%E3%81%A7%E3%82%82%E7%A9%BA/
function my_pre_get_posts( $query ) {
	if ( !is_admin() && $query->is_main_query() ) {
		if ( $query->is_category() ) {
			$query->set( 'posts_per_page', 2 );
	//	} else if ( $query->is_archive() ) {
	//		$query->set( 'posts_per_page', 5 );
		}
	}
}
add_action( 'pre_get_posts', 'my_pre_get_posts' );*/






/**
* ページネーション出力関数
* $paged : 現在のページ
* $pages : 全ページ数
* $range : 左右に何ページ表示するか
* $show_only : 1ページしかない時に表示するかどうか
*/
function pagination( $pages, $paged, $range = 2, $show_only = true ) {

	$pages = ( int ) $pages;    //float型で渡ってくるので明示的に int型 へ
	$paged = $paged ?: 1;       //get_query_var('paged')をそのまま投げても大丈夫なように

	//表示テキスト
	$text_first   = "« 最初へ";
	$text_before  = "‹ 前へ";
	$text_next    = "次へ ›";
	$text_last    = "最後へ »";

	if ( $show_only && $pages === 1 ) {
		// １ページのみで表示設定が true の時
		echo '<nav class="pager"><ul class="pager-number"><li class="is_current">1</li></ul></nav>';
		return;
	}

	if ( $pages === 1 ) return;    // １ページのみで表示設定もない場合

	if ( 1 !== $pages ) {
		//２ページ以上の時
		echo '<nav class="pager">';
		if ( $paged > 1 ) {
			// 「前へ」 の表示
			echo '<p class="pager-prev"><a href="'. get_pagenum_link( $paged - 1 ) .'"><i class="icon-prev"></i></a></p>';
		}
		echo '<ul class="pager-number">';
		for ( $i = 1; $i <= $pages; $i++ ) {

			if ( $i <= $paged + $range && $i >= $paged - $range ) {
				// $paged +- $range 以内であればページ番号を出力
				if ( $paged === $i ) {
					echo '<li class="is_current">'. $i .'</li>';
				} else {
					echo '<li><a href="'. get_pagenum_link( $i ) .'">'. $i .'</a></li>';
				}
			}

		}
		echo '</ul>';
		if ( $paged < $pages ) {
			// 「次へ」 の表示
			echo '<p class="pager-next"><a href="'. get_pagenum_link( $paged + 1 ) .'"><i class="icon-next"></i></a></p>';
		}
		echo '</nav>';
	}
}



/* 全◯件中◯件〜◯件目を表示 */
function my_result_count() {
  global $wp_query;

  $paged = get_query_var( 'paged' ) - 1;
  $ppp   = get_query_var( 'posts_per_page' );
  $count = $total = $wp_query->post_count;
  $from  = 0;
  if ( 0 < $ppp ) {
	$total = $wp_query->found_posts;
	if ( 0 < $paged )
	  $from  = $paged * $ppp;
  }
  printf(
	'<h2 class="facility-search-result" style="display:none;"><span id="facility-search-result-count" class="facility-search-result-count">%1$s</span>件（%2$s%3$s件表示）</h2>',
	$total,
	( 1 < $count ? ($from + 1 . '〜') : '' ),
	($from + $count )
  );
}



/* 非公開の親ページを選択できるようにする */
add_filter('page_attributes_dropdown_pages_args', 'add_private_draft');
function add_private_draft($args) {
	$args['post_status'] = 'publish,private,draft';
	return $args;
}


/* セッションIDをシードに */
/*session_name("pgsession");
session_start();
//add_filter('posts_orderby', 'my_orderby_request', 10, 1);
function my_orderby_request($orderby){
//var_dump(session_id());
	$seed = $_SESSION['pgsession'];
	if (empty($seed)) {
		$seed = rand();
		$_SESSION['pgsession'] = $seed;
	}
	$orderby = 'RAND(' . $seed . ')';
//var_dump($orderby);
	return $orderby;
}*/

remove_action( 'wp_head', '_wp_render_title_tag', 1);
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_print_styles', 8 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3);
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// カスタムフィールドの追加
add_action( 'admin_menu', 'add_custom_field' );
function add_custom_field() {
	add_meta_box( 'custom-footer_consult', '表示設定', 'create_footer_consult', 'facility', 'side' );
}

function create_footer_consult() {
	$keyname = 'footer_consult';
	global $post;
	$get_vals = get_post_meta( $post->ID, $keyname, true );
	$get_value = $get_vals ? $get_vals : array();
	$data = ['「専門家に相談する」を表示する'];
	wp_nonce_field( 'action-' . $keyname, 'nonce-' . $keyname );
	foreach( $data as $d ) {
		$checked = '';
		if($post->post_title == ''){
		  $checked = ' checked';
		}else{
		  if( in_array( $d, $get_value ) ) $checked = ' checked';
		}
		echo '<label><input type="checkbox" name="' . $keyname . '[]" value="' . $d . '"' . $checked . '>' . $d . '</label>';
	}
}

add_action( 'save_post', 'save_custom_field' );
function save_custom_field( $post_id ) {
	$custom_fields = ['footer_consult'];
	foreach( $custom_fields as $d ) {
		if ( isset( $_POST['nonce-' . $d] ) && $_POST['nonce-' . $d] ) {
			if( check_admin_referer( 'action-' . $d, 'nonce-' . $d ) ) {
				if( isset( $_POST[$d] ) && $_POST[$d] ) {
					update_post_meta( $post_id, $d, $_POST[$d] );
				} else {
					delete_post_meta( $post_id, $d, get_post_meta( $post_id, $d, true ) );
				}
			}
		}
	}
}

// Ajax
function add_my_ajaxurl() {
?>
	<script>
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
	</script>
<?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );


// 検討リストの即時更新
function favoriteListUpdate(){

$postID = $_POST['postID'];

?>

<?php
$favoriteList = $_COOKIE["co-mitFavoriteList"];
$favoriteList = ltrim($favoriteList, '[\"');
$favoriteList = rtrim($favoriteList, '\"]');
$favoriteList = str_replace('\"', '', $favoriteList);
$favoriteList = explode(',', $favoriteList);
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
<?php
die();

}
add_action( 'wp_ajax_favoriteListUpdate', 'favoriteListUpdate' );
add_action( 'wp_ajax_nopriv_favoriteListUpdate', 'favoriteListUpdate' );


// 無駄な画像生成を防止する
function get_thumb_img($size = 'full', $p_id = null) {
  $p_id = ($p_id) ? $p_id : get_the_ID();    //追記部分
  $thumb_id = get_post_thumbnail_id($p_id);
  $thumb_img = wp_get_attachment_image_src($thumb_id, $size);
  $thumb_src = $thumb_img[0];
  $alt = get_the_title($p_id);
  return '<img src="'.$thumb_src.'" alt="'.$alt.'">';
}

// ランキングHTMLの設定
function my_popular_posts( $mostpopular, $instance ){
	foreach( $mostpopular as $popular ) {
	$ID = $popular->id;
?>
<li class="post-list-2__item">
	<a href="<?php echo get_permalink($ID); ?>">
		<div class="post-list-2__image">
				<?php if(has_post_thumbnail($ID)): ?>
					<?php echo get_thumb_img('medium', $ID); ?>
				<?php endif; ?>
		</div>
		<div class="post-list-2__detail">
			<span class="post-list-2__main"><?php echo ( $popular->title ) ?></span>
			<p class="date"><span class="icon-clock"></span><?php echo get_the_time('Y.n.j', $ID); ?></p>
		</div>
	</a>
</li>
<?php
	}
}
add_filter( 'wpp_custom_html', 'my_popular_posts', 10, 2 );

//ページネーション作成
function columnPagination($pages = '', $range = 4){
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	//ページ情報の取得
	if($pages == '') {
	  global $wp_query;
	  $pages = $wp_query->max_num_pages;
	  if(!$pages){
		$pages = 1;
	  }
	}
	if(1 != $pages) {
	  echo '<ul class="column-pager">'.PHP_EOL;
	  for ($i=1; $i <= $pages; $i++) {
		if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
		  echo ($paged == $i) ? '<li class="column-pager__item is-active"><span>' . $i . '</span></li>'.PHP_EOL : '<li class="column-pager__item"><a href="'.get_pagenum_link($i).'" >' . $i . '</a></li>'.PHP_EOL;
		}
	  }
	  echo '</ul>'.PHP_EOL;
	}
  }


add_action( 'rest_api_init', 'add_custom_fields_to_rest' );
function add_custom_fields_to_rest() {
  register_rest_field(
	'post',
	'custom_fields',
	[
	  'get_callback'    => 'get_custom_fields_value', // カスタム関数名指定
	  'update_callback' => null,
	  'schema'          => null,
	]
  );
}

function get_custom_fields_value() {
  return get_post_custom();
}


/**
 * Make the list of enqueued resources
 **/
function my_get_dependency( $dependency ) {
	$dep = "";
	if ( is_a( $dependency, "_WP_Dependency" ) ) {
		$dep .= "$dependency->handle";
		$dep .= " [" . implode( " ", $dependency->deps ) . "]";
		$dep .= " '$dependency->src'";
		$dep .= " '$dependency->ver'";
		$dep .= " '$dependency->args'";
		$dep .= " (" . implode( " ", $dependency->extra ) . ")";
	}
	return "$dep\n";
}

function my_style_queues() {
	global $wp_styles;
	if (!is_user_logged_in()) return;
	echo "<!-- WP_Dependencies for styles\n";
	foreach ( $wp_styles->queue as $val ) {
		echo my_get_dependency( $wp_styles->registered[ $val ] );
	}
	echo "-->\n";
}
add_action( 'wp_print_styles', 'my_style_queues', 9999 );

function my_script_queues() {
	global $wp_scripts;
	if (!is_user_logged_in()) return;
	echo "<!-- WP_Dependencies for scripts\n";
	foreach ( $wp_scripts->queue as $val ) {
		echo my_get_dependency( $wp_scripts->registered[ $val ] );
	}
	echo "-->\n";
}
add_action( 'wp_print_scripts', 'my_script_queues', 9999 );


function dequeue_plugins_style() {
	//プラグインIDを指定し解除する
	wp_dequeue_style('wp-block-library');
	if (get_post_type() !== 'column') {
	  wp_dequeue_style( 'wordpress-popular-posts-css' );
	}

	if (!is_search()) {
	  wp_dequeue_style( 'searchandfilter' );
	}
}
add_action( 'wp_enqueue_scripts', 'dequeue_plugins_style', 9999);

function my_dequeue_scripts() {
  if (get_post_type() !== 'column') {
	wp_dequeue_script( 'wpp-js' );  //不用JSを削除 (例)
  }
}
add_action( 'wp_print_scripts', 'my_dequeue_scripts' );


function is_mobile () {
  $ua = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : '';

  if (stripos($ua, 'iphone') !== false || // iphone
	  stripos($ua, 'ipod') !== false || // ipod
	  stripos($ua, 'ipad') !== false || // ipod
	  (stripos($ua, 'android') !== false && stripos($ua, 'mobile') !== false) || // android
	  (stripos($ua, 'mobile') !== false && stripos($ua, 'mobile') !== false) || // android mobile
	  (stripos($ua, 'windows') !== false && stripos($ua, 'mobile') !== false) || // windows phone
	  (stripos($ua, 'firefox') !== false && stripos($ua, 'mobile') !== false) || // firefox phone
	  (stripos($ua, 'bb10') !== false && stripos($ua, 'mobile') !== false) || // blackberry 10
	  (stripos($ua, 'blackberry') !== false) // blackberry
  ) {
	  $isSmartPhone = true;
  } else {
	  $isSmartPhone = false;
  }

  return $isSmartPhone;
}

use PhpOffice\PhpSpreadsheet\Writer\Csv as CSVWriter;

add_action( 'init', 'naviplus_exporter' );
function naviplus_exporter(){
  $url = $_SERVER['REQUEST_URI'];

  if(strstr($url,'naviplus_csv')){
	// GETパラメータ取得
	$data_format = "";
	$type = "";
	if(isset($_GET['data_format'])){
	  $data_format = $_GET['data_format'];
	}
	if(isset($_GET['type'])){
	  $type = $_GET['type'];
	}
	if($type=='facility' || $type=='column'){
	  $naviplus_csv_exporter = new NaviPlus_CSV_Exporter;

	  $posts = $naviplus_csv_exporter->get_posts_from_type($type);
	  $list = $type === "facility"  ? array_merge(
		array(array("item_code","stock_flg","name","url","comment","img_url","category","area","content","content_date","weight")),
		$naviplus_csv_exporter->add_facility_row($posts)
	  ) : array_merge(
		array(array("item_code","stock_flg","name","url","comment","img_url","category","content","content_date","weight")),
		$naviplus_csv_exporter->add_column_row($posts)
	  );
	  $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
	  // $spreadsheet->setInputEncoding('SJIS-win');
	  $sheet = $spreadsheet->createSheet(0);
	  $sheet -> fromArray($list, null, 'A1');

	  // Export to CSV file.
	  $writer = new CSVWriter($spreadsheet);
	  // $writer->setInputEncoding('SJIS');
	  $writer->setSheetIndex(0);
	  $writer->setDelimiter(',');
	  $writer->setLineEnding("\n");
	  $writer->setEnclosure('"');
	  // $writer->setUseBOM(true);


	  // echo ">>> complete";
	  $filename = "export_" . time() . "_".$type.".csv";
	  $fullpath =  WP_PLUGIN_DIR."/naviplus-csv-exporter/dest/".$filename;
	  $writer->save($fullpath);

	  // HTTPヘッダ送信。ローカルPCに保存するためのダイアログが出る。
	  header("Content-type: text/csv");
	  header('Content-Length: '.filesize($fullpath));
	  header("Content-Disposition: attachment; filename=$filename");
	  // ファイルを読み込んで出力します。
	  readfile($fullpath);
	}
	return;
  }
}

add_filter( 'rewrite_rules_array', 'add_sitemap_rewrite_rules', 1, 1 );
add_action( 'do_feed_sitemap', 'load_sitemap_template' );

/**
 * FILTER HOOK : rewrite_rules_array
 * sitemap.xml へのアクセス時にURLをリライト
 */
function add_sitemap_rewrite_rules( $rules ) {
	$new_rules = array(
		'^sitemap\.xml$' => 'index.php?feed=sitemap',
	);
	return array_merge( $new_rules, $rules );
}

/**
 * ACTION HOOK : do_feed_sitemap
 * サイトマップ用のfeedテンプレートのロード
 */
function load_sitemap_template() {
	load_template( get_template_directory() . '/feed-sitemap.php');
}
//add_filter( 'redirect_canonical', 'remove_sitemap_trailingslash', 1, 2 );

/**
 * FILTER HOOK : redirect_canonical
 * sitemap.xml へのアクセス時に末尾にスラッシュをつけない
 */
// function remove_sitemap_trailingslash( $redirect_url, $requested_url ) {
// 	if ( 'sitemap' == get_query_var( 'feed' ) ) {
// 		return $requested_url;
// 	}
// 	return $redirect_url;
// }


//サーキュラーエコノミー関連のページであるか
function is_circulareeconomy(){
	return ( is_post_type_archive('circulareconomy') || get_post_type() === 'circulareconomy' ) ? true : false;
}

//サーキュラーエコノミー用パンくず
function circulareeconomy_breadcrumb(){
	global $post;

	$breadcrumb =  '<div class="breadcrumb ver-black">';
	$breadcrumb .=   '<ol class="l-wrapper breadcrumb__wraper">';
	$breadcrumb .=     '<li class="breadcrumb__item"><a href="/circulareconomy/"><span>トップ</span></a></li>';

//子なし
if( $post->post_parent === 0 ){
	$breadcrumb .=     '<li class="breadcrumb__item"><span>' . get_the_title() . '</span></li>';

}else{

	$parent_id = $post->post_parent;
	$parent_slug = get_post($parent_id)->post_name;

	$breadcrumb .=     '<li class="breadcrumb__item"><a href="/circulareconomy/' . $parent_slug . '/"><span>' . get_the_title($parent_id) . '</span></a></li>';
	$breadcrumb .=     '<li class="breadcrumb__item"><span>' . get_the_title() . '</span></li>';
}


	$breadcrumb .=   '</ol>';
	$breadcrumb .= '</div>';

	echo $breadcrumb;
}
add_shortcode("circulareeconomy_breadcrumb", "circulareeconomy_breadcrumb");

//サーキュラーエコノミー用パンくず
function circulareeconomy_examples_area(){
	get_template_part('var/circular-examples_area');
}
add_shortcode("circulareeconomy_examples_area", "circulareeconomy_examples_area");

//新着記事判定
function is_newArticle($article_date){
	$days = 30;
	$elapsed = date('U',(date_i18n('U') - $article_date)) / 86400;

	if( $days > $elapsed ){
		return true;
	}

	return false;
}

// ページ遷移時のリダイレクトを阻止する
add_filter('redirect_canonical','my_disable_redirect_canonical');
function my_disable_redirect_canonical( $redirect_url ) {
	global $post;
	if ( is_circulareeconomy() && in_array( $post->post_name, array('examples', 'column'), true ) ){
		//リクエストURLに「/page/」があれば、リダイレクトしない
		preg_match('/\/paged\//', $redirect_url, $matches);
		if ($matches){
			$redirect_url = false;
			return $redirect_url;
		}
	}
}

?>