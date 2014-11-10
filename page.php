<?php
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

			<div class='container'>
				<section role="main" class='l-main page'>
					<?php 	
							if ( have_rows('page_content') || have_posts() ):
							    // get WP content
							    while ( have_posts() ) : the_post();
										the_content();
							    endwhile;

							     // loop through the rows of ACF data
							    while ( have_rows('page_content') ) : the_row();
							 
							        if( get_row_layout() == 'body_copy' ):
							        	echo get_sub_field('text');
							        elseif ( get_row_layout() == 'cross-section_content'): 
							        	include 'modules/cross_section.php'; 
											endif;
							 
							    endwhile;
							else :
								//No content
							endif;	 
					?>
				</section>
				<?php get_sidebar("page"); ?>
			</div>

<?php get_footer(); ?>