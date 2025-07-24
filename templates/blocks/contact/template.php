<?php
	$title	= get_field('contact_title');
?>
<section class="cbo-contact">
	<div class="contact-inner cbo-container">

		<?php if($title): ?>
			<div class="contact-title cbo-title-2 slide-up" itemprop="headline">
				<?php echo $title ?>
			</div>
		<?php endif; ?>

		<div class="contact-list">
			<?php
				if( have_rows('contact_list') ):
				while ( have_rows('contact_list') ) : the_row();
				$name	= get_sub_field('name');
				$function	= get_sub_field('function');
				$contacts	= get_sub_field('contacts');
			?>
				<div class="list-el">
					<div class="el-inner">
						<?php if($name): ?>
							<div class="el-name cbo-title-5 slide-up">
								<?php echo $name ?>
							</div>
						<?php endif; ?>

						<?php if($function): ?>
							<div class="el-function slide-up">
								<?php echo $function ?>
							</div>
						<?php endif; ?>

						<?php if($contacts): ?>
							<div class="el-contacts slide-up">
								<?php echo $contacts ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php
				endwhile;
				endif;
			?>
		</div>
	</div>
</section>