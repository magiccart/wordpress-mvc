<?php
namespace Magiccart\Composer\Block\Post;
use Magiccart\Composer\Block\Shortcode;

class Desandro extends Shortcode{

    public function initShortcode( $atts, $content = null ){
    	if(is_array($atts)){
    		$this->addData($atts );
    	}
        
        	$number = isset($atts['number']) ? $this->getData('number') : 20;
            $portfolioID = $this->getData('portfolio');
            	$query = array( 
	                        'post_type' => 'portfolio',
	                        'posts_per_page'    => $number,  
                        );
                if(is_numeric($portfolioID)){
                    $query['tax_query'] = array(
	                                        array(
	                                            'taxonomy' => 'portfolio_category',
	                                            'field'    => 'id',
	                                            'terms'    => $portfolioID,
	                                        )
	                                    );
                }
                $this->_portfolio = new \WP_Query( $query );

            return $this->toHtml();
    }
}
