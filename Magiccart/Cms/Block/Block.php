<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 20:44:49
 * @@Modify Date: 2017-09-13 21:52:26
 * @@Function:
 */

namespace Magiccart\Cms\Block;

use Magiccart\Core\Block\Template;
use Magiccart\Cms\Model\Block\Collection;

class Block extends Template{

    public $_collection;

    public function initShortcode( $atts ){
        if (!isset($atts['identifier']) || !$atts['identifier']) return ;
        if(!$this->_collection) {
            $this->_collection = new Collection;
        }
        $blocks   = $this->_collection->getCollection();
        $identifier    = $atts['identifier'];
        if(isset($blocks[$identifier]['content'])){
            if($blocks[$identifier]['status']){
                $editorText = $blocks[$identifier]['content'];
                print_r(wp_kses_post( $editorText));
            }
        }
    }
}
