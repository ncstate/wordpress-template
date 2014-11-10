<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>

	<div class='l-header'>
		<div class='container'>
			<div class='page-lead'>
				<h2>Not Found</h2>
			</div>
		</div>
	</div>

	<div class='container'>

			<section class="l-main post">
				<p>It looks like nothing was found at this location. Maybe try a search?</p>

				<?php get_search_form(); ?>
				<br/>
				<br/>
				<br/>
			</section><!-- .l-main -->
	</div><!-- #container -->

<?php
get_footer();