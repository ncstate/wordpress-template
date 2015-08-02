<?php $image = get_sub_field('image'); ?>
				
<?php if ( get_sub_field('link') ): ?>
<a href="<?php the_sub_field('url'); ?>" target="_blank">
<?php endif; ?>
	<div class='cross-section <?php the_sub_field('background_color') ?>-bg'>
		<div class="container">
			<?php if ( get_sub_field('image_position') == 'left' ): ?>
					<div class='cross-section-img'>
					<?php echo get_retina_images($image['ID'], array(570,470,370,768)); ?>
					</div>
			<?php endif; ?>
			<div class='cross-section-text'>
				<div class='cross-section-container'>
					<?php the_sub_field('text'); ?>
					<?php if ( get_sub_field('link') && get_sub_field('link_text') ): ?>
					<p class="link-text"><?php the_sub_field('link_text'); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( get_sub_field('image_position') == 'right' ): ?>
					<div class='cross-section-img'>
					<?php echo get_retina_images($image['ID'], array(570,470,370,768)); ?>
					</div>
			<?php endif; ?>
		</div>
	</div>
<?php if ( get_sub_field('link') ): ?> 
</a> 
<?php endif; ?>