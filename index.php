<?php
/*
Template Name: News
*/
require 'includes/layout.php';

get_header(); ?>

<?php $theme = get_option('ncstate_theme'); ?>

<div id="content" role="main">

		<?php the_post(); ?>
		<div class='l-header'>
			<div class='container<?php echo $fluid; ?>'>
				<div class='page-lead'>
					<h1><?php echo get_the_title(); ?></h1>
				</div>
			</div>
		</div>

		<div class='container<?php echo $fluid; ?>'>
			<section class='l-main archive'>
				<!-- Page Title -->
	        
	        <?php
	            $pageNum = 1;
				query_posts( 'posts_per_page=7' );
	        ?>
	        
    	    
	        <!-- Recent Posts -->
	        <?php if (have_posts()): ?>
	            
	            <? $cnt = 0; ?>

    			<?php while (have_posts()) : the_post(); ?>
    			    
    			    <?php 
    			    
    			        $cnt++;
        			   // $large = get_field('picHome');

                        if($cnt == 1 && $pageNum == 1){

                            echo '<article class="featured">';
                            echo '<a href="' . get_permalink() . '">';
                            echo get_the_post_thumbnail(get_the_ID(), 'large');
							echo the_date('M j, Y','<h6>','</h6>', FALSE);
                            echo '<h4>' . get_the_title() .'</h4>';
                            echo '<p class="teaser">' . get_the_excerpt() . '</p>';
                            echo '</a>';
                            echo '</article>';
                            
                            $first = false;

                        } else if($cnt < 5){

                            if ( get_post_thumbnail_id($post->ID) ){
                                $thumb_class = 'has-thumb';
                                $thumb = get_post_thumbnail_id($post->ID);
                            }
                            else {
                                $thumb_class = '';
                            }

                            echo '<article>';
                            echo '<a href=' . get_permalink() . '>';

                            if ($thumb_class === 'has-thumb') {
                            echo '<picture>';
                                      $image = wp_get_attachment_image_src($thumb, 'thumbnail');
                            echo      '<source srcset="' . $image[0] . '" media="(min-width: ' . $xs_breakpoint. ')">';
                                        
                                      $image = wp_get_attachment_image_src($thumb, 'featured-phone');
                            echo      '<source srcset="' . $image[0] . '">';
                                            
                                      $image = wp_get_attachment_image_src($thumb, 'thumbnail');
                            echo      '<img src="' . $image[0] . '" class="img-responsive" />';
                            echo  '</picture>';
                            }

                            echo '<div class="article-details ' . $thumb_class . '">';
                            echo the_date('M j, Y','<h6>','</h6>', FALSE);
                            echo '<h4>' . get_the_title() .'</h4>';
                            echo '<p class="teaser">' . get_the_excerpt() . '</p>';
                            echo '</div>';
                            echo '<div class="clearfix"></div>';
                            echo '</a>';
                            echo '</article>';

                        } else {
                        	break;
                        }
                    ?>
    			    
    			<?php endwhile; ?>
    			
    		<?php else: ?>
    			
    			<p class="no-posts"><strong>No posts were found matching the current request.</strong> Trying using the categories and dates below.</p>
    			
    		<?php endif; ?>
			</section>
			
			<?php include 'full-sidebar.php'; ?>
		</div>

</div><!-- #content -->

<script type="text/javascript">
	function show_cats() {
		$('a.show_cats').css('display','none');
		$('.sb-category li').css('display','block');
	}

	function show_tags() {
		$('a.show_tags').css('display','none');
		$('.sb-tags li').css('display','block');
	}

	function show_months() {
		$('a.show_months').css('display','none');
		$('.year-month').css('display','block');
	}
</script>

<?php get_footer(); ?>
