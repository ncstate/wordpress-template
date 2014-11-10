<div class="mod-events gray-lighter-bg">
	<div class="container<?php echo $fluid; ?>">
	<?php if ( get_sub_field('section_name') ) : ?>
		<h2><?php echo strtoupper(get_sub_field('section_name')); ?></h2>
	<?php endif; ?>

<?php 	
	$events = events_calendar_get_upcoming_events(3); 

	foreach($events as $event) :
?>
		
<?php if($event['url']) : ?>
	<a href="<?php echo $event['url']; ?>">
<?php endif; ?>
		<div class="event-block">
			<div class="event-date">
				<time>
				<?php 
					$time = strtotime($event['date']);
					echo date("M j", $time);
				?>
				</time>
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
	<?php if ( get_sub_field('button') && sizeof($events) >= 3 ) : ?>
		<?php while ( have_rows('button_settings') ) : the_row(); ?>
			<a href="<?php echo esc_url( get_sub_field('button_link') ); ?>" class="btn btn-red rss-link"><?php the_sub_field("button_text"); ?><span class="glyphicon glyphicon-right-arrow"></span></a>
		<?php endwhile; ?>
	 <?php endif; ?>
	</div>
</div>