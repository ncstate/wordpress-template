<?php
/*
Template Name: Page with Nav
*/
require 'includes/layout.php';
get_header(); ?>
			
			<div class='l-header'>
				<div class='container<?php echo $fluid; ?>'>
					<div class='page-lead'>
						<h1><?php echo get_the_title() ?></h1>
						<?php
							$ancestors = get_post_ancestors(get_the_ID());
							$parent_post = get_post(end($ancestors));
							
							if(get_field('section_description')) {
								echo "<p>" . get_field('section_description') . "</p>";
							}
						?>
					</div>
				</div>
			</div>

			<div class='container<?php echo $fluid; ?>'>
				
				<?php 
						/* For left nav version */
						//if($layout=="horiz") : 
				?>
				
				<nav class="side-navigation hidden-xs hidden-sm">
					<?php 
						if(has_nav_menu($parent_post->post_name.'-menu')) {
							$args = array(
								'theme_location' => $parent_post->post_name.'-menu',
								'container' => false,
								'menu_class' => 'list-unstyled',
								'title_li' => false,
								'depth' => 2
								);
						
							wp_nav_menu($args);
						}
					?>
				</nav>
				
				<?php //endif; ?>
				
				<?php
					if(has_nav_menu($parent_post->post_name.'-menu')) {
						echo "<section class='l-main page-nav'>";
					} else {
						echo "<section class='l-main page-nav full-width'>";
					}	
				?>
					<?php 	
							if ( have_rows('page_content') || have_posts() ):
					 
							    // get WP content
							    while ( have_posts() ) : the_post();
									if ( get_the_content() ) :
							 	
							    	echo "<div class='body-copy'>";
								    echo 	'<div class="bc-container">';
								    echo 		the_content();
								    echo 	'</div>';
								    echo '</div>';

								    endif;
							    endwhile;

							     // loop through the rows of ACF data
							    while ( have_rows('page_content') ) : the_row();
							 
							        if( get_row_layout() == 'body_copy' ):
							 
							        	echo "<div class='body-copy'>";
							        	echo 	'<div class="bc-container">';
							        	echo 		get_sub_field('text');
							        	echo 	"</div>";
							        	echo "</div>";

							        elseif ( get_row_layout() == 'cross-section_content'): 

							        	include 'modules/cross_section.php'; 

									endif;
							 
							    endwhile;
						 
							else :

								//No content

							endif;	 
					?>

				</section>
			</div>

<?php get_footer(); ?>