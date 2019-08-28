<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-24 11:52:57
 * @@Modify Date: 2017-09-13 21:13:59
 * @@Function:
 */

namespace Magiccart\Cms\Block\Adminhtml\Block;

use Magiccart\Core\Block\Adminhtml\ListTable as Table;
use Magiccart\Cms\Model\Block\Collection;
	
class ListTable extends  Table{

    
    public function __construct(){

    	$collection = new Collection();

        $this->items       = $collection->getDataBlock();
        $this->total_items = $collection->totalBlock();
        
        parent::__construct();
    }
    
    /* return columns header */
    public function get_columns(){
        $columnHeader = array(
            'stt'           => 'STT',
            'name'          => 'Name',
            'short_code'    => 'Short Code',
            'published'     => 'Published',
            'edit'          => 'Edit',
            'action'        => 'Action'
        );
        return $columnHeader;
    }

    public function column_short_code($item){
        $disabled = $item['status'] ? '' : 'disabled="disabled"';
        // return "<input type='text' $disabled value='[magiccart_shortcode identifier={$item['key']}]' />";
        return '<textarea ' . $disabled . '>[magiccart_shortcode class="Magiccart\\\\Cms\\\\Block\\\\Block" identifier="' .$item['key'] . '"]</textarea>';
    }
    
}
