<?php

require 'includes/layout.php';

get_header(); ?>

<?php $theme = get_option('ncstate_theme'); ?>

<div id="content" role="main">

		<div class='l-header'>
			<div class='container'>
				<div class='page-lead'>
		  		  <?php
		  			if(is_search()) :
		  				echo "<h1>Search Results</h1>";
		  			elseif(is_date()):
		  				if (is_day()):
		  					echo "<h1 class='primary-title'>Stories From " . get_the_date() . "</h1>";
		  				elseif (is_month()):
		  					echo "<h1 class='primary-title'>Stories From " . get_the_date('M Y') . "</h1>";
		  				elseif (is_year()):
		  					echo "<h1 class='primary-title'>Stories From " . get_the_date('Y') . "</h1>";
		  				endif;
		  			elseif(is_category()):
		  				echo "<h1>" . single_cat_title('', false) . "</h1>";
		  			else :
		  				echo "<h1>Results</h1>";
		  			endif;
		  			?>
				</div>
			</div>
		</div>

		<div class='container'>
			<section class='main'>
				<!-- Page Title -->
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<a href="<?php echo get_permalink(); ?>" class="archive">
						<?php if(has_post_thumbnail()): ?>
							<div class="archive-img">
								<?php $img_id = get_post_thumbnail_id($post->ID); ?>
								<?php echo get_retina_images($img_id, array(380, 324, 0, 0)); ?>
							</div>
						<?php endif; ?>
						<div class="archive-txt">
							<h6 class="archive-txt-meta"><?php echo get_the_date('M j, Y'); ?></h6>
							<h4 class="archive-txt-title"><?php echo get_the_title(); ?></h4>
							<p><?php echo append_arrow(get_the_excerpt(), 'thin-arrow'); ?></p>
						</div>
					</a>
				<?php endwhile; ?>

					<div class="archive-nav">
					  <?php if(get_previous_posts_link()): ?>
							<div class="archive-nav-older pull-left">
								<?php echo get_previous_posts_link('<span class="glyphicon glyphicon-roman-arrow reverse"></span>&nbsp;Newer Posts'); ?>
							</div>
						<?php endif; ?>
						<?php if(get_next_posts_link()): ?>
							<div class="archive-nav-older pull-right">
								<?php echo get_next_posts_link('Older Posts&nbsp;<span class="glyphicon glyphicon-roman-arrow"></span>'); ?>
							</div>
						<?php endif; ?>
					</div>

				<?php else : ?>
					<p>Sorry, no posts matched your criteria.</p>
					<form role="form" method="get" id="archive-searchform" action="<?php echo get_option('ncstate_news_url'); ?>">
						<div class="input-group">
							<label class="sr-only" for="searchInput">Search for:</label>
		            		<input type="text" id="searchInput" class="form-control" value="" name="s" id="s">
		                	<span class="input-group-btn">
		                		<button type="submit" class="btn btn-default" id="searchsubmit"><span class="glyphicon glyphicon-search" data-alt="Submit search"></span></button>
		                	</span>
		                </div>
		             </form>
				<?php endif; ?>
			</section>
			
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
