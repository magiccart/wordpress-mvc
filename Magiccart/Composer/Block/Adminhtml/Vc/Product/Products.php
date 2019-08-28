<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 11:09:08
 * @@Modify Date: 2018-06-14 01:21:03
 * @@Function:
 */

namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Products extends Vc{

    public function initMap(){
        $temp = array(
		                array(
		                    'type'              => "multiselect",
		                    'heading'           => __("Product Collection  <span style='color:red;'>*</span> :", 'alothemes'),
		                    'param_name'        => "product_collection",
		                    'value'             => $this->get_type("name"),
		                ),
		                array(
		                    'type'      	=> "dropdown",
		                    'heading'   	=> __("Product Activated : ", 'alothemes'),
		                    'param_name' 	=> "product_activated",
		                    'value' 		=>  $this->get_type(),
		                    'save_always' 	=> true,
		                )
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

    protected function get_type($type_default = "key"){
        $type = $type_default;
        $arrType = array(
            __('Best Selling', 'alothemes')      => 'best_selling',
            __('Featured Products', 'alothemes') => 'featured_product',
            __('Top Rate', 'alothemes')          => 'top_rate',
            __('Recent Products', 'alothemes')   => 'recent_product',
            __('On Sale', 'alothemes')           => 'on_sale',
            __('Recent Review', 'alothemes')     => 'recent_review',
            __('Product Deals', 'alothemes')     => 'deals'
        );
        if($type == "key") return $arrType;
    
        return array_flip($arrType);
    }

    protected function getCategories(){
        return $this->_vcComposer->get_arr_category();
    }

    protected function count_time(){
        $downTime = array(
                        array(
                            'type'          => "date",
                            'heading'       => __('Countdown Time :', 'alothemes'),
                            'param_name'    => 'date',
                            'group'         => __( 'Settings', 'alothemes' ),
                        ),
                    );
        return $downTime;
    }
    
    protected function default_block(){
        $vcComposer = $this->_vcComposer;
        $settings = array(
                array(
                    'type'          => "dropdown",
                    'heading'       => __("Block Left :", 'alothemes'),
                    'param_name'    => "shortcode_left",
                    'value'         => $vcComposer->getBlocks(),
                    'save_always'   => true,
                ),
                array(
                    'type'          => "dropdown",
                    'heading'       => __("Block Bottom :", 'alothemes'),
                    'param_name'    => "shortcode_bottom",
                    'value'         => $vcComposer->getBlocks(),
                    'save_always'   => true,
                ),
        );
        return $settings;
    }

}

