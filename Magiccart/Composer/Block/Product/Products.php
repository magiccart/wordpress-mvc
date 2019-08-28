<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-13 17:49:46
 * @@Modify Date: 2018-06-13 23:36:37
 * @@Function:
 */

namespace Magiccart\Composer\Block\Product;

use Magiccart\Composer\Block\Shortcode;
use Magiccart\Composer\Model\Product\Collection;

class Products extends Shortcode{

    protected $_collection; 
   
    protected $_products = array();

    public function beforeShortcode(){
        if(!$this->_collection) $this->_collection = new Collection; 
    }

    public function initShortcode( $atts, $content = null ){
        global $woocommerce;
        if(!$woocommerce)  return '';
        $this->unsetData();
        $this->addData(array_merge(  $this->defaultProduct(), $atts ) );

        if($this->getData('product_collection')){
            $productCollection          = explode(',', $this->getData('product_collection'));
            
            $this->addData(array('product_collection' => $productCollection));
            if($this->getData('ajax_load')){
                $temp = array();
                $key = array_search($this->getData('product_activated'), $productCollection) ;
                if(!$key){
                    $this->addData(array('product_activated' => $productCollection[0]));
                }
                $temp[] = $productCollection[$key];
                $productCollection = $temp;
            }else{
                $key = array_search($this->getData('product_activated'), $productCollection) ;
                if($key){
                    $this->addData(array('product_activated' => $productCollection[0]));
                }
            }
            $this->_products = array();
            foreach ($productCollection as $type){
                $this->_products[$type] = $this->_collection->woo_query($type,$this->getData('number'));
            }
            return $this->toHtml();
        }
        
        return $this->addError(__( "Collection not yet select!", "alothemes" ));
    }
 
    public function getGridTemplate()
    {
        return $this->_class . '/' . str_replace($this->_class,"grid", $this->getData('template'));
    }

    public function getGridTemplateFile()
    {
        $tmp = $this->getGridTemplate();
        $tmpFile = $this->getTemplateFile($tmp);
        if(!is_dir($tmpFile) && file_exists($tmpFile)) return $tmpFile;
        $tmp = $this->_class . '/' . 'grid.phtml';
        return $this->getTemplateFile($tmp);
    }

    public function defaultProduct(){
    	$types = $this->get_type();
    	$categories = $this->_vcComposer->get_arr_category();
    	$type = array_flip(array_slice($types, 0, 1));
    	$type = implode($type, '');
    
    	$catRelated = array_flip(array_slice($categories, 0, 5));;
    	$catRelated = implode($catRelated, ',');
    
    	$default = array(
    			'default'           => $type,
    			'categories_related'=> $catRelated,
    	);
    	return $default;
    }
    
    private function get_type($type_default = "key"){
    	$type = $type_default;
    	$arrType = array(
			__('Best Selling', 'alothemes')      => 'best_selling',
			__('Featured Products', 'alothemes') => 'featured_product',
			__('Top Rate', 'alothemes')          => 'top_rate',
			__('Recent Products', 'alothemes')   => 'recent_product',
			__('On Sale', 'alothemes')           => 'on_sale',
			__('Recent Review', 'alothemes')     => 'recent_review',
			__('Product Deals', 'alothemes')     => 'deals'
    	);
    	if($type == "key") return $arrType;
    
    	return array_flip($arrType);
    }

    public function get_type_name($key){
        $arrType = array(
            __('Best Selling', 'alothemes')      => 'best_selling',
            __('Featured Products', 'alothemes') => 'featured_product',
            __('Top Rate', 'alothemes')          => 'top_rate',
            __('Recent Products', 'alothemes')   => 'recent_product',
            __('On Sale', 'alothemes')           => 'on_sale',
            __('Recent Review', 'alothemes')     => 'recent_review',
            __('Product Deals', 'alothemes')     => 'deals'
        );
    
        $arrType = array_flip($arrType);
        return $arrType[$key];
    }

    public function get_products(){
        $type = (new \ReflectionObject($this))->getShortName();
        $post = $_POST;
        define( 'DOING_AJAX', true);
        $this->addData(array('cart'     => $post["info"]['cart']));
        $this->addData(array('compare'  => $post["info"]['compare']));
        $this->addData(array('wishlist' => $post["info"]['wishlist']));
        $this->addData(array('review'   => $post["info"]['review']));
        $this->addData(array('number'   => $post["info"]['number']));
        $this->addData(array('lazy'     => $post["info"]['lazy']));

        $this->_products = array();

        $grid = isset($post["info"]['template']) ? strtolower($type) . '/' . $post["info"]['template'] : strtolower($type) . '/grid.phtml';
        $template = $this->getTemplateFile($grid);
        $template = str_replace('/view/adminhtml/templates/', '/view/frontend/templates/', $template); 
        // don't change to string 'adminhtml' and 'frontend'
        if($type == "Categories"){
            $this->addData(array('type' => $post["info"]['filter']));

            $this->_products[$post['type']] = $this->_collection->woo_query($this->getData('type'),$this->getData('number'), $post['type']);
            
            foreach($this->_products as $key => $collection){
                include $template;
            }
        }else if($type == 'Products'){
            $this->_products[$post['type']] = $this->_collection->woo_query($post['type'],$this->getData('number'));
            
            foreach($this->_products as $key => $collection){
                include $template;
            }
        }else if($type == 'Catalog'){
            $typeFilter = array("best_selling", 'featured_product', 'top_rate', 'recent_product', 'on_sale', 'recent_review', "deals");
            if(in_array($post['type'], $typeFilter)){
                
                $this->_products[$post['type']] = $this->_collection->woo_query($post['type'],$this->getData('number'), $post['info']['filter'] );
            }else{
                $this->_products[$post['type']] = $this->_collection->woo_query("",$this->getData('number'), $post['type']);
            }
            foreach($this->_products as $key => $collection){
                include $template;
            }
        }
    }

}
