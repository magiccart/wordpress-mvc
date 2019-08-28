<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-13 22:53:17
 * @@Modify Date: 2017-09-13 23:07:44
 * @@Function:
 */

namespace Magiccart\Megamenu\Block\Adminhtml\Menu;

use Magiccart\Cms\Model\Block\Collection;

class Item {

    public $_blocks;
    static $options = array();

    public function __construct(){
        add_action( 'init', array( $this, 'setup' ), 11 );
        add_filter( 'magiccart_fields', array($this, 'addFields') );
    }
    public function setup() {
        add_action( 'init', array( $this, 'setup' ), 11 );
        if ( !is_admin() )
            return;
        $new_fields = apply_filters( 'magiccart_fields', array() );
        if ( empty($new_fields) )
            return;

        self::$options['fields'] = self::get_fields_schema( $new_fields );

        add_filter( 'wp_edit_nav_menu_walker', array($this, 'menuEdit') ) ;

        add_action( 'save_post', array( $this , '_save_post' ), 10, 2 );
    }

    public function menuEdit(){
        return 'Magiccart\Megamenu\Block\Adminhtml\Menu\Edit';
    }

    static function get_fields_schema( $new_fields ) {
        $schema = array();
        foreach( $new_fields as $name => $field) {
            if (empty($field['name'])) {
                $field['name'] = $name;
            }
            $schema[] = $field;
        }
        return $schema;
    }

    static function get_item_key($name) {
        return '_magiccart_' . $name;
    }


    public static function get_field( $item, $depth, $args ) {
        $new_fields = '';
        foreach( self::$options['fields'] as $field ) {
            $field['value'] = get_post_meta($item->ID, self::get_item_key($field['name']), true);
            $field['id'] = $item->ID;

            switch ($field['input_type']) {
                case 'text':
                    $new_fields .= self::getText($field);
                    break;
                case 'select':
                    $new_fields .= self::getSelect($field);
                    break;
                case 'img':
                    $new_fields .= self::getImage($field);
                    break;
                default:
                    $new_fields .= "";
                    break;
            }
        }
        return $new_fields;
    }

    static function getText($field){
        $value = "";
        
        (isset($field['value'])) ? $value = $field['value'] : $value = "";
        $select = '<p class="magiccart-field text ' .$field['name']. ' description-'.$field['input_type'].'">
            <label for="edit-menu-item-'.$field['name'].'-'.$field['id'].'">
                '.$field['label'].'<br />
                <input type="text" value="'.$value.'" id="edit-menu-item-'.$field['name'].'-'.$field['id'].'" class="widefat edit-menu-item-'.$field['name'].'" name="menu-item-'.$field['name'].'['.$field['id'].']">';
        $select .= '</input></lable></p>';
        return $select;
    }

    static function getSelect($field){
       
        $select = '<p class="magiccart-field select ' .$field['name']. ' description-'.$field['type_show'].'">
            <label for="edit-menu-item-'.$field['name'].'-'.$field['id'].'">
                '.$field['label'].'<br />
                <select id="edit-menu-item-'.$field['name'].'-'.$field['id'].'" class="widefat edit-menu-item-'.$field['name'].'" name="menu-item-'.$field['name'].'['.$field['id'].']">';
        if(!isset($field['default']) || $field['default'] == true) $select .= '<option value="0">'.$field['label'].'</option>';
        if(!empty($field['values']) && is_array($field['values'])){
            foreach($field['values'] as $k => $v){
                $select .= '<option value="'.esc_attr($k).'" '.selected( $field['value'] , $k, false ).'>'.esc_html($v).'</option>';
            }
        }
        $select .= '</select></lable></p>';
        return $select;
    }


    static function getImage($field){
        $value  = "";
        $img    = "";
        (isset($field['value'])) ? $value = $field['value'] : $value = "";
        if($value) $img = '<img src="'. $value .'" style="max-height:35px;max-width: 60px;padding: 5px;border:1px dotted #8CCFFA;" />';
        $imageInput = '<p class="magiccart-field ' .$field['name']. ' description-'.$field['input_type'].'">
            <label for="edit-menu-item-'.$field['name'].'-'.$field['id'].'">
                <b>'.$field['label'].'<br />
                <input type="text" id="image_url_'. $field['id'] .'" size="30" style="width:60%;" value="'.$value.'" class="widefat edit-menu-item-'.$field['name'].$field['id'].'" name="menu-item-'.$field['name'].'['.$field['id'].']" />
                <input id="upload-btn" type="button" onclick="" name="upload-btn" idbtn="'.$field['name'].$field['id'].'" value="Select Image" class="button-img button" />' ;
        $imageInput .= '</input></b></lable> '. $img.'</p>';
        return $imageInput;
    }

    static function _save_post($post_id, $post) {
        if ( $post->post_type !== 'nav_menu_item' ) {
            return $post_id;
        }

        $arrSettings = array();
        foreach( self::$options['fields'] as $field_schema ) {
            $form_field_name = 'menu-item-' . $field_schema['name'];

            if ($field_schema['input_type'] == 'checkbox') {
                if(!isset($_POST[$form_field_name][$post_id])) $_POST[$form_field_name][$post_id] = false;
            }

            if (isset($_POST[$form_field_name][$post_id])) {
                $key = self::get_item_key($field_schema['name']);
                $value = stripslashes($_POST[$form_field_name][$post_id]);

                update_post_meta($post_id, $key, $value);
            }
        }
        
    }
    
    public function addFields() {
        $fields = array(
            'alothemes_hot_new' => array(
                'name' => 'hot_new',
                'label' => esc_html__('Text Hot New', 'alothemes'),
                'input_type' => 'text',
            ),
            'alothemes_category_image' => array(
                'name' => 'category_image',
                'label' => esc_html__('Category Image', 'alothemes'),
                'input_type' => 'img',
            ),
            'alothemes_image' => array(
                'name' => 'image',
                'label' => esc_html__('Image Menu', 'alothemes'),
                'input_type' => 'img',
            ),
            'alothemes_icon' => array(
                'name' => 'icon',
                'label' => esc_html__('Icon Menu', 'alothemes'),
                'input_type' => 'img',
            ),
            'alothemes_mega' => array(
                'name' => 'mega',
                'label' => esc_html__('Mega Menu', 'alothemes'),
                'input_type' => 'select',
                'values' => array(
                    '0'         => 'No',
                    '1'         => 'Yes',
                    
                ),
                'default' => false,
                'type_show' => 'wide'
            ),
            'alothemes_proportions_category' => array(
                'name' => 'proportions_category',
                'label' => esc_html__('Proportions Category ( Proportions weight )', 'alothemes'),
                'input_type' => 'text',
            ),
            'alothemes_columns' => array(
                'name' => 'columns',
                'label' => esc_html__('Columns Category', 'alothemes'),
                'input_type' => 'text',
            ),
    
            'alothemes_block_top' => array(
                'name' => 'block_top',
                'label' => esc_html__('Block top', 'alothemes'),
                'input_type' => 'select',
                'values' => $this->getBlocks(),
                'default' => false,
                'type_show' => 'wide'
            ),
    
            'alothemes_block_right' => array(
                'name' => 'block_right',
                'label' => esc_html__('Block Right', 'alothemes'),
                'input_type' => 'select',
                'values' => $this->getBlocks(),
                'default' => false,
                'type_show' => 'wide'
            ),
            'alothemes_proportions_right' => array(
                'name' => 'proportions_block_right',
                'label' => esc_html__('Proportions: Block Right( Proportions weight )', 'alothemes'),
                'input_type' => 'text',
            ),
            'alothemes_block_bottom' => array(
                'name' => 'block_bottom',
                'label' => esc_html__('Block Bottom', 'alothemes'),
                'input_type' => 'select',
                'values' => $this->getBlocks(),
                'default' => false,
                'type_show' => 'wide'
            ),
            'alothemes_block_left' => array(
                'name' => 'block_left',
                'label' => esc_html__('Block Left', 'alothemes'),
                'input_type' => 'select',
                'values' => $this->getBlocks(),
                'default' => false,
                'type_show' => 'wide'
            ),
            'alothemes_proportions_left' => array(
                'name' => 'proportions_block_left',
                'label' => esc_html__('Proportions: Block Left ( Proportions weight )', 'alothemes'),
                'input_type' => 'text',
            ),
        );
        return $fields;
    }
    
    public function getBlocks(){
        if(!$this->_blocks) {
            $model = new Collection;
            $this->_blocks = $model->getCollection();
        }
        $arrData = array();
        $arrData[] = '-- Please select a static block --';
        $blocks     = $this->_blocks;
        if(is_array($blocks)){
             foreach($blocks as $key => $value){
                if($value['status']) $arrData[$key] = $value['name'];
            }
        }
        return $arrData;
    }
}

