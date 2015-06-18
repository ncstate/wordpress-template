<?php 
if ( ! class_exists('acf')) :

    // 1. customize ACF path
    add_filter('acf/settings/path', 'events_calendar_acf_settings_path');

    function events_calendar_acf_settings_path( $path ) {
     
        // update path
        $path = plugin_dir_path(__FILE__) . 'acf/';
        
        // return
        return $path;
        
    }
     

    // 2. customize ACF dir
    add_filter('acf/settings/dir', 'events_calendar_acf_settings_dir');
     
    function events_calendar_acf_settings_dir( $dir ) {
     
        // update path
        $dir = plugin_dir_url(__FILE__) . 'acf/';
        
        // return
        return $dir;
        
    }

    // 3. Hide ACF field group menu item
    add_filter('acf/settings/show_admin', '__return_false');

    // 4. Include ACF
    include_once( plugin_dir_path(__FILE__) . 'acf/acf.php' );

endif;

if ( ! class_exists('acf_field_date_time_picker_plugin')) :

    include_once( plugin_dir_path(__FILE__) . 'acf-field-date-time-picker/acf-date_time_picker.php');

endif;