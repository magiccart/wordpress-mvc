<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-10-27 10:22:36
 * @@Modify Date: 2017-10-27 18:46:59
 * @@Function:
 */
 
namespace Magiccart\Element\Block;
use Magiccart\Composer\Block\Shortcode as ComposerShortcode;

class Shortcode extends ComposerShortcode{

     public function __construct(){
     	if(!$this->nameShortcode) $this->nameShortcode = 'magiccart_elemnt_' . $this->_class;
        parent::__construct();
    }
}

