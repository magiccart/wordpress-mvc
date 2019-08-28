<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-13 15:58:32
 * @@Modify Date: 2017-09-25 22:13:21
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;

use Magiccart\Composer\Block\Adminhtml\Vc;

class Slider extends Vc{

    public function initMap(){
        $temp = array(
	                array(
						'type'          => 'dropdown',
						'heading'       => __( 'Slider : ', 'alothemes' ),
						'value'         => array_flip($this->getSlider()),
						'param_name'    => 'slider',
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
        
        $this->add_VcMap($params);
    }

    protected function getSlider(){
        return $this->_vcComposer->getSlider();
    }

    protected function get_responsive(){

        $get_item_per_rows = $this->get_item_per_rows();
        $responsive = array(
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 360 : ', 'alothemes'),
                'param_name'    => 'mobile',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 480 : ', 'alothemes'),
                'param_name'    => 'portrait',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 640 : ', 'alothemes'),
                'param_name'    => 'landscape',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 767 : ', 'alothemes'),
                'param_name'    => 'tablet',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 991 : ', 'alothemes'),
                'param_name'    => 'notebook',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 1199 : ', 'alothemes'),
                'param_name'    => 'desktop',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Min-Width 1200 : ', 'alothemes'),
                'param_name'    => 'visible',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            )
        );

        return $responsive;
    }
}
