<?php if ( is_active_sidebar( 'page_right' ) ) : ?>
	<aside id="right-sidebar" class="l-sidebar" role="complementary">
		<?php dynamic_sidebar( 'page_right' ); ?>
	</aside>
<?php endif; ?>