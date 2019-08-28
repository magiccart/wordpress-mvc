<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-13 16:52:18
 * @@Modify Date: 2017-08-15 18:32:54
 * @@Function:
 */

namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Portfolio extends Posts
{
    
    public function initMap()
    {
        $temp   = array(
                        array(
                            'type' => "multiselect",
                            'heading' => __("Portfolio Collection : <span style='color:red;'>*</span> ", 'alothemes'),
                            'param_name' => "portfolio_collection",
                            'value' => $this->category_portfolio(),
                            'save_always' => true
                        ),
                        array(
                            'type'          => "textfield",
                            'heading'       => __("Extra class name : ", 'alothemes'),
                            'description'   => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'alothemes'),
                            'param_name'    => "el_class",
                            'save_always'   => true,
                        ),
        );
        $params = array_merge(
            $temp, 
            $this->get_settings(), 
            $this->get_responsive(),
            $this->get_templates()
        );
        
        $this->add_VcMap($params);
    }
    
    protected function category_portfolio()
    {
        $args = array(
            'type' => 'portfolio',
            'child_of' => 0,
            'parent' => '',
            'orderby' => 'id',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'number' => '',
            'taxonomy' => 'portfolio_category',
            'pad_counts' => false
            
        );
        $categories                 = get_categories($args);
        $portfolioCategories        = array();
        $portfolioCategories["all"] = "All Category";
        foreach ($categories as $value) {
            $portfolioCategories[$value->term_id] = $value->name;
        }
        return $portfolioCategories;
    }
    
}
