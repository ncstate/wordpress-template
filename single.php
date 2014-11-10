<?php 

require 'includes/layout.php';
get_header();

?>
		
		<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>
			
			<div class='l-header has-date'>
				<div class='container<?php echo $fluid; ?>'>
					<div class='page-lead'>
						<time class="hidden-xs"><?php
								echo str_replace(',','<br />', get_the_date('M j, Y','','', FALSE));
							 ?></time>
						<time class="visible-xs"><?php
								echo get_the_date('M j, Y','','', FALSE);
							 ?></time>
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
			</div>

			<div class='container<?php echo $fluid; ?>'>
				<section class='l-main post'>
					<?php if ( get_field('video_id') ) : ?>
						<div class="featured-video">
							<iframe width="960" height="720" src="<?php echo '//www.youtube.com/embed/' . get_field('video_id') . ''; ?>" frameborder="0" allowfullscreen></iframe>
						</div>
					<?php elseif ( has_post_thumbnail() ) : ?>
						<picture>
							<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'featured-lg-desktop'); ?>
							<source srcset="<?php echo $image[0]; ?>" media="(min-width: <?php echo $lg_breakpoint; ?>)">
							
							<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'featured-desktop'); ?>
							<source srcset="<?php echo $image[0]; ?>" media="(min-width: <?php echo $md_breakpoint; ?>)">
							
							<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'featured-sm-desktop'); ?>
							<source srcset="<?php echo $image[0]; ?>" media="(min-width: <?php echo $sm_breakpoint; ?>)">
							
							<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'featured-tablet'); ?>
							<source srcset="<?php echo $image[0]; ?>" media="(min-width: <?php echo $xs_breakpoint; ?>)">
							
							<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'featured-phone'); ?>
							<source srcset="<?php echo $image[0]; ?>">
								
							<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'featured-desktop'); ?>
							<img src="<?php echo $image[0]; ?>" class="img-responsive" />
						</picture>
					<?php endif; ?>
					<?php the_content(); ?>
				</section>

				<?php get_sidebar(); ?>
			</div>


			<!-- Related Posts -->
			<?php  
					    $orig_post = $post;  
					    global $post;  
					    $tags = wp_get_post_tags($post->ID);  
					      
					    if ($tags) {  
						    $tag_ids = array();  
						    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;  
						    $args = array(  
							    'tag__in' => $tag_ids,  
							    'post__not_in' => array($post->ID),  
							    'posts_per_page'=> 3, // Number of related posts to display.  
							    'ignore_sticky_posts'=> 1  
						    );  
						      
						    $my_query = new wp_query( $args );
						}
			?>

			<?php if (( ! $my_query==NULL) && ($my_query->have_posts())) : ?>
			<section class='related-stories blue-bg'>
				<div class='container<?php echo $fluid; ?>'>
					<h3>RELATED STORIES</h3>  
					<?php	  
						    while( $my_query->have_posts() ) {  
							    $my_query->the_post();  
					?>
							    <div class='rs-story'>
							    	<div class='rs-wrapper'>
								    	<h4><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h4>
								    		<?php the_excerpt(); ?>
								    </div>
							    </div>
					<?php 	
							}

					    $post = $orig_post;  
					    wp_reset_query();  
					?>
				</div>
			</section>
			<?php endif; ?>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>