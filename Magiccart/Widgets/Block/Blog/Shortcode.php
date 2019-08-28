<?php
namespace Magiccart\Widgets\Block\Blog;
class Shortcode extends \WP_Widget{
	public function __construct(){
		parent::__construct('magiccart-shortcode',  __('Magiccart Shortcode', 'alothemes'), array('magiccart-shortcode'));
	} 
	public function widget($args, $instance){
		 
			
			echo $args['before_widget'];
				if($instance['title'] != ""){
				?>
					<h3><?php echo $instance['title']?></h3>
				<?php
				}
				echo do_shortcode($instance['shortcode']);
			echo $args['after_widget'];
	} 
	public function form($instance){
		$shortcode = '';
		$titleShortcode = "";
		if ( isset( $instance[ 'shortcode' ] ) ) {
			$shortcode = $instance[ 'shortcode' ];
		}
		
		if ( isset( $instance[ 'title' ] ) ) {
			$titleShortcode = $instance[ 'title' ];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'alothemes' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $titleShortcode ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'shortcode' ); ?>"><?php _e( 'Shortcode :', 'alothemes' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'shortcode' ); ?>" name="<?php echo $this->get_field_name( 'shortcode' ); ?>" type="text" value="<?php echo esc_attr( $shortcode ); ?>" />
		</p>
		<?php
				
	}
	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['shortcode'] = ( ! empty( $new_instance['shortcode'] ) ) ? strip_tags( $new_instance['shortcode'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	} 
}
