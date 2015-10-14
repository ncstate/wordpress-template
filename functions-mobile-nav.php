<?php

// Set global variable to open the right mobile menu location
// when rendering.
function ncstate_set_current_menu_item_ancestor_id( $sorted_menu_items )
{
    foreach ( $sorted_menu_items as $menu_item ) {
        if ( $menu_item->current_item_ancestor || ($menu_item->current && in_array('menu-item-has-children', $menu_item->classes)) ) {
            $GLOBALS['current_menu_item_ancestor_id'] = $menu_item->ID;
            break;
        }
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'ncstate_set_current_menu_item_ancestor_id' );


// Returns full mobile navigation code
function get_ncstate_mobile_nav($location = 'primary') {

    $level_1_args = array(
                        'theme_location' => $location,
                        'depth' => 1,
                        'menu_class' => 'list-unstyled',
                        'container' => false,
                        'walker' => new Mobile_Walker_Nav_Menu(),
                        'echo' => false
                    );
    $level_1_menu = wp_nav_menu($level_1_args);

    $level_2_args = array(
                        'theme_location' => $location,
                        'depth' => 0,
                        'items_wrap' => '%3$s',
                        'menu_class' => 'list-unstyled',
                        'container' => false,
                        'walker' => new Mobile_Walker_Nav_Menu(),
                        'echo' => false
                    );
    $level_2_menu = wp_nav_menu($level_2_args);

    // Set variable with data attribute for displaying current menu location
    if ( isset($GLOBALS['current_menu_item_ancestor_id']) ) {
        $submenu_id = " data-sub=\"#" . $GLOBALS['current_menu_item_ancestor_id'] . "-sub\"";
    } else {
        $submenu_id = '';
    }

    $output = '';

    $output .= "<div id=\"mobile-nav\"" . $submenu_id . ">\n";
    
    $output .= "\t<div id=\"level-1\">\n";
    $output .= "\t\t" . $level_1_menu . "\n";
    $output .= "\t</div>\n";

    $output .= "\t<div id=\"level-2\">\n";
    $output .= "\t\t<ul class=\"list-unstyled\">\n";
    $output .= "\t\t\t<li id=\"full-nav\">\n";
    $output .= "\t\t\t\t<button type=\"button\"><span class=\"glyphicon glyphicon-thin-chevron\"></span></button>\n";
    $output .= "\t\t\t\t<a href=\"#\">Full Site Navigation</a>\n";
    $output .= "\t\t\t</li>\n";
    $output .= "\t\t\t" . $level_2_menu . "\n";
    $output .= "\t\t</ul>\n";
    $output .= "\t</div>\n";

    $output .= "</div>\n";

    return $output;
}

// Optional helper
function ncstate_mobile_nav($location='') {
    echo get_ncstate_mobile_nav($location);
}