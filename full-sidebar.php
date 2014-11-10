<aside class="l-sidebar full-sb">
	<div class='sb-section sb-social'>
		<h5>Follow Us</h5>
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
	</div>
	<div class='sb-section sb-category'>
		<h5>Top Categories</h5>
		<ul>
			<?php wp_list_categories('show_count=1&orderby=count&order=DESC&title_li=') ?>
		</ul>
		<a href="javascript:show_cats()" class="show_cats">+See all categories</a>
	</div>
	<div class='sb-section sb-tags'>
		<h5>Top Tags</h5>
		<ul>
			<?php wp_list_categories('show_count=1&orderby=count&order=DESC&title_li=&taxonomy=post_tag') ?>
		</ul>
		<a href="javascript:show_tags()" class="show_tags">+See all tags</a>
	</div>
	<?php if ( ! is_archive()) : ?>
	<div class='sb-section sb-archives'>
		<a href="javascript:show_months()" class="show_months">+Yearly News Archive</a>
		<div class="year-month">
			<h5>Yearly Archive</h5>
			<?php get_year_month_archive(); ?>
		</div>
	</div>
	<?php endif; ?>
</aside>