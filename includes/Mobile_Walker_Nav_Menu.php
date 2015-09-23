<?php

// Mobile Nav Walker

class Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {

  /**
   * Display array of elements hierarchically.
   *
   * Does not assume any existing order of elements.
   *
   * $max_depth = -1 means flatly display every element.
   * $max_depth = 0 means display all levels.
   * $max_depth > 0 specifies the number of display levels.
   *
   * @since 2.1.0
   *
   * @param array $elements  An array of elements.
   * @param int   $max_depth The maximum hierarchical depth.
   * @return string The hierarchical item output.
   */
  public function walk( $elements, $max_depth) {

    $args = array_slice(func_get_args(), 2);
    $output = '';

    if ($max_depth < -1) //invalid parameter
      return $output;

    if (empty($elements)) //nothing to walk
      return $output;

    $parent_field = $this->db_fields['parent'];

    // flat display
    if ( -1 == $max_depth ) {
      $empty_array = array();
      foreach ( $elements as $e )
        $this->display_element( $e, $empty_array, 1, 0, $args, $output );
      return $output;
    }

    /*
     * Need to display in hierarchical order.
     * Separate elements into two buckets: top level and children elements.
     * Children_elements is two dimensional array, eg.
     * Children_elements[10][] contains all sub-elements whose parent is 10.
     */
    $top_level_elements = array();
    $children_elements  = array();
    foreach ( $elements as $e) {
      if ( 0 == $e->$parent_field )
        $top_level_elements[] = $e;
      else
        $children_elements[ $e->$parent_field ][] = $e;
    }

    /*
     * When none of the elements is top level.
     * Assume the first one must be root of the sub elements.
     */
    if ( empty($top_level_elements) ) {

      $first = array_slice( $elements, 0, 1 );
      $root = $first[0];

      $top_level_elements = array();
      $children_elements  = array();
      foreach ( $elements as $e) {
        if ( $root->$parent_field == $e->$parent_field )
          $top_level_elements[] = $e;
        else
          $children_elements[ $e->$parent_field ][] = $e;
      }
    }

    /**
     * Modified here to find the current menu item ancestor and only display it's children
     *
     * Added by Andrew Matthews 2/24/15
     */
    foreach ( $top_level_elements as $e ) {
      if( $max_depth == 1 ) {
        $this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
      }
      elseif( $max_depth == 0 && isset($children_elements[ $e->ID ]) ) {
        $this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
      }
    }

    /*
     * If we are displaying all levels, and remaining children_elements is not empty,
     * then we got orphans, which should be displayed regardless.
     *
     * Removed by Andrew Matthews 2/26/15. Spits out unwanted elements.
     */
    // if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
    //   $empty_array = array();
    //   foreach ( $children_elements as $orphans )
    //     foreach( $orphans as $op )
    //       $this->display_element( $op, $empty_array, 1, 0, $args, $output );
    //  }

     return $output;
  }

  /**
   *  Adds the 'list-unstyled' class to all sub-menus
   */
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"sub-menu list-unstyled\">\n";
  }

  /**
   * Start the element output.
   *
   * @see Walker::start_el()
   *
   * @since 3.0.0
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param object $item   Menu item data object.
   * @param int    $depth  Depth of menu item. Used for padding.
   * @param array  $args   An array of arguments. @see wp_nav_menu()
   * @param int    $id     Current item ID.
   */
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;

    /**
     * If item has children and item is a top level element, add 'has-more'
     *
     * Added by Andrew Matthews 2/26/15
     */
    $has_children = $args->walker->has_children;
    if ( $has_children && $item->menu_item_parent == 0 && $args->depth == 1) {
      $classes[] = 'has-more';
    } elseif( $has_children && $item->menu_item_parent != 0 && $args->depth == 0) {
      $classes[] = 'has-dropdown';
    }

    /**
     * Filter the CSS class(es) applied to a menu item's list item element.
     *
     * @since 3.0.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
     * @param object $item    The current menu item.
     * @param array  $args    An array of {@see wp_nav_menu()} arguments.
     * @param int    $depth   Depth of menu item. Used for padding.
     */
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    /**
     * Filter the ID applied to a menu item's list item element.
     *
     * @since 3.0.1
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
     * @param object $item    The current menu item.
     * @param array  $args    An array of {@see wp_nav_menu()} arguments.
     * @param int    $depth   Depth of menu item. Used for padding.
     */
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    /**
     * Add ID for each Level 2 menu for js to hook
     *
     * Added by Andrew Matthews 2/26/15
     */
    if( $item->menu_item_parent == 0 && $args->depth == 0 ) {
      $id = " id=" . $item->ID . "-sub";
    }

    $output .= $indent . '<li' . $id . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

    /**
     * Filter the HTML attributes applied to a menu item's anchor element.
     *
     * @since 3.6.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array $atts {
     *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
     *
     *     @type string $title  Title attribute.
     *     @type string $target Target attribute.
     *     @type string $rel    The rel attribute.
     *     @type string $href   The href attribute.
     * }
     * @param object $item  The current menu item.
     * @param array  $args  An array of {@see wp_nav_menu()} arguments.
     * @param int    $depth Depth of menu item. Used for padding.
     */
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $item_output = $args->before;

    /**
     * If item has children and needs a button, provide button HTML
     *
     * Added by Andrew Matthews 2/26/15
     */
    if( $has_children ) {
      // Level 1 button
      if( $args->depth == 1 ) {
        $data_sub = " data-sub=\"#" . $item->ID . "-sub\"";
        $item_output .= "<button type=\"button\"" . $data_sub . "><span class=\"glyphicon glyphicon-thin-chevron\"></span></button>";
      // Level 2 button
      } elseif( $args->depth == 0 && $depth == 1 ) {
        $item_output .= "<button type=\"button\"><span class=\"glyphicon glyphicon-thin-chevron\"></span></button>";
      }
    }

    $item_output .= '<a'. $attributes .'>';
    /** This filter is documented in wp-includes/post-template.php */
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    /**
     * Filter a menu item's starting output.
     *
     * The menu item's starting output only includes `$args->before`, the opening `<a>`,
     * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
     * no filter for modifying the opening and closing `<li>` for a menu item.
     *
     * @since 3.0.0
     *
     * @param string $item_output The menu item's starting HTML output.
     * @param object $item        Menu item data object.
     * @param int    $depth       Depth of menu item. Used for padding.
     * @param array  $args        An array of {@see wp_nav_menu()} arguments.
     */
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }


}
