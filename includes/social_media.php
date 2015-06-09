<?php

include 'facebook/facebook.php';
include 'twitter/twitter.php';
include 'instagram/instagram.php';

function getSocial($social_networks) {
	$twitter = array();
	$facebook = array();
	$instagram = array();
	
	if(ot_get_option('twitter') && in_array('twitter', $social_networks)) {
		$twitter = getTwitter(ot_get_option('twitter'));
	}
	if(ot_get_option('facebook') && in_array('facebook', $social_networks)) {
		$facebook = getFacebook(ot_get_option('facebook'));
	}
	if(ot_get_option('instagram') && in_array('instagram', $social_networks)) {
		$instagram = getInstagram(ot_get_option('instagram'));
	}
	
	$social = array_merge($twitter, $instagram, $facebook);
	
	$dates = array();
	foreach($social as $key => $row) {
		$dates[$key] = $row['time'];
	}
	array_multisort($dates, SORT_DESC, $social);
	
	return $social;
}