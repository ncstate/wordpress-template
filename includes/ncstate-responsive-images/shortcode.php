<?php

// Responsive Image Sizes
// Adding Image Sizes for Responsive Design

// Floated Images
add_retina_image_size('img_460', 460); // desktop
add_retina_image_size('img_376', 376); // small desktop
add_retina_image_size('img_345', 345); // tablet
add_retina_image_size('img_768', 768); // phone

// Centered Images
add_retina_image_size('img_950', 950); // desktop
add_retina_image_size('img_783', 783); // small desktop
add_retina_image_size('img_720', 720); // tablet
add_retina_image_size('img_768', 768); // phone

if(!function_exists('retina_images_shortcode')):
function retina_images_shortcode($atts) {

    $classes = array(
        'retina-shortcode'
    );

    extract (shortcode_atts ( array (
        'id'  => '',
        'caption'  => 'false',
        'class'  => '',
        'align' => 'center',
    ), $atts ) );

    $classes = array_merge($classes, explode(' ', $class));

    $img_sizes = array(460, 376, 345, 768);

    if ( $align == 'left' || $align == 'right' || $align == 'center' ) {
        $classes[] = 'align' . $align;

        if ( $align == 'center' ) {
            $img_sizes = array(950, 783, 720, 768);
        }
    }

    $classes = implode(' ', $classes);

	if ( $caption == 'true') :
		$return .= '<div class="wp-caption ' . $classes . '">';
		$return .= get_retina_images($id, $img_sizes);
		$img = get_post($id);
		$return .= '<p class="wp-caption-text">' . $img->post_excerpt . '</p></div>';
	else:
		$return .= get_retina_images($id, $img_sizes, $classes);
	endif;
	return $return;
}
add_shortcode('retina_image', 'retina_images_shortcode');
endif;
