<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-10-09 18:41:29
 * @@Function:
 */

namespace Magiccart\Composer\Block\Element;
use Magiccart\Composer\Block\Shortcode;

class Copyright extends Shortcode{

    public function initShortcode( $atts, $content = null){
        if(is_array($atts)) $this->addData($atts);
        return $this->toHtml();
    }

}

