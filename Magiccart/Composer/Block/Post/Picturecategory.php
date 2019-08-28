<?php
namespace Magiccart\Composer\Block\Post;
use Magiccart\Composer\Block\Shortcode;

class Picturecategory extends Shortcode{

    public function category_picture( $atts, $content = null ){
        $listCat = "";
        $image = wp_get_attachment_image_src($atts['img_src'],'full');
    
        $picture = "<img src='{$image[0]}' />";
        if($atts["parent"] != ""){
            $listCat = "<ul>";
            foreach ($this->get_name_category() as $value){
                if($value->term_id == $atts["parent"]){
                    $listCat .= "<li class='title'>" . $value->name ."</li>";
                    break;
                }
            }
            foreach ($this->get_name_category($atts["parent"]) as $value){
                $listCat .= "<li>" . $value->name ."</li>";
            }
            $listCat .= "</ul>";
        }
    
        $content = "<div class='cat_picture'>
        {$picture} {$listCat}
        </div>";
        return $content;
    }

}

