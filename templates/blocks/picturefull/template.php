<?php
	$picture	= get_field('picturefull_picture');
?>
<section class="cbo-picturefull">
	<div class="picturefull-inner cbo-container container--medium">
		<div class="picturefull-wrapper">
			<div class="picturefull-picture cbo-picture-cover">
				<img
					class="parallax-img"
					decoding="async"
					src="<?php echo $picture['sizes']['large']; ?>"
					srcset="<?php echo $picture['sizes']['large']; ?> 320w, <?php echo $picture['sizes']['large']; ?> 768w, <?php echo $picture['sizes']['large']; ?> 1024w"
					alt="<?php echo $picture['alt']; ?>"
					sizes="100vw"
					loading="lazy"
					width="1000"
					height="1000"
				>
			</div>
		</div>
	</div>
</section>