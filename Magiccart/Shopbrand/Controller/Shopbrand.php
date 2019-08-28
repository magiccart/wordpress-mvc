<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-25 16:33:14
 * @@Modify Date: 2018-04-23 00:24:21
 * @@Function:
 */

namespace Magiccart\Shopbrand\Controller;

use Magiccart\Core\Controller\Action;
use Magiccart\Shopbrand\Controller\Adminhtml\Brand as AdminBrand;

class Shopbrand extends Action
{
    public function __construct()
    {
        
    	if(!defined('SHOPBRAND')){
    		define('SHOPBRAND', 'manufacturer');
    	}
        if(is_admin()){
            new AdminBrand;
        }else{

        }
    }
}
