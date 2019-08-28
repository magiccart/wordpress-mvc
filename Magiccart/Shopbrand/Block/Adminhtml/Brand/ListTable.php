<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-24 11:52:57
 * @@Modify Date: 2018-06-06 14:41:44
 * @@Function:
 */

namespace Magiccart\Shopbrand\Block\Adminhtml\Brand;

use Magiccart\Core\Block\Adminhtml\ListTable as Table;
use Magiccart\Shopbrand\Model\Brand\Collection;
	
class ListTable extends  Table{

    public function __construct(){

    	$collection        = new Collection();
        $this->items       = $collection->getBrands();
        $this->total_items = $collection->totalBrands();

        parent::__construct();
    }
    
    /* return columns header */
    public function get_columns(){
        $columnHeader = array(
            'stt'           => 'STT',
            'name'          => 'Name',
        	'brand'         => 'Brand',
            'image'    		=> 'Image',
            'published'     => 'Published',
            'edit'          => 'Edit',
            'action'        => 'Action',
        );

        return $columnHeader;
    }   

    public function column_brand($item)
    {
        return isset($item['brand']) ? ucfirst($item['brand']) : '';
    }

}
