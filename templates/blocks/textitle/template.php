<?php
	$bgcolor	= get_field('textitle_color');
	$maintitle	= get_field('textitle_maintitle');
	$leftitle	= get_field('textitle_titleleft');
	$content	= get_field('textitle_titlecontent');
?>
<section class="cbo-textitle textitle--<?php echo $bgcolor ?>">
	<div class="textitle-inner cbo-container container--nomargin container--padding">
		<?php if($maintitle): ?>
			<div class="textitle-maintitle cbo-title-2 slide-up cbo-indexsup" itemprop="headline">
				<?php echo $maintitle ?>
			</div>
		<?php endif; ?>

		<div class="textitle-content">
			<?php if($leftitle): ?>
				<div class="content-title cbo-title-4 slide-up">
					<?php echo $leftitle ?>
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