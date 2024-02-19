
<article class="article">
	<h2 class="heading-1">良く見られている施設</h2>
	<div class="swiper-container-2__wrap">
		<div id="ranking-facility" class="swiper-container-2 swiper-container--facility_post">
			<div class="swiper-wrapper">

			<?php
				/*$parent_id = $post->post_parent;
				if ( isset($parent_id) ){
					$id = get_post_field( 'post_name', $parent_id );
				} else {
					$id = get_post( get_the_ID() )->post_name;
				}*/
				$xml_url = 'https://r6.snva.jp/api/recommend/rule/?k=O1Dq8VN3M8QBH&tmpl=2&lang_type=xml&output_type=2&format_type=2';
				$xml = simplexml_load_file($xml_url);
				foreach($xml->items->item as $item){
				echo '<section class="swiper-slide facility-list-3">', PHP_EOL;
				 echo '<a href="' . str_replace("https://co-mit.jp", "", $item->url) . '" onclick="apiSetCtr(\'' . $item->item_code . '\', \'2\', this, \'O1Dq8VN3M8QBH\');return false;"></a>', PHP_EOL;
				 echo '<div class="facility-list-3__sub">', PHP_EOL;
				  echo '<div class="facility-list-3__image">';
				  if (empty($item->img_url)){
					echo '<img src="/img/naviplus_noimage.jpg" alt="' . $item->name . '">' . '</div>', PHP_EOL;
				  } else {
				  // echo '<!-- '. preg_replace('/^https:(.*)\.jp\//', "/", $item->img_url) . '-->';
					echo '<img src="' . preg_replace('/^https:(.*)\.jp\//', "/", $item->img_url) . '" alt="' . $item->name . '">' . '</div>', PHP_EOL;
				  }
				  $tags = explode(":", $item->category);
				  $search = '#360°パノラマビュー';
				  $key = in_array($search, $tags);
				  if ($key){
					echo '<p class="facility-list-3__360"><img src="/co-mit_renew_201910/img/icon_360.png" alt="360°パノラマビュー"></p>';
				  }
				  echo '<ul class="facility-list-3__tag">', PHP_EOL;
				  $i = 0;
				  foreach($tags as $tag){
				 	  if($i >= 3){
						  break;
					  }
					  if(strpos( $tag, "#" ) === 0){
						  echo '<li>' . $tag . '</li>', PHP_EOL;
						  $i++;
					  }
				  }
				  echo '</ul>', PHP_EOL;
				 echo '</div>', PHP_EOL;
				 echo '<div class="facility-list-3__main">', PHP_EOL;
				  echo '<div class="facility-list-3__info">' . '<span class="facility-list-3__area">' . $item->area . '</span>' . '</div>', PHP_EOL;
				  echo '<h3 class="facility-list-3__name">' . $item->name . '</h3>', PHP_EOL;
				  echo '<p class="facility-list-3__text">' . $item->comment . '</p>', PHP_EOL;
				 echo '</div>', PHP_EOL;
				echo '</section>', PHP_EOL;
				}
			?>

			</div>
		</div>
		<div class="swiper-button-prev-column ranking-facility-prev"></div>
		<div class="swiper-button-next-column ranking-facility-next"></div>
        </div>
</article>
