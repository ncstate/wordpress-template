<?php

    /** 
     **  This file is organized in 5 main components:
     ** 
     **  i.   Wordpress Resets
     **  ii.  Custom Post Types
     **  iii. Custom Taxonomies
     **  iv.  Theme Functions
     **  v.   Short Codes
     ** 
     **/
	
	date_default_timezone_set('America/New_York');

     include "includes/phpFlickr/phpFlickr.php";
	 include "acf.php";
	 include "includes/custom_fields.php";
	 
	 // Include OptionTree theme options
	 require( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );
	 require( trailingslashit( get_template_directory() ) . 'includes/theme-options.php' );
	 add_filter( 'ot_show_pages', '__return_false' );
	 add_filter( 'ot_theme_mode', '__return_true' );
	 add_filter( 'ot_meta_boxes', '__return_false' );

    /*****************************************************************************
     ** i.   Wordpress Resets 
     *****************************************************************************/

     ## Resource: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters

    function return_2( $seconds ) {
      // change the default feed cache recreation period to 2 seconds
      return 2;
    }

    function custom_excerpt_length( $length ) {
        return 15;
    }
    add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

      
    /*****************************************************************************
     ** ii.   Custom Post Types
     *****************************************************************************/
     
     ## Documentation: http://codex.wordpress.org/Post_Types
      
      
    /*****************************************************************************
     ** iii.  Custom Taxonomies
     *****************************************************************************/
     
     ## Documentation: http://codex.wordpress.org/Taxonomies
      
      
    /*****************************************************************************
     ** iv.  Theme Functions
     *****************************************************************************/

     ## FYI: http://codex.wordpress.org/Functions_File_Explained

	add_theme_support( 'post-thumbnails' );
	add_image_size('banner-phone',480,192,true);
	add_image_size('banner-tablet',768,307,true);
	add_image_size('banner-sm-desktop',992,397,true);
	add_image_size('banner-desktop',1200,480,true);
	add_image_size('banner-lg-desktop',1500,600,true);
	add_image_size('callout-phone',480,270,true);
    add_image_size('callout-tablet',768,432,true);
    add_image_size('callout-sm-desktop',400,265,true);
    add_image_size('callout-desktop',400,265,true);
    add_image_size('callout-lg-desktop',625,490,true);
	add_image_size('generic-phone',480,270,true);
    add_image_size('generic-tablet',768,432,true);
    add_image_size('generic-sm-desktop',240,135,true);
    add_image_size('generic-desktop',315,177,true);
    add_image_size('generic-lg-desktop',500,281,true);
	add_image_size('featured-phone',480,270,true);
    add_image_size('featured-tablet',768,432,true);
    add_image_size('featured-sm-desktop',705,397,true);
    add_image_size('featured-desktop',745,419,true);
    add_image_size('featured-lg-desktop',1100,619,true);

    //Allow iframes
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
	
	function remove_default_image_sizes($sizes) {
	    unset( $sizes['medium']);
	    unset( $sizes['large']);
		unset( $sizes['news']);
     
		$myimgsizes = array(
			"phone" => __( "Phone" ),
			"tablet" => __( "Tablet" ),
			"desktop" => __( "Desktop" )
		);
		$newimgsizes = array_merge($sizes, $myimgsizes);
		return $newimgsizes;
	}
	add_filter('image_size_names_choose', 'remove_default_image_sizes');

    function register_my_menus() {
		$menus['primary-menu'] = "Primary";
        register_nav_menus($menus);    
    }
    add_action( 'init', 'register_my_menus' );
     
     function ncsu_show_feed( $source = "", $cnt = 5 , $class = "" ){

         if(!empty($source)){

         	// content of feed 
         	$feedContent = "";

         	// create curl object and set options
         	if(strlen($feedContent) < 1){

         		$curl = curl_init();
         		curl_setopt($curl, CURLOPT_URL,$source);
         		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

         		// load xml object from curl execution
         		$feedContent = curl_exec($curl);
         		curl_close($curl);

         	} 

         	if($feedContent == false || strstr($feedContent,"<title>WordPress &rsaquo; Error</title>")){

         		return false;

         	} else {

         		// load curl content into simplexml
         		$feedObj = simplexml_load_string($feedContent);
         		
         		if(count($feedObj->channel->item) < 1)
         		    return;
         		    
         		if(empty($class))       echo "<ul>";
         		else                    echo "<ul class=\"$class\">";
         		             		    
         		foreach($feedObj->channel->item as $item){

            		if($cnt-- > $cnt){

                		echo "<li><a href=\"" . $item->link . "\">" . $item->title . "</a> <span>" . date("n/j/Y",strtotime($item->pubDate)) . "</span></li>";

                    }

            	}
            	
            	echo "</ul>";

         	}        

         }

     }
     
     function ncsu_show_twitter( $handle = "ncstate" , $cnt = 5 ){

         // json source
         $source = "https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=$handle&count=$cnt";

       	$curl = curl_init();
     	curl_setopt($curl, CURLOPT_URL,$source);
     	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

     	// load xml object from curl execution
     	$twitterSource = curl_exec($curl);
     	curl_close($curl);

     	$twitterObj = json_decode($twitterSource);

     	if(count($twitterObj) < 1)
     	    return;

        echo "<ul>";

     	foreach($twitterObj as $status){

     	    $text = $status->text;

     	    // check for links
     	    foreach($status->entities->urls as $l){
     	        $url = $l->url;
     	        $replace = "<a href=\"" . $url . "\">" . $url . "</a>";
     	        $text = str_replace( $url , $replace, $text);
     	    }

     	    $id = $status->id;
     	    $time = strtotime($status->created_at);

     	    echo "<li>" . $text . " &mdash;  <a href=\"https://twitter.com/intent/retweet?tweet_id=" . $id . "\">" . date("n/j/Y, g:h a", $time)  . "</a></li>";
     	    
     	}

     	echo "</ul>";

     }
     
     function ncsu_show_flickr_set( $set = "" , $api = "ddd4387ab0f016240787f9b72c9f9df4" ){
         
         ## phpFlickr Documentation: http://phpflickr.com/
         
 	     $f = new phpFlickr($api);
 	     
         $photos = $f->photosets_getPhotos($set);
         
         foreach ($photos['photoset']['photo'] as $photo){
             
             echo "<li><a rel=\"gallery\" href=\"" . $f->buildPhotoURL($photo, 'large') . "\">";
             echo "<img src=\"" . $f->buildPhotoURL($photo, 'square') . "\" alt=\"" . $photo['title'] . "\" title=\"" . $photo['title'] . "\" width=\"75\" height=\"75\" />";
             echo "</a></li>";
             
         }
         
     }

     /**
     * Register our sidebars and widgetized areas.
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
	 
	 /**
	  * Add a widget to the dashboard.
	  *
	  * This function is hooked into the 'wp_dashboard_setup' action below.
	  */
	 function theme_documentation_dashboard_widgets() {

	 	wp_add_dashboard_widget(
	                  'theme_documentation_dashboard_widget',         // Widget slug.
	                  'NC State Theme Quickstart',         // Title.
	                  'theme_documentation_dashboard_widget_function' // Display function.
	         );	
	 }
	 add_action( 'wp_dashboard_setup', 'theme_documentation_dashboard_widgets' );

	 /**
	  * Create the function to output the contents of our Dashboard Widget.
	  */
	 function theme_documentation_dashboard_widget_function() {

	 	// Display whatever it is you want to show.
		echo "<b>Theme Features</b>";
		echo "<p>'<a href='admin.php?page=_options'>NC State Theme Options</a>' has several options that can be set that affect your overall site.  You can also add your social media accoutns and customize your site's footer.</p>";
	 	echo "<b>Create Homepage</b>";
		echo "<p>Create a new page with the 'Home Page' template.  Under <a href='customize.php'>Appearances->Customize</a> set that page as the 'Static Front Page'.</p>";
		echo "<b>Creating Menus</b>";
		echo "<p><a href='nav-menus.php'>Create a menu</a> and assign it to one or more theme locations (i.e. pages).  The main menu is auto-generated.</p>";
		echo "<b>Creating Pages</b>";
		echo "<p>New pages can be created in the <a href='edit.php?post_type=page'>Pages menu</a>.  Pages have four different template options: Home, News, Page with Nav, and Default Template.  The 'Home Page' should be used to create a page that will act as your homepage.  'News' can be used to display all of your <a href='edit.php'>Posts</a>.  'Page with Nav' or 'Default Template' will generally be used for all of your sub-pages.</p>";
		echo "<b>Full Documentation</b>";
		echo "<p>The full theme documentation can be found at <a href='http://brand.ncsu.edu/downloads/template-documentation-1-1.php' target='_blank'>brand.ncsu.edu</a>.</p>";
	 }
	 
	 //Adding special styles for admin pages so that utility bar and WP menu bar don't overlap
	 if(is_user_logged_in()) {
		 wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
		 wp_enqueue_style( 'custom_wp_admin_css' );
	 }



     // Update theme version option and run migrations unless version number hasn't changed
     function ncsu_update_theme() {
        $theme = wp_get_theme();
        $current_version = $theme->get('Version');

        if ( get_site_option( 'ncstate_theme_version' ) !== $current_version ) {
             update_site_option( 'ncstate_theme_version', $current_version );
             ncsu_migrations($current_version);
         }
     }
     add_action( 'after_setup_theme', 'ncsu_update_theme' );


     /**
     *
     * Checks the theme's /migrations directory for previously unexecuted
     * migration files.
     *
     * See the markdown file in /migrations for more information.
     *
     */
     function ncsu_migrations($version) {

        // Get all migration files from /migrations
        $migrations_dir = opendir(dirname(__FILE__) . '/migrations');
        // Loop over migration files
        while (false !== ( $migration_file = readdir($migrations_dir) )) {
            // If the file is .php, store the migration version number
            if ( false !== strpos($migration_file, '.php') ) {
                $migrations[] = str_replace('.php', '', $migration_file);
            }
        }

        // Get completed migrations
        if ( get_site_option( 'ncstate_theme_migrations' ) ) {
            $completed_migrations = get_site_option( 'ncstate_theme_migrations' );
        } else {
            $completed_migrations = array();
        }

         foreach ($migrations as $migration) {
            if ( ! in_array($migration, $completed_migrations) && version_compare($migration, $version, '<=')) {
                include 'migrations/' . $migration . '.php';
                $completed_migrations[] = $migration;
            }
         }

         // Update the complete migrations records
         update_site_option( 'ncstate_theme_migrations', $completed_migrations );
     }
     

    /*****************************************************************************s
     ** v.  Short Codes
     *****************************************************************************/

     ## Docuementation: http://codex.wordpress.org/Shortcode_API
	 
	 function get_year_month_archive(){
    
	     global $wpdb;
    
	     echo "<ul>";
	
	 	$limit = 0;
	 	$year_prev = null;
		
	 	$months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,  YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY month , year ORDER BY year DESC, month ASC");
		
	 	foreach($months as $month){
		    
	 		$year_current = $month->year;
		    
	 		if ($year_current != $year_prev){
		        
	 			if ($year_prev != null){
	 				echo "</ul></li>";
	 			}
		         	
	 			echo "<li><h3><a href=\"" . get_bloginfo('url') . "/" . $month->year ."/\">" . $month->year . "</a></h3><ul>";
		     
	 		}
		    
	 		echo "<li><a href=\"" . get_bloginfo('url') . "/" . $month->year . "/" . date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ."\"><span class=\"archive-month\">" . 
	 		    date("F", mktime(0, 0, 0, $month->month, 1, $month->year)) . "</span></a> (" . $month->post_count . ") </li>";
				
	 		$year_prev = $year_current;
		
	 	} // end foreach
	
	 	echo "</ul></li></ul>";
	
	 }

     // Used to create ACF-like image object from media library image url.
    function ncsu_get_attachment_id_from_src( $attachment_url = '' ) {
 
        global $wpdb;
        $attachment_id = false;
     
        // If there is no url, return.
        if ( '' == $attachment_url )
            return;
     
        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();
     
        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
     
            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
     
            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
     
            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
     
        }
     
        return $attachment_id;
    }

    function ncsu_get_img_object_from_url($img_src) {

        $post_id = ncsu_get_attachment_id_from_src($img_src);
        
        // validate
        if( !$post_id )
        {
            return null;
        }

        $attachment = get_post( $post_id );

        // create array to hold img data
        $src = wp_get_attachment_image_src( $attachment->ID, 'full' );
        
        $image = array(
            'id' => $attachment->ID,
            'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
            'title' => $attachment->post_title,
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'mime_type' => $attachment->post_mime_type,
            'url' => $src[0],
            'width' => $src[1],
            'height' => $src[2],
            'sizes' => array(),
        );

        // find all image sizes
        $image_sizes = get_intermediate_image_sizes();

        foreach( $image_sizes as $image_size ) {
            // find src
            $src = wp_get_attachment_image_src( $attachment->ID, $image_size );
            
            // add src
            $image[ 'sizes' ][ $image_size ] = $src[0];
        } // foreach( $image_sizes as $image_size )

        return $image;
    }

     // Create Cross Section short code
    add_shortcode( 'cross_section', 'cross_section_shortcode' );
    function cross_section_shortcode( $atts, $content = "" ){
        include "includes/layout.php";
        
        extract (shortcode_atts ( array (
            'img_src' => '',
            'img_pos' => 'left',
            'link' => false,
            'link_txt' => '',
            'link_url' => '',
            'color' => 'green'
        ), $atts ) );
        
        $id = "cross_section_" . rand(0,1000000);

        $image = ncsu_get_img_object_from_url( $img_src );

        $output = "";

        if ( $link && $link_url ):
            $output .= "<a href=\"" . $link_url . "\" target=\"_blank\" id=\"" . $id . "\">";
        endif;
            $output .= "<div class='cross-section " . $color . "-bg'>";
                if ( $img_pos == 'left' && $image):
                $output .= "<picture class='cross-section-img'>";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-lg-desktop'] . "\" media=\"(min-width: " . $lg_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-desktop'] . "\" media=\"(min-width: " . $md_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-sm-desktop'] . "\" media=\"(min-width: " . $sm_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-tablet'] . "\" media=\"(min-width: " . $xs_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-phone'] . "\">";
                    $output .= "<img src=\"" . $image['sizes']['callout-desktop'] . "\" class=\"img-responsive\" alt=\"" . $image['alt'] . "\" />";
                $output .= "</picture>";
                endif;
                $output .= "<div class='cross-section-text'>";
                    $output .= "<div class='cross-section-container'>";
                        $output .= $content;
                        if ( $link && $link_txt ):
                            $output .= "<p class=\"link-text\">" . $link_txt . "</p>";
                        endif;
                    $output .= "</div>";
                $output .= "</div>";
                if ( $img_pos == 'right' && $image):
                $output .= "<picture class='cross-section-img img-right'>";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-lg-desktop'] . "\" media=\"(min-width: " . $lg_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-desktop'] . "\" media=\"(min-width: " . $md_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-sm-desktop'] . "\" media=\"(min-width: " . $sm_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-tablet'] . "\" media=\"(min-width: " . $xs_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-phone'] . "\">";
                    $output .= "<img src=\"" . $image['sizes']['callout-desktop'] . "\" class=\"img-responsive\" alt=\"" . $image['alt'] . "\" />";
                $output .= "</picture>";
                endif;
            $output .= "</div>";
        if ( $link && $link_url ): 
            $output .= "</a>"; 
        endif;
        
        return $output;
    }

?>
