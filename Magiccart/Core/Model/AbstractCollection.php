<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-23 22:55:17
 * @@Modify Date: 2018-02-03 12:47:54
 * @@Function:
 */

namespace Magiccart\Core\Model;

abstract class AbstractCollection
{
    
    public function get_option($name)
    {
        return get_option($name);
    }

    public function update_option($name)
    {
    	return update_option($name);
    }

    abstract function getCollection();

}
