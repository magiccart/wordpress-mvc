<?php
/*
 Plugin Name: Magiccart
 Plugin URI: http://alothemes.com
 Description: Plugins Magiccart
 Author: alothemes.com
 Version: 1.0
 Author URI: http://alothemes.com/
 */

/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 17:19:56
 * @@Modify Date: 2018-06-13 16:15:13
 * @@Function:
 */


// echo WP_CONTENT_DIR;
// echo WP_LANG_DIR;
// echo WP_PLUGIN_DIR;
// echo WP_PLUGIN_URL;
// plugins_url()
// $constant_overrides = array(
//     'FTP_BASE' => ABSPATH,
//     'FTP_CONTENT_DIR' => WP_CONTENT_DIR,
//     'FTP_PLUGIN_DIR' => WP_PLUGIN_DIR,
//     'FTP_LANG_DIR' => WP_LANG_DIR
// );

define('MAGICCART_URL', plugin_dir_url(__FILE__));            // URL

define('MC_PLUGIN_DIR', WP_PLUGIN_DIR );         // DIR

define('MAGICCART_DIR', plugin_dir_path( __FILE__ ));         // DIR

// plugin_dir_path( __DIR__ ); // return /home/user/var/www/wordpress/wp-content/plugins/
// plugin_dir_path( __FILE__ ); // return /home/user/var/www/wordpress/wp-content/plugins/your_plugin_dir_file 

// plugin_dir_url( __DIR__ ); // return http://example.com/wp-content/plugins/
// plugin_dir_path( __FILE__ ); // return http://example.com/wp-content/plugins/your_plugin_dir_file 


use Magiccart\Cms\Controller\Cms;
use Magiccart\Composer\Controller\Composer;
use Magiccart\Core\Controller\Core;
use Magiccart\Core\Controller\Adminhtml\Footer;
use Magiccart\Core\Controller\Adminhtml\Header;
use Magiccart\Import\Controller\Adminhtml\Import;
use Magiccart\Magicslider\Controller\Magicslider;
use Magiccart\Megamenu\Controller\Megamenu;
use Magiccart\Portfolio\Controller\Portfolio;
use Magiccart\Testimonial\Controller\Testimonial;
use Magiccart\Shopbrand\Controller\Shopbrand;
use Magiccart\Widgets\Controller\Widgets;

// **********************************************************************//
// Register autoloader
// **********************************************************************//
spl_autoload_register( 'maggiccart_autoloader' ); 
function maggiccart_autoloader( $class_name ) {
    if ( false !== strpos( $class_name, 'Magiccart' ) ) {
        $class_file = MC_PLUGIN_DIR . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
        // if(file_exists($class_file)) require_once $class_file; // Require will crash if it's missing.
        // else echo '<div class="message error woocommerce-error">' . sprintf( __( "Class %s not exist", 'alothemes'), $class_name) . '</div>';
        include_once  $class_file; // include will not crash if it's missing.
    }   
}

class Magiccart{

    /**
     * Core singleton class
     * @var self - pattern realization
     */
    private static $_instance;

    private $_menu_slug  = 'magiccart';

    public function __construct(){
        // Add hooks
        add_action( 'plugins_loaded', array(
            $this,
            'pluginsLoaded',
        ), 9 );
        add_action( 'init', array(
            $this,
            'init',
        ), 0 );
        // add_action("plugins_loaded", array($this, 'init'), 55); // 99
        if(is_admin()){
            // if (isset($_GET['page']) && $_GET['page'] == 'magiccart') {
            //     add_action( 'admin_print_scripts', array($this, 'admin_scripts') );
            //     add_action( 'admin_print_styles', array($this, 'admin_styles') );
            // }
            add_action( 'admin_enqueue_scripts', array($this, 'load_wp_media_files') );
            add_action( 'admin_menu', array($this, '_setActiveMenu') );
        }
    }

    /**
     * Get the instane of Magiccart
     *
     * @return self
     */
    public static function getInstance() {
        if ( ! ( self::$_instance instanceof self ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function pluginsLoaded() {
        do_action( 'magiccart_plugins_loaded' );
    }
    
    public function init(){

        if( defined( 'ALOTHEMES' ) ){
            new Megamenu();
        }
        if(is_admin()){
            if(defined('HEADER_BUILDER') && HEADER_BUILDER) new Header();
            new Cms();
            new Magicslider();
            new Import();
            if(defined('FOOTER_BUILDER') && FOOTER_BUILDER) new Footer();
        }

        new Core();
        new Portfolio();
        new Shopbrand();
        new Testimonial();
        if ( class_exists( 'WooCommerce' ) ) {
            new Widgets();   
        } else {
                // <div class="message error"><p>Color Filters by <a href="https://www.elementous.com" target="_blank">Elementous</a> is enabled but not effective. It requires <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> plugin in order to work.</p></div>
                echo '<div class="message error woocommerce-error"><p>' . __('WooCommerce not installed or Activate', 'alothemes') . '</p></div>';

        }
        if ( class_exists( 'Vc_Manager' ) ) {
            new Composer();
        } else {
            echo '<div class="message error woocommerce-error"><p>' . __('Visual Composer not installed or Activate', 'alothemes') . '</p></div>';
        }

    }
    
    public function _setActiveMenu(){
        add_menu_page(__('Magiccart', "alothemes"), __('Magiccart', "alothemes"), 'manage_options', $this->_menu_slug 
            , "", "dashicons-smiley", 30);
    }
    
    public function admin_scripts() {
    	wp_enqueue_script('media-upload');
    	wp_enqueue_script('thickbox');
    }

    public function admin_styles() {
    	wp_enqueue_style('thickbox');
    }

    public function load_wp_media_files() {
    	wp_enqueue_media();
    }   
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
is_plugin_active($plugin);
global $magiccart;
if ( ! $magiccart ) {
    if ( ! defined( 'MAGICCART' ) ) {
        define( 'MAGICCART', true );
    }
    $magiccart = Magiccart::getInstance();
}
