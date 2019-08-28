<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-13 17:50:35
 * @@Modify Date: 2018-06-13 23:36:29
 * @@Function:
 */

namespace Magiccart\Composer\Block\Product;

class Categories extends Products{

    public function initShortcode( $atts, $content = null ){
        global $woocommerce;
        if(!$woocommerce)  return '';
        $this->unsetData();
        $this->addData( array_merge( $this->defaultProduct(), $atts ) );

        $categories    = $this->getCategoriesByIdName($this->getData('categories'));
        $defaultSlug = $this->getCategoriesByIdKey($this->getData('category_activated'));
                $this->addData(array('defaultSlug' => $defaultSlug));
        $this->addData(array('categories' => $categories));
        
        if($categories){
            if($this->getData('ajax_load')){
                $temp[] = isset($categories[$defaultSlug]) ? $defaultSlug : '';
                if($temp[0] != ""){
                    $categories = $temp;
                }else{
                    $temp = $categories;
                    $first = array_shift($temp);
                    $key = array_search($first, $categories);
                    $this->addData(array('defaultSlug' => $key));
                    $categoryTemp[$key] = $categories[$key];
                    $categories = $categoryTemp;
                }
            }else{
                $temp = $categories;
                $first = array_shift($temp);
                $key = array_search($first, $categories);
                $this->addData(array('defaultSlug' => $key));
            }
            $this->_products = array();
            foreach ($categories as $key => $value){
                $this->_products[$key] = $this->_collection->woo_query($this->getData('product_activated'),$this->getData('number'), $key);
            }
            return $this->toHtml();
        }
        
        return $this->addError(__( "Category not yet select!", "alothemes" ));
    }
    
    public function defaultProduct(){
    	$categories = $this->_vcComposer->get_arr_category();
    	
    	$category = array_flip(array_slice($categories, 0, 1));
    	$category = implode($category, '');
    
    	$catRelated = array_flip(array_slice($categories, 0, 5));;
    	$catRelated = implode($catRelated, ',');
    	 
    	$default = array(
    			'default'           => $category,
    			'categories_related'=> $catRelated,
    	);
    	return $default;
    }  
}
