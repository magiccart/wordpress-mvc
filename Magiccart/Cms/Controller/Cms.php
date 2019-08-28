<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 12:11:00
 * @@Modify Date: 2017-09-06 17:23:02
 * @@Function:
 */

namespace Magiccart\Cms\Controller;

use Magiccart\Core\Controller\Action;
use Magiccart\Cms\Controller\Adminhtml\Block as AdminBlock;    
use Magiccart\Cms\Controller\Adminhtml\Cms as AdminCms;    

class Cms extends Action
{
    public function __construct()
    {
        if(is_admin()){
            new AdminBlock;
            new AdminCms;
        }else{

        }
    }
}
