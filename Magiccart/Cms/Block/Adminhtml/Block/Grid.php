<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 23:54:46
 * @@Modify Date: 2017-08-24 16:40:23
 * @@Function:
 */
namespace Magiccart\Cms\Block\Adminhtml\Block;

use Magiccart\Core\Block\Adminhtml\Template;
    
class Grid extends  Template
{
    public $listTable;

    public function __construct(){

        $this->listTable = new ListTable();

        parent::__construct();
    } 

}
