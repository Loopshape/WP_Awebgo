<?php

class SCFP_FormWidget extends WP_Widget {
    
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
            $widget_ops = array( 'description' => __( "Adds contact form to your sidebar") );
            parent::__construct('scfp_form_widget', __('WCP Contact Form'), $widget_ops);
	}
    
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if (!empty( $instance['title'])) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        
        $atts = array();
        $atts['id'] = 'scfp-' . $this->id;
            
        echo SCFP()->doContactFormWidget($atts);
        
        echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
            $title = !empty($instance['title']) ? $instance['title'] : '';
            
        ?>
            <p><?php $this->renderTitleField($title); ?></p>
           
    <?php    
	}
    
    
	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
            $instance = array();

            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags( $new_instance['title'] ) : '';

            return $instance;
	}    
    
    public function renderTitleField ($title) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">    
    <?php    
    }    
 
}

    