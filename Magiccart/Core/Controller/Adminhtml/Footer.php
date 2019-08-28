<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-09 22:09:48
 * @@Modify Date: 2018-06-14 11:03:12
 * @@Function:
 */

namespace Magiccart\Core\Controller\Adminhtml;

class Footer extends Action {

    private $_static = '/Magiccart/Core/view/adminhtml/web/';

    public function __construct(){
        add_action('init', array($this, 'footer_init'));
        add_action( 'save_post', array($this, 'save_meta_box'), 10, 3 );
        if( defined('HEADER_BUILDER') && ! HEADER_BUILDER ){
            add_action('admin_init', array($this, 'add_admin_web'));
        }
        add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
        add_submenu_page(
            'magiccart',
            'Footer',
            'Footer',
            'manage_options',
            'edit.php?post_type=footer'
        );

    }

    public function footer_init(){
        $labels = array(
            'name'               => _x( 'Footer', 'Post type general name', 'alothemes' ),
            'singular_name'      => _x( 'Footer', 'Post type singular name', 'alothemes' ),
            'menu_name'          => _x( 'Footer', 'Admin Menu text', 'alothemes' ),
            'name_admin_bar'     => _x( 'Footer', 'Add New on Toolbar', 'alothemes' ),
            'add_new'            => __( 'Add New', 'alothemes' ),
            'add_new_item'       => __( 'Add New Footer', 'alothemes' ),
            'new_item'           => __( 'New Footer', 'alothemes' ),
            'edit_item'          => __( 'Edit Footer', 'alothemes' ),
            'view_item'          => __( 'View Footer', 'alothemes' ),
            'all_items'          => __( 'All Footers', 'alothemes' ),
            'search_items'       => __( 'Search Footer', 'alothemes' ),
            'parent_item_colon'  => __( 'Parent Footer:', 'alothemes' ),
            'not_found'          => __( 'No Footer found.', 'alothemes' ),
            'not_found_in_trash' => __( 'No Footer found in Trash.', 'alothemes' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Magiccart Footer .', 'alothemes' ),
            'menu_icon'          => 'dashicons-image-filter',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false, // show in main admin set true
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'footer' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            //'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
            'supports'           => array( 'title', 'editor', 'thumbnail', 'postcustom' )
        );
        register_post_type( 'footer', $args );

    }

    public function register_meta_boxes() {
        add_meta_box( 'el_class', __( 'Extra class name', 'alothemes' ), array($this, 'callback_el_class'), 'footer' );
        add_meta_box( 'footer_skin', __( 'Skin', 'alothemes' ), array($this, 'callback_footer_skin'), 'footer' );
    }

    public function save_meta_box( $post_id, $post, $update  ) {
        if(isset($_POST['footer_skin'])){
            update_post_meta($post_id, 'footer_skin', $_POST['footer_skin']);
        }
        if(isset($_POST['el_class'])){
            update_post_meta($post_id, 'el_class', $_POST['el_class']);
        }
    }

    public function callback_el_class( $post ) {
        $meta = get_post_meta($post->ID, 'el_class', true);
        $html = '<input id="el_class" type="text" placeholder="Extra class Footer" name="el_class" value="' . esc_html( $meta ) . '" />';
        echo $html;
    }

    public function callback_footer_skin( $post ) {
        $meta = get_post_meta($post->ID, 'footer_skin', true);
        $html = '<textarea id="footer_skin" name="footer_skin" class="widefat hidden" cols="50" rows="5">' . esc_textarea( $meta )  . '</textarea>';
        $html .= '<div id ="ace_footer_skin" class="code-editor" data-language="css" data-theme="monokai">'. esc_html( $meta ) . '</div>';
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

}

