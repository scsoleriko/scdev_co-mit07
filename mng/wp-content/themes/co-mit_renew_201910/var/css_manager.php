
<?php if (is_user_logged_in()): ?>
<script type="text/javascript">
<?php
  global $template;
  ?>
console.log("<?php echo 'このページで使用しているテンプレートファイル：'. basename($template); ?>");
</script>
<?php endif; ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/common.css">
<?php if ( is_home() ): ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_frontpage.css">
<?php endif; ?>

<?php if (get_post_type() === 'column' || is_singular('facility') || is_archive('facility') || is_circulareeconomy() ) : ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_blog-module.css">
<?php endif; ?>

<?php if (is_page('favorite')): ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_favorite.css">
<?php endif; ?>

<?php if (is_page('faq') || is_singular('faq')): ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_blog-module.css">
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_faq-module.css">
<?php endif; ?>
<?php if (is_page('beginner')): ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/style.css">
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_beginner.css">
<?php endif; ?>

<?php if (get_post_type() === 'circulareconomy' || is_circulareeconomy() ) : ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/circular.min.css?20230808">
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_archive.css">

<?php endif; ?>


<?php
// 一覧ページ
if (
  (is_post_type_archive('facility') ||
  is_archive('area') ||
  is_archive('feature') ||
  is_archive('puprpose')) && !is_post_type_archive("column") && !is_post_type_archive("circulareconomy")
): ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_archive.css">

<?php endif; ?>

<?php if ( is_singular('facility')): ?>
<?php
/*
<link rel="stylesheet" href="/co-mit_renew_201910/css/classic_style.css">
<link rel="stylesheet" href="/co-mit_renew_201910/css/classic_adjust.css">
<link rel="stylesheet" href="/co-mit_renew_201910/css/style.css">
*/
?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_single-facility.css">
<?php endif; ?>

<?php if (is_page('about')): ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_about.css">
<?php elseif (is_page('agreement') || is_page('disclaimer')): ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/template_agreement.css">
<?php endif; ?>


<?php if (is_404()): ?>
<link rel="stylesheet" href="/co-mit_renew_201910/css/style.css">
<?php endif; ?>
