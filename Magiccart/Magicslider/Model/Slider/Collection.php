<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-19 23:27:30
 * @@Modify Date: 2018-01-31 12:24:25
 * @@Function:
 */

namespace Magiccart\Magicslider\Model\Slider;

use Magiccart\Core\Model\AbstractCollection;

class Collection extends AbstractCollection 
{

    public $_optioncfg = 'magiccart_slider';
    public $_config;
    public $_per_page = 15;
    
    public function __construct()
    {
        $this->_config = get_option($this->_optioncfg, '');
    }

    public function getCollection()
    {
        return json_decode($this->_config, true);
    }

    public function save($data)
    {
        $data = json_encode($data);
        update_option($this->_optioncfg, $data);
    }

    public function getGroupSlider()
    {
        $groups = $this->getCollection();
        $temp = array();
         
        if(is_array($groups)){
            foreach ($groups as $key => $value) {
                $temp[$key]['name']     = $value['name'];
                $temp[$key]['total']    = count($value['value']);
                $firstItem              = array_slice($value['value'], 0, 1);
                foreach ($firstItem as $value) {
                    $temp[$key]['avatar']   = $value['src'];
                }
            }
        }
        $groups = $temp;
        
        return $groups;
    }   
}
