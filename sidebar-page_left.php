<?php if ( is_active_sidebar( 'page_left' ) ) : ?>
	<aside id="left-sidebar" class="l-sidebar" role="complementary">
		<?php dynamic_sidebar( 'page_left' ); ?>
	</aside>
<?php endif; ?>