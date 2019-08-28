<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-10-26 10:22:36
 * @@Modify Date: 2017-10-26 18:41:49
 * @@Function:
 */

namespace Magiccart\Element\Block;

class Logo extends Shortcode{

    public function initShortcode( $atts, $content = null){
        if(is_array($atts)) $this->addData($atts);
        return $this->toHtml();
    }

}

