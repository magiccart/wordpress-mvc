<?php

namespace Magiccart\Megamenu\Block\Adminhtml\Menu;
use Magiccart\Megamenu\Block\Adminhtml\Menu\Item;

class Edit extends \Walker_Nav_Menu_Edit {
    private $style = '';
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $item_output = '';
        parent::start_el($item_output, $item, $depth, $args, $id);
        
        $new_fields  = Item::get_field($item, $depth, $args);
        $item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $new_fields, $item_output);
        $output .= $item_output;
    }
}


