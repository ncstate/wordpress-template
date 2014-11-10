<?php if ( is_active_sidebar( 'page_sidebar' ) ) : ?>
	<aside class="l-sidebar" role="complementary">
		<?php dynamic_sidebar( 'page_sidebar' ); ?>
	</aside>
<?php endif; ?>