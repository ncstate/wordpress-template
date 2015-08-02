<?php date_default_timezone_set("America/New_York"); ?>

<div class="mod-social">
	<div class="container">
		<?php if ( get_sub_field('section_name') ) : ?>
			<h2><?php echo strtoupper(get_sub_field('section_name')); ?></h2>
		<?php endif; ?>
		<div class="social-feed">
			<div class="feed-container">
			<?php 
				$network = get_sub_field('social_network');
				if($network=='facebook'):
					$social_post = getFacebook(ot_get_option('facebook'));
					$suffix = "fb";
					echo '<pre>';
					var_dump($social_post);
					echo '</pre>';
				elseif($network=='twitter'):
					$social_post = getTwitter(ot_get_option('twitter'));
					$suffix = "twitter";
				endif;
				for($i=0; $i<3; $i++):
			?>
				<?php echo '<a href="' . $social_post[$i]['url'] . '">'; ?>
				<div class="social-block">
					<div class="social-date">
						<p><span class='glyphicon glyphicon-<?php echo $suffix ?>'></span><time><?php echo date("M j", $social_post[$i]['time']); ?></time></p>
					</div>
					<div class="social-details">
						<?php
						if($network=='twitter') {
							echo '<p>' . $social_post[$i]['description'] . '</p>';
						} else if($network=='facebook') {
							echo '<p>' . $social_post[$i]['message'] . '</p>';
						}
						?>
					</div>
				</div>
				<?php echo '</a>'; ?>
				<?php endfor; ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>