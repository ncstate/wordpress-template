<?php

add_filter('single_template', 'events_get_single');
function events_get_single($single) {
	$post_type = get_query_var( 'post_type' ); 

    if($post_type == 'events'):
        return plugin_dir_path(__FILE__) . 'views/single.php';
    else:
        return $single;
    endif;
}

add_filter('index_template', 'events_get_index');
function events_get_index($index) {
	$post_type = get_query_var( 'post_type' );
    $post_tax = get_query_var( 'taxonomy' ); 

    if($post_type == 'events' || $post_tax == 'subcalendar'):
		return plugin_dir_path(__FILE__) . 'views/index.php';
	else:
		return $index;
	endif;
}
