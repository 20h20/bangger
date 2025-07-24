<?php
	$content	= get_field('textpicture_content');
	$title	= get_field('textpicture_title');
	$picture	= get_field('textpicture_picture');
	$picturepos	= get_field('textpicture_picturepos');
?>
<section class="cbo-textpicture textpicture--<?php echo $picturepos; ?>">
	<div class="textpicture-inner cbo-container container--medium">
		<div class="textpicture-picture cbo-picture-cover slide-up">
			<img
				class="parallax-img"
				decoding="async"
				src="<?php echo $picture['sizes']['small']; ?>"
				srcset="<?php echo $picture['sizes']['small']; ?> 320w, <?php echo $picture['sizes']['large']; ?> 768w, <?php echo $picture['sizes']['large']; ?> 1024w"
				alt="<?php echo $picture['alt']; ?>" sizes="100vw"
				loading="lazy"
				width="1000" height="1000"
			>
		</div>
	
		<div class="textpicture-content">
			<?php if($title): ?>
				<div class="content-title cbo-title-2 slide-up" itemprop="headline">
					<?php echo $title; ?>
				</div>
			<?php endif; ?>

			<?php if($content): ?>
				<div class="content-text cbo-cms slide-up">
					<?php echo $content ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>