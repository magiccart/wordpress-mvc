<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-11-28 14:58:07
 * @@Modify Date: 2018-02-03 18:59:19
 * @@Function:
 */
namespace Magiccart\Widgets\Block\Blog;
class Tags extends \WP_Widget{
	public function __construct(){
		parent::__construct('magiccart-blog-tags',  __('Magiccart Blog Tags', 'alothemes'), array('magiccart-blog-tags'));
	} 
	public function widget($args, $instance){
			$args2 = array(
				'number'  => $instance['number'],
				// 'post_type' => 'post',
			 );
			// echo $args['before_widget'];
			?>
			<li class="widget tags blog">
				<h3 class="left-widget-title"><?php echo $instance['title']?></h3>
				<ul class="magiccart-tag">
					<li><?php wp_tag_cloud( $args2 ); ?></li>
				</ul>
			</li>
			<?php 
			// echo $args['after_widget'];
	} 
	public function form($instance){
		if ( isset( $instance[ 'number' ] ) ) {
			$number = $instance[ 'number' ];
		}else{
			$number = 10;
		}
		
		if ( isset( $instance[ 'title' ] ) ) {
			$titlePost = $instance[ 'title' ];
		}else{
			$titlePost = __( 'Blog Tags', 'alothemes' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'alothemes' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $titlePost ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of tags to show :', 'alothemes' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
		</p>
		<?php
				
	}
	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	} 
}
