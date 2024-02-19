<?php get_header(); ?>

	<?php if(in_category(1)): ?>

        <section class="normal-section common-content" id="404not">
          <div class="section-title-area no-follow">
            <h2 class="notfound-section-title">404 Not Found.<br><span class="notfound-section-catch">お探しのページが見つかりませんでした。</span></h2>
			  <p class="notfound-section-text">お探しのページは移動もしくは削除された可能性があります。<br>お手数ですがトップページよりお探しのページをお求めください。</p>
			  <div class="btn-area">
            <p class="btn-normal"><a href="/">トップページへ</a></p>
          </div>
          </div>
        </section>

	<?php else: ?>

	<?php the_content(); ?>

	<?php endif; ?>

<?php get_footer(); ?>

