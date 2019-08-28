<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-25 11:41:43
 * @@Modify Date: 2018-05-17 19:36:40
 * @@Function:
 */

namespace Magiccart\Core\Controller;

use Magiccart\Core\Block\Shortcode;
// use Magiccart\Core\Block\Themecfg;

class Index extends Action{ 

    public function __construct(){
        if( !defined( 'ALOTHEMES' ) ) add_action('wp_enqueue_scripts', array($this, 'add_fontend_web'));
        new Shortcode();
        // new Themecfg();
    }

    public function add_fontend_web(){
        wp_register_script('jquerylazyloadmin', $this->get_url('frontend/web/js/jquery.lazyload.min.js'));
        wp_enqueue_script('jquerylazyloadmin');

        wp_register_style('slick', $this->get_url('frontend/web/js/slick/slick.css'));
        wp_enqueue_style('slick');

        wp_register_script('slickminjs', $this->get_url('frontend/web/js/slick/slick.min.js'));
        wp_enqueue_script('slickminjs');

        wp_register_style('magnific-popup', $this->get_url('frontend/web/js/magnific-popup/magnific-popup.css'));
        wp_enqueue_style('magnific-popup');
        
        wp_register_script('jquery.magnific-popup.min', $this->get_url('frontend/web/js/magnific-popup/jquery.magnific-popup.min.js'));
        wp_enqueue_script('jquery.magnific-popup.min');

        wp_register_script('jquery-cookie-master', $this->get_url('frontend/web/js/jquery.cookie.js'));
        wp_enqueue_script('jquery-cookie-master');
    }

}
