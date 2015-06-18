<?php
/**
 * Plugin Name: NC States Events Calendar
 * Plugin URI: http://sciences.ncsu.edu
 * Description: Creates custom post type for events that are added manually or from an external feed.
 * Version: 0.1
 * Author: Scott Thompson, NC State
 * Author URI: http://github.com/csthomp89
 * License: MIT
 */

function events_styles() {
	wp_enqueue_style('events_map_style', plugins_url() . '/ncstate-events/css/style.css');
	wp_enqueue_script('google_maps', 'https://maps.googleapis.com/maps/api/js?v=3');
}
add_action('wp_enqueue_scripts', 'events_styles');

// Create 'Events' custom post type
add_action( 'init', 'create_events_post_type' );
function create_events_post_type() {
	register_post_type( 'events',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' )
			),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'events', 'with_front' => false ),
		'supports' => array('excerpt','title','custom-fields'),
		)
	);
}

// Create custom taxonomy for 'Events' CPT
add_action( 'init', 'events_init' );
function events_init() {
	// create a new taxonomy
	register_taxonomy(
		'subcalendar',
		'events',
		array(
	        'labels' => array(
	            'name' => 'Subcalendar',
	            'add_new_item' => 'Add Subcalendar',
	            'new_item_name' => "New Subcalendar"
	        ),
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'rewrite' => array( 'with_front' => false ),
	    )
	);
}

add_action( 'admin_menu', 'events_options' );
function events_options() {
	add_submenu_page('edit.php?post_type=events', 'Events Admin', 'Settings', 'edit_posts', 'events_options_menu_page', 'print_events_options');
	register_setting('events_settings', 'events_cal_feed');
	register_setting('events_settings', 'events_auto_publish');

	if( function_exists('acf_add_options_page') ) {
	
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Events Index Settings',
			'menu_title'	=> 'Index Settings',
			'parent_slug'	=> 'edit.php?post_type=events',
		));
		
	}
}

function print_events_options() {
	echo '<div class="wrap">';
	echo	'<h2>Events Admin</h2>';
	echo 		'<form method="post" action="options.php">';
					settings_fields('events_settings');
					do_settings_sections('events_settings');
					
	echo 			'<table class="form-table>"
						<tr valign="top">
							<th>Calendar Feeds</th>
							<td>Enter each calendar ID/feed on a new line.  For Google Calendar, only provide the calendar ID: "ncsu.edu_507c8794r25bnebhjrrh3i5c4s%40group.calendar.google.com".  For ActiveData, provide entire XML feed URL.<br /><br />
							<textarea name="events_cal_feed" rows="4" cols="150">' . get_option('events_cal_feed') . '</textarea></td>
						</tr>
						<tr valign="top">
							<th scope="row">Automatically publish events from feeds</th>
							<td><input type="checkbox" name="events_auto_publish" value="1" ' . checked( 1, get_option('events_auto_publish'), false ) . ' /></td>
						</tr>
					</table>
					';
					submit_button();
	echo		'</form>';
	echo '<pre>';
	events_get_feeds();
	echo '</pre>';
	echo '</div>';
}

//TODO: Change input interface and then foreach to get each feed
function events_get_feeds() {
	$raw = get_option('events_cal_feed');
	$calendars = explode("\n", $raw);
	$feeds = array();
	foreach($calendars as $calendar) {
		if(strpos($calendar, 'google.com')):
			events_insert_events(events_get_feed_google($calendar));
		elseif(strpos($calendar, 'activedatax.com')):
			events_insert_events(events_get_feed_activedata($calendar));
		endif;
	}
}

function events_get_feed_google($calendar_id) {
	$key = 'AIzaSyDMvWtn-rcA0H9VQt_FD7ZIRnA96cMPGvc';
	$time = urlencode(date("Y-m-d\TH:i:s\Z"));

	$url = 'https://www.googleapis.com/calendar/v3/calendars/' . trim($calendar_id) . '/events?orderBy=startTime&singleEvents=true&timeMin=' . $time . '&maxResults=30&key=' . $key;
	//var_dump($url);
	$json = file_get_contents($url);
	$data = json_decode($json, true);
	
	$events = array();
	foreach($data['items'] as $event):
		if($event['start']['date']!=null):
			$date = $event['start']['date'];
		else:
			$date = $event['start']['dateTime'];	
		endif;
		$event_array = array(
			$event['id'],
			$event['summary'],
			$event['description'],
			date("Y-m-d H:i:s", strtotime($date)),
			$event['location'],
			$event['organizer']['email'],
			$event['htmlLink'],
		);
		$events[] = $event_array;
	endforeach;
	return $events;
}

function events_get_feed_activedata($calendar) {
	$feed = simplexml_load_file(trim($calendar));
	$events = array();
	foreach($feed->EVENT as $event) {
	
		$event_array = array(
			(string)$event->EventGUID,
			(string)$event->Name,
			(string)$event->Description,
			date("Y-m-d H:i:s", strtotime($event->StartDate . " " . $event->StartTime)),
			(string)$event->LocationName,
			"active_data",
			(string)$event->EventURL
		);
		$events[] = $event_array;
	}
	return $events;
}

function events_insert_events($events) {
	foreach($events as $event) {
		$uid = $event[0];
		
		if(new_entry($uid)==null):
			$test_post = array(
				'post_title' => $event[1],
				'post_type' => 'events'
			);
			if(get_option('events_auto_publish')):
				$test_post['post_status'] = 'publish';
			endif;
			$post_id = wp_insert_post($test_post);
			update_post_meta($post_id,'uid',$event[0]);
			update_post_meta($post_id,'title',$event[1]);
			update_post_meta($post_id,'description',$event[2]);
			update_post_meta($post_id,'start_time',strtotime($event[3]));
			update_post_meta($post_id,'location',$event[4]);
			update_post_meta($post_id, 'event_updates', 1);
		else:
			$post_id = new_entry($uid);
		endif;
		
		if(get_post_meta($post_id,'event_updates')):
			update_post_meta($post_id,'uid',$event[0]);
			update_post_meta($post_id,'title',$event[1]);
			update_post_meta($post_id,'description',$event[2]);
			update_post_meta($post_id,'start_time',strtotime($event[3]));
			update_post_meta($post_id,'location',$event[4]);
		endif;
	}
}

function new_entry($uid) {
	$arqs = array(
		'meta_key'	  => 'uid',
		'meta_value'  => $uid,
		'meta_compare' => '=',
		'post_type'	  => 'events',
	);
	$query = new WP_Query($arqs);
	return $query->posts[0]->ID;
}

function ncstate_events_image_sizes() {
    if ( function_exists('add_retina_image_size') ) :
    	add_retina_image_size('img_345', 345); // Index sidebar large desktop
        add_retina_image_size('img_360', 360); // Index sidebar desktop
        add_retina_image_size('img_220', 220); // Index sidebar tablet
        add_retina_image_size('img_768', 768); // Index sidebar phone
    endif;
}
add_action('plugins_loaded', 'ncstate_events_image_sizes');

// Setting auto hourly calendar feed updates

register_activation_hook(__FILE__, 'ncstate_events_calendar_schedule');

function ncstate_events_calendar_schedule() {
	if(!wp_next_scheduled('ncstate_events_calendar_hourly_update')):
		wp_schedule_event(time(), 'hourly', 'ncstate_events_calendar_hourly_update');
	endif;
}

function ncstate_events_calendar_hourly_update() {
	events_get_feeds();
}

register_deactivation_hook(__FILE__, 'ncstate_events_calendar_unschedule');

function ncstate_events_calendar_unschedule() {
	wp_clear_scheduled_hook('ncstate_events_calendar_hourly_update');
}

// End hourly calendar updates section

// Adding ACF custom fields info
include 'acf.php';
include 'custom-fields.php';
include 'events-index-fields.php';
include 'add-views.php';
