<div class="mod-events">
	<div class="container">
	<?php if ( get_sub_field('section_name') ) : ?>
		<h2><?php echo strtoupper(get_sub_field('section_name')); ?></h2>
	<?php endif; ?>

<?php 	
$arqs = array(
        'post_type'       => 'events',
        'subcalendar' 	  => $subcalendar,
        'meta_key'        => 'start_time',
        'meta_query' => array(
            array(
                'key' => 'start_time',
                'value' => current_time('timestamp'),
                'compare' => '>='
            )
        ),
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'posts_per_page' => 3,
);
$wp_query = new WP_Query($arqs);

?>

<?php if ( $wp_query->have_posts() ) : ?>
	<?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
		<?php $event = get_post_meta(get_the_ID()); ?>
		
		<?php if(get_sub_field('details_link')): ?>
			<a href="<?php echo get_permalink(get_the_ID()); ?>">
		<?php endif; ?>
			<div class="event-block">
				<div class="event-date">
					<time>
					<?php 
						$time = $event['start_time'][0];
						echo date("M j", $time);
					?>
					</time>
				</div>
				<div class="event-details">
					<p><strong><?php echo date("l", $time); ?></strong></p>
					<h4><?php echo get_the_title(); ?></h4>
					<p><?php echo (empty($event['location'][0]) ? date("g:i a", $time) : date("g:i a", $time) . " | " . $event['location']); ?></p>
				</div>
			</div>
		<?php if(get_sub_field('details_link')): ?>
			</a>
		<?php endif; ?>

<?php endwhile; ?>
<?php endif; ?>
		<div class="clearfix"></div>
	<?php if ( get_sub_field('button') ) : ?>
		<?php while ( have_rows('button_settings') ) : the_row(); ?>
			<a href="<?php echo esc_url( get_sub_field('button_link') ); ?>" class="btn btn-red rss-link"><?php the_sub_field("button_text"); ?><span class="glyphicon glyphicon-right-arrow"></span></a>
		<?php endwhile; ?>
	 <?php endif; ?>
	</div>
</div>
<?php wp_reset_query(); ?>