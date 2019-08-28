<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-06-06 00:25:23
 * @@Modify Date: 2018-06-14 01:21:48
 * @@Function:
 */

namespace Magiccart\Widgets\Block\Product;

use Magiccart\Composer\Model\Product\Collection;

class ProductSidebar extends \WC_Widget{

    protected $_collection; 

    /**
     * Constructor
     */
    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_product_sidebar';
        $this->widget_description = esc_html__( 'Display product sidebar.', 'alothemes' );
        $this->widget_id          = 'magiccart_product_sidebar';
        $this->widget_name        = esc_html__( 'Magiccart Product Sidebar', 'alothemes' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Product Collection', 'alothemes' ),
                'label' => esc_html__( 'Title', 'alothemes' )
            ),
            'product_collection' => array(
                'type'  => 'select',
                'std'   => 'best_selling',
                'label' => esc_html__( 'Product collection', 'alothemes' ),
                'options' => $this->get_type('name')
            ),
            'limit' => array(
                'type'  => 'text',
                'std'   => 3,
                'label' => esc_html__( 'Limit products', 'alothemes' )
            ),
            'cart' => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => esc_html__( 'Show cart', 'alothemes' )
            ),
            'compare' => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => esc_html__( 'Show compare', 'alothemes' )
            ),
            'wishlist' => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => esc_html__( 'Show wishlist', 'alothemes' )
            ),
            'review' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Show review', 'alothemes' )
            ),
            // 'template' => array(
            //     'type'  => 'select',
            //     'std'   => 'productsidebar.phtml',
            //     'label' => esc_html__( 'template', 'alothemes' ),
            //     'options' => $this->get_templates()
            // )
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     *
     * @return void
     */
    public function widget( $args, $instance ) {
        
        global $woocommerce;
        if(!$woocommerce) return array();

        $this->widget_start( $args, $instance );

            $dataArgs = array();

            $dataArgs['product_collection'] = isset( $instance['product_collection'] ) ? $instance['product_collection'] : $this->settings['product_collection']['std'];

            $dataArgs['limit']              = isset( $instance['limit'] ) ? $instance['limit'] : $this->settings['limit']['std'];

            $dataArgs['cart']               = isset( $instance['cart'] ) ? $instance['cart'] : $this->settings['cart']['std'];

            $dataArgs['compare']            = isset( $instance['compare'] ) ? $instance['compare'] : $this->settings['compare']['std'];

            $dataArgs['wishlist']            = isset( $instance['wishlist'] ) ? $instance['wishlist'] : $this->settings['wishlist']['std'];
            $dataArgs['review']              = isset( $instance['review'] ) ? $instance['review'] : $this->settings['review']['std'];

            if(!$this->_collection) $this->_collection = new Collection; 
            $type = $dataArgs['product_collection'];
            $products = $this->_collection->woo_query($type, $dataArgs['limit']);
            echo $args['before_widget'];
            ?>
            <?php
                // $block = new Template;
                // $block->setTemplate('product/productsidebar.phtml');
                // echo $block->toHtml();
            ?>
            <div class="widget-products-siderbar">
<!--                     <h3><?php echo $instance['title']?></h3> -->
                    <ul class="products-siderbar">
                        <?php 
                            if($products->have_posts() ){
                                while ( $products->have_posts() ) : $products->the_post();
                                    wc_get_template( 'content-product-sidebar.php', $dataArgs); 
                                endwhile; 
                            }else{
                                echo '<p class="woocommerce-info">'. __('No products were found matching your selection.', 'alothemes') .'</p>';
                            }
                            
                        ?>
                    </ul>
                </div>
                <?php 
            echo $args['after_widget'];
        $this->widget_end( $args );
    }

    protected function get_type($type_default = "key"){
        $type = $type_default;
        $arrType = array(
            __('Best Selling', 'alothemes')      => 'best_selling',
            __('Featured Products', 'alothemes') => 'featured_product',
            __('Top Rate', 'alothemes')          => 'top_rate',
            __('Recent Products', 'alothemes')   => 'recent_product',
            __('On Sale', 'alothemes')           => 'on_sale',
            __('Recent Review', 'alothemes')     => 'recent_review',
            __('Product Deals', 'alothemes')     => 'deals'
        );
        if($type == "key") return $arrType;
    
        return array_flip($arrType);
    }

    protected function get_templates(){
        $settings = array();
        $templates = array();
        $msg_template = '';
        $class = explode('\\', get_class($this));
        $templatesDirs = array(
                        get_stylesheet_directory(),
                        get_template_directory()
            );
        foreach ($templatesDirs as $dir) {
            $templateDir = $dir . '/' . $class[0] . '_' .$class[1] . '/templates/';
            if (file_exists($templateDir) && is_dir($templateDir)) {
                $fileTheme  = $templateDir . $this->_template;
                $msg_template .= "Create custom file in path: $fileTheme <br/>";
                $regexr     = '/^' . $this->_class . '.*.phtml$/';
                $tmps  = preg_grep($regexr,  scandir($templateDir, 1));
                if($templates){
                    foreach ($tmps as $fileName) {
                        $templates[] = $fileName;
                    }
                } else {
                    $templates = $tmps;
                }
            }
        }
        

        if($templates){
            $templates = array_unique($templates);
            asort($templates);
            if(!in_array($this->_template , $templates)){
                array_unshift($templates, $this->_template);
            }
            if(count($templates) > 1){
                $settings[] = array(
                    'type'          => "dropdown",
                    'heading'       => __('Template custom file: ', 'alothemes'),
                    'param_name'    => 'template',
                    'value'         => $templates,
                    'group'         => __( 'Template', 'alothemes' ),
                    'std'           => '',
                    'description'   => $msg_template,
                    'save_always'   => true,
                );                     
            }        
        }

        return $settings;
    }

}
