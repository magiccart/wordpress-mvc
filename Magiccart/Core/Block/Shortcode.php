<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 12:11:00
 * @@Modify Date: 2018-02-04 01:04:47
 * @@Function:
 */
 
namespace Magiccart\Core\Block;
use Magiccart\Core\Block\Template;

// How to use: add to function in theme: $block = new Magiccart\Core\Block\Shortcode;

class Shortcode extends Template{
    protected $_products = array();
    protected $_post = array();

    public function __construct(){
        parent::__construct();
        $nameShortcode = 'magiccart_shortcode';
        add_shortcode($nameShortcode, array($this, 'initShortcode'));

    }
    
    public function initShortcode($atts){
        if(isset($atts['class'])){
            // echo $atts['class'];
            $class = str_replace('/', '\\', $atts['class']);
            if(!class_exists($class, true)) return '<div class="message error woocommerce-error">' . printf( esc_html__( "Class %s not exist.", 'alothemes' ), $class ) . '</div>';
            $block = new $class;
            $block->addData( $atts );
            if(method_exists($block,'initShortcode')) $block->initShortcode($atts);
            if(isset($atts['template'])){
                $template = str_replace('\\', '/', $atts['template']); 
                $block->setTemplate($template);
            }          
            return $block->toHtml();
        }else {
            // include tempalte in theme
            echo __('Attribute class not isset', 'alothemes');
        }
    }

}

