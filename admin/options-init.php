<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('ncstate_theme_Redux_Framework_config')) {

    class ncstate_theme_Redux_Framework_config {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'ncstate_theme'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'ncstate_theme'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'ncstate_theme'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'ncstate_theme'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'ncstate_theme'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'ncstate_theme') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'ncstate_theme'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-cogs',
                'title'     => __('General Settings', 'ncstate_theme'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-brick',
                        'type'      => 'image_select',
                        'title'     => __('Brick Dimensions', 'ncstate_theme'),
                        'subtitle'  => __('Choose the 2x1 or 2x2 brick for your header.', 'ncstate_theme'),

                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '2x1' => array('title' => '2x1', 'img' => get_template_directory_uri() . '/img/ncstate-brick-2x1-red.png'),
                            '2x2' => array('title' => '2x2', 'img' => get_template_directory_uri() . '/img/ncstate-brick-2x2-red.png')
                        ),
                        'width'     => '25% !important', 
                        'default'   => '2x1',
                    ),
                    /**
                        This enables the option to chose a left navigation layout. Not ready for prime
                        time.
                    * */
                    /*array(
                        'id'        => 'opt-layout',
                        'type'      => 'radio',
                        'title'     => __('Main Menu Layout', 'ncstate_theme'),
                        'subtitle'  => __('This will be the position of the main menu on your website.', 'ncstate_theme'),
                        
                         //Must provide key => value pairs for radio options
                        'options'   => array(
                            'left' => 'Left', 
                            'horiz' => 'Horizontal',
                        ),
                        'default'   => 'horiz'
                    ),*/
                    array(
                        'id'        => 'opt-tracking-code',
                        'type'      => 'textarea',
                        'title'     => __('Tracking Code', 'ncstate_theme'),
                        'subtitle'  => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'ncstate_theme'),
                        'desc'      => 'Make sure your code includes &lt;script&gt; tags around the javascript.',
                    ),
                    array(
                        'id'        => 'opt-on-page-custom-fields',
                        'type'      => 'checkbox',
                        'title'     => __('Build Pages with Custom Fields', 'ncstate_theme'),
                        'subtitle'  => __('Check this box to allow users to construct sub-pages with rows for text and callouts.', 'ncstate_theme'),
						'default'	=> '1',
                    ),
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'el-icon-cogs',
                'title'     => __('Social Media', 'ncstate_theme'),
                'fields'    => array(
					array(
					    'id'   => 'info-social',
					    'type' => 'info',
					    'desc' => __('You can provide your social media ID to each network below.  User IDs for all networks do not have to be provided.  Information provided here will be used in the footer of your website.  The Facebook, Twitter, and Instagram IDs will also be used in the social media available on your homepage.', 'ncstate_theme')
					),
                    array(
                        'id'        => 'opt-facebook',
                        'type'      => 'text',
                        'title'     => __('Facebook', 'ncstate_theme'),
                        'subtitle'  => __('Facebook User ID', 'ncstate_theme'),
                    ),
                    array(
                        'id'        => 'opt-twitter',
                        'type'      => 'text',
                        'title'     => __('Twitter', 'ncstate_theme'),
                        'subtitle'  => __('Twitter Handle', 'ncstate_theme'),
                    ),
                    array(
                        'id'        => 'opt-instagram',
                        'type'      => 'text',
                        'title'     => __('Instragram', 'ncstate_theme'),
                        'subtitle'  => __('Instagram User ID', 'ncstate_theme'),
                    ),
                    array(
                        'id'        => 'opt-youtube',
                        'type'      => 'text',
                        'title'     => __('YouTube', 'ncstate_theme'),
                        'subtitle'  => __('YouTube User ID', 'ncstate_theme'),
                    ),	
				)				
			);
			
            $this->sections[] = array(
                'icon'      => 'el-icon-cogs',
                'title'     => __('Footer', 'ncstate_theme'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-contact',
                        'type'      => 'editor',
                        'title'     => __('Contact Info', 'ncstate_theme'),
                        'subtitle'  => __('This will be displayed in the footer of site.  Use &lt;br /&gt; HTML tags to break content onto a new line.', 'ncstate_theme'),
						'args' => array(
							'wpautop' => 'false',
						)
                    ),
					array(
						'id' => 'opt-resources-col-1',
						'type' => 'multi_text',
						'title' => 'Resources -- Column 1',
						'subtitle' => 'Please provide link display text and URL as seen in the example text.<br /><br />University Dining##http://ncsu.edu/dining',
					),
					array(
						'id' => 'opt-resources-col-2',
						'type' => 'multi_text',
						'title' => 'Resources -- Column 2',
						'subtitle' => 'Please provide link display text and URL as seen in the example text.<br /><br />University Dining##http://ncsu.edu/dining',
					),	
				)				
			);
			
            $this->sections[] = array(
                'icon'      => 'el-icon-cogs',
                'title'     => __('Metadata', 'ncstate_theme'),
                'fields'    => array(
					array(
					    'id'   => 'info-meta',
					    'type' => 'info',
					    'desc' => __('Metadata provides additional information about your site for search engines and social media.  This allows you to indidcate what you would like for your description to be on a search engine.  It also allows you to choose what image and text is displayed on a social network such as Facebook when a link to your site is shared.  The information below will apply to every page on your site, but it can be overridden on an individual page\'s \'Custom Metadata\' section.', 'ncstate_theme')
					),
                    array(
                        'id'        => 'opt-meta-description',
                        'type'      => 'text',
                        'title'     => __('Search Engine Description', 'ncstate_theme'),
                        'subtitle'  => __('Usually displayed on search engines as the page description.', 'ncstate_theme'),
                    ),
                    array(
                        'id'        => 'opt-social-title',
                        'type'      => 'text',
                        'title'     => __('Social Network Title', 'ncstate_theme'),
                        'subtitle'  => __('Title of page when shared on a social network.', 'ncstate_theme'),
                    ),
                    array(
                        'id'        => 'opt-social-description',
                        'type'      => 'text',
                        'title'     => __('Social Network Description', 'ncstate_theme'),
                        'subtitle'  => __('Description displayed on a social network.', 'ncstate_theme'),
                    ),
                    array(
                        'id'        => 'opt-social-image',
                        'type'      => 'media',
                        'title'     => __('Social Network Image', 'ncstate_theme'),
                        'subtitle'  => __('Image shown on a social network.  Should be 180x110px.', 'ncstate_theme'),
                    ),	
				)				
			);

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'ncstate_theme'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'ncstate_theme'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'ncstate_theme')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'ncstate_theme'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'ncstate_theme')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'ncstate_theme');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array (
                'opt_name' => 'ncstate_theme',
                'allow_sub_menu' => '1',
                'customizer' => '1',
                'default_mark' => '*',
                //'footer_text' => '<p>This text is displayed below the options panel. It isn\\’t required, but more info is always better! The footer_text field accepts all HTML.</p>',
                'hint-icon' => 'el-icon-question-sign',
                'icon_position' => 'right',
                'icon_color' => 'lightgray',
                'icon_size' => 'normal',
                'tip_style_color' => 'light',
                'tip_position_my' => 'top left',
                'tip_position_at' => 'bottom right',
                'tip_show_duration' => '500',
                'tip_show_event' => 
                array (
                  0 => 'mouseover',
                ),
                'tip_hide_duration' => '500',
                'tip_hide_event' => 
                array (
                  0 => 'mouseleave',
                  1 => 'unfocus',
                ),
                //'intro_text' => '<p>This text is displayed above the options panel. It isn\\’t required, but more info is always better! The intro_text field accepts all HTML.</p>’',
                'menu_title' => 'NC State Theme Options',
                'menu_type' => 'menu',
                'output' => '1',
                'output_tag' => '1',
                'page_icon' => 'icon-themes',
                'page_parent_post_type' => 'your_post_type',
                'page_permissions' => 'manage_options',
                'page_slug' => '_options',
                'page_title' => 'Sample Options',
                'save_defaults' => '1',
                'show_import_export' => '1',
                'update_notice' => '1',
            );

            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"] = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new ncstate_theme_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('ncstate_theme_my_custom_field')):
    function ncstate_theme_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('ncstate_theme_validate_callback_function')):
    function ncstate_theme_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
