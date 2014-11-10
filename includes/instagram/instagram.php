<?php

require_once 'Instagram-PHP-API-master/instagram.class.php';

function getInstagram($username) {
	
	$instagram = new Instagram('3e5edeebf0b64390ac988d228ee3d289');
	
	$user_info = $instagram->searchUser($username, 1);
	$user_info = $user_info->data;
	
	$temp = $instagram->getUserMedia($user_info[0]->id,'10');
	
	$media = $temp->data;
	
	$photos = array();
	
	foreach($media as $image) {
		$photo = array(
			'img' => $image->images->standard_resolution->url,
			'type' => 'instagram',
			'time' => $image->created_time,
			'url' => $image->link,
		);
		$photos[] = $photo;
	}
	return $photos;
}
	
?>