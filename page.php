<?php
require 'includes/layout.php';
get_header(); ?>
			
			<div class='l-header'>
				<div class='container'>
					<div class='page-lead'>
						<h1><?php echo get_the_title() ?></h1>
						<?php
							$ancestors = get_post_ancestors(get_the_ID());
							$parent_post = get_post(end($ancestors));
							
							if($section_description = get_post_meta(get_the_ID(), 'section_description', true)) {
								echo "<p>" . $section_description . "</p>";
							}
						?>
					</div>
				</div>
			</div>

			<div class='container'>
				<?php get_sidebar('page_left'); ?>
				<?php
					if(is_active_sidebar('page_left') && is_active_sidebar('page_right')):
						$width = 'half-width';
					elseif(is_active_sidebar('page_left') || is_active_sidebar('page_right')):
						$width = 'default-width';
					else:
						$width = 'full-width';
					endif;
				?>
				<section role="main" class='l-main page<?php echo " " . $width; ?>'>
					<?php 	
							if ( have_posts() ):
							    // get WP content
							    while ( have_posts() ) : the_post();
										the_content();
							    endwhile;
							else :
								//No content
							endif;	 
					?>
				</section>
				<?php get_sidebar('page_right'); ?>
			</div>

<?php get_footer(); ?>