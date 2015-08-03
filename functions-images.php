<?php

add_theme_support( 'post-thumbnails' );
add_image_size('generic-phone',480,270,true);
add_image_size('generic-tablet',768,432,true);
add_image_size('generic-sm-desktop',240,135,true);
add_image_size('generic-desktop',315,177,true);
add_image_size('generic-lg-desktop',500,281,true);
add_image_size('featured-phone',480,270,true);
add_image_size('featured-tablet',768,432,true);
add_image_size('featured-sm-desktop',705,397,true);
add_image_size('featured-desktop',745,419,true);

if ( function_exists('add_retina_image_size') ) :
  // Call outs
  add_retina_image_size('img_570', 570); // desktop
  add_retina_image_size('img_470', 470); // small desktop
  add_retina_image_size('img_370', 370); // tablet
  add_retina_image_size('img_768', 768); // phone

  // Banner
  add_retina_image_size('img_825', 825); // desktop
  add_retina_image_size('img_825', 825); // small desktop
  add_retina_image_size('img_992', 992); // tablet
  add_retina_image_size('img_768', 768); // phone

  // Generic/Announcements
  add_retina_image_size('img_324', 324); // desktop
  add_retina_image_size('img_258', 258); // small desktop
  add_retina_image_size('img_184', 184); // tablet
  add_retina_image_size('img_681', 681); // phone
endif;