<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-13 22:35:58
 * @@Modify Date: 2018-06-11 12:09:53
 * @@Function:
 */
namespace Magiccart\Import\Model\Import;

use Magiccart\Core\Model\System\Theme\Option;

class Collection{

    private $_etc = ABSPATH . 'wp-content/plugins/Magiccart/Import/etc/';
    public $wp_option = array
        (
            'magiccart_cms',
            'magiccart_shopbrand',
            'magiccart_slider',
        );
    
    /* Export / Import */
    public function __construct(){
        $data['message']= '';
        $brandsName     = 'magiccart_shopbrand';
        $blocksName     = 'magiccart_cms';
        $sliderName     = 'magiccart_slider';
        $folderExport   = 'exportimages';
        $_option = new Option;

        $reduxName = $_option->getName();
        $theme_option = $_option->theme_option;
        update_option($theme_option, $reduxName);
        $error      = "";
        if(!isset($_POST['submit'])) return;
        
        $pathEtc = $this->_etc;

        $action     = $_POST['action'];
        $wp_option      = isset($_POST['wp_option']) ? $_POST['wp_option'] : array();
        $wp_option[]    = 'post';
        $page       = $_POST['front_page'];
        if($action == "export"){

            $redux      = isset($_POST['redux']) ? $_POST['redux'] : array();
            $option_name = '';
            foreach ( $wp_option as $type ) {
                $arrPage = explode('_', $page);
                $path = $pathEtc . 'data_theme';
                if($type == 'redux' || $type == 'post'){
                    $path = $pathEtc . 'data_page/' . $page;
                }
                
                if(!file_exists($path)){
                    @mkdir($path, 0777, true);
                }
                if($type == 'post'){
                    $this->exportData($type, $path . '/', $arrPage[1]);
                }else if($type == 'images'){
                    $this->exportImage($folderExport, true);
                }else{
                    $this->exportData($type, $path . '/');
                }
            }
            
            $data['message'] = '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> <p><strong>Export success !</strong></p></div>';
        }else{
            foreach ($wp_option as  $type) {
                $fileName = 'magiccart' . $type;
                $pathFile = $pathEtc . 'data_theme/' . $fileName . '.xml';
                if($type == 'redux' || $type == 'post'){
                    $pathFile = $pathEtc . 'data_page/' . $page . '/' . $fileName . '.xml';
                }

                if(file_exists($pathFile)){
                    $content = file_get_contents($pathFile);
                    $objXml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
        
                    $old_domain = $objXml->domain;
                    $new_domain = get_site_url();
                    $jsonOld_domain = substr(json_encode($old_domain), 1, -1) ;
                    $jsonNew_domain = substr(json_encode($new_domain), 1, -1);
                    
                    $options = $objXml->options->item;
                    if(in_array($type, $this->wp_option)){
                        foreach ($options as $key => $value) {
                            $content = str_replace($jsonOld_domain, $jsonNew_domain, $value);
                            update_option($blocksName, "$content");
                        }                        
                    }else if($type == "redux"){
                        foreach ($options as $key => $value) {
                            $content = str_replace($jsonOld_domain, $jsonNew_domain, $value);
                            $content = json_decode($content, true);
                            update_option($reduxName, $content);
                        }
                    }else if($type == "post"){
                        $this->import_wp_posts($item);
                    }

                    $data['message'] = '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> <p><strong>Import success !</strong></p></div>';
                }else if($type == "images"){
                    $listLinkImage = $this->exportImage($folderExport);
                    $this->up($folderExport, $listLinkImage);
                }else{
                    $data['message'] = '<div id="setting-error-invalid_siteurl" class="error settings-error notice is-dismissible"> 
<p><strong>File Import not exists !</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                }
            }
        }
        return $data;
     }

    public function export_wp_option($file, $opt)
    {
        $option = get_option($opt, '');
        if(!$option) return;
        $theme = wp_get_theme();
        $path = $file . $theme->template . '/';
        if(!file_exists($path)){
            @mkdir($path, 0777, true);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<root>';
                $xml.= '<domain><![CDATA[' . get_site_url() . ']]></domain>';
                $xml.= '<options>';
                    $xml .= '<item><![CDATA[ '. $option . ']]></item>';
                $xml.= '</options>';
            $xml.= '</root>';
        $doc =  new \DOMDocument('1.0', 'UTF-8');
        $doc->loadXML($xml);
        $doc->formatOutput = true;
        $doc->save($path . $option . '.xml');
    }

    public function export_wp_posts($file, $id, $type='post')
    {
        $post = get_post($id);
        if(!$post) return;
        $theme = wp_get_theme();
        $path  = $file . $theme->template . '/';
        if(!file_exists($path)){
            @mkdir($path, 0777, true);
        }
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<root>';
                $xml.= '<domain><![CDATA[' . get_site_url() . ']]></domain>';
                $xml.= '<options>';
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
                        $xml.= '<template>' . get_post_meta($id, '_wp_page_template', true) . '</template>';
                    $xml .= '</item>';
                $xml.= '</options>';
            $xml.= '</root>';
        $doc =  new \DOMDocument('1.0', 'UTF-8');
        $doc->loadXML($xml);
        $doc->formatOutput = true;
        $doc->save($path . $option . '.xml');
    }

    public function import_wp_option($file, $overwrite=false)
    {
        if(!file_exists($file)) return;

        $content = file_get_contents($file);
        $objXml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

        $old_domain = $objXml->domain;
        $new_domain = get_site_url();

        $jsonOld_domain = substr(json_encode($old_domain), 1, -1) ;
        $jsonNew_domain = substr(json_encode($new_domain), 1, -1);
        
        $options = $objXml->options->item;
        foreach ($options as $key => $value) {
            $content = str_replace($jsonOld_domain, $jsonNew_domain, $value);
            update_option($blocksName, "$content");
        }

    }

    public function import_wp_posts($post)
    {
        $template = $post->template;
        $my_post = array(
            'post_title'    => $post->post_title,
            'post_content'  => $post->post_content,
            'post_name'     => $post->post_name,
            'post_type'     => $post->post_type,
            'post_status'   => 'publish',
        );
        wp_insert_post( $my_post );
        add_action( 'save_post', 'save_page', 10, 3 );
    
        function save_page($post_id, $post, $update  ){
            update_post_meta($post_id, '_wp_page_template', $template);
        }        
    }

    //function exportImage($folder, $database, $name, $copy = false){
    public function exportImage($folder,$copy = false){
        global $wpdb; 

        $brandsName = 'magiccart_shopbrand';
        $blocksName = 'magiccart_cms';
        $sliderName = 'magiccart_slider';
        $imgs       = array();

        /*Brands*/
        $brands = get_option($brandsName, '');
        $brands = json_decode($brands, true);

        foreach ($brands as $brand) {
            foreach ($brand as $key => $value) {
                if($key == 'img'){
                    $imgs[]  = $value;
                }
            }   
        }

        /*Blocks*/
        $blocks = get_option($blocksName, '');
        $blocks = json_decode($blocks, true);
        
        foreach ($blocks as $block) {
            foreach ($block as $key => $value) {
                if($key == 'value'){
                    
                    $arr = explode('<img', $value);
                    
                    foreach ($arr as $img) {
                        $html = "<img " . $img;

                        $doc = new \DOMDocument('1.0', 'UTF-8');
                        @$doc->loadHTML($html);
                        $xpath = new \DOMXPath($doc);
                        $src = $xpath->evaluate("string(//img/@src)") ;
                        $imgs[] = substr($src, 2, -2) ;
                    }
                }
            }
        }
        /*Slider*/
        $optionSlider                  = get_option($sliderName, '');
        $optionSlider                  = json_decode($optionSlider, true);
        foreach ($optionSlider as $keyGP => $group) {
            foreach ($group as $key => $value) {
                if(is_array($value)){
                    foreach ($value as $kyItem => $valItem) {
                        foreach ($valItem as $ky => $content) {
                            if($ky == 'src'){
                                $imgs[] = $content;
                            }
                        }
                    }
                }
            }
        }

        /*Banner*/
        $banner = magiccart_options('logo-image');
        $imgs[] = $banner['url'];


        /*Posts*/
        $post_like = '%http%';
        $sql_posts = $wpdb->prepare(
            "SELECT post_content FROM $wpdb->posts WHERE post_content LIKE %s", 
            $post_like
        ); 
        $resultPosts = $wpdb->get_results($sql_posts, "ARRAY_A");
        foreach ($resultPosts as $key => $value) {
            foreach ($value as $val) {
                $arr = explode('<img', $val);
                foreach ($arr as $img) {
                    $html = "<img " . $img;

                    $doc = new \DOMDocument('1.0', 'UTF-8');
                    @$doc->loadHTML($html);
                    $xpath = new \DOMXPath($doc);
                    $imgs[] = $xpath->evaluate("string(//img/@src)") ;
                }
            }
        }
        
        $args = array(
                    'category' => 0,
                    'order' => 'DESC', 'include' => array(),
                    'exclude' => array(), 'meta_key' => '',
                    'meta_value' =>'', 'post_type' => 'post',
                    'suppress_filters' => true
            );
        $posts = get_posts($args);
        foreach($posts as  $value){
            $idImage    = get_post_thumbnail_id($value->ID);
            $image      = wp_get_attachment_image_src($idImage,'medium');
            $imgs[] = $image[0] ;
         }
         
        
        /*Menu*/
        $sql_icon   = 'SELECT `meta_value` FROM `'. $wpdb->postmeta. '` WHERE `meta_key` = "_magiccart_icon"';
        $sql_image  = 'SELECT `meta_value` FROM `'. $wpdb->postmeta. '` WHERE `meta_key` = "_magiccart_image"';
        $sql_image_wp  = 'SELECT `meta_value` FROM `'. $wpdb->postmeta. '` WHERE `meta_key` = "_wp_attached_file"';
        

        $resultIcon = $wpdb->get_results($sql_icon, "ARRAY_A");
        foreach ($resultIcon as $image) {
            foreach ($image as $value) {
                if($value != ""){
                    $imgs[] = $value;
                }
            }
        }
        
        $resultImage = $wpdb->get_results($sql_image, "ARRAY_A");
        foreach ($resultImage as $image) {
            foreach ($image as $value) {
                if($value != ""){
                    $imgs[] = $value;
                }
            }
        }

        $resultImageWp = $wpdb->get_results($sql_image_wp, "ARRAY_A");
        foreach ($resultImageWp as $image) {
            foreach ($image as $value) {
                if($value != ""){
                    $imgs[] = "uploads/" . $value;
                }
            }
        }

        

        foreach ($imgs as $key => $value) {
            if(trim($value) != ""){
                //echo "<img src={$value} style='max-width:80px;max-height:80px;float:left;margin-right:20px;margin-bottom:10px;' />";
            }else{
                unset($imgs[$key]);
            }
        }
        
        $temp = array();
        foreach ($imgs as $value) {
            $temp[] = substr($value, strripos($value, "uploads"));
        }
        $imgs = array_unique($temp);

        if(!$copy) return $imgs;
        $linkFolder = ABSPATH . 'wp-content/';
        foreach ($imgs as $value) {
            $oldFile = $linkFolder . $value;
            $newFile = $linkFolder . $folder . str_replace('uploads', '', $value);
            
            $FolderPath = explode('/', $value);
            array_pop($FolderPath);
            array_shift($FolderPath);

            if(!file_exists($linkFolder . $folder)){
                @mkdir($linkFolder . $folder, 0777, true);
            }
            if(!file_exists($linkFolder . $folder . '/' . $FolderPath[0])){
                @mkdir($linkFolder . $folder . '/' . $FolderPath[0], 0777, true);
            }
            if(@!file_exists($linkFolder . $folder . '/' . $FolderPath[0] . '/' . $FolderPath[1])){
                @mkdir($linkFolder . $folder . '/' . $FolderPath[0] . '/' . $FolderPath[1], 0777, true);
            }
            @copy($oldFile, $newFile);
        }
        return $imgs;
    }

    public function upImage($linkFolder, $time = ""){
        $fileFolder = scandir($linkFolder);
        $fileFolder = array_slice($fileFolder, 2);
        $siteurl    = get_option('siteurl');
        foreach ($fileFolder as $key => $file) {
            $filename = basename($file);

            $temp = explode('/', $linkFolder);
            array_shift($temp);
            $temp = implode('/', $temp);
            if(file_exists(ABSPATH . 'wp-content/uploads/' . $time . '/' . $filename)) continue;

            $upload_file = wp_upload_bits( $filename, null, file_get_contents($linkFolder . '/' .$file), $time);
            if (!$upload_file['error']) {
                $wp_filetype = wp_check_filetype($filename, null );
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_parent' => $parent_post_id,
                    'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'guid' => $siteurl.'/'.$temp. '/' .$file,
                );
                $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
                if (!is_wp_error($attachment_id)) {
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                    wp_update_attachment_metadata( $attachment_id,  $attachment_data );
                }
            }
        }
    }
    public function up($folder, $listLinkImage){
        $linkFolder = get_home_path() .'wp-content/';
        
        foreach ($listLinkImage as $path) {
            $pathName = str_replace('uploads', $folder, $path);
            $pathFolderArr = explode('/', $pathName);
            array_pop($pathFolderArr);
            $pathFolder = implode('/', $pathFolderArr);

            
            if(!file_exists($linkFolder . 'uploads')){
                @mkdir($linkFolder . 'uploads', 0777, true);
            }
            if(!file_exists($linkFolder . 'uploads' . '/' . $FolderPath[0])){
                @mkdir($linkFolder . 'uploads' . '/' . $FolderPath[0], 0777, true);
            }
            if(!file_exists($linkFolder . 'uploads' . '/' . $FolderPath[0] . '/' . $FolderPath[1])){
                @mkdir($linkFolder . 'uploads' . '/' . $FolderPath[0] . '/' . $FolderPath[1], 0777, true);
            }

            $pathFol[] = get_home_path() . 'wp-content/'. $pathFolder;
        }


        $pathFol = array_unique($pathFol);

        foreach ($pathFol as  $path) {
            $time = str_replace( get_home_path() . 'wp-content/'. $folder .'/', '', $path);
            $this->upImage($path, $time);
        }
    }

}

