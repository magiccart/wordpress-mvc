<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-14 16:23:56
 * @@Modify Date: 2017-08-14 17:21:43
 * @@Function:
 */

namespace Magiccart\Core\Model\System;

class Row{
	
    public function getOptions($num=5){
        $rows = array();
        for ($i = 1; $i <= $num; $i++) {
            $rows[$i] = "$i Row (s)";
        }
        return $rows;
    }

}
