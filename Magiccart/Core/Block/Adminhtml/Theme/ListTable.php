<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-12-07 11:52:57
 * @@Modify Date: 2017-12-07 14:42:41
 * @@Function:
 */

namespace Magiccart\Core\Block\Adminhtml\Theme;

use Magiccart\Core\Block\Adminhtml\ListTable as Table;
use Magiccart\Core\Model\Theme\Collection;
	
class ListTable extends  Table{

    
    public function __construct(){

    	$collection = new Collection();

        $this->items       = $collection->getItems();
        $this->total_items = $collection->getTotal();
        
        parent::__construct();
    }
    
    /* return columns header */
    public function get_columns(){
        $columnHeader = array(
            'stt'           => 'STT',
            'name'          => 'Name',
            'theme'         => 'Theme',
            'published'     => 'Published',
            'edit'          => 'Edit',
            'action'        => 'Action'
        );
        return $columnHeader;
    }

    public function column_theme($item){
        // $disabled = $item['status'] ? '' : 'disabled="disabled"';
        // // return "<input type='text' $disabled value='[magiccart_shortcode identifier={$item['key']}]' />";
        // return '<textarea ' . $disabled . '>[magiccart_shortcode class="Magiccart\\\\Cms\\\\Block\\\\Block" identifier="' .$item['key'] . '"]</textarea>';
    }
    
}
