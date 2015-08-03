<div class="mod-generic">
	<div class="container">
	<?php if ( get_sub_field('section_name') ) : ?>
		<h2><?php echo strtoupper(get_sub_field('section_name')); ?></h2>
	<?php endif; ?>
<?php while ( have_rows('content_blocks') ) : the_row(); ?>
	<?php if ( get_sub_field('link_to') ) : ?>
		<a href="<?php echo esc_url( get_sub_field('link_to') ); ?>">
	<?php endif; ?>
			<div class="generic-block">
			<?php if ( get_sub_field('image') ) : ?>
					<?php $image = get_sub_field('image'); ?>
					<?php echo get_retina_images($image['ID'], array(324,258,184,681)); ?>
			<?php endif; ?>
			<?php if ( get_sub_field('heading') ) : ?>
				<h4><?php the_sub_field('heading'); ?></h4>
			<?php endif; ?>
			<?php if ( get_sub_field('description') ) : ?>
				<p><?php the_sub_field('description'); ?></p>
			<?php endif; ?>
			</div>
	<?php if ( get_sub_field('link_to') ) : ?>
		</a>
	<?php endif; ?>	
<?php endwhile; ?>
		<div class="clearfix"></div>
	</div>
</div>