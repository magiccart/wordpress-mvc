<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-01 22:57:48
 * @@Modify Date: 2018-03-12 20:39:20
 * @@Function:
 */

namespace Magiccart\Composer\Block;

use Magiccart\Core\Block\Template;
use Magiccart\Composer\Model\Vccomposer;

class Shortcode extends Template{

    protected $_vcComposer;
    protected $nameShortcode;

    public function __construct(){
        parent::__construct();
        $this->_vcComposer = new Vccomposer();
        if(!$this->nameShortcode) $this->nameShortcode = 'magiccart_' . $this->_class;
        $this->beforeShortcode();
        add_shortcode($this->nameShortcode, array($this, 'initShortcode'));
        $this->afterShortcode();

    }

    public function beforeShortcode(){
        // NULL
    }
    
    public function initShortcode($atts, $content = null ){
        $this->addData((array) $atts);
    }

    public function afterShortcode(){
        // NULL
    }
    
    public function getOptions(){

        // if(isset($_GET['visible'])) $this->addData( array('visible' => absint($_GET['visible'])) ); // USED DEMO 

        $arrResponsive = array(1201=>'visible', 1200=>'desktop', 992=>'notebook', 768=>'tablet', 641=>'landscape', 481=>'portrait', 361=>'mobile');
        $settings = array();
        $settings['padding'] = $this->getData('padding');    
        $total   = count($arrResponsive);
        if($this->getData('slide')){
            $options = array(
                    'autoplay',
                    'arrows',
                    'dots',
                    'infinite',
                    'padding',
                    'responsive' ,
                    'rows',
                    //'vertical-swiping',
                    //'swipe-to-slide',
                    'autoplay-speed',
                    //'slides-to-show'
                    'vertical',
            );
            
            foreach ($options as $value){
                $settings[$value] = $this->getData( $value );
            }
            $settings['vertical-swiping'] = $this->getData('vertical');
            $settings['slides-to-show']   = $this->getData('visible');
            $settings['swipe-to-slide']   = 'true';
            
            $responsive = '[';
            foreach ($arrResponsive as $size => $screen) {
                $responsive .= '{"breakpoint": "'.$size.'", "settings":{"slidesToShow":"'.$this->getData($screen).'"}}';
                if($total-- > 1) $responsive .= ', ';
            }
            $responsive .= ']';
            $settings['responsive']         = $responsive;
 
        }else{          
            $responsive = '[["'. $this->getData('mobile') .'"],';
            ksort($arrResponsive);
            foreach ($arrResponsive as $size => $screen) {
                $size -= 1;
                $responsive .= '{"'.$size.'":"'.$this->getData($screen).'"}';
                if($total-- > 1) $responsive .= ',';
            }
            $responsive .= ']';
            $settings['responsive'] = $responsive;
        }
        return $settings;
    }

    public function getCategoryById($cat_id, $taxonomy='product_cat'){
        $term = get_term_by( 'id', $cat_id, $taxonomy );
        return $term;
    }

    public function getCategoriesByIdKey($ids, $taxonomy='product_cat'){
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
            'taxonomy'      => $taxonomy,
            'pad_counts'    => false,
    
        );
        $categories = get_categories( $args );

        $arrCategories = explode(',', $ids);

        $keyCat = '';
        foreach ($categories as $key => $value) {
            foreach ($arrCategories as $ky => $val) {
                if($value->cat_ID == $val){
                    $keyCat .= $value->slug . ',';
                }
            }
        }
        return $keyCat;
    }

    public function getSlugCategoryById($category_id, $taxonomy='product_cat')
    {
        $term = get_term_by( 'id', $category_id, $taxonomy, 'ARRAY_A' );
        if($term) return $term['slug'];
    }

    public function getCategoriesByIdName($ids, $arr = true, $taxonomy='product_cat'){
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
            'taxonomy'      => $taxonomy,
            'pad_counts'    => false,
    
        );
        $categories = get_categories( $args );

        $arrCategories = explode(',', $ids);

        $nameCat = '';
        foreach ($categories as $key => $value) {
            foreach ($arrCategories as $ky => $val) {
                if($arr == true){
                    if($value->cat_ID == $val){
                        $nameCat[$value->slug] = $value->name ;
                    }
                }else{
                    if($value->cat_ID == $val){
                        $nameCat .= $value->name;
                    }
                }
            }
        }
        return $nameCat;
    }

    protected function get_name_category($parent_id = "", $taxonomy='product_cat'){
        $args = array(
            'type'          => 'post',
            'child_of'      => 0,
            'parent'        => $parent_id,
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'hierarchical'  => 1,
            'exclude'       => '',
            'include'       => '',
            'number'        => '',
            'taxonomy'      => $taxonomy,
            'pad_counts'    => false,
    
        );
        return $categories = get_categories( $args );
    }

}
