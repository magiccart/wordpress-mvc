<?php
namespace Magiccart\Composer\Block\Post;
use Magiccart\Composer\Block\Shortcode;

class Testimonial extends Shortcode{

    protected $_testimonial = array();

    protected $_sliders = array();

    public function initShortcode( $atts, $content = null ){
        $this->addData($atts);
        
        $query = array( 
            'post_type' => 'testimonial', 
            'posts_per_page'    => $this->getData('number'),
            'meta_query' => array(
                                array(
                                    'key' => 'testimonial-status',
                                    'value' => 0,
                                    'type' => 'numeric',
                                    'compare' => '='
                                )
                            ),
        );
        $testimonial = new \WP_Query( $query );

        $this->_testimonial =  $testimonial;

        return $this->toHtml();
    }
}

