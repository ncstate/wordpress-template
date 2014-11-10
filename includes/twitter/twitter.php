<?php

require_once('twitteroauth-master/twitteroauth/twitteroauth.php');
require_once('twitteroauth-master/config.php');


// Twitter Access Function
function getConnectionWithAccessToken($oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
	return $connection;
}

function getTwitter($twitter_handle) {
	$oauth_token = "487624974-AFwA4BLyLJzY9ozD47iCiMk2XyEbePu9SLUbA";
	$oauth_token_secret = "Zi3gXgCt8Z0RNh0WnbaOkrZnfBNyEcAbEyshjE6CnQ";
	$twitterUser = $twitter_handle;
	$count = 10;
	
	date_default_timezone_set('America/New_York');

    $connection = getConnectionWithAccessToken($oauth_token, $oauth_token_secret);
    $statuses = $connection->get('statuses/user_timeline', array('screen_name' => $twitterUser, 'count' => $count));
	
	$tweets = array();  

	foreach($statuses as $status) {
		//echo '<pre>';
		//var_dump($status);
		//echo '</pre><br /><br />';
		$tweet = array(
			'time' => strtotime($status->created_at),
			'description' => $status->text,
			'type' => 'twitter',
			'url' => 'https://twitter.com/' . $status->user->screen_name . '/status/' . $status->id_str,
			'media' => $status->entities->media
		);
	    $tweets[] = $tweet;
   }
   return $tweets;
}