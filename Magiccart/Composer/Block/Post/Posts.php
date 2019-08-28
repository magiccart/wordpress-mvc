<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 11:34:47
 * @@Modify Date: 2018-03-09 16:22:12
 * @@Function:
 */

namespace Magiccart\Composer\Block\Post;
use Magiccart\Composer\Block\Shortcode;

class Posts extends Shortcode{

    protected $_posts = array();

    public function initShortcode( $atts, $content = null ){
        $this->addData($atts);
        
        $args = array(
        		'numberposts' => $this->getData('number'),
        		'category' => 0, 'orderby' => $this->getData('orderby'),
        		'order' => 'DESC', 'include' => array(),
        		'exclude' => array(), 'meta_key' => '',
        		'meta_value' =>'', 'post_type' => 'post',
        		'suppress_filters' => true
        );
        
        $this->_posts = get_posts($args);
        
    	return $this->toHtml();
    }

    public function getPostViews($postID){ 
        $count_key  = 'post_views_count';
        $count      = get_post_meta($postID, $count_key, true);
        if($count==''){ 
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0"; 
        }
        return $count; 
    }

}
