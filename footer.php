<?php require 'includes/layout.php'; ?>
<?php $theme = get_option('ncstate_theme'); ?>
<?php if($layout=="left") : ?>
		</div> <!-- end .main-content-container -->	
<?php endif; ?>
	<footer>
		<div class="container<?php echo $fluid; ?> main-footer">
			<div class="footer-address">
				<p class="footer-title"><?php bloginfo('name'); ?></p>
				<address>
					<?php echo($theme['opt-contact']) ?>
				</address>
			</div>
			<ul class="social" aria-label="Social media links">
				<?php if($theme['opt-facebook']!=NULL) {
					echo '<li><a href="https://www.facebook.com/' . $theme['opt-facebook'] . '"><span class="glyphicon glyphicon-fb"></span>Facebook</a></li>';
				}
				if($theme['opt-twitter']!=NULL) {
					echo '<li><a href="http://www.twitter.com/' . $theme['opt-twitter'] . '"><span class="glyphicon glyphicon-twitter"></span>Twitter</a></li>';
				}
				if($theme['opt-instagram']!=NULL) {
					echo '<li><a href="http://instagram.com/' . $theme['opt-instagram'] . '"><span class="glyphicon glyphicon-instagram"></span>Instagram</a></li>';
				}
				if($theme['opt-youtube']!=NULL) {
					echo '<li><a href="http://www.youtube.com/user/' . $theme['opt-youtube'] . '"><span class="glyphicon glyphicon-youtube"></span>YouTube</a></li>';
				} ?>
			</ul>				
			<ul class="resources ncstate-padded-list" aria-label="Additional resources">
				<?php 
				if ($theme['opt-resources-col-1'] !== NULL) {
					foreach($theme['opt-resources-col-1'] as $link) {
						if ( ! empty($link)) {
							$content = explode("##", $link);
							if(strpbrk($content[1],"http://")===false || strpbrk($content[1],"https://")===false) {
								echo '<li><a href="http://' . $content[1] . '">' . $content[0] . '</a></li>';
							} else {
								echo '<li><a href="' . $content[1] . '">' . $content[0] . '</a></li>';
							}
						}
					}
				} 
				?>
			</ul>
			<ul class="resources ncstate-padded-list" aria-label="Additional resources continued">
				<?php 
				if ($theme['opt-resources-col-2'] !== NULL) {
					foreach($theme['opt-resources-col-2'] as $link) {
						if ( ! empty($link)) {
							$content = explode("##", $link);
							if(strpbrk($content[1],"http://")===false || strpbrk($content[1],"https://")===false) {
								echo '<li><a href="http://' . $content[1] . '">' . $content[0] . '</a></li>';
							} else {
								echo '<li><a href="' . $content[1] . '">' . $content[0] . '</a></li>';
							}
						}
					} 
				}
				?>
			</ul>
		</div>
		<div class="sub-footer">
			<div class="container<?php echo $fluid; ?>">
				<h4><strong>NC STATE</strong> UNIVERSITY</h4>
				<address>
					<span><strong>NORTH CAROLINA STATE UNIVERSITY</strong></span>
					<span>RALEIGH, NC 27695</span>
					<span>919.515.2011</span>
				</address>
			</div>
		</div>
	</footer>

	<!-- jQuery 2.1.0 -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://cdn.ncsu.edu/brand-assets/bootstrap/js/bootstrap.min.js"></script>

	<script src='<?php bloginfo('template_directory'); ?>/js/main.js'></script>


	<?php 
			if ($theme['opt-tracking-code']!=NULL) :
				echo $theme['opt-tracking-code'];
		  	endif; 
	?>
	<?php wp_footer(); ?> 
</body>
</html>