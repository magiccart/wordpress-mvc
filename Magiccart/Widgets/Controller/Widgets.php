<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-11-28 14:37:23
 * @@Modify Date: 2018-06-13 23:46:07
 * @@Function:
 */

namespace Magiccart\Widgets\Controller;

use Magiccart\Widgets\Block\Blog\Posts;
use Magiccart\Widgets\Block\Blog\Tags;
use Magiccart\Widgets\Block\Blog\Shortcode;
use Magiccart\Core\Controller\Action;

use Magiccart\Widgets\Block\Portfolio\Categories as PortfolioCat;
use Magiccart\Widgets\Block\Portfolio\Tags as PortfolioTag;

use Magiccart\Widgets\Block\Product\Categories;
use Magiccart\Widgets\Block\Product\ProductSidebar;

class Widgets extends Action{
	public function __construct(){
		add_action( 'widgets_init', array($this, 'magiccart_register_widget') );
		add_action( 'admin_enqueue_scripts', array($this, 'add_admin_web') );
	}
	
	public function magiccart_register_widget() {
		
		$blogPosts = new Posts();
		register_widget( $blogPosts );
		
		$blogTags = new Tags;
		register_widget( $blogTags );

		$blogShortcode = new Shortcode;
		register_widget( $blogShortcode );

		$portfolioCategories = new PortfolioCat;
		register_widget( $portfolioCategories );

		$portfolioTag = new PortfolioTag;
		register_widget( $portfolioTag );
		
		$productCategories = new Categories;
		register_widget( $productCategories );

		$productSidebar = new ProductSidebar;
		register_widget( $productSidebar );

	}
	
	public function add_admin_web(){
		wp_register_script('upload-image-widget',  $this->get_url("adminhtml/web/js/upload-image-widget.js") , array('jquery') ,'1.0');
		wp_enqueue_script('upload-image-widget');
	}

}
