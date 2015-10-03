<?php

class vortex_top_likes extends WP_Widget {

// constructor
	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'vortex_top_likes', 

		// Widget name will appear in UI
		__('Most liked posts', 'vortex_system_ld'), 

		// Widget description
		array( 'description' => __( 'Displays a list with the most licked posts.', 'vortex_system_ld' ), ) 
		);
	}
	
	public function flush_widget_cache() {
		wp_cache_delete('vortex_top_likes', 'widget');
	}
	
	public function widget( $args, $instance ) {
		
		ob_start();
		
		$show_like = isset( $instance['show_like'] ) ? $instance['show_like'] : false;
		
		$show_sticky = isset( $instance['show_sticky'] ) ? $instance['show_sticky'] : false;
		
		$show_thumbnail = isset( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : false;
		
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Most liked posts','vortex_system_ld');
		
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		
		$query_args = array(
			'orderby'			=> 'meta_value_num',
			'meta_key'			=> 'vortex_system_likes',
			'post_type' 		=> 'post',
			'post_status'		=> 'publish',
			'posts_per_page'	=> $number

		);
		if(!$show_sticky){
			$query_args['post__not_in'] = get_option("sticky_posts");
		}

		$r = new WP_Query( $query_args );
		
		if ($r->have_posts()) :
?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . esc_html($title) . $args['after_title'];
		} ?>
		<ul class="rating-system-list">
		<input id="rating-system-limit" type="hidden" value="<?php echo esc_attr($number) ?>" >
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<?php  $current_likes = get_post_meta(get_the_ID(),'vortex_system_likes',true);
				if($current_likes >= '1'):
				global $vortex_like_dislike;
			?>
			<?php if ( !$show_like ) : ?>
				<div class="no-like"></div>
			<?php endif; ?>
			<li class="<?php the_ID(); ?>">
			<?php if ( $show_thumbnail ) : ?>
			<?php
			$images = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches);
			if ( has_post_thumbnail() ) {
					echo '<a class="th-vortex" href="'.esc_url(get_permalink()).'">';
					the_post_thumbnail('thumbnail');
					echo '</a>';
				}elseif(!empty($images)){
					echo '<a class="th-vortex" href="'.esc_url(get_permalink()).'">';
					echo '<img src="'.esc_url($matches[1][0]).'" width="50px" height="40px">';
					echo '</a>';
				} ?>
			<?php endif; ?>	
				<a title="<?php esc_html(get_the_title() ? the_title() : the_ID())?>" href="<?php esc_url(the_permalink()); ?>"><?php esc_html(get_the_title() ? the_title() : the_ID()) ?></a>
			<?php if ( $show_like ) : ?>
				<?php
					  $like = ' '.sanitize_text_field($vortex_like_dislike['v-singular-text']);
					  $likes = ' '.sanitize_text_field($vortex_like_dislike['v-plural-text']);
					  if($current_likes == '1'){
						echo '<span class="post-like-counter '.esc_attr(get_the_ID()).'">'.esc_html($current_likes).'</span>';
						echo '<span class="post-like-text '.esc_attr(get_the_ID()).'">'.esc_html($like).'</span>';
					  }elseif($current_likes > '1'){
						echo '<span class="post-like-counter '.esc_attr(get_the_ID()).'">'.esc_html($current_likes).'</span>';
						echo '<span class="post-like-text '.esc_attr(get_the_ID()).'">'.esc_html($likes).'</span>';
					  }
				
				?>
			<?php endif; ?>
			</li>
			<?php endif; ?>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
		
		ob_end_flush();
	}
	
	public function form( $instance ) {
		$domain = 'vortex_system_ld';
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_like = isset( $instance['show_like'] ) ? (bool) $instance['show_like'] : false;
		$show_sticky = isset( $instance['show_sticky'] ) ? (bool) $instance['show_sticky'] : false;
		$show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : false;
		?>
				<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',$domain ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
				<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:',$domain ); ?></label>
				<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
				<p><input class="checkbox" type="checkbox" <?php checked( $show_thumbnail ); ?> id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e( 'Display the thumbnail for each post?',$domain ); ?></label></p>
				<p><input class="checkbox" type="checkbox" <?php checked( $show_like ); ?> id="<?php echo $this->get_field_id( 'show_like' ); ?>" name="<?php echo $this->get_field_name( 'show_like' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_like' ); ?>"><?php _e( 'Display the likes(counter) for each post?',$domain ); ?></label></p>
				<p><input class="checkbox" type="checkbox" <?php checked( $show_sticky ); ?> id="<?php echo $this->get_field_id( 'show_sticky' ); ?>" name="<?php echo $this->get_field_name( 'show_sticky' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_sticky' ); ?>"><?php _e( 'Display sticky posts?',$domain ); ?></label></p>
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$instance['show_like'] = isset( $new_instance['show_like'] ) ? (bool) $new_instance['show_like'] : false;
		$instance['show_sticky'] = isset( $new_instance['show_sticky'] ) ? (bool) $new_instance['show_sticky'] : false;
		$instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] ) ? (bool) $new_instance['show_thumbnail'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['vortex_top_likes']) )
			delete_option('vortex_top_likes');

		return $instance;
	}
}

	// Register and load the widget
	function vortex_load_widget() {
		register_widget( 'vortex_top_likes' );
	}
	add_action( 'widgets_init', 'vortex_load_widget' );

?>