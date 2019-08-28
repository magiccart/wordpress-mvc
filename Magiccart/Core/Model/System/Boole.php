<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-14 16:23:56
 * @@Modify Date: 2017-11-23 21:54:36
 * @@Function:
 */

namespace Magiccart\Core\Model\System;

class Boole{
	
    public function getOptions($type ="" , $flip = true){

        switch ($type) {
            case 'tf':
                $bool = array(
                    'true'  => __('True', 'alothemes'),
                    'false' => __('False', 'alothemes'),
                );
            case 'ft':
                $bool = array(
                    'false' => __('False', 'alothemes'),
                    'true'  => __('True', 'alothemes'),
                );
                break;
            case 'ad':
                $bool = array(
                    '1' => __('Enable', 'alothemes'),
                    '0'  => __('Disable', 'alothemes'),
                );
                break;
            case 'da':
                $bool = array(
                    '0'  => __('Disable', 'alothemes'),
                    '1' => __('Enable', 'alothemes'),
                );
                break;
            case 'yn':
                $bool = array(
                    'yes' => __('Yes', 'alothemes'),
                    'no'  => __('No', 'alothemes'),
                );
                break;
            case 'ny':
                $bool = array(
                    'no'  => __('No', 'alothemes'),
                    'yes' => __('Yes', 'alothemes'),
                );
                break;
            default:
                if(!$type){
                    $bool = array(
                        '0'  => __('No', 'alothemes'),
                        '1' => __('Yes', 'alothemes'),
                    );
                }else{
                    $bool = array(
                        '1' => __('Yes', 'alothemes'),
                        '0'  => __('No', 'alothemes'),
                    );
                }
        }

        if($flip){
            return array_flip($bool);
        }
        return $bool;
    }

}
