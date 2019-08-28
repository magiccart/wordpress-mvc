<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-12 11:39:21
 * @@Modify Date: 2018-06-10 14:55:50
 * @@Function:
 */
 
namespace Magiccart\Composer\Controller;

use Magiccart\Composer\Block\Element\Copyright;
use Magiccart\Composer\Block\Element\Logo;
use Magiccart\Composer\Block\Element\Newsletter;
use Magiccart\Composer\Block\Element\Newsletterpopup;
use Magiccart\Composer\Block\Element\Toplink;
use Magiccart\Composer\Block\Menu\Navigation;
use Magiccart\Composer\Block\Menu\Navmobile;
use Magiccart\Composer\Block\Product\Catalog;
use Magiccart\Composer\Block\Product\Categories;
use Magiccart\Composer\Block\Product\Minicart;
use Magiccart\Composer\Block\Product\Products;
use Magiccart\Composer\Block\Product\Producttags;
use Magiccart\Composer\Block\Product\Search;
use Magiccart\Composer\Block\Post\Posts;
use Magiccart\Composer\Block\Post\Slider;
use Magiccart\Composer\Block\Post\Testimonial;
use Magiccart\Composer\Block\Post\Portfolio;
use Magiccart\Composer\Block\Post\Desandro;
use Magiccart\Composer\Block\Product\Brands;
use Magiccart\Composer\Block\Product\Shopbrand;

class Index{
	public function __construct(){
        new Toplink();
        new Logo();
        new Newsletter();
        new Newsletterpopup();
        new Navigation();
        new Navmobile();
		new Search();
		new Posts();
		new Brands();
		new Slider();
		new Testimonial();
		new Portfolio();
		new Copyright();
		new Desandro();
        if ( class_exists( 'WooCommerce' ) ) {
			new Catalog();
			new Categories();
			new Minicart();
			new Products();   	
			new Producttags();
			new Shopbrand();
        }
	}
}

