<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-08-17 23:24:58
 * @@Function:
 */

namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Minicart extends Vc{

    public function initMap(){
        $temp = array(
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

