<?php

include 'facebook/facebook.php';
include 'twitter/twitter.php';
include 'instagram/instagram.php';

function getSocial($social_networks) {
	$theme = get_option('ncstate_theme');
	$twitter = array();
	$facebook = array();
	$instagram = array();
	
	if($theme['opt-twitter'] && in_array('twitter', $social_networks)) {
		$twitter = getTwitter($theme['opt-twitter']);
	}
	if($theme['opt-facebook'] && in_array('facebook', $social_networks)) {
		$facebook = getFacebook($theme['opt-facebook']);
	}
	if($theme['opt-instagram'] && in_array('instagram', $social_networks)) {
		$instagram = getInstagram($theme['opt-instagram']);
	}
	
	$social = array_merge($twitter, $instagram, $facebook);
	
	$dates = array();
	foreach($social as $key => $row) {
		$dates[$key] = $row['time'];
	}
	array_multisort($dates, SORT_DESC, $social);
	
	return $social;
}