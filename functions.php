<?php

	include "acf.php";
	include "includes/custom_fields.php";
	include "includes/Sidebar_Walker_Level_Menu.php";
	include "widgets/child_nav.php";
	include "includes/ncstate-responsive-images/ncstate-responsive-images.php";
	
	// Include OptionTree theme options
	require( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );
	require( trailingslashit( get_template_directory() ) . 'includes/theme-options.php' );
	add_filter( 'ot_show_pages', '__return_false' );
	add_filter( 'ot_theme_mode', '__return_true' );
	add_filter( 'ot_meta_boxes', '__return_false' );

	get_template_part('functions','migrations');
	get_template_part('functions','images');
	get_template_part('functions','social');
	get_template_part('functions','shortcodes');
	get_template_part('functions','mobile-nav');

	// register mobile nav js
	wp_register_script('wp-mobile-nav', get_template_directory_uri().'/js/ncstate-mobile-nav.js','','',true);
	wp_enqueue_script('wp-mobile-nav');

	// register NC State left nav widget
	function register_ncstate_child_nav_widget() {
	    register_widget( 'NCState_Child_Nav' );
	}
	add_action( 'widgets_init', 'register_ncstate_child_nav_widget' );

	// Changing post excerpt length for index pages
	function custom_excerpt_length( $length ) {
		return 15;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

	// Allow iframes in TinyMCE editor
	function fb_change_mce_options($initArray) {
		$ext = 'pre[id|name|class|style],iframe[align|longdesc| name|width|height|frameborder|scrolling|marginheight| marginwidth|src]';

		if ( isset( $initArray['extended_valid_elements'] ) ) {
			$initArray['extended_valid_elements'] .= ',' . $ext;
		} else {
			$initArray['extended_valid_elements'] = $ext;
		}
		return $initArray;
	}
	add_filter('tiny_mce_before_init', 'fb_change_mce_options');

	// Setting menu location for main, horizontal navigation
	function register_my_menus() {
		$menus['primary-menu'] = "Primary";
		register_nav_menus($menus);
	}
	add_action( 'init', 'register_my_menus' );

	/**
	* Register sidebars and widgetized areas.
	*
	*/
	function ncsu_widgets_init() {

		register_sidebar( array(
			'name' => 'Page Left Sidebar',
			'id' => 'page_left',
			'before_widget' => '<div class="sb-section %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		) );
		register_sidebar( array(
			'name' => 'Page Right Sidebar',
			'id' => 'page_right',
			'before_widget' => '<div class="sb-section %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		) );
	}
	add_action( 'widgets_init', 'ncsu_widgets_init' );

	//Adding special styles for admin pages so that utility bar and WP menu bar don't overlap
	if(is_user_logged_in()) {
		wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_css' );
	}

	// Append arrow if necessary on Feature Content teaser text
	function append_arrow( $value, $arrow ) {
	    if($value) {

	        $autop = '';
	        $value = trim($value);
        
	        // Find last word start
	        $last_word_start = strrpos($value, ' ');
	        if($last_word_start !== false) {
	            // Add one to get the first letter of the last word
	            $last_word_start++;
	        } else {
	            // Only one word
	            $last_word_start = 0;
	        }

	        // Handle auto p's for last word parsing
	        if( strrpos($value, '</p>') ) {
	            $autop = '</p>';
	            $last_word_end = strrpos($value, '</p>') - $last_word_start;
	            $last_word = substr( $value, $last_word_start, $last_word_end );
	        } else {
	            $last_word = substr( $value, $last_word_start );
	        }


	        // Join beginning of string to last word + arrow unit
	        $value = substr( $value, 0, $last_word_start ) . 
	                '<span class=nowrap>' .
	                    $last_word .
	                '<span class="glyphicon glyphicon-' . $arrow . '"></span></span>' . $autop;
	    }
	    return $value;
	}
