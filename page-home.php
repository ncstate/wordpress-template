<?php
/*
Template Name: Home Page
*/
require 'includes/layout.php';
date_default_timezone_set('America/New_York');

get_header();

	// loop through the rows of data
	while ( have_rows('banner') ) : the_row();
?>
		<div class="container<?php echo $fluid; ?>">
			<div class='<?php echo (get_sub_field('sidebar') ? "hp-banner split" : "hp-banner"); ?>'>

			<?php if ( get_sub_field('link_to') ) : ?>
				<a href="<?php echo esc_url( get_sub_field('link_to') ); ?>">
			<?php endif; ?>

					<picture>
						<?php $image = get_sub_field('image'); ?>
						<source srcset="<?php echo $image['sizes']['banner-lg-desktop']; ?>" media="(min-width: <?php echo $lg_breakpoint; ?>)">
						<source srcset="<?php echo $image['sizes']['banner-desktop']; ?>" media="(min-width: <?php echo $md_breakpoint; ?>)">
						<source srcset="<?php echo $image['sizes']['banner-sm-desktop']; ?>" media="(min-width: <?php echo $sm_breakpoint; ?>)Â">
						<source srcset="<?php echo $image['sizes']['banner-tablet']; ?>" media="(min-width: <?php echo $xs_breakpoint; ?>)?">
						<source srcset="<?php echo $image['sizes']['banner-phone']; ?>">
						<img src="<?php echo $image['sizes']['banner-desktop']; ?>" class="img-responsive" alt="<?php echo $image['alt']; ?>" />
					</picture>

			<?php if ( get_sub_field('headline') ) : ?>
					<div class="banner-action">
				<?php if ( ! get_sub_field('sidebar') ) : ?>
						<div class="container<?php echo $fluid; ?>">
				<?php endif; ?>

						<?php if ( get_sub_field('sub_heading') ) : ?>
							<div class="sub-head">
								<p><?php echo strtoupper(get_sub_field('sub_heading')); ?></p>
							</div>
						<?php endif; ?>

							<h2><?php the_sub_field('headline'); ?> 
							<?php if ( get_sub_field('link_to') ) : ?>
								<span class="glyphicon glyphicon-right-arrow-bkgrnd"></span>
							<?php endif; ?>
							</h2>
				<?php if ( ! get_sub_field('sidebar') ) : ?>
						</div>
				<?php endif; ?>
					</div>
			<?php endif; ?>

			<?php if ( get_sub_field('link_to') ) : ?>
				</a>
			<?php endif; ?>
			</div>

	<?php if ( get_sub_field('sidebar') ) : ?>
			<div class="hp-banner-sidebar">
	<?php			if( get_sub_field('sidebar_type') == 'rss' ):
					        	
					        // Get RSS Feed(s)
							include_once( ABSPATH . WPINC . '/feed.php' );

							while ( have_rows('sidebar_settings') ) : the_row();
	?>
					        	<div class="mod-rss">
									<?php if ( get_sub_field('sidebar_name') ) : ?>
										<h2><?php echo strtoupper(get_sub_field('sidebar_name')); ?></h2>
									<?php endif; ?>
				<?php 				
								// Get a SimplePie feed object from the specified feed source.
								add_filter( 'wp_feed_cache_transient_lifetime' , 'return_60' );
								$rss = fetch_feed( $rss_app_feed_url );
								remove_filter( 'wp_feed_cache_transient_lifetime' , 'return_60' );

									if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
										
									    // Figure out how many total items there are, but limit it to 2.
									    $maxitems = $rss->get_item_quantity( 2 );

									    // Build an array of all the items, starting with element 0 (first element).
									    $rss_items = $rss->get_items( 0, $maxitems );

									endif;

				?>
									<?php if ( $maxitems == 0 ) : ?>

											<p>No stories in feed.  Stories can be <a href="wp-admin/admin.php?page=rss-app">added</a> in admin menu.</p>

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
														<h4><?php echo esc_html( $item->get_title() ); ?></h4>
														<p><?php echo wp_trim_words( esc_html($item->get_description()), 15, "<span style='color:#c00'> [&hellip;]</span>" ) ;?></p>
													</div>
												</a>
											</div>
										<?php endforeach; ?>

		   							 <?php endif; ?>
											<div class="clearfix"></div>
									 <?php if ( $maxitems != 0 && get_sub_field('button') ) : 
									 			while ( have_rows('button_settings') ) : the_row();
									 ?>
											<a href="<?php echo esc_url( get_sub_field('button_link') ); ?>" class="btn btn-red rss-link"><?php the_sub_field("button_text"); ?><span class="glyphicon glyphicon-right-arrow"></span></a>
									 <?php 		
									 			endwhile;
									 		endif; 
									 ?>
								</div>
<?php						endwhile;

					else :
						while ( have_rows('sidebar_settings') ) : the_row();
?>
						<div class="mod-events is-vertical">
							<?php if ( get_sub_field('sidebar_name') ) : ?>
								<h2><?php echo strtoupper(get_sub_field('sidebar_name')); ?></h2>
							<?php endif; ?>

		<?php 					$events = array_reverse(events_calendar_get_upcoming_events(2)); 

								foreach($events as $event) :
		?>
						<?php if($event['url']) : ?>
							<a href="<?php echo $event['url']; ?>">
						<?php endif; ?>
								<div class="event-block">
									<div class="event-date">
										<?php 
											$time = strtotime($event['date']);
											echo "<time>" . date("M", $time) . "<span>" . date("j", $time) . "</span></time>";;
										?>
									</div>
									<div class="event-details">
										<p><strong><?php echo date("l", $time); ?></strong></p>
										<h4><?php echo $event['summary']; ?></h4>
										<p><?php echo (empty($event['location']) ? date("g:i a", $time) : date("g:i a", $time) . " | " . $event['location']); ?></p>
									</div>
								</div>
						<?php if($event['url']) : ?>
							</a>
						<?php endif; ?>

							<?php endforeach; ?>
								<div class="clearfix"></div>
							<?php if ( get_sub_field('button') ) : ?>
							<?php 	  while ( have_rows('button_settings') ) : the_row();   ?>
									<a href="<?php echo esc_url( get_sub_field('button_link') ); ?>" class="btn btn-red rss-link"><?php the_sub_field("button_text"); ?><span class="glyphicon glyphicon-right-arrow"></span></a>
							<?php 		
							 		  endwhile;
							 	   endif; 
							?>
						</div>
<?php
						endwhile;
					endif;
?>
				</div> <!-- end hp-banner-sidebar -->
<?php
			endif;
?>
		</div> <!-- end hp-banner container -->

<?php endwhile; ?>

	<section class="l-main">

	<?php   if( have_rows('page_content') ):
					 
			    // loop through the rows of data
			    while ( have_rows('page_content') ) : the_row();

			    	if( get_row_layout() == 'body_copy' ):
						
						include 'modules/body_copy.php';

					elseif ( get_row_layout() == 'cross-section_content'):
						
						include 'modules/cross_section.php';
 
			        elseif( get_row_layout() == 'story_feed' ):
			        	
			        	include 'modules/rss.php';

					elseif( get_row_layout() == 'generic_content' ):

						include 'modules/generic.php';
								
					elseif( get_row_layout() == 'social_media' ):
							
						include_once 'includes/social_media.php';
						include 'modules/social.php';

					elseif( get_row_layout() == 'events' ):

						include 'modules/events.php';
						
					endif;
					
				endwhile;
			 
			else :
			 
			    // no layouts found
			 
			endif;	 
	?>

	</section><!--.l-main-->

<?php get_footer(); ?>
