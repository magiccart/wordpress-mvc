<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-24 17:24:50
 * @@Modify Date: 2017-08-24 17:41:07
 * @@Function:
 */

namespace Magiccart\Core\Block\Adminhtml\Block;

class Edit extends Template{
    
    public function get_url_grid()
    {
    	$page    = $_GET['page'];  
    	return "?page=$page&block=gird&module=cms&model=collection&view=gird";
    }

}
