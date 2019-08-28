<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-21 15:45:16
 * @@Modify Date: 2018-03-09 17:41:54
 * @@Function:
 */
 
namespace Magiccart\Megamenu\Block;

use Magiccart\Cms\Model\Block\Collection;

class Menu extends \Walker_Nav_Menu{
    private $_blockTop    = "";
    private $_blockRight  = "";
    private $_blockBottom = "";
    private $_blockLeft   = "";
    public $_blocks;
    public $_id;
    public $_id_parent;
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        
        $indent = str_repeat("\t", $depth);
        if(!$depth) $this->_id_parent = $this->_id;
        if( !$depth && get_post_meta($this->_id, '_magiccart_mega', true)){
        	$this->init_data_blocks();// init value in $this->_blockTop,  $this->_blockLeft
            $output .=  '<div class="level-top-mega" >
                            <div class="content-mega" >
                                '. $this->_blockTop .'
                                    <div class="content-mega-horizontal" >
                                        '.$indent  . $this->_blockLeft.
                                            '<ul class="submenu mage-column cat-mega level'.$depth.'">';
        }else{
            $output .= "$indent <ul class=' submenu level{$depth}'>";
        }
        global $navmobile;
        if($args->menu && is_string($args->menu)) $navmobile[$args->menu] .= "$indent <ul class=' submenu level{$depth}'>";
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
    
        $indent     = str_repeat("\t", $depth);

        if(!$depth && get_post_meta($this->_id_parent, '_magiccart_mega', true) ){
            $output .= $indent;
            if($this->_blockBottom != ""){
                $output .= "<li>{$this->_blockBottom }</li>";
            }
            
            $output .=  "</ul>{$this->_blockRight }</div></div></div>\n";
                
            $this->_blockBottom    = "";
            $this->_blockRight     = "";
        }else{
            $output .= "$indent </ul>\n";
        }
        global $navmobile;
        if($args->menu && is_string($args->menu)) $navmobile[$args->menu] .= "$indent </ul>\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $this->_id  = $item->ID;

        $isMega   = get_post_meta($this->_id, '_magiccart_mega', true);
        $isMegaParent = get_post_meta($this->_id_parent, '_magiccart_mega', true); 
        $parent     = 1;
        $icon       = '';
        $level      = '';
        $img        = '';
        $data_options = $this->get_data_options($this->_id);

        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts           = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $title          = apply_filters( 'the_title', $item->title, $item->ID );
        $title          = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
        

        $linkIcon = get_post_meta($item->ID, '_magiccart_icon', true);
        if(trim($linkIcon)){
            $icon = '<img src="'. esc_url($linkIcon).'" alt="'. esc_attr($title) .'" title="'. esc_attr($title) .'" />';
        }
        
        $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
        if (empty($children)) $parent = 0;
        
        if($isMegaParent  && $depth == 1){
            $href = get_post_meta($item->ID, '_magiccart_image', true);
            if($href){
                $img = '<a href="'. esc_url($atts['href']) .'"><img class="img-responsive" title="'. esc_attr($title) .'" alt="'. esc_attr($title) .'" src="'. esc_url($href).'"></a>';
            }
            $level = 'children';
        }
                
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $classes   = array('');
        if($item->classes) $classes[] = implode(" ",$item->classes);
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'level' . $depth;
        $classes[] = $level;
        $classes[] = 'nav-' . $depth;
        if($parent == 1) $classes[] = 'hasChild';
        if($depth  == 0 && !$isMega)  $classes[] = 'dropdown' ;
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $item_output = isset($args->before) ? $args->before : '';
        
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $categoryImage = get_post_meta( $item->ID, "_magiccart_category_image", true );
        $dataImage = "";
        if($categoryImage){
            $dataImage = " data-image='$categoryImage' ";
        }
        if(!$depth){
            $hotNew = '';
            if(get_post_meta($item->ID, '_magiccart_hot_new', true)){
                $hotNew = '<span class="cat_label">'. get_post_meta($item->ID, '_magiccart_hot_new', true) . '</span>';
            }
            
            $class_names = $class_names ? ' class="cat ' . esc_attr( $class_names ) . '"' : '';
            $output     .= $indent . '<li '. $class_names .' ' .$data_options .'>';
            $item_output .= '<a class="level-top" '. $dataImage . $attributes .'>';
            $item_output .= isset($args->link_before) ? $args->link_before : '';
            $item_output .= $icon . '<span>' .$title . $hotNew . '</span>';
            $item_output .= isset($args->link_after) ? $args->link_after : '';
        }else{
            $class_names = $class_names ? ' class=" ' . esc_attr( $class_names ) . '"' : '';
            $output .= $indent . '<li ' . $class_names .'>'. $img  ;
            $item_output .= '<a '. $dataImage . $attributes .'>';
            $item_output .= $args->link_before . '<span>' .$title . '</span>' . $args->link_after;
        }

        $mobileHtml = $indent . '<li ' . $class_names  .'>';
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        $html_output = apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        $output .= $html_output;
        $mobileHtml .= $html_output;
        global $navmobile;
        if($args->menu && is_string($args->menu)) $navmobile[$args->menu] .=  $mobileHtml;
    }

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $output .= "</li>{$n}";
        global $navmobile;
        if($args->menu && is_string($args->menu)) $navmobile[$args->menu] .= "</li>{$n}";
    }


    public function get_data_options($id){
        $data_options   = "";
        $columns        = get_post_meta($id, '_magiccart_columns', true);
        $category       = get_post_meta($id, '_magiccart_proportions_category', true); 
        $right          = get_post_meta($id, '_magiccart_proportions_block_right', true); 
        $left           = get_post_meta($id, '_magiccart_proportions_block_left', true); 
        
        if(get_post_meta($this->_id, '_magiccart_mega', true)){
            $arrSetting = array();

            if( $columns ){
                $arrSetting['cat_col']  = ceil( $columns );
            }
            if( $category ){
                $arrSetting['cat_proportion']   = ceil( $category );
            }
            if( $right ){
                $arrSetting['right_proportion'] = ceil( $right );
            }
            if( $left ){
                $arrSetting['left_proportion']  = ceil( $left );
            } 
            
            $tmp = count($arrSetting);
            foreach($arrSetting as $key => $value){
                if(!$value)continue;
                $data_options .= '"' . $key . '":"' . $value . '"';
                if($tmp > 1){
                    $data_options .= ",";
                    $tmp--;
                }
            }
            if($data_options) $data_options = "data-options = '{".$data_options. "}'";
        }
        return $data_options;
    }

    public function init_data_blocks()
    {
        if(!$this->_blocks) {
            $model = new Collection;
            $this->_blocks = $model->getCollection();
        }
		$blocks = $this->_blocks;
        $this->_blockTop = $this->_blockLeft   = '';
        
        $top    = get_post_meta($this->_id, '_magiccart_block_top', true);
        $right  = get_post_meta($this->_id, '_magiccart_block_right', true);
        $left   = get_post_meta($this->_id, '_magiccart_block_left', true);
        $bottom = get_post_meta($this->_id, '_magiccart_block_bottom', true);
       
        if($top){
            if(isset($blocks[$top]['content']) && $blocks[$top]['status'] ){
                $editorText = $blocks[$top]['content'];
                $this->_blockTop = $editorText ? '<div class="mage-column mega-block-top">' . wp_kses_post($editorText) . '</div>' : '';
            }
        }

        if($right){
            if(isset($blocks[$right]['content']) && $blocks[$right]['status'] ){
                $editorText = $blocks[$right]['content'];
                $this->_blockRight = $editorText ? '<div class="mage-column mega-block-right">' . wp_kses_post($editorText) . '</div>' : '';
            }
        }

        if($left){
            if(isset($blocks[$left]['content']) && $blocks[$left]['status'] ){
                $editorText = $blocks[$left]['content'];
                $this->_blockLeft = $editorText ? '<div class="mage-column mega-block-left">' . wp_kses_post($editorText) . '</div>' : '';
            }
        }

        if($bottom){
            if(isset($blocks[$bottom]['content']) && $blocks[$bottom]['status'] ){
                $editorText = $blocks[$bottom]['content'];
                $this->_blockBottom = $editorText ? '<div class="mage-bottom"><div class="mage-column mega-block-bottom">' . wp_kses_post($editorText) . '</div></div>' : '';
            }
        }
    }
    
    public function setMenu($args){
        // if($args['theme_location'] != "mobile-menu"){
            $args['walker']     = $this; 
        // }
        global $navmobile;
        if(isset($args['menu']) && is_string($args['menu'])){
            if(!isset($navmobile[$args['menu']])) $navmobile[$args['menu']] = '';  
        }
        //$args['items_wrap'] = '<ul id="%1$s" class="%2$s menu nav-desktop ' . $args['theme_location'] . '">%3$s</ul>';
        $args['container']  = '';
        return $args;
    }
}
