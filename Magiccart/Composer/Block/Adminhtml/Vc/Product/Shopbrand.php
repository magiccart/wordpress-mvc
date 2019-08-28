<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-06-07 14:20:46
 * @@Modify Date: 2018-06-14 00:32:39
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Shopbrand extends Vc{

	public function initMap()
	{
        $limit = array(
                'type'          => "textfield",
                'heading'       => __("Limit : ", 'alothemes'),
                'description'   => __('Limit of product to show.', 'alothemes'),
                'param_name'    => "limit",
                'value'         => "12",
                'group'         => __( 'Setting Product', 'alothemes' ),
                'save_always'   => true,                
                );
        $params = array_merge(
        	$this->get_settings(), 
        	$this->get_responsive(),
        	$this->setting_product($limit), 
        	$this->get_templates()
        );
        
		$this->add_VcMap($params);
	}
	
}

