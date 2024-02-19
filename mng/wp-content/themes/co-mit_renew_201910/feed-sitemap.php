<?php
	header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
	echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo home_url(); ?></loc>
		<lastmod><?php echo date( 'Y-m-d', strtotime( get_lastpostdate( 'blog' ) ) ); ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
	</url>

<?php
// 施設
$query = new WP_Query(array(
'order'   => 'DESC',
'post_type' => 'facility',
// 'taxonomy' => array('feature', 'area', 'purpose'),
'posts_per_page'=> 9999,
'post_status' => 'publish',
'paged' => -1,
'post_parent' => 0 // 親を持たない投稿を取得
));
?>
<?php while ($query->have_posts()): $query->the_post(); ?>
<url>
  <loc><?php the_permalink(); ?></loc>
  <lastmod><?php the_modified_time( 'Y-m-d' ); ?></lastmod>
  <changefreq>daily</changefreq>
  <priority>1.0</priority>
</url>
<?php endwhile; ?>

<?php
// コラム
$query = new WP_Query(array(
  'order'   => 'DESC',
  'post_type' => 'column',
  'posts_per_page'=> 9999,
  'post_status' => 'publish',
  'paged' => -1
));
?>
<?php while ($query->have_posts()): $query->the_post(); ?>
<url>
  <loc><?php the_permalink(); ?></loc>
  <lastmod><?php the_modified_time( 'Y-m-d' ); ?></lastmod>
  <changefreq>daily</changefreq>
  <priority>1.0</priority>
</url>
<?php endwhile; ?>


<?php
// 一覧
$tax_list = array('feature', 'area', 'purpose', 'category_column', 'tag_column');

// echo $tax_list;
foreach ( $tax_list as $tax ) :
$terms = get_terms( $tax, array(
  //投稿のないタームは取得しない
  'hide_empty' => true,
));

foreach ( $terms as $term ) :
// echo "<!--" . $tax ."|".$term->slug . "-->";
?>
<url>
  <loc><?php echo preg_replace('/\/(facility|column)/', '', get_term_link($term->slug, $tax)); ?></loc>
  <changefreq>daily</changefreq>
  <priority>1.0</priority>
</url>
<?php endforeach; endforeach; ?>

<?php
function getFileList($dir) {
    $files = glob(rtrim($dir, '/') . '/*');
    $list = array();
    foreach ($files as $file) {
        if (is_file($file) && preg_match('/.html/',$file)) {
            $list[] = $file;
        }
        if (is_dir($file)) {
            $list = array_merge($list, getFileList($file));
        }
    }
    return $list;
}

foreach (getFileList('./offsite/') as $path) :
?>

<url>
  <loc>https://<?php echo $_SERVER["HTTP_HOST"] . preg_replace('/^./', '', $path); ?></loc>
  <changefreq>daily</changefreq>
  <priority>1.0</priority>
</url>
<?php endforeach; ?>

</urlset>
