<?php
global $post;


if(empty($_SERVER['HTTPS'])) {
  $protocol = "http";
}else {
  $protocol = "https";
}

$path = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/co-mit_renew_201910/img/serp/";


function get_thumb_url($size = 'full', $post_id = null) {

  $post_id = ($post_id) ? $post_id : get_the_ID();  //第2引数が指定されていればそれを、指定がなければ現在の投稿IDをセット
  if (!has_post_thumbnail($post_id)) return false;  //指定した投稿がアイキャッチ画像を持たない場合、falseを返す
  $thumb_id = get_post_thumbnail_id($post_id);      // 指定した投稿のアイキャッチ画像の画像IDを取得
  $thumb_img = wp_get_attachment_image_src($thumb_id, $size);  // 画像の情報を配列で取得
  $thumb_src = $thumb_img[0];  // 配列の中からURLの情報だけ取得

  return $thumb_src;           //URLを返す
}

if (
  (is_home() || is_front_page() ) ||
  ( is_page( array( "disclaimer", "agreement", "favorite", "about" ) ) ) ||
  is_search() ||
  is_tax('area') ||
  is_post_type_archive('facility') ||
  is_post_type_archive('column')
) {

  $path .= "comit_logo_square.jpg";

} else if (is_tax('purpose')) {
  $term_name = single_term_title( '', false );

  if ( $term == 'concent' ) {
    $path .= "ph_purpose01.jpg";
  } else if ( $term == 'motivate' ) {
    $path .= "ph_purpose02.jpg";
  } else if ( $term == 'environment' ) {
    $path .= "ph_purpose03.jpg";
  } else if ( $term == 'incentive' ) {
    $path .= "ph_purpose04.jpg";
  }
} else if ( get_post_type() === 'column' && is_single() ) {

  $path = get_thumb_url("full", $post->ID);

} else if ( get_post_type() === 'facility' && is_single() ) {
  $id = $post->post_parent !== 0 ? $post->post_parent : $post->ID;

  $path = get_field('facility_mainimage', $id);
}

if ( preg_match("/^\/\//", $path) ) {
  $path = $protocol . ":" . $path;
}

if ( !preg_match("/^http/", $path) ) {
  $path = $protocol . "://" . $path;
}



echo "<meta name=\"thumbnail\" content=\"".$path."\" />";

?>

<?php if (is_user_logged_in()): ?>
<script type="text/javascript">
<?php
  global $template;
  ?>
console.log("<?php echo 'このページで使用しているサムネイル：'. $path; ?>");
</script>
<?php endif; ?>