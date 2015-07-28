<?php

use MetzWeb\Instagram\Instagram;


/**
 * Retrieves Instagram photos for a given username.
 * 
 * @param string $username An Instagram handle without @
 * @param int $num How many photos to return. Defaults to 10.
 * @param string $tag A hashtag to filter the query
 * @return array Returns an array of photos with keys time, img, and url.
 */
function getInstagram($username, $num = 10, $tag = false)
{
	
	if(get_option('instagram_app_key')):
		$instagram = new Instagram(get_option('instagram_app_key'));
	else:
		$instagram = new Instagram(INSTAGRAM_APP_KEY);
	endif;
	$user_id = getInstaUserId($username, $instagram);
	$media_obj = $instagram->getUserMedia($user_id, 33); // Instagram limit of 33
	$loop_count = 0;

	do {

		if( ! isset($photos) ) {
			$photos = buildInstaArray($media_obj, $tag);
		} else {
			$media_obj = $instagram->pagination($media_obj);
			$more_photos = buildInstaArray($media_obj, $tag);
			$photos = array_merge($photos, $more_photos);
		}

		$photos_returned = count($photos);
		$loop_count++;
	}
	while ($photos_returned < $num && $loop_count <= 7);
	
	return array_slice($photos, 0, $num);
}

function getInstaUserId($username, Instagram $instagram)
{
	$user_info = $instagram->searchUser($username, 1);
	$user_info = $user_info->data;
	return $user_info[0]->id;
};

function getInstaMedia($json)
{
	return $json->data;
}

function buildInstaArray($media_obj, $tag)
{
	$photos = array();

	$media = getInstaMedia($media_obj);

	foreach($media as $image) {
		if( ! $tag || ( in_array($tag, $image->tags) )) {
			$photo = array(
				'time' => $image->created_time,
				'img' => $image->images->standard_resolution->url,
				'url' => $image->link,
			);
			$photos[] = $photo;
		}
	}

	return $photos;
}
