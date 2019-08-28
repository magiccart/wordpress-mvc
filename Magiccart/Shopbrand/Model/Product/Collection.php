<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-06-09 00:57:51
 * @@Modify Date: 2018-06-10 11:57:12
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model\Product;

class Collection{
	
	/*==========================================================================
	 WooCommerce - Function get Query
	 ==========================================================================*/
	public function woo_query($attribute, $value, $post_per_page=-1, $paged=''){
		global $woocommerce;
		if(!$woocommerce) return array();
	
		$meta_query   = array();
		$meta_query[] = $woocommerce->query->stock_status_meta_query();
		$meta_query[] = $woocommerce->query->visibility_meta_query();
	
		remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_popularity_post_clauses' ) );
		
		if(!$paged) {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		$args = array(
				'post_type'         => 'product',
				'posts_per_page'    => $post_per_page,
				'post_status'       => 'publish',
				'paged'             => $paged
		);

		$args['meta_query'] = $meta_query;
		$args['tax_query']  = array(
			array(
	                'taxonomy' => $attribute,
	                'field'    => 'name',
	                'terms'    => $value,
	            )
		);
		$args['order']   = 'ASC';

		return new \WP_Query($args);
	}
}
