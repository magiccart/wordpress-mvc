<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-13 22:50:26
 * @@Modify Date: 2017-09-25 22:17:22
 * @@Function:
 */

namespace Magiccart\Composer\Model;

use Magiccart\Cms\Model\Block\Collection as blockCollection;
use Magiccart\Magicslider\Model\Slider\Collection as sliderCollection;

class Vccomposer{
    
    public $_blocks;
    public $_sllider;

    // **********************************************************************//
    // get Category + parent-child category
    // **********************************************************************//
    public function getCategoryChildsFull( $parent_id, $pos, $array, $level, &$dropdown ) {
        for ( $i = $pos; $i < count( $array ); $i ++ ) {
            if ( $array[ $i ]->category_parent == $parent_id ) {
                $name = str_repeat( '- ', $level ) . $array[ $i ]->name;
                $value = $array[ $i ]->cat_ID;
                $dropdown[] = array(
                    'label' => $name,
                    'value' => $value,
                );
                $this->getCategoryChildsFull( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
            }
        }
    }
    
    // **********************************************************************//
    // get_arr value category
    // **********************************************************************//
    public function get_arr_category(){
        $args = array(
            'type'          => 'post',
            'child_of'      => 0,
            'parent'        => '',
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'hierarchical'  => 1,
            'exclude'       => '',
            'include'       => '',
            'number'        => '',
            'taxonomy'      => 'product_cat',
            'pad_counts'    => false,
    
        );
        $categories = get_categories( $args );
        $product_categories_dropdown = array();
        $product_categories = array();
        $this->getCategoryChildsFull( 0, 0, $categories, 0, $product_categories_dropdown );


        foreach($product_categories_dropdown as $value){
            $product_categories[$value['value']] = $value['label'];
        }
       
        return $product_categories;
    }

    // **********************************************************************//
    // get parent category
    // **********************************************************************//
    public function get_parent_category(){
        $args = array(
            'type'          => 'post',
            'child_of'      => 0,
            'parent'        => '',
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'hierarchical'  => 1,
            'exclude'       => '',
            'include'       => '',
            'number'        => '',
            'taxonomy'      => 'product_cat',
            'pad_counts'    => false,
    
        );
        $parent = array();
        $parent['-- Select --'] = "";
        $categories = get_categories( $args );
        
        foreach ($categories as $value){
            if($value->parent == 0){
                $parent[ $value->name ] = $value->term_id;
            }
        }
        return $parent;
    }

    public function getBlocks()
    {
        if(!$this->_blocks) {
            $model = new blockCollection;
            $this->_blocks = $model->getCollection();
        }
        $arrBlock   = array();
        $arrBlock[] = '-- Please select a static block --';
        $blocks     = $this->_blocks;
        
        if(is_array($blocks)){
            foreach($blocks as $key => $value){
                if($value['status']) $arrBlock[$key] = $value['name'];
            }
        }
        return array_flip($arrBlock);
    }

    public function getSlider()
    {
        if(!$this->_sllider) {
            $model = new sliderCollection;
            $this->_sllider = $model->getCollection();
        }
        $optionSlider = $this->_sllider;
        $sliders      = array();
        
        if(is_array($optionSlider)){
            foreach($optionSlider as $value){
                $sliders[$value['key-group']] = $value['name'];
            }
        }
        return $sliders;
    }
}
