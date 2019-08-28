<?php
namespace Magiccart\Shopbrand\Block\Adminhtml\Brand;

use Magiccart\Core\Block\Adminhtml\Template;
	
class Grid extends  Template
{
    public $listTable;

    public function __construct(){

    	$this->listTable = new ListTable();

        parent::__construct();
    } 

}

