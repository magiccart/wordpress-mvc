<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-06-03 19:22:49
 * @@Modify Date: 2018-06-04 10:55:10
 * @@Function:
 */

namespace Magiccart\Widgets\Block\Walker;


if ( ! class_exists( 'Product_Cat_Dropdown_Walker', false ) ) :

class Portfolio_Cat_Dropdown_Walker extends \Walker {

	public $_idCurrent = '';
	public $tree_type = 'portfolio_category';

	public $db_fields = array(
		'parent' => 'parent',
		'id'     => 'term_id',
		'slug'   => 'slug',
	);

	public function __construct($current){
		//parent::__construct();
		$this->_idCurrent = $current;
	}

	
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat( "\t", $depth );
		$output .= "$indent<ul class='submenu children'>\n";
	}

	
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	
	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$active = '';
		if($cat->term_id == $this->_idCurrent){
			$active = 'active';
		}
		if($depth == 0) $active .= 'level0';
		$output .= '<li class="'. $active .' cat-item cat-item-' . $cat->term_id;

		if ( $args['current_category'] == $cat->term_id ) {
			$output .= ' current-cat';
		}

		if ( $args['has_children'] && $args['hierarchical'] ) {
			$output .= ' cat-parent';
		}

		if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
			$output .= ' current-cat-parent';
		}

		$classer = ($depth == 0) ? 'level0 item' : 'item';
		$output .= '"><a class="' . $classer . '" href="' . get_term_link( (int) $cat->term_id, $this->tree_type ) . '">' . $cat->name . '</a>';

		if ( $args['show_count'] ) {
			$output .= ' <span class="count">(' . $cat->count . ')</span>';
		}
	}

	
	public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

	
	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		if ( ! $element || ( 0 === $element->count && ! empty( $args[0]['hide_empty'] ) ) ) {
			return;
		}
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

}

endif;
