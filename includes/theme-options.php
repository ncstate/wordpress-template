<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /* OptionTree is not loaded yet, or this is not an admin request */
  if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
    return false;
    
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => __( 'General', 'wordpress-template' )
      ),
      array(
        'id'          => 'footer',
        'title'       => __( 'Footer', 'wordpress-template' )
      ),
      array(
        'id'          => 'social',
        'title'       => __( 'Social', 'wordpress-template' )
      ),
      array(
        'id'          => 'social-api',
        'title'       => __( 'API Keys', 'wordpress-template' )
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'brick',
        'label'       => __( 'Brick', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'radio-image',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '2x1',
            'label'       => __( '2x1', 'wordpress-template' ),
            'src'         => get_stylesheet_directory_uri() . '/img/ncstate-brick-2x1-red.png'
          ),
          array(
            'value'       => '2x2',
            'label'       => __( '2x2', 'wordpress-template' ),
            'src'         => get_stylesheet_directory_uri() . '/img/ncstate-brick-2x2-red.png'
          )
        )
      ),
      array(
        'id'          => 'ga_id',
        'label'       => __( 'Google Analytics ID', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cse_id',
        'label'       => __( 'Google Custom Search Engine ID', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'address',
        'label'       => __( 'Address', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'resource_links',
        'label'       => __( 'Resource Links', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'settings'    => array( 
          array(
            'id'          => 'url',
            'label'       => __( 'URL', 'wordpress-template' ),
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          )
        )
      ),
      array(
        'id'          => 'facebook',
        'label'       => __( 'Facebook Username', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'twitter',
        'label'       => __( 'Twitter Username', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'instagram',
        'label'       => __( 'Instagram Username', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'youtube',
        'label'       => __( 'YouTube Username', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'rss',
        'label'       => __( 'RSS', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'FACEBOOK_APP_ID',
        'label'       => __( 'Facebook App ID', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social-api',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'FACEBOOK_SECRET',
        'label'       => __( 'Facebook Secret', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social-api',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'INSTAGRAM_APP_KEY',
        'label'       => __( 'Instagram App Key', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social-api',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'TWITTER_CONSUMER_KEY',
        'label'       => __( 'Twitter Consumer Key', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social-api',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'TWITTER_CONSUMER_SECRET',
        'label'       => __( 'Twitter Consumer Secret', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social-api',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'OAUTH_TOKEN',
        'label'       => __( 'Twitter oAuth Token', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social-api',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'OAUTH_TOKEN_SECRET',
        'label'       => __( 'Twitter oAuth Token Secret', 'wordpress-template' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social-api',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      )
	  
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings ); 
  }
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;
  
}