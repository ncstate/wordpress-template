<?php

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;


/**
 * Retrieves Facebook posts for a given username.
 * 
 * @param string $username A facebook username
 * @param bool $raw Whether to return the full raw response data instead of only
 *    parsed time, date, and url. Defaults to false.
 * @param int $num How many posts to return. Defaults to 15.
 * @return array If $raw is TRUE, returns an array of graph objects. If $raw is
 *    FALSE, returns an array of posts with keys time, message, and url.
 */
function getFacebook($username, $num = 15, $raw = false) {
	
	$response = requestFacebook('/' . $username . '/posts');

	if($raw) {
		return $response;
	}

	$data = $response->getGraphObject()->getPropertyAsArray('data');

	$posts = array();
	$successful_posts = 0;

	foreach($data as $post) {
		if( ! $post->getProperty('story') && $successful_posts < $num) {
			$fb_post = array(
				'time' => strtotime($post->getProperty('updated_time')),
				'message' => $post->getProperty('message'),
				'url' => $post->getProperty('link')
			);
		  $posts[] = $fb_post;
		  $successful_posts++;
		} elseif (! $post->getProperty('story') ) {
			break;
		}
	}

	return $posts;
}

function requestFacebook($request) {
	$session = getFbSession();
	$response = '';

	try {
		$response = (new FacebookRequest($session, 'GET', $request ))->execute();
	} catch (FacebookRequestException $ex){
		echo $ex->getMessage();
	} catch (Exception $ex){
		echo $ex->getMessage();
	}

	return $response;
}


/**
 * Creates a Facebook session.
 * 
 * @return new FacebookSession object
 */
function getFbSession() {
	if(get_option('facebook_app_id')):
		$app_id = get_option('facebook_app_id');
		$secret = get_option('facebook_secret');
		$authToken = get_option('facebook_app_id') . "|" . get_option('facebook_secret');
	else:
		$app_id = FACEBOOK_APP_ID;
		$secret = FACEBOOK_SECRET;
		$authToken = FACEBOOK_APP_ID . "|" . FACEBOOK_SECRET;
	endif;
	
	FacebookSession::setDefaultApplication($app_id, $secret);

	return new FacebookSession($authToken);
}