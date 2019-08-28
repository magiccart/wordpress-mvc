<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-09 23:30:25
 * @@Modify Date: 2018-03-08 19:34:32
 * @@Function:
 */

namespace Magiccart\Portfolio\Controller;

use Magiccart\Core\Controller\Adminhtml\Action;

class Portfolio extends Action {
 	public function __construct(){
 		add_action('init', array($this, 'portfolio_init'));
 		if(!is_admin()) return;
 		add_action( 'save_post', array($this, 'save_meta_box'), 10, 3 );
 		add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
        add_submenu_page(
            'magiccart',
            'Portfolio',
            'Portfolio',
            'manage_options',
            'edit.php?post_type=portfolio'
        );
        add_submenu_page(
            'magiccart',
            'Portfolio Categories',
            'Portfolio Categories',
            'manage_options',
            'edit-tags.php?taxonomy=portfolio_category&post_type=portfolio'
        );
 	}

 	public function portfolio_init(){
		$labels = array(
			'name'               => _x( 'Portfolio', 'Post type general name', 'alothemes' ),
			'singular_name'      => _x( 'Portfolio', 'Post type singular name', 'alothemes' ),
			'menu_name'          => _x( 'Portfolio', 'Admin Menu text', 'alothemes' ),
			'name_admin_bar'     => _x( 'Portfolio', 'Add New on Toolbar', 'alothemes' ),
			'add_new'            => __( 'Add New', 'alothemes' ),
			'add_new_item'       => __( 'Add New Portfolio', 'alothemes' ),
			'new_item'           => __( 'New Portfolio', 'alothemes' ),
			'edit_item'          => __( 'Edit Portfolio', 'alothemes' ),
			'view_item'          => __( 'View Portfolio', 'alothemes' ),
			'all_items'          => __( 'All Portfolios', 'alothemes' ),
			'search_items'       => __( 'Search Portfolio', 'alothemes' ),
			'parent_item_colon'  => __( 'Parent Portfolio:', 'alothemes' ),
			'not_found'          => __( 'No Portfolio found.', 'alothemes' ),
			'not_found_in_trash' => __( 'No Portfolio found in Trash.', 'alothemes' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Magiccart Portfolio.', 'alothemes' ),
	        'menu_icon'			 => 'dashicons-image-filter',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false, // show in main admin set true
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'portfolio' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			//'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', )
		);
		register_post_type( 'portfolio', $args );

		$category = array(
	        'name' => _x( 'Portfolio Categories', 'taxonomy general name', 'alothemes' ),
	        'singular_name' => _x( 'Category', 'taxonomy singular name', 'alothemes' ),
	        'search_items' =>  __( 'Search Types', 'alothemes' ),
	        'all_items' => __( 'All Categories', 'alothemes' ),
	        'parent_item' => __( 'Parent Category', 'alothemes' ),
	        'parent_item_colon' => __( 'Parent Category:', 'alothemes' ),
	        'edit_item' => __( 'Edit Categories', 'alothemes' ),
	        'update_item' => __( 'Update Category', 'alothemes' ),
	        'add_new_item' => __( 'Add New Category', 'alothemes' ),
	        'new_item_name' => __( 'New Category Name', 'alothemes' ),
	    );

		register_taxonomy('portfolio_tag','portfolio',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'portfolio-tag' ),
		));

	    register_taxonomy('portfolio_category', array('portfolio'), array(
	        'hierarchical' => true,
	        'labels' => $category,
	        'show_ui' => true,
	        'query_var' => true,
	        'rewrite' => array( 'slug' => 'portfolio-category' ),
	    ));

	    // flush_rewrite_rules();
	}

	public function register_meta_boxes() {
	    add_meta_box( 'meta-box-skill-needed', __( 'Skill needed', 'alothemes' ), array($this, 'callback_skill_needed'), 'portfolio' );
	    add_meta_box( 'meta-box-url', __( 'Url', 'alothemes' ), array($this, 'callback_url'), 'portfolio' );
	    add_meta_box( 'meta-box-copyright', __( 'Copyright', 'alothemes' ), array($this, 'callback_copyright'), 'portfolio' );
	}

	public function save_meta_box( $post_id, $post, $update  ) {
		if(isset($_POST['portfolio-skill-needed'])){
			update_post_meta($post_id, 'portfolio-skill-needed', $_POST['portfolio-skill-needed']);
		}
		if(isset($_POST['portfolio-url'])){
			update_post_meta($post_id, 'portfolio-url', $_POST['portfolio-url']);
		}
		if(isset($_POST['portfolio-copyright'])){
			update_post_meta($post_id, 'portfolio-copyright', $_POST['portfolio-copyright']);
		}
	}

	public function callback_skill_needed( $post ) {
		$metaSkillNeeded = get_post_meta($post->ID, 'portfolio-skill-needed', true);
	    echo '<input id="mc-skill-needed" name="portfolio-skill-needed" type="text" value="' . esc_attr($metaSkillNeeded) . '" style="width:100%;" />';
	}

	public function callback_url( $post ) {
		$metaUrl = get_post_meta($post->ID, 'portfolio-url', true);
	    echo  '<input id="mc-url" name="portfolio-url" type="text" value="' . esc_attr($metaUrl) . '" style="width:100%;" />';
	}

	public function callback_copyright( $post ) {
		$metaCopyright = get_post_meta($post->ID, 'portfolio-copyright', true);
	    echo  '<input id="mc-copyright" name="portfolio-copyright" type="text" value="' . esc_attr($metaCopyright) . '" style="width:100%;" />';
	}
}

