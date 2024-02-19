<div class="l-wrapper">
	<div class="home-content">

<h2 style="font-size: 1.8rem; font-weight: bold; color: #fff; background-color: #00B2B0; padding: 20px; margin:15px 0; text-align:center;">今人気の研修や設備など目的ごとにオススメの施設を特集でご紹介しています！</h2>

    <ul class="special-banner">
      <?php
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'top-special-banner',
            'post_status'      => 'publish',
            'meta_key' => 'order_num', //カスタムフィールド名
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        );
        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) :  $the_query->the_post();
      ?>
      <?php
        $special_img = get_field("top-banner-img");
        $special_link = get_field("top-banner-link");
        $special_target = in_array('blank',(array)get_field("top-banner-link-target"));
      ?>
        <li>
          <a href="<?php echo $special_link; ?>" <?php if($special_target) { echo 'target="_blank"'; } ?>>
            <img src="<?php echo $special_img ?>">
          </a>
        </li>
      <?php
        endwhile; endif;
        wp_reset_postdata();
      ?>
    </ul>
    <a href="/category_column/special_content/" class="button">特集一覧はこちら</a>
	</div>
</div>