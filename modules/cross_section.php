<?php $image = get_sub_field('image'); ?>
				
<?php if ( get_sub_field('link') ): ?>
<a href="<?php the_sub_field('url'); ?>" target="_blank">
<?php endif; ?>
	<div class='cross-section <?php the_sub_field('background_color') ?>-bg'>
		<?php if ( get_sub_field('image_position') == 'left' ): ?>
		<picture class='cross-section-img'>
			<source srcset="<?php echo $image['sizes']['callout-lg-desktop']; ?>" media="(min-width: <?php echo $lg_breakpoint; ?>)">
			<source srcset="<?php echo $image['sizes']['callout-desktop']; ?>" media="(min-width: <?php echo $md_breakpoint; ?>)">
			<source srcset="<?php echo $image['sizes']['callout-sm-desktop']; ?>" media="(min-width: <?php echo $sm_breakpoint; ?>)">
			<source srcset="<?php echo $image['sizes']['callout-tablet']; ?>" media="(min-width: <?php echo $xs_breakpoint; ?>)">
			<source srcset="<?php echo $image['sizes']['callout-phone']; ?>">
			<img src="<?php echo $image['sizes']['callout-desktop']; ?>" class="img-responsive" alt="<?php echo $image['alt']; ?>" />
		</picture>
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
		<picture class='cross-section-img img-right'>
			<source srcset="<?php echo $image['sizes']['callout-lg-desktop']; ?>" media="(min-width: <?php echo $lg_breakpoint; ?>)">
			<source srcset="<?php echo $image['sizes']['callout-desktop']; ?>" media="(min-width: <?php echo $md_breakpoint; ?>)">
			<source srcset="<?php echo $image['sizes']['callout-sm-desktop']; ?>" media="(min-width: <?php echo $sm_breakpoint; ?>)">
			<source srcset="<?php echo $image['sizes']['callout-tablet']; ?>" media="(min-width: <?php echo $xs_breakpoint; ?>)">
			<source srcset="<?php echo $image['sizes']['callout-phone']; ?>">
			<img src="<?php echo $image['sizes']['callout-desktop']; ?>" class="img-responsive" alt="<?php echo $image['alt']; ?>" />
		</picture>
		<?php endif; ?>
	</div>
<?php if ( get_sub_field('link') ): ?> 
</a> 
<?php endif; ?>