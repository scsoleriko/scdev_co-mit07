<?php
  $terms = $args['terms'];
  $term_name = $args['term_name'];

	$query_1 = get_posts(array( 
		'post_type' => 'facility', // 投稿タイプを指定
		'posts_per_page'=> 3,
		'post_parent' => 0, // 親を持たない投稿を取得
    'meta_key' => 'plan',
    'meta_value' => 'normal',
    'orderby' => 'rand',
    'tax_query' => array(
      'relation' => 'AND',
      array(
			'taxonomy'=>'area',
			'terms'=>$terms,
			'field'=>'slug',
			'operator'=>'IN'
      )
    )
	));

	$query_2 = get_posts(array( 
		'post_type' => 'facility', // 投稿タイプを指定
		'posts_per_page'=> 3,
		'post_parent' => 0, // 親を持たない投稿を取得
    'meta_key' => 'plan',
    'meta_value' => 'normal',
    'orderby' => 'rand',
    'tax_query' => array(
      'relation' => 'AND',
      array(
			'taxonomy'=>'area',
			'terms'=>$terms,
			'field'=>'slug',
			'operator'=>'IN'
      ),
      array(
        'taxonomy'=>'feature',
        'terms'=>'offsite',   //オフサイトミーティング
        'field'=>'slug',
        'operator'=>'AND'
      )
    )
	));
	$query_3 = get_posts(array( 
		'post_type' => 'facility', // 投稿タイプを指定
		'posts_per_page'=> 3,
		'post_parent' => 0, // 親を持たない投稿を取得
    'meta_key' => 'plan',
    'meta_value' => 'normal',
    'orderby' => 'rand',
    'tax_query' => array(
      'relation' => 'AND',
      array(
			'taxonomy'=>'area',
			'terms'=>$terms,
			'field'=>'slug',
			'operator'=>'IN'
      ),
      array(
        'taxonomy'=>'feature',
        'terms'=>'new-member',    // 新入社員
        'field'=>'slug',
        'operator'=>'AND'
      )
    )
	));
	$query_4 = get_posts(array( 
		'post_type' => 'facility', // 投稿タイプを指定
		'posts_per_page'=> 3,
		'post_parent' => 0, // 親を持たない投稿を取得
    'meta_key' => 'plan',
    'meta_value' => 'normal',
    'orderby' => 'rand',
    'tax_query' => array(
      'relation' => 'AND',
      array(
			'taxonomy'=>'area',
			'terms'=>$terms,
			'field'=>'slug',
			'operator'=>'IN'
      ),
      array(
        'taxonomy'=>'feature',
        'terms'=>'near_station',    // 駅近
        'field'=>'slug',
        'operator'=>'AND'
      )
    )
	));
?>
<article class="article" id="footer-faq" itemscope itemtype="https://schema.org/FAQPage">
	<h2 class="heading-1"><?php echo $term_name; ?>エリアについてよくある質問</h2>
  <ul class="accordion" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
    <li class="accordion__column accordion__title" itemprop="name"><?php echo $term_name; ?>エリアでオススメの研修施設を教えてください。</li>
    <?php
      $facility_1 = '';
      foreach( $query_1 as $post ):
        setup_postdata( $post );
        $facility_1 = $facility_1 . '「<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>」';
      endforeach;
    ?>
    <li class="accordion__column accordion__content" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text"><?php echo $term_name; ?>エリアでおすすめの研修施設は、<?php echo $facility_1; ?>などがあります！</p></li>
  </ul>
  <ul class="accordion" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
    <li class="accordion__column accordion__title" itemprop="name"><?php echo $term_name; ?>エリアでオフサイトミーティングに最適な施設はどこですか？</li>
    <?php
      $facility_2 = '';
      foreach( $query_2 as $post ):
        setup_postdata( $post );
        $facility_2 = $facility_2 . '「<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>」';
      endforeach;
    ?>
    <li class="accordion__column accordion__content" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text"><?php echo $term_name; ?>エリアでオフサイトミーティングに最適な施設は、<?php echo $facility_2; ?>などがあります！<p></li>
  </ul>
  <ul class="accordion" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
    <li class="accordion__column accordion__title" itemprop="name"><?php echo $term_name; ?>エリアで新入社員研修に最適な施設はどこですか？</li>
    <?php
      $facility_3 = '';
      foreach( $query_3 as $post ):
        setup_postdata( $post );
        $facility_3 = $facility_3 . '「<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>」';
      endforeach;
    ?>
    <li class="accordion__column accordion__content" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text"><?php echo $term_name; ?>エリアで新入社員研修に最適な研修施設は、<?php echo $facility_3; ?>などがあります！<p></li>
  </ul>
  <ul class="accordion" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
    <li class="accordion__column accordion__title" itemprop="name"><?php echo $term_name; ?>エリアで駅から近い施設はどこですか？</li>
    <?php
      $facility_4 = '';
      foreach( $query_4 as $post ):
        setup_postdata( $post );
        $facility_4 = $facility_4 . '「<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>」';
      endforeach;
    ?>
    <li class="accordion__column accordion__content" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text"><?php echo $term_name; ?>エリアで駅から近い研修施設は、<?php echo $facility_4; ?>などがあります！<p></li>
  </ul>
  <ul class="accordion" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
    <li class="accordion__column accordion__title" itemprop="name">人数や予算、目的が決まっているので、<?php echo $term_name; ?>エリアでおすすめの施設を紹介してもらいたいです。</li>
    <li class="accordion__column accordion__content" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text"><?php echo $term_name; ?>エリアで希望の条件が決まっていて提案を受けたい方は、無料で利用できる<a href="https://co-mit.jp/consult/">専門家相談</a>をぜひご利用ください。<p></li>
  </ul>
</article>
