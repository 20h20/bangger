<?php
	$chapo = get_field('team_chapo');
?>
<section class="cbo-team">
	<div class="team-inner cbo-container container--medium">
		<div class="team-content">
			<?php if($chapo): ?>
				<div class="team-title cbo-title-3 slide-up" itemprop="headline">
					<?php echo $chapo ?>
				</div>
			<?php endif; ?>
			<?php get_template_part('templates/parts/button/template', null, array()); ?>
		</div>
		<div class="team-list">
			<?php
				if( have_rows('team_list') ):
				while ( have_rows('team_list') ) : the_row();
				$picture	= get_sub_field('picture');
			?>
				<div class="list-el slide-up">
					<div class="el-inner cbo-picture-cover">
						<img
							decoding="async"
							src="<?php echo $picture['sizes']['medium']; ?>"
							srcset="<?php echo $picture['sizes']['medium']; ?> 320w, <?php echo $picture['sizes']['medium']; ?> 768w, <?php echo $picture['sizes']['medium']; ?> 1024w"
							alt="<?php echo $picture['alt']; ?>" sizes="100vw"
							loading="lazy"
							width="600" height="600"
							class="parallax-img"
						>
					</div>
				</div>
			<?php
				endwhile;
				endif;
			?>
		</div>
	</div>
	<div class="team-shape cbo-picture-contain">
		<img
			decoding="async"
			src="<?php bloginfo('template_directory'); ?>/library/img/team-shape.svg"
			alt="<?php echo get_bloginfo('description'); ?>" sizes="100vw"
			width="1000" height="1000"
		>
	</div>
</section>