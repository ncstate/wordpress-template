<?php

add_theme_support( 'post-thumbnails' );

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

  // Single Featured Image
  add_retina_image_size('img_825', 825); // desktop
  add_retina_image_size('img_675', 675); // small desktop
  add_retina_image_size('img_690', 690); // tablet
  add_retina_image_size('img_707', 707); // phone
endif;