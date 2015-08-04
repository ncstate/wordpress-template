<?php

class Sidebar_Walker_Level_Menu extends Walker_Nav_Menu {


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
  

  	public static function is_ancestor($e){

  		if ($e->current_item_ancestor OR $e->current_item_parent OR $e->current) {
  			return true;
  		} else {
  			return false;
  		}

  	}

	public function walk( $elements, $max_depth) {

		/*
		//title = name in menu 
		//id = id name of menu object
		// there is no actual object title of page

		*/
		 
		$args = array_slice(func_get_args(), 2);
		$output = '';
		$empty_array = array();
		$levels = array();
		$level = array();
		$all_first_levels = array();

		$in = false;
		$current_page_id = strval(get_the_ID());

		foreach($elements as $e) {
			if ($e->object_id == $current_page_id) {
				$in = true;
			}
		}

		if (!$in) {
			return false;
		}

		/* START TOP LEVEL ONLY */
		foreach ($elements as $e) {
			
			if ($e->current) {
				$current = $e;
			}
			
			if ( (!$e->menu_item_parent AND $e->current_item_ancestor) OR ($e->current AND !$e->menu_item_parent) OR ($e->current_item_parent AND !$e->menu_item_parent) ) {
				$top = $e;
			}

			if (!$e->menu_item_parent) {
				$all_first_levels[] = $e;
			}

		}

		if ($current == $top && !in_array('menu-item-has-children',$current->classes)) {
			return false;
		}

			foreach($elements as $e ) {
				if ($e->menu_item_parent == strval($top->ID)) {
					$level[0][] = $e;
				}
			}


			foreach ($level[0] as $l) {
				foreach ($elements as $e) {
					if ($e->menu_item_parent == strval($l->ID)) {
						$level[1][$l->ID][] = $e;
					}
				}
			}



			if (isset($level[1])) {
			foreach($level[1] as $l) {
				foreach($l as $lsub) {
					foreach ($elements as $e) {
						if ($e->menu_item_parent == strval($lsub->ID)) {
							$level[2][$lsub->ID][] = $e;
						}
					}
					
				}
			}
			}

		if ( true ):
			$this->display_element( $top, $empty_array, 1, 0, $args, $output );
			$this->start_lvl($output);



			foreach ($level[0] as $l) {
				$this->display_element( $l, $empty_array, 1, 0, $args, $output );
				if (self::is_ancestor($l)) {
					$this->start_lvl($output);
					if (isset($level[1][$l->ID])) {
						foreach($level[1][$l->ID] as $l1) {
							$this->display_element( $l1, $empty_array, 1, 0, $args, $output );
							if (self::is_ancestor($l1)) {
								$this->start_lvl($output);
								if (isset($level[2][$l1->ID])) {
									foreach($level[2][$l1->ID] as $l2) {
										$this->display_element( $l2, $empty_array, 1, 0, $args, $output );
									}
								}
								$this->end_lvl($output);
							}
						}
					}
					$this->end_lvl($output);
				}
			}

			$this->end_lvl($output);

		else:

			if (!$current->menu_item_parent) {

				foreach($elements as $e ) {
					if ($e->menu_item_parent == strval($current->ID)) {
						$levels[] = $e;
					}
				}



				foreach ($all_first_levels as $f) :

					if ($f == $current) {
						$this->display_element( $f, $empty_array, 1, 0, $args, $output );
						if( isset($levels) AND !empty($levels)) {
							$this->start_lvl($output);
							foreach($levels as $lev) {
								$this->display_element( $lev, $empty_array, 1, 0, $args, $output );
							}
							$this->end_lvl($output);
						}
					} else {
						$this->display_element( $f, $empty_array, 1, 0, $args, $output );
					}
					

				endforeach;


			} else {

				foreach($all_first_levels as $f) :
					$this->display_element( $f, $empty_array, 1, 0, $args, $output );
					if ($f == $top) {
						$this->start_lvl($output);
						foreach ($level[0] as $l) {
							$this->display_element( $l, $empty_array, 1, 0, $args, $output );
							if (self::is_ancestor($l)) {
								$this->start_lvl($output);
								if (isset($level[1][$l->ID])) {
									foreach($level[1][$l->ID] as $l1) {
										$this->display_element( $l1, $empty_array, 1, 0, $args, $output );
										if (self::is_ancestor($l1)) {
											$this->start_lvl($output);
											if (isset($level[2][$l1->ID])) {
												foreach($level[2][$l1->ID] as $l2) {
													$this->display_element( $l2, $empty_array, 1, 0, $args, $output );
												}
											}
											$this->end_lvl($output);
										}
									}
								}
								$this->end_lvl($output);
							}
						}
						$this->end_lvl($output);
					}
				endforeach;
			}

		endif;

		return $output;

	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n<ul class=\"sub-menu list-unstyled\">\n";
		return $output;
	}
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n</ul>\n";
		return $output;
	}


}

?>