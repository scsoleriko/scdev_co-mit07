<?php get_header(); ?>

<div class="bg-gray bg-gray--pd">
	<div class="l-wrapper l-pc-2col">
		<div class="l-pc-2col__pro-main">
			<article class="article">
				<h1 class="heading-1">よくある質問</h1>
        <?php if(have_posts()): while(have_posts()): the_post();?>
          <?php $terms = get_the_terms($post->ID,  'faq_category'); ?>
              <h2 id="faq-cat-1" class="heading-2"><?php echo $terms[0]->name; ?></h2>
				<dl class="faq-list detail">
          <dt class="faq-list__question"><p><?php echo get_field("question", $post->ID); ?></p></dt>
          <dd class="faq-list__answer"><p><?php echo get_field("answer", $post->ID); ?></p></dd>
        </dl> 
        <?php endwhile; endif; ?>
	      <a href="/faq/" class="button button--lg">よくある質問トップへ</a>
        <?php
        $posts = get_field('kanren');
        if( $posts ):
        ?>
        <h2 class="heading-2 detail-sub-heading">関連する質問</h2>
				<dl class="faq-list">
          <?php foreach( $posts as $post ): ?>
					<dt class="faq-list__question"><a href="<?php the_permalink( $post->ID); ?>"><?php echo get_field("question", $post->ID); ?></a></dt>
          <?php endforeach; ?>
				</dl>
        <?php endif; ?>
      </article>
  	</div>
    <?php get_template_part("var/faq-sidebar"); ?>
	</div>
</div>

<?php get_footer(); ?>
