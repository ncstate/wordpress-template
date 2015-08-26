<?php
/**
 * Plugin Name: NC State Responsive Retina Images
 * Plugin URI: https://github.ncsu.edu/ncstate-ucomm/ncstate-responsive-images
 * Description: Resizes and inserts images using <picture> tag and polyfill.
 * Version: 1.0.1
 * Author: University Communications
 * Author URI: http://university-communications.ncsu.edu/
 * License: MIT
 */

if(!function_exists('responsive_images_scripts')):
function responsive_images_scripts() {
	wp_enqueue_script('create_picture', plugin_dir_url(__FILE__) . 'js/createPicture.js');
	wp_enqueue_script('picture_polyfill', plugin_dir_url(__FILE__) . 'js/picturefill.js', array('create_picture'));
}
add_action('wp_enqueue_scripts', 'responsive_images_scripts');
endif;

if(!function_exists('add_retina_image_size')):
function add_retina_image_size($name, $width) {
	add_image_size($name, $width);
	add_image_size($name . '@2x', $width*2);
}
endif;

if(!function_exists('get_retina_images')):
function get_retina_images($image_id, $sizes, $classes='') {
	$breakpoints = array(1200, 992, 768, 0);
	$return = '';
	$return .= '<picture>';
	$i = 0;
	foreach($sizes as $size):
		$image = wp_get_attachment_image_src($image_id, 'img_' . $size);
		$image_retina = wp_get_attachment_image_src($image_id, 'img_' . $size . '@2x');
		$return .= '<source srcset="' . $image[0] . '" media="(min-width: ' . $breakpoints[$i] . 'px)">';
		$return .= '<source srcset="' . $image_retina[0] . '" media="(min-width: ' . $breakpoints[$i] . 'px) and (-webkit-device-pixel-ratio: 1.3)">';
		$i++;
	endforeach;
	$image = wp_get_attachment_image_src($image_id, 'img_' . max($sizes) );
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	$return .= '<img src="' . $image[0] . '" alt="' . $alt . '" class="img-responsive ' . $classes . '" itemprop="image">';
	$return .= '</picture>';
	return $return;
}
endif;

include 'shortcode.php';
