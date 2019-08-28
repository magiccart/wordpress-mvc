<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-13 22:42:42
 * @@Modify Date: 2017-09-19 23:05:42
 * @@Function:
 */

namespace Magiccart\Composer\Block\Product;

use Magiccart\Composer\Block\Shortcode;
use Magiccart\Shopbrand\Model\Brand\Collection as brandCollection;

class Brands extends Shortcode{

    protected $_brands = array();
    public $_brandCollection;
    
    public function initShortcode( $atts, $content = null ){
        $this->unsetData();
        $this->addData($atts);
        if(!$this->_brandCollection) {
            $this->_brandCollection = new brandCollection;
        }
        $brands   = $this->_brandCollection->getCollection();
        foreach ($brands as $key => $value) {
            if(!$value['status']){
                unset($brands[$key]);
            }
        }
        if(isset($atts['number']) && $atts['number']){
            $this->_brands = array_slice($brands, 0, $atts['number']);
        } else {
            $this->_brands = $brands;
        }

        return $this->toHtml();
    }
}

