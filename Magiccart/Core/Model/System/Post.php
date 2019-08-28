<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-12-08 16:23:56
 * @@Modify Date: 2018-01-02 17:26:53
 * @@Function:
 */

namespace Magiccart\Core\Model\System;

class Post{
	
    public function getPost($type='post', $usedId=false, $limit=-1){
        global $post;
        $posts = array();
        $args= array(
        'post_type' => $type,
        'orderby'   => 'post_title',
        'order'     => 'ASC',
        'posts_per_page' => $limit, 
        );
        $query = new \WP_Query($args);
        if($query->have_posts()): 
        	while ($query->have_posts()):$query->the_post();
                if($usedId){
                    $posts[$post->ID] = $post->post_title;
                } else {
                    $posts[$post->post_name] = $post->post_title;                    
                }
            endwhile;
        endif;
        wp_reset_postdata();
        return $posts;
    }

}
