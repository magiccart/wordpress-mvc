<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-09-06 10:12:41
 * @@Modify Date: 2018-02-03 11:57:33
 * @@Function:
 */

namespace Magiccart\Cms\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;

class Cms extends Action {
    protected $_type;
    public function __construct(){
        apply_filters( 'admin_url', array($this, 'getAddNewLinkCms', 10, 3 ) );
        add_action('init', array($this, 'cms_init'));
        add_action( 'save_post', array($this, 'save_meta_box'), 10, 3 );
        if(isset($_GET['type']) && $_GET['type']) {
            $this->_type = $_GET['type'];
        }
        add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
        // add_submenu_page(
        //     'magiccart',
        //     'Cms',
        //     'Cms',
        //     'manage_options',
        //     'edit.php?post_type=cms'
        // );

        // add_submenu_page(
        //     'magiccart',
        //     'Foooter 2',
        //     'Foooter 2',
        //     'manage_options',
        //     'edit.php?post_type=cms&type=footer'
        // );

        // add_submenu_page(
        //     'magiccart',
        //     'Header 2',
        //     'Header 2',
        //     'manage_options',
        //     'edit.php?post_type=cms&type=header'
        // );

        // add_submenu_page(
        //     'magiccart',
        //     'Slider 2',
        //     'Slider 2',
        //     'manage_options',
        //     'edit.php?post_type=cms&type=slider'
        // );

    }

    public function cms_init(){
        $labels = array(
            'name'               => _x( 'Cms', 'Post type general name', 'alothemes' ),
            'singular_name'      => _x( 'Cms', 'Post type singular name', 'alothemes' ),
            'menu_name'          => _x( 'Cms', 'Admin Menu text', 'alothemes' ),
            'name_admin_bar'     => _x( 'Cms', 'Add New on Toolbar', 'alothemes' ),
            'add_new'            => __( 'Add New', 'alothemes' ),
            'add_new_item'       => __( 'Add New Cms', 'alothemes' ),
            'new_item'           => __( 'New Cms', 'alothemes' ),
            'edit_item'          => __( 'Edit Cms', 'alothemes' ),
            'view_item'          => __( 'View Cms', 'alothemes' ),
            'all_items'          => __( 'All Cms', 'alothemes' ),
            'search_items'       => __( 'Search Cms', 'alothemes' ),
            'parent_item_colon'  => __( 'Parent Cms:', 'alothemes' ),
            'not_found'          => __( 'No Cms found.', 'alothemes' ),
            'not_found_in_trash' => __( 'No Cms found in Trash.', 'alothemes' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Magiccart Cms .', 'alothemes' ),
            'menu_icon'          => 'dashicons-image-filter',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false, // show in main admin set true
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'Cms' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            //'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
            'supports'           => array( 'title', 'editor', 'thumbnail', 'postcustom' )
        );
        register_post_type( 'cms', $args );

    }

    public function register_meta_boxes() {
        $type = $this->_type;
        switch ($type) {
             case 'header':
                # code...
                break;
            case 'slider':
                # code...
                break;
            case 'brand':
                # code...
                break;  
            case 'footer':
                # code...
                break;           
            default: // block
                # code...
                break;
        }
        add_meta_box( 'type', __( 'Cms Type', 'alothemes' ), array($this, 'callback_type'), 'cms' );

        add_meta_box( 'el_class', __( 'Extra class name', 'alothemes' ), array($this, 'callback_el_class'), 'cms' );
        add_meta_box( 'cms_skin', __( 'Skin', 'alothemes' ), array($this, 'callback_cms_skin'), 'cms' );
    }

    public function callback_type( $post ) {
        $meta = get_post_meta($post->ID, 'type', true);
        $type = esc_html( $meta ) ? esc_html( $meta ) : esc_html( $this->_type );
        $html = '<input id="type" type="hidden" placeholder="Cms Type" name="type" value="' .  $type . '" />';
        echo $html;
    }

    public function save_meta_box( $post_id, $post, $update  ) {
        if(isset($_POST['cms_skin'])){
            update_post_meta($post_id, 'cms_skin', $_POST['cms_skin']);
        }
        if(isset($_POST['el_class'])){
            update_post_meta($post_id, 'el_class', $_POST['el_class']);
        }
    }

    public function callback_el_class( $post ) {
        $meta = get_post_meta($post->ID, 'el_class', true);
        $html = '<input id="el_class" type="text" placeholder="Extra class Cms" name="el_class" value="' . esc_html( $meta ) . '" />';
        echo $html;
    }

    public function callback_cms_skin( $post ) {
        $meta = get_post_meta($post->ID, 'cms_skin', true);
        $html = '<textarea id="cms_skin" name="cms_skin" class="widefat hidden" cols="50" rows="5">' . esc_textarea( $meta )  . '</textarea>';
        $html .= '<div id ="ace_cms_skin" class="code-editor" data-language="css" data-theme="monokai">'. esc_html( $meta ) . '</div>';
        $html .= '<div class="description">' .__('Paste your CSS code here.', 'alothemes') . '</span>';
        $html .= '<style type="text/css">.ace_editor { height: 150px }</style>';
        echo $html;
    }

    public function add_admin_web(){
        $plugin = plugins_url();
       // wp_register_script('ace-editor',  'http://cdn.jsdelivr.net/ace/1.1.9/min/ace.js', array('jquery') ,'1.0');

       wp_register_script('ace-editor',  $plugin .  $this->_static . 'js/ace-editor/ace.js', array('jquery') ,'1.0');
        wp_enqueue_script('ace-editor');
        wp_register_script('ace-alothemes',  $plugin .  $this->_static . 'js/ace.alothemes.js', array('jquery', 'ace-editor') ,'1.0');
        wp_enqueue_script('ace-alothemes');
    }

    public function getAddNewLinkCms( $url, $path ){
        if( $path === 'post-new.php?post_type=cms' ) {
            $newPath = 'post-new.php?post_type=cms&type=' . $this->_type;
            $url = get_permalink($newPath); 
        }
        if( $path === 'edit.php?post_type=cms' ) {
            $newPath = 'edit.php?post_type=cms&type=' . $this->_type;
            $url = get_permalink($newPath); 
        }

        // echo $url;
        // die('ssd');
        return $url;
    }

}
