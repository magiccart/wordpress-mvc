<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-13 16:52:59
 * @@Modify Date: 2017-08-13 21:28:25
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;

class Desandro extends Portfolio{

    public function initMap(){
        $temp = array(
                       array(
                            'type'          => "dropdown",
                            'heading'       => __("Portfolio : <span style='color:red;'>*</span> ", 'alothemes'),
                            'param_name'    => "portfolio",
                            'value'         => array_flip($this->category_portfolio()),
                            'save_always'   => true,
                        ),
                       array(
                            'type'          => "textfield",
                            'heading'       => __("Number of posts to show : ", 'alothemes'),
                            'param_name'    => "number",
                            'value'         => 20,
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
            $this->get_settings(), 
            $this->get_responsive(),
            $this->get_templates()
        );
        
        $this->add_VcMap($temp);
    }
}
