<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-12-07 11:54:46
 * @@Modify Date: 2017-12-07 15:48:38
 * @@Function:
 */
namespace Magiccart\Core\Block\Adminhtml\Theme;

use Magiccart\Core\Block\Adminhtml\Template;
    
class Grid extends  Template
{
    public $_template= 'theme/grid.phtml';
    public $listTable;

    public function __construct(){

        $this->listTable = new ListTable();

        parent::__construct();
    } 

}
