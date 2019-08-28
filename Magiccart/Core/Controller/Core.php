<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 17:22:24
 * @@Modify Date: 2018-03-12 14:36:54
 * @@Function:
 */
 
namespace Magiccart\Core\Controller;

use Magiccart\Core\Controller\Index as FontIndex;
use Magiccart\Core\Controller\Adminhtml\Index as AdminIndex;
// use Magiccart\Core\Controller\Adminhtml\Theme as AdminTheme;
// use Magiccart\Core\Block\Themestyle;

class Core {
    public function __construct()
    {
        if(is_admin()){
            new AdminIndex();
            // new AdminTheme();
        }else{
            new FontIndex();
        }
        // new Themestyle();
    } 
}
