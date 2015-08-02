<?php
		// Get RSS Feed(s)
		include_once( get_template_directory() . '/includes/rss/rss.php' );

		$feed_output = load_rss_feed(array('source' => get_sub_field('feed_url')));

?>

<div class="mod-rss">
	<div class="container">
		<?php if ( get_sub_field('section_name') ) : ?>
		<h2><?php echo strtoupper(get_sub_field('section_name')); ?></h2>
		<?php endif; ?>
		<?php if (count($feed_output->channel->item)<=0) : ?>
			<p class='no-stories'>No stories in feed.
			</p>
		<?php else : ?>
			<?php for( $i=0; $i<3; $i++ ) : ?>
				<?php $item = $feed_output->channel->item[$i] ?>
				<div class="rss-story-block">
					<a href="<?php echo esc_url( $item->link ); ?>">
						<div class="rss-text">
						<?php if ( get_sub_field('show_date') ) : ?>
							<time><?php echo date('M j, Y', strtotime($item->pubDate)); ?></time>
						<?php endif; ?>	
							<h4><?php echo esc_html( $item->title ); ?></h4>
							<p><?php echo wp_trim_words( esc_html((string)$item->description), 20, "<span style='color:#c00'> [&hellip;]</span>" ) ;?></p>
						</div>
					</a>
				</div>
			<?php endfor; ?>
		<?php endif; ?>
				<div class="clearfix"></div>
		<?php 
			  if ( get_sub_field('more_button') ) : 
		 		while ( have_rows('button_settings') ) : the_row();
		?>
				<a href="<?php echo esc_url( get_sub_field('button_link') ); ?>" class="btn btn-red rss-link"><?php the_sub_field("button_text"); ?><span class="glyphicon glyphicon-right-arrow"></span></a>
		<?php 		
		 		endwhile;
		 	  endif; 
		?>
	</div>
</div>