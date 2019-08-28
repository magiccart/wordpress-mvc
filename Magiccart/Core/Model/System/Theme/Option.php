<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-12-07 16:34:54
 * @@Modify Date: 2018-03-09 18:02:27
 * @@Function:
 */
namespace Magiccart\Core\Model\System\Theme;

class Option{
	
	public $_option_files;
	
	public $theme_option = 'magiccart_theme_option';

	public function __construct(){
		$styleDir 		= get_template_directory() . '/css/style';
		if (file_exists($styleDir) && is_dir($styleDir)) {
		    $regexr     =  '/^style.*.css$/';
		    $this->_option_files = preg_grep($regexr,  scandir($styleDir));
		}
	}
	
	public function getName(){

		$fileStyle = $this->_option_files;
		if(!$fileStyle) return;
		$opt = "";
		foreach ($fileStyle as $file) {
			$name 	= str_replace('.css', '', $file);
			$name 	= str_replace('-', '_', $name);
			$opt 	= $this->theme_option . '_' . $name;
			break;
		}

		$optionsName = get_option($this->theme_option, $opt);

		return $optionsName;
	}

	public function option_styles(){
		$fileStyle = $this->_option_files;
		if(!$fileStyle) return;
		$optionsTheme 	= array();
		$i = 1;
		foreach ($fileStyle as $file) {
			$style[$file] = $file;
			$name 	= str_replace('.css', '', $file);
			$name 	= str_replace('-', '_', $name);
			$key 	=  $this->theme_option . '_' . $name;
			$value 	= __('Theme', 'alothemes') . ' ' . wp_get_theme() . ' ' . $i++;
			$optionsTheme[$key] = $value;
		}
		return 	$optionsTheme;
	}
	
	public function get_option($opt){
		return get_option($opt);
	}

	public function get_all_options(){
		global $wpdb;
		$theme_options = $this->theme_option . '_%';
    	$sql = $wpdb->prepare(
	    	"SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s", 
	    	$theme_options
    	); 
		$reduxOptions = $wpdb->get_results( $sql );
		$_options = array();
		foreach ($reduxOptions as $option) {
            $regexr     = '/.*.backup|transients$/';
            $tmps  = preg_match($regexr,  $option->option_name);
			if ($tmps) continue;	
			$_options[] = $option->option_name;
		}
		return 	$_options;
	}

}
