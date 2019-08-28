<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 11:09:08
 * @@Modify Date: 2018-06-14 01:21:16
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;

class Catalog extends Products{

	public function initMap()
	{
  		$listCat = array_flip($this->getCategories());
        
        $temp 	= array(
        			array(
	                    'type'          => 'dropdown',
	                    'heading'       => __( "Category Activated :", 'alothemes' ),
	                    'value'         => $listCat,
	                    'param_name'    => 'category_activated',
	                    'save_always' 	=> true,
	                ),
	                array(
	                    'type'      	=> "multiselect",
	                    'heading'   	=> __("Product Collection : <span style='color:red;'>*</span> ", 'alothemes'),
	                    'param_name' 	=> "product_collection",
	                    'value' 		=> $this->get_type("name"),
	                ),
	                array(
	                    'type'          => 'multiselect',
	                    'heading'       => __( "Categories <span style='color:red;'>*</span> :", 'alothemes' ),
	                    'value'         => $this->getCategories(),
	                    'param_name'    => 'categories',
	                    'description'   => __( 'Product Categories list', 'alothemes' ),
	                ),
	                array(
	                    'type'      	=> "dropdown",
	                    'heading'   	=> __("Product Activated : ", 'alothemes'),
	                    'param_name' 	=> "product_activated",
	                    'value' 		=>  $this->get_type(),
	                    'save_always' 	=> true,
	                ),
	                
	            );
        
        $params = array_merge(
        	$temp, 
        	$this->get_settings(), 
        	$this->get_responsive(), 
        	$this->setting_product(), 
        	$this->count_time(), 
        	$this->default_block(), 
        	$this->get_templates()
        );
        
		$this->add_VcMap($params);
	}	
}

