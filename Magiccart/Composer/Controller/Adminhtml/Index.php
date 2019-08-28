<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 09:52:21
 * @@Modify Date: 2018-06-10 14:56:32
 * @@Function:
 */

namespace Magiccart\Composer\Controller\Adminhtml;

use Magiccart\Composer\Block\Adminhtml\Vc\Element\Copyright;
use Magiccart\Composer\Block\Adminhtml\Vc\Element\Logo;
use Magiccart\Composer\Block\Adminhtml\Vc\Element\Newsletter;
use Magiccart\Composer\Block\Adminhtml\Vc\Element\Newsletterpopup;
use Magiccart\Composer\Block\Adminhtml\Vc\Element\Toplink;
use Magiccart\Composer\Block\Adminhtml\Vc\Menu\Accordion;
use Magiccart\Composer\Block\Adminhtml\Vc\Menu\Navigation;
use Magiccart\Composer\Block\Adminhtml\Vc\Menu\Navmobile;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Posts;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Slider;
//use Magiccart\Composer\Block\Adminhtml\Vc\Post\Picturecategory;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Testimonial;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Portfolio;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Desandro;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Brands;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Shopbrand;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Catalog;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Categories;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Minicart;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Products;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Producttags;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Search;

class Index
{
	public function __Construct(){

		// global $typenow;
		// if (is_edit_page('edit') && $typenow == 'portfolio' {
		//    //yes its an edit page  of a custom post type named portfolio
		// }

		// if ($this->is_edit_page() || (defined( 'DOING_AJAX' ) && DOING_AJAX)){
		if ($this->is_edit_page() || isset($_POST['_vcnonce'])){
			// new Accordion();
			new Brands();
			new Shopbrand();
			new Catalog();
			new Categories();
			new Copyright();
			new Desandro();
			new Minicart();
			new Logo();
			new Navigation();
			new Navmobile();
			new Newsletter();
			new Newsletterpopup();
			new Products();
			new Producttags();
			new Posts();
			new Portfolio();
			new Slider();
			new Search();
			new Testimonial();
			new Toplink();
		}
	}

	protected function is_edit_page($new_edit = null){
	    global $pagenow;
	    //make sure we are on the backend
	    if (!is_admin()) return false;

	    if($new_edit == "edit")
	        return in_array( $pagenow, array( 'post.php',  ) );
	    elseif($new_edit == "new") //check for new post page
	        return in_array( $pagenow, array( 'post-new.php' ) );
	    else //check for either new or edit
	        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
	}

}

