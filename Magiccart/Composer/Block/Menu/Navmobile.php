<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-08-21 16:44:58
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Menu;
use Magiccart\Composer\Block\Shortcode;
// use Magiccart\Megamenu\Block\Menu;

class Navmobile extends Shortcode{

    protected $_menu;

    public function initShortcode( $atts, $content = null){

        $this->addData($atts);
        
        return $this->toHtml();
    }

    public function getMobileHtml($menu){
    	ob_start();
    	$_type = has_nav_menu($menu) ? 'theme_location' : 'menu';
        wp_nav_menu(array(
            $_type    => $menu,
            'items_wrap'        => '<ul id="%1$s" class="%2$s nav-desktop sticker">%3$s</ul>'
        )); 
        $content = ob_get_contents();
        ob_end_clean();
        global $navmobile;
        return 	$navmobile[$menu];
    }

}

