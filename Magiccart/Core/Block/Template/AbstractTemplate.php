<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 12:11:00
 * @@Modify Date: 2018-06-11 17:16:52
 * @@Function:
 */
 
namespace Magiccart\Core\Block\Template;

class AbstractTemplate {
    
    protected $_class;
    protected $_template;
    protected $_data = array();
    protected $_pluginName;
    protected $_moduleName;
    protected $_moduleDir;
    protected $_templateDir;
    protected $_viewFile;
    protected $is_admin;

    public function __construct(){
        // echo get_class($this);
        $this->is_admin  = is_admin();
        $this->_viewFile = ($this->is_admin) ?   'adminhtml' : 'frontend';
        $this->_class = strtolower((new \ReflectionObject($this))->getShortName());
        if(!$this->_template) $this->_template = $this->_class . '.phtml'; //$this->_class . '.phtml';
        $this->getModule();
    }
    protected function templateDir(){
        if(!$this->_templateDir){
            $this->_templateDir = $this->getModule() . '/view/' . $this->_viewFile .'/templates/';
        }
        return $this->_templateDir;
    }

    protected function getStaticFile(){
        if(!$this->_templateDir){
            $this->_templateDir = $this->getModule() . '/view/' . $this->_viewFile .'/templates/';
        }
        return $this->_templateDir;
    }

    protected function getViewFile(){
        if(!$this->_templateDir){
            $this->_templateDir = $this->getModule() . '/view/' . $this->_viewFile .'/templates/';
        }
        return $this->_templateDir;
    }

    protected function getViewFileUrl(){
        if(!$this->_templateDir){
            $this->_templateDir = $this->getModule() . '/view/' . $this->_viewFile .'/templates/';
        }
        return $this->_templateDir;
    }

    
    protected function getModule(){
        if(!$this->_moduleDir){

            $dirName = explode('\\', get_class($this));
            $this->_moduleDir = MC_PLUGIN_DIR . DIRECTORY_SEPARATOR . $dirName[0] . DIRECTORY_SEPARATOR . $dirName[1];
        }
        return $this->_moduleDir;
    }

    protected function getModuleName(){
        $dirName = explode('\\', get_class($this));
        return $dirName[1];    
    }
    
    public function addData(array $data){
        if(is_array($data)){
           $this->_data = array_merge($this->_data, $data);
        }
        return $this;
    }

    /**
     * Overwrite data in the object.
     *
     * The $key parameter can be string or array.
     * If $key is string, the attribute value will be overwritten by $value
     *
     * If $key is an array, it will overwrite all the data in the object.
     *
     * @param string|array  $key
     * @param mixed         $value
     * @return $this
     */
    public function setData($key, $value = null)
    {
        if ($key === (array)$key) {
            $this->_data = $key;
        } else {
            $this->_data[$key] = $value;
        }
        return $this;
    }

    /**
     * Unset data from the object.
     *
     * @param null|string|array $key
     * @return $this
     */
    public function unsetData($key = null)
    {
        if ($key === null) {
            $this->setData([]);
        } elseif (is_string($key)) {
            if (isset($this->_data[$key]) || array_key_exists($key, $this->_data)) {
                unset($this->_data[$key]);
            }
        } elseif ($key === (array)$key) {
            foreach ($key as $element) {
                $this->unsetData($element);
            }
        }
        return $this;
    }
   
    public function getData($key = ""){
       if(!$key) return $this->_data;
       
       return (isset($this->_data[$key])) ? $this->_data[$key] : null; 
    } 
    
    public function toHtml(){

        $fileName = $this->getTemplateFile();
        if(!file_exists($fileName)) return $this->addError(printf( esc_html__( "File %s not exist.", 'alothemes' ), $this->_template ));
        $html = $this->fetchView($fileName);

        return $html;
    }

    /**
     * Get absolute path to template
     *
     * @return string
     */
    public function getTemplateFile($_template='')
    {
        if(!$_template){
            if($this->getData('template')) $this->_template = $this->getData('template');
            $_template = $this->_template;      
        }
        $class = explode('\\', get_class($this));
        $fileName = $class[0] . '_' .$class[1] . '/templates/' . $_template ;
        $templateName = $this->getThemeFile($fileName, false);
        if(!$templateName){
            $templateName = $this->templateDir() . $_template;
        }
        return $templateName;
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

    /**
     * Retrieve block view from file (template)
     *
     * @param   string $fileName
     * @return  string
     */
    public function fetchView($located, $do=true)
    {
        if($do){
            ob_start();
        }
            // if ($this->getShowTemplateHints()) {
            //     echo '<div style="position:relative; border:1px dotted red; margin:6px 2px; padding:18px 2px 2px 2px; zoom:1;"><div style="position:absolute; left:0; top:0; padding:2px 5px; background:red; color:white; font:normal 11px Arial; text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=999" onmouseout="this.style.zIndex=998" title="'.$located.'">'.$located.'</div>';
            //     $thisClass = (is_object($this)) ? get_class($this) : '';
            //     if($thisClass) {
            //         echo '<div style="position:absolute; right:0; top:0; padding:2px 5px; background:red; color:blue; font:normal 11px Arial; text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=999" onmouseout="this.style.zIndex=998" title="' .$thisClass. '">' .$thisClass. '</div>';

            //     }
       
            // }


            do_action( 'magiccart_before_template_part', $located, $this );

            include( $located );

            do_action( 'magiccart_after_template_part', $located, $this );

            // if ($this->getShowTemplateHints()) {
            //     echo '</div>';
            // }

        if($do){
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }      
    }

    public function getShowTemplateHints(){
        return defined('TEMPLATEDHINTS');
    }
    
    public function setTemplate($file){
        $this->_template =  $file ;
        return $this;
    }

    protected function getTemplate(){
        return $this->_template;
    }

    public function get_options($key = ''){
        $opt = "";
        $template = get_option('stylesheet');
        $opt = $template . "_options";
        if(trim($key) != '' ){
            if(isset($GLOBALS[$opt][$key])){
                return $GLOBALS[$opt][$key];
            }else{
                $options = get_option($opt, array());
                if(isset($options[$key])){
                    return $options[$key];
                }else{
                    echo "$key not isset";
                }
            }
        }
        if(isset($GLOBALS[$opt])){
            return $GLOBALS[$opt];
        }else{
            return get_option($opt, array());
        }
    }

    public function addError($message, $type='error woocommerce-error')
    {
        // $error = new \WP_Error( 'broke', __( "File $this->_template not exist", 'alothemes' ) );
        // return $error->get_error_message();
        return '<div class="message ' . $type . '">' . $message . '</div>';
    }

}
