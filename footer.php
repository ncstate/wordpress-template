<?php require 'includes/layout.php'; ?>
	<footer>
		<div class="container main-footer">
			<div class="footer-address">
				<p class="footer-title"><?php bloginfo('name'); ?></p>
				<address>
					<?php echo(ot_get_option('address')); ?>
				</address>
			</div>
			<ul class="social" aria-label="Social media links">
				<?php if(ot_get_option('facebook')!=NULL) {
					echo '<li><a href="https://www.facebook.com/' . ot_get_option('facebook') . '"><span class="glyphicon glyphicon-fb"></span>Facebook</a></li>';
				}
				if(ot_get_option('twitter')!=NULL) {
					echo '<li><a href="http://www.twitter.com/' . ot_get_option('twitter') . '"><span class="glyphicon glyphicon-twitter"></span>Twitter</a></li>';
				}
				if(ot_get_option('instagram')!=NULL) {
					echo '<li><a href="http://instagram.com/' . ot_get_option('instagram') . '"><span class="glyphicon glyphicon-instagram"></span>Instagram</a></li>';
				}
				if(ot_get_option('youtube')!=NULL) {
					echo '<li><a href="http://www.youtube.com/user/' . ot_get_option('youtube') . '"><span class="glyphicon glyphicon-youtube"></span>YouTube</a></li>';
				} ?>
			</ul>				
			<ul class="resources ncstate-padded-list" aria-label="Additional resources">
				<?php
				$links = ot_get_option('resource_links');
				if ($links !== NULL) {
					$num = count($links);
					$i=1;
					foreach($links as $link) {
						if ( ! empty($link)) {
							echo '<li><a href="' . $link['url'] . '">' . $link['title'] . '</a></li>';
						}
						if($i==ceil($num/2)) {
							echo '</ul>';
							echo '<ul class="resources ncstate-padded-list" aria-label="Additional resources continued">';
						}
						$i++;
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

	<?php if (ot_get_option('ga_id')) : ?>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', <?php echo '\'' . ot_get_option('ga_id') . '\''; ?>, 'auto');
	ga('send', 'pageview');

	</script>
	<?php endif; ?>
	<?php wp_footer(); ?> 
	
	</div> <!--mobile-nav-slide-out -->
</body>
</html>