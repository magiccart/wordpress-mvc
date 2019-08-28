<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-12-08 14:17:12
 * @@Modify Date: 2018-06-11 17:18:45
 * @@Function:
 */
namespace Magiccart\Import\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Core\Model\System\Post;
use Magiccart\Import\Block\Adminhtml\Import as Block;
use Magiccart\Core\Model\System\Theme\Option;
use Magiccart\Core\Block\Themestyle;

class Import extends Action {
	private $_menu_slug  = 'magiccart';
	private $_etc = MC_PLUGIN_DIR . '/Magiccart/Import/etc/';
    private $wp_option = array(
            'magiccart_cms',
            'magiccart_shopbrand',
            'magiccart_slider',
            'magiccart_testimonial',
            'sidebars_widgets'
        );
    private $postmeta = array(
    	'_wp_page_template',
    	'_wpb_shortcodes_custom_css',
    	'header_skin',
    	'footer_skin',
    	'el_class'  	
    	);
    private $_tmppost;
	public $_block;
	public $_post;
	public $_option;
	public $_theme;
	public function __construct(){
		add_action('admin_enqueue_scripts', array($this, 'add_admin_web'));
		$this->_initAction();
	}
	
	protected function _initAction(){
		add_action('admin_menu', array($this, 'subMenu'));
	}
	
	public function subMenu(){
		add_submenu_page($this->_menu_slug, __('Import', 'alothemes'), __('Import', 'alothemes'), 'manage_options',
				$this->_menu_slug . '-import' , array($this, 'importAction'));
		add_submenu_page($this->_menu_slug, __('Export', 'alothemes'), __('Export', 'alothemes'), 'manage_options',
				$this->_menu_slug . '-export' , array($this, 'exportAction'));
	}
	
	public function exportAction(){
		$this->_block = new Block();
		$this->_option = new Option();
		$message = '';
		if(isset($_POST['redux'])){
			$redux = $_POST['redux'];
			$this->_theme = wp_get_theme();
			$prefix_option = $this->_option->theme_option;
			$option_style = str_replace($this->_option->theme_option, '', $redux);
			$dir = $this->_etc . $this->_theme->template . '/' . $option_style . '/';

            $wp_option = $this->wp_option;
            array_unshift($wp_option, $redux);
            array_unshift($wp_option, $this->_option->theme_option);
            global $wpdb;
            $option_like = 'widget_magiccart%';
            $sql = $wpdb->prepare(
                "SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s", 
                $option_like
            );
            $widgetOptions = $wpdb->get_results( $sql );
            foreach ($widgetOptions as $option) { 
                $wp_option[] = $option->option_name;
            }

            // $wp_option[] = 'sidebars_widgets';
            
			$this->export_wp_option($dir, $wp_option);
            $posts = array();
            if(isset($_POST['header'])) $posts[] = $_POST['header'];
            if(isset($_POST['pages'])) $posts = array_merge($posts, $_POST['pages']);
            if(isset($_POST['footer'])) $posts[] = $_POST['footer'];
            try {
                $this->export_wp_posts($dir, $posts);
                $message = '<div id="message" class="updated"><p>' . __('Export data successfully to path: ', 'alothemes') . $dir . '</p></div>';
            } catch (Exception $e) {
                $message = '<div id="message" class="error"><p>' . $e->getMessage() . '</p></div>';
            }
			
		}

		$this->_post = new Post();
		$data['header'] = $this->_post->getPost('header', true);
		$data['footer'] = $this->_post->getPost('footer', true);
		$data['redux']  = $this->_option->get_all_options();
		// $data['wp_option'] = $this->wp_option;	
        $data['message'] = $message;			
		if($data) $this->_block->addData($data);
		$this->_block->setData('template', 'export.phtml');
		echo $this->_block->toHtml();
	}

	public function importAction($withEmpty = true){
		$this->_block = new Block();
		$this->_option = new Option();
		$message = '';
		$data = array();
		$path = $this->_etc;

		if(isset($_POST['theme'])){
			$theme = $_POST['theme'];
			$dir = $this->_etc . $theme;
			$wp_post = $dir . '/wp_post.xml';
            if(!file_exists($wp_post)){
                echo __('File not exist:', 'alothemes') . $wp_post;
                die();
            }
            $wp_option = $dir . '/wp_option.xml';
            if(!file_exists($wp_post)){
                echo __('File not exist:', 'alothemes') . $wp_option;
                die();
            }
            ;

            // var_dump($_POST['activate']);

            try {
                $this->import_wp_option($wp_option);
                $this->import_wp_posts($wp_post, $_POST['overwrite']);
                $message = '<div id="message" class="updated"><p>' . __('Import data successfully from path: ', 'alothemes') . $dir . '</p></div>';
                $themestyle = new Themestyle;
                $style = $themestyle->css_path();
                if(file_exists($style))unlink($style); // delete file
            } catch (Exception $e) {
                $message = '<div id="message" class="error"><p>' . $e->getMessage() . '</p></div>';
            }
		}

        $packages = $this->_listDirectories($path);
        $themeOptions = array();
        foreach ($packages as $pkg) {
            $themes = $this->_listDirectories($path.$pkg);
            foreach ($themes as $theme) {
                $themeOptions[] = array(
                    'label' => $pkg. '/' .$theme,
                    'value' => $pkg. '/' .$theme
                );
            }
        }
        $label = $themeOptions ? __('-- Select Theme --', 'alothemes') : __('-- Not found theme --', 'alothemes');
        if ($withEmpty) {
            array_unshift($themeOptions, array(
                'value' => '',
                'label' => $label
            ));
        }
    	$data['theme'] = $themeOptions;
        $data['message'] = $message;
		if($data) $this->_block->addData($data);
		echo $this->_block->toHtml();
	}

    private function _listDirectories($path, $fullPath = false)
    {
        $result = array();
        $dir = opendir($path);
        if ($dir) {
            while ($entry = readdir($dir)) {
                if (substr($entry, 0, 1) == '.' || !is_dir($path . DIRECTORY_SEPARATOR . $entry)){
                    continue;
                }
                if ($fullPath) {
                    $entry = $path . DIRECTORY_SEPARATOR . $entry;
                }
                $result[] = $entry;
            }
            unset($entry);
            closedir($dir);
        }
        asort($result);
        return $result;
    }

	public function add_admin_web(){
         wp_register_script('mc-import', $this->get_url('adminhtml/web/js/import.js') );
         wp_enqueue_script('mc-import');
	}

    public function export_wp_option($path, array $opts)
    {
        if(!file_exists($path)){
            @mkdir($path, 0777, true);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<root>';
                $xml.= '<domain><![CDATA[' . get_site_url() . ']]></domain>';
                $xml.= '<options>';
                    $private_option = $this->_option->theme_option;
                    foreach ($opts as $opt) {
                        if($opt == $private_option){
                            $value = $_POST['redux'];
                        } else {
                            $value = get_option($opt, '');
                            if(!$value) continue;
                        }

                        $convert = 0; 
                        if (is_array($value)){
                            $convert = 1;
                            $value = json_encode($value);
                        }
                        if ( is_object($value)){
                            $convert = 2;
                            $value = json_encode($value);
                        }
                        $xml .= '<item>';
                            $xml.= '<option_name>';
                            $xml .= '<![CDATA[' . $opt . ']]>';
                            $xml.= '</option_name>';
                            $xml.= '<option_value>';
                            $xml .= '<![CDATA[' . $value . ']]>';
                            $xml.= '</option_value>';
                            $xml.= '<json_decode>';
                            $xml .= '<![CDATA[' . $convert . ']]>';
                            $xml.= '</json_decode>';
                        $xml .= '</item>';
                    }
                $xml.= '</options>';
            $xml.= '</root>';
        $doc =  new \DOMDocument('1.0', 'UTF-8');
        $doc->loadXML($xml);
        $doc->formatOutput = true;
        $doc->save($path . 'wp_option.xml');
    }

    public function export_wp_posts($path, array $ids)
    {
        if(!file_exists($path)){
            @mkdir($path, 0777, true);
        }
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<root>';
                $xml.= '<domain><![CDATA[' . get_site_url() . ']]></domain>';
                $xml.= '<options>';
        			foreach ($ids as $id) {
				        $post = get_post($id);
				        if(!$post) continue;
	                    $xml .= '<item>';
	                        $xml.= '<post_title>';
	                        $xml .= '<![CDATA[' . $post->post_title . ']]>';
	                        $xml.= '</post_title>';
	                        $xml.= '<post_name>';
	                        $xml .= '<![CDATA[' . $post->post_name . ']]>';
	                        $xml.= '</post_name>';
	                        $xml.= '<post_type>';
	                        $xml .= '<![CDATA[' . $post->post_type . ']]>';
	                        $xml.= '</post_type>';
	                        $xml.= '<post_content>';
	                        $xml .= '<![CDATA[' . $post->post_content . ']]>';
	                        $xml.= '</post_content>';
	                        foreach ($this->postmeta as $meta_key) {
	                        	$xml.= '<' . $meta_key . '><![CDATA[' . get_post_meta($id, $meta_key, true) . ']]></' . $meta_key . '>';
	                        }
	                    $xml .= '</item>';
        			}
                $xml.= '</options>';
            $xml.= '</root>';
        $doc =  new \DOMDocument('1.0', 'UTF-8');
        $doc->loadXML($xml);
        $doc->formatOutput = true;
        $doc->save($path . 'wp_post.xml');
    }

    public function import_wp_option($file)
    {
        $content = file_get_contents($file);
        $objXml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

        $old_domain = $objXml->domain;
        $new_domain = get_site_url();
        $jsonOld_domain = substr(json_encode($old_domain), 1, -1) ;
        $jsonNew_domain = substr(json_encode($new_domain), 1, -1);
            
        $options = $objXml->options->children();
        foreach ($options as $item) {
            $opt = (array) $item;
            $value = $opt['option_value'];
            if($opt['json_decode'] == '1'){
                $value = json_decode($value, true); // return array;
            }elseif($opt['json_decode'] == '2'){
                $value = json_decode($value);  // return object;
            }
            update_option( $opt['option_name'], $value );    
        }
    }

    public function import_wp_posts($file, $overwrite=false)
    {
        $content = file_get_contents($file);
        $objXml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

        $old_domain = $objXml->domain;
        $new_domain = get_site_url();
        $jsonOld_domain = substr(json_encode($old_domain), 1, -1) ;
        $jsonNew_domain = substr(json_encode($new_domain), 1, -1);
        
        add_action( 'save_post', array($this, 'import_post_meta'), 10, 3 );
        // add_action( 'post_updated', array($this, 'import_post_meta'), 10, 3 );
 		$posts = $objXml->options->children();
        $postsexist = array();
 		foreach ($posts as $item) {
            $item = (array) $item;
            if($overwrite){
                $post = get_page_by_path( $item['post_name'], OBJECT, $item['post_type'] );
                if($post){
                    $post_id = $post->ID;
                    $update_post = array(
                        'ID'            => $post_id,
                        'post_title'    => $item['post_title'],
                        'post_content'  => $item['post_content'],
                        'post_name'     => $item['post_name'],
                        'post_type'     => $item['post_type'],
                        'post_status'   => 'publish',
                    );

                    wp_update_post( $update_post );
                    foreach ($this->postmeta as $meta_key) {
                        $meta_value = addslashes($item[$meta_key]);
                        if( !$meta_value ) continue;
                        update_post_meta($post_id, $meta_key, $meta_value);
                    }                    
                    $postsexist[$item['post_name']] = $item['post_title'];
                    continue;
                }
            }
	        $add_post = array(
                'post_title'    => $item['post_title'],
                'post_content'  => $item['post_content'],
                'post_name'     => $item['post_name'],
                'post_type'     => $item['post_type'],
	            'post_status'   => 'publish',
	        );
	        $this->_tmppost = $item;
	        wp_insert_post( $add_post );
 		}
   
    }

    public function import_post_meta($post_id, $post, $update)
    {
        foreach ($this->postmeta as $meta_key) {
        	$meta_value = addslashes($this->_tmppost[$meta_key]);
        	if( !$meta_value ) continue;
        	update_post_meta($post_id, $meta_key, $meta_value);
        }
    }

}

