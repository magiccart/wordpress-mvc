<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-01 18:10:46
 * @@Modify Date: 2018-06-14 01:20:34
 * @@Function:
 */

namespace Magiccart\Composer\Block\Adminhtml;
use Magiccart\Composer\Model\Vccomposer;

class Vc {
    protected $_class;
    protected $_template;
	protected $_vcSetting = array();
    protected $_vcComposer;
    
    public function __construct(){
        $this->_class = strtolower((new \ReflectionObject($this))->getShortName());
        $this->_template = $this->_class . '.phtml'; //$this->_class . '.phtml';
        $this->_vcComposer = new Vccomposer();
    	add_action('init', array($this, 'initMap'), 99);
    }
    
    // **********************************************************************//
    // add Vc
    // **********************************************************************//
	public function initMap()
	{
		$params =array();
		$this->add_VcMap($params);
	}
    protected function add_VcMap($params, $name='', $shortcode='', $show_settings=true){
    	
		//     	$namespace = (new \ReflectionObject($this))->getNamespaceName();
		//     	$name = str_replace($namespace. '\\','', get_class($this) );
        if(!$name) $name = 'Magiccart ' . ucfirst($this->_class);
    	if(!$shortcode) $shortcode = 'magiccart_' . strtolower($this->_class);
        // $html_template = plugin_dir_path(__DIR__) . 'Magiccart/Composer/view/frontend/templates/vc_template.php';
    	$this->_vcSetting = array(
    			'name'           => $name,
    			'base'           => $shortcode,
    			'category'       => __( 'Magiccart', 'alothemes' ),
                'is_container'   => false,
    			'params'	     => $params,
                'icon'           => get_template_directory_uri() . "/images/logo.png",
                'show_settings_on_create' => $show_settings,
                // 'html_template'  => locate_template('templates/vc_row-header.php') ,

    	);
        
        vc_map($this->_vcSetting);
    }

    // **********************************************************************//
    // Bool
    // **********************************************************************//
    protected function bool($type ="", $defaut = 0, $flip = true){
        $bool = array();
        if(!$type){
            if(!$defaut){
                $bool = array(
                    '0'  => __('No', 'alothemes'),
                    '1' => __('Yes', 'alothemes'),
                );
            }else{
                $bool = array(
                    '1' => __('Yes', 'alothemes'),
                    '0'  => __('No', 'alothemes'),
                );
            }
        } else if($type == "yn"){
            if(!$defaut){
                $bool = array(
                    'no'  => __('No', 'alothemes'),
                    'yes' => __('Yes', 'alothemes'),
                );
            }else{
                $bool = array(
                    'yes' => __('Yes', 'alothemes'),
                    'no'  => __('No', 'alothemes'),
                );
            }
        }else if($type == "tf") {
            if(!$defaut){
                $bool = array(
                    'false' => __('False', 'alothemes'),
                    'true'  => __('True', 'alothemes'),
                );
            }else{
                $bool = array(
                    'true'  => __('True', 'alothemes'),
                    'false' => __('False', 'alothemes'),
                );
            }
        }
        if($flip){
            return array_flip($bool);
        }
        return $bool;
    }
    
    // **********************************************************************//
    // get_rows
    // **********************************************************************//
    protected function get_rows($row = 4, $flip=true){
        $option = array();
    
        for($i = 1; $i < $row; $i++){
            $option[$i] = $i . __(' row(s)', 'alothemes');
        }
        if($flip){
            return array_flip($option);
        }
        return $option;
    }
    
    // **********************************************************************//
    // get_item_per_rows
    // **********************************************************************//
    protected function get_item_per_rows($item = 10, $flip=true){
        $perRows = array();
        for($i = 1; $i < $item; $i++){
            $perRows[$i] = $i . __(' item(s) /row', 'alothemes');
        }
       
       if($flip){
            return array_flip($perRows);
       }
        return $perRows;
    }
    
    // **********************************************************************//
    // get_params settings
    // **********************************************************************//
    protected function get_settings($more = array()){

        $settings = array(
        	array(
    			'type'          => "textfield",
    			'heading'       => __("Limit : ", 'alothemes'),
                'description'   => __('Number of posts to show.', 'alothemes'),
    			'param_name'    => "number",
    			'value'         => "12",
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
        	),
            array(
                'type'          => "dropdown",
                'heading'       => __('Timer :', 'alothemes'),
                'description'   => __('Countdown time.', 'alothemes'),
                'param_name'    => 'timer',
                'value'         => $this->bool(),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Slide :', 'alothemes'),
                'description'   => __('Use Slider or Grid.', 'alothemes'),
                'param_name'    => 'slide',
                'value'         => $this->bool($type ="", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Slider Vertical :', 'alothemes'),
                'param_name'    => 'vertical',
                'value'         =>  $this->bool($type ="tf", $defaut = 0),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Infinite :', 'alothemes'),
                'param_name'    => 'infinite',
                'value'         => $this->bool($type ="tf", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Auto Play :', 'alothemes'),
                'param_name'    => 'autoplay',
                'value'         => $this->bool($type ="tf", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Arrows :', 'alothemes'),
                'param_name'    => 'arrows',
                'value'         => $this->bool($type ="tf", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Dots :', 'alothemes'),
                'param_name'    => 'dots',
                'value'         => $this->bool($type ="tf", $defaut = 0),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Rows :', 'alothemes'),
                'description'   => __('Use Slider or Grid.', 'alothemes'),
                'param_name'    => 'rows',
                'value'         => $this->get_rows(),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "textfield",
                'heading'       => __("Speed <span style='color:red;'>*</span> :", 'alothemes'),
                'param_name'    => "speed",
                'value'         => "300",
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "textfield",
                'heading'       => __("AutoPlay Speed <span style='color:red;'>*</span> :", 'alothemes'),
                'param_name'    => "autoplay-speed",
                'value'         => "3000",
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "textfield",
                'heading'       => __("Padding <span style='color:red;'>*</span> :", 'alothemes'),
                'param_name'    => "padding",
                'value'         => "15",
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),

            // array(
            //     'type'          => 'css_editor',
            //     'param_name'    => 'css',
            //     'group'         => __( 'Design options', 'alothemes' ),
            //     'admin_label'   => false,
            // ),
        );
        if($more) $settings = $more;
        return $settings;
    }

    protected function get_ajax_load(){
        return array(
                'type'          => "dropdown",
                'heading'       => __('Ajax :', 'alothemes'),
                'param_name'    => 'ajax_load',
                'value'         => $this->bool(),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            );
    }
    
    protected function get_responsive(){

        $get_item_per_rows = $this->get_item_per_rows();
        $responsive = array(
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 360 : ', 'alothemes'),
                'param_name'    => 'mobile',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 480 : ', 'alothemes'),
                'param_name'    => 'portrait',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 640 : ', 'alothemes'),
                'param_name'    => 'landscape',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 767 : ', 'alothemes'),
                'param_name'    => 'tablet',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 2,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 991 : ', 'alothemes'),
                'param_name'    => 'notebook',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 3,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Max-Width 1199 : ', 'alothemes'),
                'param_name'    => 'desktop',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 4,
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Min-Width 1200 : ', 'alothemes'),
                'param_name'    => 'visible',
                'value'         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 4,
                'save_always'   => true,
            )
        );

        return $responsive;
    }

    protected function setting_product( $more = array()){

        $settings = array(
            array(
                'type'          => "dropdown",
                'heading'       => __('Ajax :', 'alothemes'),
                'param_name'    => 'ajax_load',
                'value'         => $this->bool('', 1),
                'group'         => __( 'Setting Product', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Show Cart :', 'alothemes'),
                'param_name'    => 'cart',
                'value'         => $this->bool('', 1),
                'group'         => __( 'Setting Product', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Show Compare :', 'alothemes'),
                'param_name'    => 'compare',
                'value'         => $this->bool('', 1),
                'group'         => __( 'Setting Product', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Show Wishlist :', 'alothemes'),
                'param_name'    => 'wishlist',
                'value'         => $this->bool('', 1),
                'group'         => __( 'Setting Product', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                'type'          => "dropdown",
                'heading'       => __('Show Review :', 'alothemes'),
                'param_name'    => 'review',
                'value'         => $this->bool('', 1),
                'group'         => __( 'Setting Product', 'alothemes' ),
                'save_always'   => true,
            )
        );
        if($more) $settings[] = $more;
        return $settings;
    }

    protected function get_templates(){
        $settings = array();
        $templates = array();
        $msg_template = '';
        $class = explode('\\', get_class($this));
        $templatesDirs = array(
                        get_stylesheet_directory(),
                        get_template_directory()
            );
        foreach ($templatesDirs as $dir) {
            $templateDir = $dir . '/' . $class[0] . '_' .$class[1] . '/templates/';
            if (file_exists($templateDir) && is_dir($templateDir)) {
                $fileTheme  = $templateDir . $this->_template;
                $msg_template .= "Create custom file in path: $fileTheme <br/>";
                $regexr     = '/^' . $this->_class . '.*.phtml$/';
                $tmps  = preg_grep($regexr,  scandir($templateDir, 1));
                if($templates){
                    foreach ($tmps as $fileName) {
                        $templates[] = $fileName;
                    }
                } else {
                    $templates = $tmps;
                }
            }
        }
        

        if($templates){
            $templates = array_unique($templates);
            asort($templates);
            if(!in_array($this->_template , $templates)){
                array_unshift($templates, $this->_template);
            }
            if(count($templates) > 1){
                $settings[] = array(
                    'type'          => "dropdown",
                    'heading'       => __('Template custom file: ', 'alothemes'),
                    'param_name'    => 'template',
                    'value'         => $templates,
                    'group'         => __( 'Template', 'alothemes' ),
                    'std'           => '',
                    'description'   => $msg_template,
                    'save_always'   => true,
                );                     
            }        
        }

        return $settings;
    }
}
