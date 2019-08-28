<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-08-21 16:55:58
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Menu;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Navmobile extends Navigation{

    public function initMap(){
        $temp = array(
                        array(
                            'type'          => "multiselect",
                            'heading'       => __('Select menu :', 'alothemes'),
                            'param_name'    => 'menu',
                            'value'         => array_flip($this->get_nav_menus()),
                            'save_always'   => true,
                        ),
                        array(
							'type'          => "textfield",
							'heading'       => __("Maximal Depth : ", 'alothemes'),
							'description'   => __('The default Maximal Depth value is zero, which does not place a limit on the number of subcategory levels.', 'alothemes'),
							'param_name'    => "depth",
							'value'         => "0",
							'save_always'   => true,
                        ),
                        array(
							'type'          => "textfield",
							'heading'       => __("Extra class name : ", 'alothemes'),
							'description'   => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'alothemes'),
							'param_name'    => "el_class",
							'save_always'   => true,
                        ),

		            );
        $params = array_merge(
            $temp, 
            $this->get_templates()
        );
        // $name = 'Magiccart Menu ' . ucfirst($this->_class);
        // $shortcode = 'magiccart_menu_' . strtolower($this->_class);
        // $this->add_VcMap($params,  $name, $shortcode);
        $this->add_VcMap($params);
    }
}

