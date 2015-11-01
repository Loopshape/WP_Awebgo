<?php 
	class vortex_like_com_mycred extends myCRED_Hook {
		/**
		 * Construct
		 */
		function __construct( $hook_prefs, $type ) {
			parent::__construct( array(
				'id'       => 'vortex_like_com_mycred',
				'defaults' => array(
					'like'   => array(
						'creds'	 => 1,
						'log'	 => '%plural% for like(comment)',
						'author' => 4,
					),
					'dislike'   => array(
						'creds'	 => 0,
						'log'	 => '%plural% deduction for dislike(comment)',
						'author' => '-1',
					),
					'canceled'	=> "Vote canceled(comment)"
				)
			), $hook_prefs, $type );
		}

		/**
		 * Hook into WordPress
		 */
		public function run() {
			// Since we are running a single instance, we do not need to check
			// if points are set to zero (disable). myCRED will check if this
			// hook has been enabled before calling this method so no need to check
			// that either.
			add_action( 'vortex_com_dislike',  array( $this, 'vortex_com_update' ),10,4 );
		}

		/**
		 * Check if the user qualifies for points
		 */
		public function vortex_com_update($like,$dislike,$id,$com_id) {
			$user_id = $id;
			$com_author_id = get_comment($com_id)->user_id;
			if($user_id != 0 && $com_author_id != $user_id && $com_author_id != 0){
				if ( $this->core->exclude_user( $user_id ) ) return;
				
				if($like == "-likes" && $dislike == "+dislikes"){
					
					$likes = 0 - $this->prefs['like']['creds'];
					$dislikes = $this->prefs['dislike']['creds'];
					$text = $this->prefs['dislike']['log'];
					$points = $likes + $dislikes;
					$ref = 'vortex_dislike_coms_mycred_author';
					
				}elseif($like == "+likes" && $dislike == "-dislikes"){
					
					$likes = $this->prefs['like']['creds'];
					$dislikes = 0 - $this->prefs['dislike']['creds'];
					$points = $likes + $dislikes;
					$text = $this->prefs['like']['log'];
					$ref = 'vortex_like_coms_mycred_author';
					
				}elseif($like == "+likes"){
					
					$points = $this->prefs['like']['creds'];
					$text = $this->prefs['like']['log'];
					$ref = 'vortex_like_coms_mycred_author';
					
				}elseif($like == "-likes"){
					
					$points = 0 - $this->prefs['like']['creds'];
					$text = $this->prefs['canceled'];
					$ref = 'vortex_cancel_like_coms_mycred_author';
					
				}elseif($dislike == "+dislikes"){
					
					$points = $this->prefs['dislike']['creds'];
					$text = $this->prefs['dislike']['log'];
					$ref = 'vortex_dislike_coms_mycred_author';
					
				}else{
					
					$points = 0 - $this->prefs['dislike']['creds'];
					$text = $this->prefs['canceled'];
					$ref = 'vortex_cancel_dislike_coms_mycred_author';
					
				}
				$this->core->add_creds(
					$ref,
					$user_id,
					$points,
					$text,
					0,
					'',
					$m
				);
					
				if($like == "-likes" && $dislike == "+dislikes"){
					
					$likes = 0 - $this->prefs['like']['author'];
					$dislikes = $this->prefs['dislike']['author'];
					$points = $likes + $dislikes;
					$text = $this->prefs['dislike']['log'];
					$ref = 'vortex_dislike_coms_mycred_author_content';
					
				}elseif($like == "+likes" && $dislike == "-dislikes"){
					
					$likes = $this->prefs['like']['author'];
					$dislikes = 0 - $this->prefs['dislike']['author'];
					$points = $likes + $dislikes;
					$text = $this->prefs['like']['log'];
					$ref = 'vortex_like_coms_mycred_author_content';
					
				}elseif($like == "+likes"){
					
					$points = $this->prefs['like']['author'];
					$text = $this->prefs['like']['log'];
					$ref = 'vortex_like_coms_mycred_author_content';
					
				}elseif($like == "-likes"){
					
					$points = 0 - $this->prefs['like']['author'];
					$text = $this->prefs['canceled'];
					$ref = 'vortex_cancel_like_coms_mycred_author_content';
					
				}elseif($dislike == "+dislikes"){
					
					$points = $this->prefs['dislike']['author'];
					$text = $this->prefs['dislike']['log'];
					$ref = 'vortex_dislike_coms_mycred_author_content';
					
				}else{
					
					$points = 0 - $this->prefs['dislike']['author'];
					$text = $this->prefs['canceled'];
					$ref = 'vortex_cancel_dislike_coms_mycred_author_content';
					
				}
				$this->core->add_creds(
					$ref,
					$com_author_id,
					$points,
					$text,
					0,
					'',
					$m
				);
			}
			
		}
		
		/**
		 * Add Settings
		 */
		 public function preferences() {
			// Our settings are available under $this->prefs
			$prefs = $this->prefs; ?>
	
	<!-- First we set the amount -->
	<label class="subheader"><?php _e( 'Like', 'mycred' ); ?></label>
	<ol class="inline">
		<li style="min-width: 200px;">
			<label for="<?php echo $this->field_id( array( 'like' => 'creds' ) ); ?>"><?php _e( 'Like Author', 'mycred' ); ?></label>
			<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'like' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'like' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['like']['creds'] ); ?>" size="8" /></div>
		</li>
		<li>
			<label for="<?php echo $this->field_id( array( 'like' => 'author' ) ); ?>"><?php _e( 'Comment Author', 'mycred' ); ?></label>
			<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'like' => 'author' ) ); ?>" id="<?php echo $this->field_id( array( 'like' => 'author' ) ); ?>" value="<?php echo $this->core->number( $prefs['like']['author'] ); ?>" size="8" /></div>
		</li>
		<li class="block empty">&nbsp;</li>
		<li class="block">
			<label for="<?php echo $this->field_id( array( 'like' => 'log' ) ); ?>"><?php _e( 'Log template', 'mycred' ); ?></label>
			<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'like' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'like' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['like']['log'] ); ?>" class="long" /></div>
			<span class="description"><?php echo $this->available_template_tags( array( 'general', 'comment' ) ); ?></span>
		</li>
	</ol>
	<label class="subheader"><?php _e( 'Dislike', 'mycred' ); ?></label>
	<ol class="inline">
		<li style="min-width: 200px;">
			<label for="<?php echo $this->field_id( array( 'dislike' => 'creds' ) ); ?>"><?php _e( 'Dislike Author', 'mycred' ); ?></label>
			<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'dislike' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'dislike' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['dislike']['creds'] ); ?>" size="8" /></div>
		</li>
		<li>
			<label for="<?php echo $this->field_id( array( 'dislike' => 'author' ) ); ?>"><?php _e( 'Comment Author', 'mycred' ); ?></label>
			<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'dislike' => 'author' ) ); ?>" id="<?php echo $this->field_id( array( 'dislike' => 'author' ) ); ?>" value="<?php echo $this->core->number( $prefs['dislike']['author'] ); ?>" size="8" /></div>
		</li>
		<li class="block empty">&nbsp;</li>
		<li class="block">
			<label for="<?php echo $this->field_id( array( 'dislike' => 'log' ) ); ?>"><?php _e( 'Log template', 'mycred' ); ?></label>
			<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'dislike' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'dislike' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['dislike']['log'] ); ?>" class="long" /></div>
			<span class="description"><?php echo $this->available_template_tags( array( 'general', 'comment' ) ); ?></span>
		</li>
	</ol>
	<label class="subheader"><?php _e( 'Log for canceled vote', 'mycred' ); ?></label>
	<ol>
		<li>
			<div class="h2"><input type="text" name="<?php echo $this->field_name( 'canceled' ); ?>" id="<?php echo $this->field_id( 'canceled' ); ?>" value="<?php echo $prefs['canceled']; ?>" class="long" /></div>
		</li>
	</ol>
	<?php
		}

		/**
		 * Sanitize Preferences
		 */
		public function sanitise_preferences( $data ) {
			$new_data = $data;

			$new_data['like']['log'] = ( !empty( $data['like']['log'] ) ) ? sanitize_text_field( $data['like']['log'] ) : $this->defaults['like']['log'];
			$new_data['dislike']['log'] = ( !empty( $data['dislike']['log'] ) ) ? sanitize_text_field( $data['dislike']['log'] ) : $this->defaults['dislike']['log'];
			$new_data['canceled'] = ( !empty( $data['canceled'] ) ) ? sanitize_text_field( $data['canceled'] ) : $this->defaults['canceled'];
			

			return $new_data;
		}
	}
	add_filter( 'mycred_setup_hooks', 'vortex_com_register_my_custom_hook' );
	function vortex_com_register_my_custom_hook( $installed )
	{
		$installed['vortex_like_com_mycred'] = array(
			'title'       => __( 'Points for like/dislike comments', 'vortex_system_ld' ),
			'description' => __( 'Settings', 'vortex_system_ld' ),
			'callback'    => array( 'vortex_like_com_mycred' )
		);
		return $installed;
	}