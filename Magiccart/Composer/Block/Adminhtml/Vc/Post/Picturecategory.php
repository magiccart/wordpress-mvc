<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Picturecategory extends Vc{

    public function initMap(){
        $params = array(
		                array(
		                    'type' 			=> 'attach_image',
		                    'heading' 		=> __("Image", 'alothemes'),
		                    'param_name' 	=> "img_src",
		                    'save_always' 	=> true,
		                ),
		                array(
		                    'type'      	=> "dropdown",
		                    'heading'   	=> __("Parent Category", 'alothemes'),
		                    'param_name' 	=> "parent",
		                    'value' 		=>  $this->getArrParentCat(),
		                    'save_always' 	=> true,
		                ),
		            );
        
        $this->add_VcMap($params);
    }

    protected function getArrParentCat(){
        return $this->_vcComposer->get_parent_category();
    }

}

