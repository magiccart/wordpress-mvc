<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-08-13 20:29:35
 * @@Function:
 */

namespace Magiccart\Composer\Block\Product;
use Magiccart\Composer\Block\Shortcode;

class Minicart extends Shortcode{

    public function initShortcode( $atts, $content = null){
        // if ( !class_exists( 'WooCommerce' ) ) return;
        $this->addData($atts);
        return $this->toHtml();
    }

}

