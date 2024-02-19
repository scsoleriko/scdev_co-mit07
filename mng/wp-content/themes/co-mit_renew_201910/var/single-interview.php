<?php global $interview_post; ?>

<?php if (!empty($interview_post)): ?>
<section class="normal-section interview-section">
		<h2 class="section-title">
			<span class="section-title-en">INTERVIEW</span>
			<i class="st-icon-pen"></i>
		</h2>
	<div class="interview">
		<div class="interview__image">
			<a href="<?php echo $interview_post->permalink; ?>"><img src="<?php echo $interview_post->thumbnail ?>" alt=""></a>
		</div>
		<div class="interview__main">
			<a href="<?php echo $interview_post->permalink; ?>">
				<h3 class="interview__sub-heading">CO-MIT編集部が実際に行き、取材しました！</h3>
				<h3 class="interview__heading"><?php echo $interview_post->post_title; ?></h3>
				<div class="interview__text">
					<p><?php echo $interview_post->column_lead; ?></p>
				</div>
			</a>
		</div>
	</div>
</section>

<?php endif; ?>
