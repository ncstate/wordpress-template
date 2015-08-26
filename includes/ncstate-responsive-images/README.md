Responsive Images
=================
Inserts `<picture>` tag with automatically resized images for each defined breakpoint.

## Overview
This plugin uses Scott Jehl's `<picture>` polyfill and utilizes WordPress's image resizing capability.

## Defining Breakpoints
All possible breakpoints should be defined in a theme's `functions.php` file.  By default, the plugin utilizes four minimum breakpoints (1200, 992, 768, 0) based upon Bootstrap. The breakpoint declarations may look similar to the example below:

```
if ( function_exists('add_retina_image_size') ) :

  // landing page intro image
  add_retina_image_size('img_825', 825); // desktop
  add_retina_image_size('img_659', 659); // small desktop
  add_retina_image_size('img_992', 992); // tablet
  add_retina_image_size('img_768', 768); // phone

  // Image divider module
  add_retina_image_size('img_1500', 1500); // desktop
  add_retina_image_size('img_1200', 1200); // small desktop
  add_retina_image_size('img_992', 992); // tablet
  add_retina_image_size('img_768', 768); // phone
}
```

A second breakpoint of double the specified width will be created automatically for Retina and other high pixel density displays.

## Outputting <picture> Element
Including the following code will return the `<picture>` element:

```<?php get_retina_images($img_id, $breakpoints, [$classes]); ?>```

**Parameters**

$img_id: (int/string, required) ID of an image attachment

$breakpoints: (array, required) Array of breakpoints.

$classes: (string, optional) CSS class name to include on `img` element.  Multiple classes can be specified if separated by a space.  `img-responsive` is added by default even if the `$classes` parameter is not passed.

Note that the `get_retina_images()` function returns a string without outputing to the screen. Alt text provided within the WordPress media library will also be output within the `<img>` element.

## Shortcodes
You may want to include an image within the body copy of a WordPress post.  It is possible to return a responsive image by using the `[retina_image]` shortcode.

Shortcode parameters include:

| Parameter | Description                                                   | Required            |
| --------- | ------------------------------------------------------------- | --------------------|
| `id`      | (int/string) Image attachment ID                              | Yes                 |
| `caption` | (Boolean) Print `.wp-caption` text                            | No, default `false` |
| `class`   | (string) CSS class to pass to surrounding `div`               | No                  |
| `align`   | (string, `left`,`center`,`right`) Float/alignment within copy | No, default `center`|

When left or right aligned, default image widths are `460, 376, 345, 768`.  When center aligned, default widths are `950, 783, 720, 768`.  These widths can be changed in `shortcode.php`.
