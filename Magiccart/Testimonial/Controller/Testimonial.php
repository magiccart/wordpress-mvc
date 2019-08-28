<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-09 23:20:32
 * @@Modify Date: 2018-03-12 11:11:12
 * @@Function:
 */

namespace Magiccart\Testimonial\Controller;

use Magiccart\Core\Controller\Adminhtml\Action;

 class Testimonial extends Action {
 	public function __construct(){
 		add_action('init', array($this, 'testimonial_init'));
 		if(!is_admin()) return;
 		add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
 		add_action( 'save_post', array($this, 'save_meta_box'), 10, 3 );
        add_submenu_page(
            'magiccart',
            'Testimonial',
            'Testimonial',
            'manage_options',
            'edit.php?post_type=testimonial'
        );
 	}

 	public function testimonial_init(){
		$labels = array(
			'name'               => _x( 'Testimonial', 'Post type general name', 'alothemes' ),
			'singular_name'      => _x( 'Testimonial', 'Post type singular name', 'alothemes' ),
			'menu_name'          => _x( 'Testimonial', 'Admin Menu text', 'alothemes' ),
			'name_admin_bar'     => _x( 'Testimonial', 'Add New on Toolbar', 'alothemes' ),
			'add_new'            => __( 'Add New', 'alothemes' ),
			'add_new_item'       => __( 'Add New Testimonial', 'alothemes' ),
			'new_item'           => __( 'New Testimonial', 'alothemes' ),
			'edit_item'          => __( 'Edit Testimonial', 'alothemes' ),
			'view_item'          => __( 'View Testimonial', 'alothemes' ),
			'all_items'          => __( 'All Testimonials', 'alothemes' ),
			'search_items'       => __( 'Search Testimonial', 'alothemes' ),
			'parent_item_colon'  => __( 'Parent Testimonial:', 'alothemes' ),
			'not_found'          => __( 'No Testimonial found.', 'alothemes' ),
			'not_found_in_trash' => __( 'No Testimonial found in Trash.', 'alothemes' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Magiccart Tesimonial .', 'alothemes' ),
	        'menu_icon'			 => 'dashicons-editor-quote',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false, // show in main admin set true
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'testimonial' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			//'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
			'supports'           => array( 'title', 'editor', 'thumbnail', 'postcustom' )
		);
		register_post_type( 'testimonial', $args );
	}

 	public function register_meta_boxes() {
	    add_meta_box( 'meta-box-name', __( 'Name', 'alothemes' ), array($this, 'callback_name'), 'testimonial' );
	    add_meta_box( 'meta-box-company', __( 'Company', 'alothemes' ), array($this, 'callback_company'), 'testimonial' );
	    add_meta_box( 'meta-box-email', __( 'Email', 'alothemes' ), array($this, 'callback_email'), 'testimonial' );
	    add_meta_box( 'meta-box-website', __( 'Website', 'alothemes' ), array($this, 'callback_website'), 'testimonial' );
	    add_meta_box( 'meta-box-rating', __( 'Detailed Rating :', 'alothemes' ), array($this, 'callback_rating'), 'testimonial' );
	    add_meta_box( 'meta-box-status', __( 'Status :', 'alothemes' ), array($this, 'callback_status'), 'testimonial' );
	}

	public function callback_name( $post ) {
		echo $metaName = get_post_meta($post->ID, 'testimonial-name', true);
	    echo  '<input id="mc-name" name="testimonial-name" type="text" value="' . esc_attr($metaName) . '" style="width:100%;" />';
	}

	public function callback_company( $post ) {
		$metaCompany = get_post_meta($post->ID, 'testimonial-company', true);
	    echo  '<input id="mc-company" name="testimonial-company" type="text" value="' . esc_attr($metaCompany) .'" style="width:100%;" />';
	}

	public function callback_email( $post ) {
		$metaEmail = get_post_meta($post->ID, 'testimonial-email', true);
	    echo  '<input id="mc-email" name="testimonial-email" type="text" value="' . esc_attr($metaEmail) . '" style="width:100%;" />';
	}

	public function callback_website( $post ) {
		$metaWebsite = get_post_meta($post->ID, 'testimonial-website', true);
	    echo '<input id="mc-website" name="testimonial-website" type="text" value="' . esc_attr($metaWebsite) .'" style="width:100%;" />';
	}

	public function callback_rating( $post ) {
		$metaRating = get_post_meta($post->ID, 'testimonial-rating', true);
		$xhtml = '';
	    for($i = 1; $i < 6; $i++){
	    	if($metaRating == $i){
                $xhtml .=  '<input checked="checked" name="rating" type="radio" value="'.  esc_attr($i) . '" /><b>' . "$i " . __('Star(s)') . '</b>&nbsp;&nbsp;&nbsp;';
                continue;
            }
            $xhtml .= '<input id="mc-rating" name="testimonial-rating" type="radio" value="'.  esc_attr($i) . '" /><b>' . "$i " . __('Star(s)') . '</b>&nbsp;&nbsp;&nbsp;';
        }
        echo $xhtml;
	}

	public function callback_status( $post ) {
		$metaStatus = get_post_meta($post->ID, 'testimonial-status', true);
	    $xhtml = '<select id="mc-status" name="testimonial-status">';
            $status = array(
	                0 => __('Approved'), 
	                1 => __('Pending'), 
	                2 => __('Not Approved')
	            );
	        foreach ($status as $key => $value) {
	            if($key == $metaStatus){
	                $xhtml .=  '<option selected="selected" value="'. esc_attr($key) .'">'. $value .'</option>';
	                continue;
	            }
	            $xhtml .= '<option value="'. esc_attr($key) .'">'. $value .'</option>';
	        }
       	$xhtml .= '</select>';
       	echo $xhtml;
	}
	 
	
	public function save_meta_box( $post_id, $post, $update  ) {
		if(isset($_POST['testimonial-name'])){
			update_post_meta($post_id, 'testimonial-name', $_POST['testimonial-name']);
		}
		if(isset($_POST['testimonial-company'])){
			update_post_meta($post_id, 'testimonial-company', $_POST['testimonial-company']);
		}
		if(isset($_POST['testimonial-email'])){
			update_post_meta($post_id, 'testimonial-email', $_POST['testimonial-email']);
		}
		if(isset($_POST['testimonial-rating'])){
			update_post_meta($post_id, 'testimonial-rating', $_POST['testimonial-rating']);
		}
		if(isset($_POST['testimonial-status'])){
			update_post_meta($post_id, 'testimonial-status', $_POST['testimonial-status']);
		}
		if(isset($_POST['testimonial-website'])){
			update_post_meta($post_id, 'testimonial-website', $_POST['testimonial-website']);
		}
	}
}

