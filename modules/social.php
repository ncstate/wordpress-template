<?php date_default_timezone_set("America/New_York"); ?>

<div class="mod-social gray-lighter-bg">
	<div class="container<?php echo $fluid; ?>">
		<?php if ( get_sub_field('section_name') ) : ?>
			<h2><?php echo strtoupper(get_sub_field('section_name')); ?></h2>
		<?php endif; ?>
		<div class="social-feed">
			<div class="feed-container">
			<?php 
					$social = getSocial(get_sub_field('social_networks'));
					$num_of_posts = 3;
					for($i=0; $i<$num_of_posts; $i++) :
						$social_post = $social[$i];
						$suffix = null;
						if($social_post['type']=='facebook') {
							$suffix="fb";
							if(!$social_post['description']) {
								$num_of_posts++;
								continue;
							}
						} else if($social_post['type']=='twitter') {
							$suffix="twitter";
						} else if($social_post['type']=='instagram') {
							$suffix="instagram";
						}
			?>
				<?php echo '<a href="' . $social_post['url'] . '">'; ?>
				<div class="social-block">
					<div class="social-date">
						<p><span class='glyphicon glyphicon-<?php echo $suffix ?>'></span><time><?php echo date("M j", $social_post['time']); ?></time></p>
					</div>
					<div class="social-details">
						<?php
						if($social_post['type']=='instagram') {
							echo '<img src="' . $social_post['img'] . '" alt="" />';
						} else if($social_post['type']=='twitter') {
							echo '<p>' . $social_post['description'] . '</p>';
							if($social_post['media'][0]->type == 'photo') {
								echo '<img src="' . $social_post['media'][0]->media_url . ':small" />';
							}
						} else if($social_post['type']=='facebook') {
							echo '<p>' . $social_post['description'] . '</p>';
							echo '<img src="' . $social_post['img'] . '" alt="" />';
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