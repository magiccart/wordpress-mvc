<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-23 22:23:54
 * @@Modify Date: 2018-02-05 14:54:44
 * @@Function:
 */

namespace Magiccart\Core\Controller;

abstract class AbstractAction{

    protected $_class;
    protected $_data = array();
    protected $parent_slug = 'magiccart';
    protected $_pluginName;
    protected $_moduleName;
    protected $_moduleDir;

    public function __construct(){
        $this->getModule();
    }

    /**
     * @param string $page
     *
     * @return bool
     */
    public function is_action_page( $page = null ) {
        // any settings page
        if( is_null( $page ) ) {
            return isset( $_GET['page'] ) && strpos( $_GET['page'], $this->get_menu_slug() ) === 0;
        }

        // specific page
        return $this->get_menu_slug() === $page;
    }

    protected function get_menu_slug()
    {
        if(!$this->_class) $this->_class = $this->_class = strtolower((new \ReflectionObject($this))->getShortName());
        $menu_slug = $this->parent_slug . '_' . strtolower($this->getModuleName()) . '_' . $this->_class; 
        return $menu_slug;
    }

    protected function getPluginName(){
        if(!$this->_pluginName){
            $dirName = explode('\\', get_class($this));
            $this->_pluginName = $dirName[0];
        }
        return $this->_pluginName;    
    }

    protected function getModuleName(){
        if(!$this->_moduleName){
            $dirName = explode('\\', get_class($this));
            $this->_moduleName = $dirName[1];
        }
        return $this->_moduleName;    
    }

    protected function getModule(){
        if(!$this->_moduleDir){
            $dirName = explode('\\', get_class($this));
            $this->_pluginName = $dirName[0];
            $this->_moduleName = $dirName[1];
            $this->_moduleDir = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $this->_pluginName . DIRECTORY_SEPARATOR . $this->_pluginName;
        }
        return $this->_moduleDir;
    }
    
    public function addData($data){
        if(is_array($data)){
           $this->_data = array_merge($this->_data, $data);
        }
    }
   
    public function getData($key = ""){
       if(!$key) return $this->_data;
       
       return (isset($this->_data[$key])) ? $this->_data[$key] : null; 
    } 
    
    public function get_url($link){
        $tmp = explode('\\', get_class($this));
        $themefile = '/Magiccart_' . $tmp[1] . '/' . $link;
        $templateName = $this->getThemeFile($themefile, false);
        if($templateName){
            return get_template_directory_uri() . $themefile;
        }
        return  plugins_url() . '/Magiccart/' . $tmp[1] . '/view/' . $link;
    }

    public function getThemeFile($fileName, $message=true){
        $templateName = get_stylesheet_directory() . '/' . $fileName;
        if(!file_exists($templateName)){
            $templateName = get_template_directory() . '/' . $fileName;
            if(!file_exists($templateName)){
                if($message) return $this->addError(printf( esc_html__( "File %s not exist.", 'alothemes' ), $fileName ));
                return;
            }
        }
        return $templateName;
    }
    
}
