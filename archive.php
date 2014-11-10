<?php
require 'includes/layout.php';
get_header(); ?>

<?php $theme = get_option('ncstate_theme'); ?>

<div id="content" role="main">

		<div class='l-header'>
			<div class='container<?php echo $fluid; ?>'>
				<div class='page-lead'>
					<h1>Archives</h1>
				</div>
			</div>
		</div>

		<div class='container<?php echo $fluid; ?>'>
			<section class='l-main archive'>
				<!-- Page Title -->
	        
	        <?php 
	            $first = true; 
	            $pageNum = 1;
	        ?>
	        
	        <?php if(is_author()): ?>
	            
	            <?php if (have_posts()): ?>
	                
	                <?php the_post(); ?>
	            
	                <?php $author = get_the_author_meta('display_name'); ?>
	                <?php $pageNum = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
	                <?php if($pageNum > 1){ $first = false; } ?>
				    <h2>Recent Stories From <?php echo $author; ?> <?php if(is_paged() && $first == false){ echo "&mdash; Page " . $pageNum;  }?></h2>
	        
	            <?php endif;?>
	        
	             <?php rewind_posts(); ?> 
	        
	        <?php elseif(is_date()): ?>
	            
	        	<?php 
					if ( is_day() ) :
						$title = "Stories From <span>" . get_the_date() . "</span>";
					elseif ( is_month() ) :
						$title = "Stories From <span>" . get_the_date('F Y') . "</span>";
					elseif ( is_year() ) :
						$title = "Stories From <span>" . get_the_date('Y') . "</span>";
					endif;
				?>
				<?php $first = false; ?>
				<?php $pageNum = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
				<h2><?php echo $title; ?>  <?php if(is_paged() && $first == false){ echo "&mdash; Page " . $pageNum;  }?></h2>
	        
	        <?php elseif(is_tag()): ?>
	        
	            <?php $first = false; ?>
			
				<?php //if(!is_paged()) : ?>
					<?php $pageNum = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
					<h2>Stories Tagged &lsquo;<?php single_cat_title(); ?>&rsquo; <?php if(is_paged() && $first == false){ echo "&mdash; Page " . $pageNum;  }?></h2>
				<?php //endif; ?>
	        
	        <?php else: ?>
	        
	            <?php $first = false; ?>
			
				<?php //if(!is_paged()) : ?>
					<?php $pageNum = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
					<h2>Recent <?php single_cat_title(); ?> Stories <?php if(is_paged() && $first == false){ echo "&mdash; Page " . $pageNum;  }?></h2>
				<?php //endif; ?>
	        
	        <?php endif; ?>
    	    
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

                        } else {

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

                        }
                    ?>
    			    
    			<?php endwhile; ?>

    			<?php
					global $wp_query;

					$big = 999999999; // need an unlikely integer

					$list = paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $wp_query->max_num_pages,
								'type' => 'list',
								'prev_text' => '&laquo;',
								'next_text' => '&raquo;',
								'before_page_number' => '<span class="sr-only">Page</span>'
							) );
					echo str_replace( "<ul class='page-numbers'>", '<ul class="page-numbers pagination" aria-label="Page nagivation">', $list);
				?>
    			
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
</script>

<?php get_footer(); ?>
