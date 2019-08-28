<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-23 20:55:31
 * @@Modify Date: 2017-09-25 21:54:00
 * @@Function:
 */
 
namespace Magiccart\Magicslider\Block\Adminhtml\Slider;

use Magiccart\Core\Block\Adminhtml\Template;
use Magiccart\Magicslider\Model\Slider\Collection;

 class Grid extends Template{
    public $_items;
    public function __construct(){
        
        $collection   = new Collection();
        $this->_items = $collection->getGroupSlider();

        parent::__construct();
    }
}
