<aside class="l-sidebar">
	<div class='sb-section sb-social'>
		<h2>SHARE</h2>
		<ul>
			<li><a href='http://www.facebook.com/share.php?u=<?php echo the_permalink(); ?>' target="_blank"><span class="glyphicon glyphicon-fb"></span>Facebook</a></li>
			<li><a href='https://twitter.com/share?url=<?php echo the_permalink(); ?>' target="_blank"><span class="glyphicon glyphicon-twitter"></span>Twitter</a></li>
			<li><a href="mailto:?subject=<?php echo str_replace(" ", "%20", get_the_title()); ?>&body=<?php the_permalink(); ?>"><span class="glyphicon glyphicon-email"></span>Email</a></li>
		</ul>
	</div>
		<div class='sb-section sb-author'>
			<h2>AUTHOR</h2>
			<a href="mailto:<?php echo get_the_author_meta('user_email') . '?Subject=' . rawurlencode(get_the_title()); ?>"><?php the_author(); ?></a>
		</div>
		<div class='sb-section sb-category'>
			<h2>FILED UNDER</h2>
			<?php the_category(); ?>
		</div>
		<?php if (has_tag()) : ?>
		<div class='sb-section sb-tags'>
			<h2>TAGS</h2>
			<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
		</div>
		<?php endif; ?>
</aside>