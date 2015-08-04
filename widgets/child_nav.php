<?php

class NCState_Child_Nav extends WP_Widget {
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
					'ncstate_child_nav', // Base ID
					'NC State Child Page Navigation', // Name
					array( 'description' => 'Displays subnav of toplevel page' ) // Args
				);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		extract($args);
		
		echo $before_widget;
		$args = array(
			'theme_location' => 'primary-menu',
			'depth' => 3,
			'walker' => new Sidebar_Walker_Level_Menu(),
		);
		echo wp_nav_menu($args);
		echo $after_widget;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}