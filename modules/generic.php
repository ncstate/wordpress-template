<div class="mod-generic gray-lighter-bg">
	<div class="container<?php echo $fluid; ?>">
	<?php if ( get_sub_field('section_name') ) : ?>
		<h2><?php echo strtoupper(get_sub_field('section_name')); ?></h2>
	<?php endif; ?>
<?php while ( have_rows('content_blocks') ) : the_row(); ?>
	<?php if ( get_sub_field('link_to') ) : ?>
		<a href="<?php echo esc_url( get_sub_field('link_to') ); ?>">
	<?php endif; ?>
			<div class="generic-block">
			<?php if ( get_sub_field('image') ) : ?>
					<picture>
						<?php $image = get_sub_field('image'); ?>
						<source srcset="<?php echo $image['sizes']['generic-lg-desktop']; ?>" media="(min-width: <?php echo $lg_breakpoint; ?>)">
						<source srcset="<?php echo $image['sizes']['generic-desktop']; ?>" media="(min-width: <?php echo $md_breakpoint; ?>)">
						<source srcset="<?php echo $image['sizes']['generic-sm-desktop']; ?>" media="(min-width: <?php echo $sm_breakpoint; ?>)">
						<source srcset="<?php echo $image['sizes']['generic-tablet']; ?>" media="(min-width: <?php echo $xs_breakpoint; ?>)">
						<source srcset="<?php echo $image['sizes']['generic-phone']; ?>">
						<img src="<?php echo $image['sizes']['generic-desktop']; ?>" class="img-responsive" alt="<?php echo $image['alt']; ?>" />
					</picture>
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