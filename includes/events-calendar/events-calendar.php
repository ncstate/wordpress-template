<?php
/**
 * Plugin Name: Events Calendar
 * Plugin URI: http://sciences.ncsu.edu
 * Description: Creates custom post type for events that are added manually or from an external feed.
 * Version: 0.1
 * Author: Scott Thompson, NC State
 * Author URI: http://github.com/csthomp89
 * License: MIT
 */

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
	        'hierarchical' => true
	    )
	);
}

add_action( 'admin_menu', 'events_options' );
function events_options() {
	add_submenu_page('edit.php?post_type=events', 'Events Admin', 'Settings', 'edit_posts', 'events_options_menu_page', 'print_events_options');
	register_setting('events_settings', 'events_cal_feed');
	register_setting('events_settings', 'events_auto_publish');
}

function print_events_options() {
	echo '<div class="wrap">';
	echo	'<h2>Events Admin</h2>';
	echo		'<p>Place each calendar feed on a new line.  Google Calendar XML and ActiveData XML feed are acceptable.  See the <a href="http://brand.ncsu.edu/downloads/template-documentation-1-1.php#calendar">theme documentation</a> for proper feed URL formatting.</p>';
	echo 		'<form method="post" action="options.php">';
					settings_fields('events_settings');
					do_settings_sections('events_settings');
					
	echo 			'<table class="form-table>"
						<tr valign="top">
							<th scope="row">Calendar Feeds</th>
							<td><textarea name="events_cal_feed" rows="4" cols="150">' . get_option('events_cal_feed') . '</textarea></td>
						</tr>
						<tr valign="top">
							<th scope="row">Automatically publish new events from feeds</th>
							<td><input type="checkbox" name="events_auto_publish" value="1" ' . checked( 1, get_option('events_auto_publish'), false ) . ' /></td>
						</tr>
					</table>
					';
					submit_button();
					events_refresh();
	echo		'</form>';
	echo '</div>';
}

function events_refresh() {
	$feeds = events_feed_parser();
	foreach($feeds as $feed):
		$temp = events_get_feed($feed[0]);
	        events_insert_events($temp);
	endforeach;
}

function events_feed_parser() {
	$raw = get_option('events_cal_feed');
	$calendars = explode("\n", $raw);
	$feeds = array();
	foreach($calendars as $calendar) {
		$feeds[] = explode('##', $calendar);
	}
	return $feeds;
}

function events_get_feed($calendar) {
	if(strpos($calendar, 'google.com/calendar')):
		return events_get_google_calendar_feed(trim($calendar));
	elseif(strpos($calendar, 'activedatax.com')):
		$temp = events_get_activedata_feed(trim($calendar));
		return $temp;
	else:
		return false;
	endif;
}

function events_get_google_calendar_feed($calendar) {
	$feed = simplexml_load_file(trim($calendar));
        $events = array();
        foreach($feed->entry as $event) {
                $event_array = @array(
                        (string)$event->children('gCal',true)->uid->attributes()->value,
                        (string)$event->title,
                        (string)$event->content,
                        date("Y-m-d H:i:s", strtotime($event->children('gd',true)->when->attributes()->startTime)),
                        (string)$event->children('gd',true)->where->attributes()->valueString,
                        (string)$calendar['id'],
                        (string)$event->link->attributes()->href
                );
                $events[] = $event_array;
        }
	return $events;
}

function events_get_activedata_feed($calendar) {
	$feed = simplexml_load_file(trim($calendar));
        $events = array();
        foreach($feed->EVENT as $event) {
                $event_array = array(
                        (string)$event->EventGUID,
                        (string)$event->Name,
                        (string)$event->Description,
                        date("Y-m-d H:i:s", strtotime($event->StartDate . $event->StartTime)),
                        ($event->Locations->Location->LocationName ? (string)$event->Locations->Location->LocationName : ""),
                        "temp",
                        (string)$event->EventURL
                );
                $events[] = $event_array;
        }
	return $events;	
}

function events_insert_events($events) {
	if($events):
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
		else:
			$post_id = new_entry($uid);
		endif;

		if(get_post_meta($post_id,'event_updates') || get_post_meta($post_id,'uid',true)==''):
			update_post_meta($post_id,'uid',$event[0]);
			update_post_meta($post_id,'title',$event[1]);
			update_post_meta($post_id,'description',$event[2]);
			update_post_meta($post_id,'start_time',$event[3]);
			update_post_meta($post_id,'location',$event[4]);
			update_post_meta($post_id,'url',$event[6]);
		endif;
	}
	endif;
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

// Adding ACF custom fields info

include 'custom-fields.php';

// Setting auto hourly calendar feed updates

register_activation_hook(__FILE__, 'events_calendar_schedule');

function events_calendar_schedule() {
	if(!wp_next_scheduled('events_calendar_hourly_update')):
		wp_schedule_event(time(), 'hourly', 'events_calendar_hourly_update');
	endif;
}

function events_calendar_hourly_update() {
	events_refresh();
}

register_deactivation_hook(__FILE__, 'events_calendar_unschedule');

function events_calendar_unschedule() {
	wp_clear_scheduled_hook('events_calendar_hourly_update');
}

// Retrieving events

function events_calendar_get_upcoming_events($num = NULL, $subcal = NULL) {
	$args = array(
		'meta_key'	=> 'start_time',
		'post_type'	=> 'events',
		'subcalendar' => $subcal, // use to only show events from one specific category
	);
	$query = new WP_Query($args);
	$events = array();
	foreach($query->posts as $post) {
		$events[$post->ID] = get_post_meta($post->ID, 'start_time');
	}

	function dateTimeSort($a, $b) {
		if($a == $b) {
			return 0;
		}
		return ($a<$b) ? -1 : 1;
	}
	
	uasort($events, dateTimeSort);
	
	$return_events = array();
	$i = 0;
	foreach($events as $id => $event):
		if($num != NULL && $i < $num) :
		$temp_event = array(
			'url' => get_post_meta($id, 'url', true),
			'title' => get_post_meta($id, 'title', true),
			'summary' => get_post_meta($id, 'description', true),
			'location' => get_post_meta($id, 'location', true),
			'date' => get_post_meta($id, 'start_time', true),
		);
		$return_events[] = $temp_event;
		endif;
		$i++;
	endforeach;
	return $return_events;
}
