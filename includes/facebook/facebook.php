<?php

include 'facebook-php-sdk-master/src/facebook.php';

function getFacebook($username) {

	$facebook = new Facebook(array(
		'appId' => '865524736796621',
		'secret' => '7d3e9946d72a8dd17da7673ebba409ec',
	));
	
	$json = file_get_contents('https://graph.facebook.com/' . $username);
	$obj = json_decode($json);

	$temp = $facebook->api('/' . $obj->id . '/posts');

	$data = $temp['data'];
	
	$posts = array();

	foreach($data as $post) {
		$img = null;
		if($post['type']=='photo') {
			$img = $facebook->api('/' . $post['object_id']);
		}
		
		$fb_post = array(
			'time' => strtotime($post['created_time']),
			'description' => $post['message'],
			'type' => 'facebook',
			'url' => $post['link'],
			'img' => $img['source'],
		);
	    $posts[] = $fb_post;
	}
	return $posts;
}