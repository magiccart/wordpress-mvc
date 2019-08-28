<?php
namespace Magiccart\Widgets\Block\Blog;
class Picture extends \WP_Widget{
	public function __construct(){
		parent::__construct('magiccart-blog-picture',  __('Magiccart Blog Picture', 'alothemes'), array('magiccart-blog-picture'));
	} 
	public function widget($args, $instance){
		
		if(trim($instance['url-picture']) != ''){
			echo $args['before_widget'];
			echo '<div class="widget-picture"><a href="#"><img src="'. $instance['url-picture'] .'" alt="" /></a></div>';
			echo $args['after_widget'];
		}
		
		
		
	} 
	public function form($instance){
		$picture  = isset($instance[ 'url-picture' ]) ? $instance[ 'url-picture' ] : '';
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'url-picture' ); ?>"><?php _e( 'Url Picture:', 'alothemes' ); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'url-picture' ); ?>"  value="<?php echo esc_attr( $picture ); ?>" class="widefat magiccart-picture" name="<?php echo $this->get_field_name( 'url-picture' ); ?>" />
				<input class="widefat magiccart-button-img" id="upload-btn" idbtn="<?php echo $this->get_field_name( 'url-picture' ); ?>" type="button" name="upload-btn"  value="Select Image" />
				
			</p>
		<?php
	} 
	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['url-picture'] = ( ! empty( $new_instance['url-picture'] ) ) ? strip_tags( $new_instance['url-picture'] ) : '';
		return $instance;
	} 
}
