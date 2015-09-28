<?php
include_once ('acf.php');
include_once ('includes/custom_fields.php');
include_once ('widgets/child_nav.php');
include_once ('includes/ncstate-responsive-images/ncstate-responsive-images.php');

get_template_part('functions', 'migrations');
get_template_part('functions', 'images');
get_template_part('functions', 'social');
get_template_part('functions', 'shortcodes');
get_template_part('functions', 'mobile-nav');

// Include OptionTree theme options
require (trailingslashit(get_template_directory()) . 'option-tree/ot-loader.php');
require (trailingslashit(get_template_directory()) . 'includes/theme-options.php');
add_filter('ot_show_pages', '__return_false');
add_filter('ot_theme_mode', '__return_true');
add_filter('ot_meta_boxes', '__return_false');

// Load styles
if (!function_exists('ncsu_theme_styles')) {
    
    function ncsu_theme_styles() {
        
        wp_register_style('ncstate-bootstrap', '//cdn.ncsu.edu/brand-assets/bootstrap/css/bootstrap.css', array(), null);
        wp_enqueue_style('ncstate-bootstrap');
        
        wp_register_style('theme-css', get_template_directory_uri() . '/style.css', array('ncstate-bootstrap'), null);
        wp_enqueue_style('theme-css');
        
        //Adding special styles for admin pages so that utility bar and WP menu bar don't overlap
        if (is_user_logged_in()) {
            wp_register_style('custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0');
            wp_enqueue_style('custom_wp_admin_css');
        }
    }
    add_action('wp_enqueue_scripts', 'ncsu_theme_styles');
}

// Load js
if (!function_exists('ncsu_theme_scripts')) {
    function ncsu_theme_scripts() {
        
        // Deregister the included library
        wp_deregister_script('jquery');
        
        // Register jQuery again from Google's CDN
        wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js', array(), null, true);
        
        wp_register_script('ncsu-bootstrap', 'https://cdn.ncsu.edu/brand-assets/bootstrap/js/bootstrap.min.js', array('jquery'), null, true);
        wp_enqueue_script('ncsu-bootstrap');
        
        /** 
        *   Uncomment to enqueue individual scripts (development)
        *
        */
        
        /*
         wp_register_script('theme-main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true);
         wp_enqueue_script('theme-main-js');
        
         wp_register_script('wp-mobile-nav', get_template_directory_uri() . '/js/ncstate-mobile-nav.js', array('jquery'), null, true);
         wp_enqueue_script('wp-mobile-nav');
        
         wp_register_script('picture-fill', get_template_directory_uri(). '/js/picturefill.min.js');
         wp_enqueue_script('picture-fill');

         */
        
        /**
        * Use minified js in production environments - 
        * Uncomment the lines below if using non-minified scripts
        *
        */
         
        wp_register_script('minified-js', get_template_directory_uri() . '/js/main.min.js', array('jquery'), null, true);
        wp_enqueue_script('minified-js');
    }
    add_action('wp_enqueue_scripts', 'ncsu_theme_scripts');
}

// Nav menus

if (!function_exists('ncsu_register_menus')) {
    
    register_nav_menu('primary', 'Primary website navigation');
    
    if (!class_exists('Sidebar_Walker_Level_Menu')):
        include_once ('includes/Sidebar_Walker_Level_Menu.php');
    endif;
    
    if (!class_exists('Mobile_Walker_Nav_Menu')):
        include_once ('includes/Mobile_Walker_Nav_Menu.php');
    endif;
    
    add_action('init', 'ncsu_register_menus');
}

/**
 * Register sidebars and widgetized areas.
 *
 */

if (!function_exists('ncsu_widgets_init')) {
    function ncsu_widgets_init() {
        
        register_sidebar(array('name' => 'Page Left Sidebar', 'id' => 'page_left', 'before_widget' => '<div class="sb-section %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',));
        register_sidebar(array('name' => 'Page Right Sidebar', 'id' => 'page_right', 'before_widget' => '<div class="sb-section %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',));
    }
    add_action('widgets_init', 'ncsu_widgets_init');
}

/**
 * Append arrow if necessary on Feature Content teaser text
 *
 */
if (!function_exists('append_arrow')) {
    
    function append_arrow($value, $arrow) {
        if ($value) {
            $autop = '';
            $value = trim($value);
            
            // Find last word start
            $last_word_start = strrpos($value, ' ');
            if ($last_word_start !== false) {
                
                // Add one to get the first letter of the last word
                $last_word_start++;
            } 
            else {
                
                // Only one word
                $last_word_start = 0;
            }
            
            // Handle auto p's for last word parsing
            if (strrpos($value, '</p>')) {
                $autop = '</p>';
                $last_word_end = strrpos($value, '</p>') - $last_word_start;
                $last_word = substr($value, $last_word_start, $last_word_end);
            } 
            else {
                $last_word = substr($value, $last_word_start);
            }
            
            // Join beginning of string to last word + arrow unit
            $value = substr($value, 0, $last_word_start) . '<span class=nowrap>' . $last_word . '<span class="glyphicon glyphicon-' . $arrow . '"></span></span>' . $autop;
        }
        return $value;
    }
}

// Allow iframes in TinyMCE editor
function fb_change_mce_options($initArray) {
    $ext = 'pre[id|name|class|style],iframe[align|longdesc| name|width|height|frameborder|scrolling|marginheight| marginwidth|src]';
    
    if (isset($initArray['extended_valid_elements'])) {
        $initArray['extended_valid_elements'].= ',' . $ext;
    } 
    else {
        $initArray['extended_valid_elements'] = $ext;
    }
    return $initArray;
}
add_filter('tiny_mce_before_init', 'fb_change_mce_options');

//assorted tweaks
if (!function_exists('get_post_thumbnail_caption')) {
    function get_post_thumbnail_caption() {
        if ($thumb = get_post_thumbnail_id()) {
            return get_post($thumb)->post_excerpt;
        }
    }
}

// Changing post excerpt length for index pages
function custom_excerpt_length($length) {
    return 15;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

