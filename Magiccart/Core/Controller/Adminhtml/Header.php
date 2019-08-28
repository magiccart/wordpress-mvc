<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-09 22:09:48
 * @@Modify Date: 2018-02-03 11:52:34
 * @@Function:
 */

namespace Magiccart\Core\Controller\Adminhtml;

class Header extends Action {

    private $_static = '/Magiccart/Core/view/adminhtml/web/';

    public function __construct(){
        add_action('admin_init', array($this, 'header_init'));
        add_action('admin_init', array($this, 'add_admin_web'));
        add_action( 'save_post', array($this, 'save_meta_box'), 10, 3 );
        add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
        add_submenu_page(
            'magiccart',
            'Header',
            'Header',
            'manage_options',
            'edit.php?post_type=header'
        );

    }

    public function header_init(){
        $labels = array(
            'name'               => _x( 'Header', 'Post type general name', 'alothemes' ),
            'singular_name'      => _x( 'Header', 'Post type singular name', 'alothemes' ),
            'menu_name'          => _x( 'Header', 'Admin Menu text', 'alothemes' ),
            'name_admin_bar'     => _x( 'Header', 'Add New on Toolbar', 'alothemes' ),
            'add_new'            => __( 'Add New', 'alothemes' ),
            'add_new_item'       => __( 'Add New Header', 'alothemes' ),
            'new_item'           => __( 'New Header', 'alothemes' ),
            'edit_item'          => __( 'Edit Header', 'alothemes' ),
            'view_item'          => __( 'View Header', 'alothemes' ),
            'all_items'          => __( 'All Headers', 'alothemes' ),
            'search_items'       => __( 'Search Header', 'alothemes' ),
            'parent_item_colon'  => __( 'Parent Header:', 'alothemes' ),
            'not_found'          => __( 'No Header found.', 'alothemes' ),
            'not_found_in_trash' => __( 'No Header found in Trash.', 'alothemes' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Magiccart Header .', 'alothemes' ),
            'menu_icon'          => 'dashicons-image-filter',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false, // show in main admin set true
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'header' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            //'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
            'supports'           => array( 'title', 'editor', 'thumbnail', 'postcustom' )
        );
        register_post_type( 'header', $args );

    }

    public function register_meta_boxes() {
        add_meta_box( 'el_class', __( 'Extra class name', 'alothemes' ), array($this, 'callback_el_class'), 'header' );
        add_meta_box( 'header_skin', __( 'Skin', 'alothemes' ), array($this, 'callback_header_skin'), 'header' );
    }

    public function save_meta_box( $post_id, $post, $update  ) {
        if(isset($_POST['header_skin'])){
            update_post_meta($post_id, 'header_skin', $_POST['header_skin']);
        }
        if(isset($_POST['el_class'])){
            update_post_meta($post_id, 'el_class', $_POST['el_class']);
        }
    }

    public function callback_el_class( $post ) {
        $meta = get_post_meta($post->ID, 'el_class', true);
        $html = '<input id="el_class" type="text" placeholder="Extra class Header" name="el_class" value="' . esc_html( $meta ) . '" />';
        echo $html;
    }

    public function callback_header_skin( $post ) {
        $meta = get_post_meta($post->ID, 'header_skin', true);
        $html = '<textarea id="header_skin" name="header_skin" class="widefat hidden" cols="50" rows="5">' . esc_textarea( $meta )  . '</textarea>';
        $html .= '<div id ="ace_heade_skin" class="code-editor" data-language="css" data-theme="monokai">'. esc_html( $meta ) . '</div>';
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
