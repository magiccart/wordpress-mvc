<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-08-13 21:17:04
 * @@Function:
 */

namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Search extends Vc{

    public function initMap(){
        $temp = array(
                        array(
                            'type'          => "textfield",
                            'heading'       => __("Placeholder Search : ", 'alothemes'),
                            'description'   => __('Text Placeholder form search.', 'alothemes'),
                            'param_name'    => "placeholder",
                            'save_always'   => true,
                        ),

                        array(
                            'type'          => "dropdown",
                            'heading'       => __('Category Search :', 'alothemes'),
                            'description'   => __('Display Option Search Follow Category.', 'alothemes'),
                            'param_name'    => 'categorysearch',
                            'value'         => $this->bool(),
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

