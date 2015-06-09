<?php 

// 1. customize ACF path
add_filter('acf/settings/path', 'campus_template_acf_settings_path');

function campus_template_acf_settings_path( $path ) {
    // update path
    $path = get_template_directory() . '/acf/';
    
    // return
    return $path;
    
}
 

// 2. customize ACF dir
add_filter('acf/settings/dir', 'campus_template_acf_settings_dir');
 
function campus_template_acf_settings_dir( $dir ) {
    // update path
    $dir = get_template_directory_uri() . '/acf/';
    
    // return
    return $dir;
    
}
 

// 3. Hide ACF field group menu item
//add_filter('acf/settings/show_admin', '__return_false');


if( !class_exists('acf') ):
	// 4. Include ACF
	include_once( get_template_directory() . '/acf/acf.php' );
endif;