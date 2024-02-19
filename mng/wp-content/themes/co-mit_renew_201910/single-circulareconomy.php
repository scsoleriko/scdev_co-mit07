<?php
  get_header();

  //親ページ
  if( $post->post_parent === 0 ){

    //一覧（実例、コラム）
    if( in_array( $post->post_name, array('examples', 'column'), true ) ){
      get_template_part("var/circular-archive");

    }else{
      the_content();
      get_template_part("var/circular-banner");
    }

  //子ページ
  }else{

    $parent_id = $post->post_parent;
    $parent_slug = get_post($parent_id)->post_name;

    //記事（実例、コラム）
    if( in_array( $parent_slug, array('examples', 'column'), true ) ){
      get_template_part("var/circular-single");
    }
  }

  get_footer();
?>
