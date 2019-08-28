<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-08-13 21:29:42
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Menu;

class Accordion extends Navigation{

    public function initMap(){
        $temp = array(
                        array(
                            'type'          => "dropdown",
                            'heading'       => __('Select a menu :', 'alothemes'),
                            'param_name'    => 'menu',
                            'value'         => $this->get_nav_menus(),
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

        $this->add_VcMap($params);
    }
}
