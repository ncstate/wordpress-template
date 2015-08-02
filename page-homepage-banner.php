<?php while ( have_rows('banner') ) : the_row(); ?>
	<header class="landing-header">
		<?php $img = get_sub_field('image'); ?>
		<?php echo get_retina_images($img['ID'], array(825, 825, 992, 768)); ?>
		<div class="container">
			<div class="header-content">
				<h1><?php echo get_sub_field('headline'); ?></h1>
				<p><?php echo get_sub_field('teaser'); ?></p>
				<p><a href="<?php echo get_sub_field('url'); ?>"><?php echo append_arrow(get_sub_field('url_text'), 'roman-arrow'); ?></a></p>
			</div>
		</div>
	</header>
<?php endwhile; ?>