<?php
		// Get RSS Feed(s)
		include_once( ABSPATH . WPINC . '/feed.php' );

		// Get a SimplePie feed object from the specified feed source.
		add_filter( 'wp_feed_cache_transient_lifetime' , 'return_2' );
		$rss = fetch_feed( $rss_app_feed_url );
		remove_filter( 'wp_feed_cache_transient_lifetime' , 'return_2' );

		if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
			
		    // Figure out how many total items there are, but limit it to 3.
		    $maxitems = $rss->get_item_quantity( 3 );

		    // Build an array of all the items, starting with element 0 (first element).
		    $rss_items = $rss->get_items( 0, $maxitems );

		endif;
?>

<div class="mod-rss gray-lighter-bg">
	<div class="container<?php echo $fluid; ?>">
		<?php if ( get_sub_field('section_name') ) : ?>
		<h2><?php echo strtoupper(get_sub_field('section_name')); ?></h2>
		<?php endif; ?>
		<?php if ( $maxitems == 0 ) : ?>
			<p class='no-stories'>No stories in feed.  
			<?php if (current_user_can('activate_plugins')) : ?>
				Stories can be <a href="wp-admin/admin.php?page=rss-app">added</a> in admin menu.
			<?php endif; ?>
			</p>
		<?php else : ?>
			<?php foreach ( $rss_items as $item ) : ?>
				<div class="rss-story-block">
					<a href="<?php echo esc_url( $item->get_permalink() ); ?>">
		<!-- ********** Picture functionality to be added later.
						If picture is present, add 'has-thumb' class to rss-text div below.
						<picture>
							<img src="http://placehold.it/300/c00" class="img-responsive" alt="" />
			*********** </picture> -->
						<div class="rss-text">
						<?php if ( get_sub_field('show_date') ) : ?>
							<time><?php echo $item->get_date('M j, Y'); ?></time>
						<?php endif; ?>	
							<h4><?php echo esc_html( $item->get_title() ); ?></h4>
							<p><?php echo wp_trim_words( esc_html($item->get_description()), 20, "<span style='color:#c00'> [&hellip;]</span>" ) ;?></p>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
				<div class="clearfix"></div>
		<?php 
			  if ( $maxitems >= 3 && get_sub_field('more_button') ) : 
		 		while ( have_rows('button_settings') ) : the_row();
		?>
				<a href="<?php echo esc_url( get_sub_field('button_link') ); ?>" class="btn btn-red rss-link"><?php the_sub_field("button_text"); ?><span class="glyphicon glyphicon-right-arrow"></span></a>
		<?php 		
		 		endwhile;
		 	  endif; 
		?>
	</div>
</div>