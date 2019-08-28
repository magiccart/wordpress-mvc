<?php
namespace Magiccart\Composer\Block\Post;
use Magiccart\Composer\Block\Shortcode;

class Portfolio extends Shortcode{

    protected $_portfolio = array();

    public function initShortcode( $atts, $content = null ){
        $this->addData($atts);

        if($this->getData('portfolio_collection')){
            $portfolioID = explode(',', $this->getData('portfolio_collection'));
            
            $this->addData(array('portfolioId' => $portfolioID));
            foreach ($portfolioID as  $value) {
                $query = array();
                if(is_numeric($value)){
                    $query = array( 
                        'post_type' => 'portfolio', 
                        'posts_per_page'    => $this->getData('number'), 
                        'tax_query' => array(
                                        array(
                                            'taxonomy' => 'portfolio_category',
                                            'field'    => 'id',
                                            'terms'    => $value,

                                        )
                                    ),
                    );
                }else{
                    $query = array( 
                        'post_type' => 'portfolio', 
                        'posts_per_page'    => $this->getData('number'), 
                    );
                }
                
                $portfolio = new \WP_Query( $query );

                $this->_portfolio[$value] =  $portfolio;
            }

            add_shortcode( 'jmliker', 'sl_shortcode' );
            
            return $this->toHtml();
        }
        return __("Please select !", 'alothemes');
    }
    public function getOptions(){

        if(isset($_GET['visible'])) $this->addData( array('visible' => absint($_GET['visible'])) ); // USED DEMO 
        return parent::getOptions();
    }

    public function getTabs(){
        $portfolioId     = $this->getData('portfolioId');
        $visible = "visible-" . $this->getData("visible");
        $args = array(
                    'type'          => 'portfolio',
                    'child_of'      => 0,
                    'orderby'       => 'id',
                    'order'         => 'ASC',
                    'hide_empty'    => false,
                    'hierarchical'  => 1,
                    'taxonomy'      => 'portfolio_category',
                    'pad_counts'    => false,

                );
        $categories = get_categories( $args );
        $titleTab = array();
        $titleTab['all']  = __("All Portfolio", 'alothemes');
            foreach ($categories as  $value) {
            if(in_array($value->term_id, $portfolioId)){
                $titleTab[$value->term_id] = $value->name;
            }
        }
        return $titleTab;        
    }

}
