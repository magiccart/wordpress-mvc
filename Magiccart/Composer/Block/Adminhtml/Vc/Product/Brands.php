<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 11:09:08
 * @@Modify Date: 2017-08-13 17:02:25
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Brands extends Vc{

	public function initMap()
	{
        $params = array_merge(
        	$this->get_settings(), 
        	$this->get_responsive(), 
        	$this->get_templates()
        );
        
		$this->add_VcMap($params);
	}
	
}

