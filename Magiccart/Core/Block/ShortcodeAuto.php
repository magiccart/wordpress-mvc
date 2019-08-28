<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 12:11:00
 * @@Modify Date: 2017-09-19 23:05:07
 * @@Function:
 */
 
namespace Magiccart\Core\Block;
use Magiccart\Core\Block\Template;

// How to use: add to function in theme: $block = new Magiccart\Core\Block\ShortcodeAuto;

class ShortcodeAuto extends Template{
    protected $_products = array();
    protected $_post = array();

    public function __construct(){
        parent::__construct();
        $nameShortcode = get_class($this);
        add_shortcode($nameShortcode, array($this, 'initShortcode'));

    }
    
    public function initShortcode($atts){
        $this->unsetData();
        $this->addData( $atts );
        if(isset($atts['template'])) $this->setTemplate($atts['template']);
        return $this->toHtml();
    }

}

