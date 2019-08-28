<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-23 20:57:05
 * @@Modify Date: 2017-08-25 22:30:12
 * @@Function:
 */
 
namespace Magiccart\Magicslider\Controller;

use Magiccart\Core\Controller\Action;
use Magiccart\Magicslider\Controller\Adminhtml\Slider as AdminSlider;
class Magicslider extends Action
{
    public function __construct()
    {
        if(is_admin()){
            new AdminSlider;
        }else{

        }
    }
}
