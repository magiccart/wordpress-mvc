<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-25 22:20:36
 * @@Modify Date: 2017-09-25 22:26:25
 * @@Function:
 */

namespace Magiccart\Composer\Block\Post;

use Magiccart\Composer\Block\Shortcode;
use Magiccart\Magicslider\Model\Slider\Collection as sliderCollection;

class Slider extends Shortcode{

    protected $_sliders = array();
    public $_sliderCollection;

    public function initShortcode( $atts, $content = null )
    {
        $this->addData($atts);
        if(!$this->_sliderCollection) {
            $this->_sliderCollection = new sliderCollection;
        }
        $optionSlider   = $this->_sliderCollection->getCollection();       
        if(!isset( $optionSlider[$this->getData('slider')] )) return ; 
        
        $group         = $optionSlider[$this->getData('slider')];
        $idSlider      = array();
        $slider = array();
       
        foreach ($group['value'] as $key => $value) {
            if($value['status']){
                unset($group['value'][$key]);
            }
        }
        $this->_sliders = array_slice($group['value'], 0, $this->getData('number'));

        return $this->toHtml();
    }
}

