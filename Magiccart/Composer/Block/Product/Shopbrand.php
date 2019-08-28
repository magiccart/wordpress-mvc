<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-06-07 13:57:54
 * @@Modify Date: 2018-06-14 00:46:11
 * @@Function:
 */

namespace Magiccart\Composer\Block\Product;

use Magiccart\Composer\Block\Shortcode;
use Magiccart\Shopbrand\Model\Product\Collection as productCollection;
use Magiccart\Shopbrand\Model\Brand\Collection as brandCollection;

class Shopbrand extends Shortcode{

    protected $_brands = array();
    public $_brandCollection;
    public $_productCollection;
    public $_attribute;

    protected $_products = array();

    public function beforeShortcode(){
        $this->_attribute = 'pa_' . SHOPBRAND;
        if(!$this->_productCollection) $this->_productCollection = new productCollection; 
    }

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
        if(isset($atts['limit']) && $atts['limit']){
            $this->_brands = array_slice($brands, 0, $atts['limit']);
        } else {
            $this->_brands = $brands;
        }
        
        global $woocommerce;
        if(!$woocommerce)  return '';
        $type = '';
        foreach ($this->_brands as $item) {
            $type = $item['brand'];
            break;
        }
        if(!$this->_productCollection) {
            $this->_productCollection = new productCollection;
        }
        $this->_products[$type] = $this->_productCollection->woo_query($this->_attribute, $type, $this->getData('limit'));

        return $this->toHtml();
    }

    public function get_products(){
        $type = (new \ReflectionObject($this))->getShortName();
        $post = $_POST;
        define( 'DOING_AJAX', true);
        $this->addData(array('cart'     => $post["info"]['cart']));
        $this->addData(array('compare'  => $post["info"]['compare']));
        $this->addData(array('wishlist' => $post["info"]['wishlist']));
        $this->addData(array('review'   => $post["info"]['review']));
        $this->addData(array('limit'    => $post["info"]['limit']));

        $this->_products = array();
        $grid = isset($post["info"]['template']) ? $post["info"]['template'] : strtolower($type) . '/grid.phtml';
        $template = $this->getTemplateFile($grid);
        $template = str_replace('/view/adminhtml/templates/', '/view/frontend/templates/', $template); 
        // don't change to string 'adminhtml' and 'frontend'

        $this->_products[$post['type']] = $this->_productCollection->woo_query($this->_attribute, $post['type'], $this->getData('limit'));

        foreach($this->_products as $key => $collection){
            include $template;
        }
    }
}

