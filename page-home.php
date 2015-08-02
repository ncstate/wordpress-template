<?php
/*
Template Name: Home Page
*/
require 'includes/layout.php';

//Eventuall remove after additional testing
//date_default_timezone_set('America/New_York');

get_header();

get_template_part('page', 'homepage-banner');

	?>

	<section class="main">

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
							
						include_once 'includes/ncstate-social-sdk/ncstate-social-sdk.php';
						include 'modules/social.php';

					elseif( get_row_layout() == 'events' ):

						include 'modules/events.php';
						
					endif;
					
				endwhile;
			 
			else :
			 
			    // no layouts found
			 
			endif;	 
	?>

	</section><!--.main-->

<?php get_footer(); ?>
