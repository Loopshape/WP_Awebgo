<?php
global $vortex_like_dislike;
	
	if($vortex_like_dislike['v-switch-posts']){

		add_action( 'wp_ajax_nopriv_vortex_system_like_button', 'vortex_system_like_button' );
		add_action( 'wp_ajax_vortex_system_like_button', 'vortex_system_like_button' );
		function vortex_system_like_button() {
				
				global $vortex_like_dislike;
				
				$nonce = $_POST['nonce'];
				if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ){
					wp_die();
				}
				
				$singular = sanitize_text_field($vortex_like_dislike['v-singular-text']);
				$plural = sanitize_text_field($vortex_like_dislike['v-plural-text']);
				
				$post_id = absint($_POST['post_id']);
				
				$likes = 'vortex_system_likes';
				$dislikes = 'vortex_system_dislikes';
				
				if(is_user_logged_in()){
				
				$current_user_id = get_current_user_id();
				$user_key = 'vortex_system_user_'.$current_user_id;
				
				}elseif($vortex_like_dislike['v-switch-anon']){
					
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					
					$user_key = 'vortex_system_user_'.$user_ip;
					
				}else wp_die();
				
				//defaults for user when he first time likes a post
				$user_data = array(
					'liked'    => 'liked',
					'disliked' => 'disliked'
				);
				
				//if this is the first time a user likes this post add the users data to the meta post
				if(get_post_meta ($post_id,$user_key,true) == ''){
					add_post_meta($post_id, $user_key, $user_data,true);
				}
				
				$user_data_new = array(
					'liked'    => 'noliked',
					'disliked' => 'disliked',
				);
				
				$current_user = get_post_meta($post_id,$user_key,true);
				$disliked_value = $current_user['disliked'];
				$current_user_liked = $current_user['liked'];
				
				if($current_user_liked == 'liked' && $disliked_value == 'nodisliked'){
					$current_likes = get_post_meta($post_id,$likes,true);
					$current_likes++;
					update_post_meta($post_id,$likes,$current_likes);
					
					$current_dislikes = get_post_meta($post_id,$dislikes,true);
					$current_dislikes--;
					update_post_meta($post_id,$dislikes,$current_dislikes);
					update_post_meta($post_id,$user_key,$user_data_new);
					/*
					global $vortex_like_dislike;
					if($vortex_like_dislike['v-switch-tooltip']){
						$response = array(
						'dislikes' => $current_dislikes,
						'likes'	   => $current_likes,
						'both'	   => 'yes',
						'singular' => $singular,
						'plural'   => $plural,
						'title'	   => esc_html(get_the_title($post_id)),
						'url'	   => esc_url(get_permalink($post_id)),
						'id'	   => $post_id,
						'like'     => $vortex_like_dislike['v-like-text'],
						'allreadylike' => $vortex_like_dislike['v-like-text-yes'],
						'dislike'	=> $vortex_like_dislike['v-dislike-text'],
						'allreadydislike' => $vortex_like_dislike['v-dislike-yes']
					}else{}*/
					if ($vortex_like_dislike['v_custom_text']){
						$current_likes = $vortex_like_dislike['v_custom_text_post_like'];
					};
						$response = array(
						'dislikes' => $current_dislikes,
						'likes'	   => $current_likes,
						'both'	   => 'yes',
						'singular' => $singular,
						'plural'   => $plural,
						'title'	   => esc_html(get_the_title($post_id)),
						'url'	   => esc_url(get_permalink($post_id)),
						'id'	   => $post_id
					);
					
					echo json_encode($response);
					exit();
					
				}elseif($current_user_liked == 'liked'){
					//he likes the post add +1 to likes
					//change the liked value so when he clicks again we can undo his vote
					$current_likes = get_post_meta($post_id,$likes,true);
					$current_likes++;
					update_post_meta($post_id,$likes,$current_likes);
					update_post_meta($post_id,$user_key,$user_data_new);
					
				}elseif($current_user_liked == 'noliked'){
					//he doesn't like the post anymore let's undo his vote and change his meta so we can add his vote back 
					//if he changes his mind
					$current_likes = get_post_meta($post_id,$likes,true);
					$current_likes--;
					update_post_meta($post_id,$likes,$current_likes);
					update_post_meta($post_id,$user_key,$user_data);
					global $vortex_like_dislike;
					if ($vortex_like_dislike['v_custom_text']){

						$response = array(
							'likes' => $current_likes,
							'both'   => 'no',
							'singular' => $singular,
							'plural'   => $plural,
							'title'	   => esc_html(get_the_title($post_id)),
							'url'	   => esc_url(get_permalink($post_id)),
							'id'	   => $post_id
						);
						echo json_encode($response);
					
						wp_die();
					}
				}
				
				if ($vortex_like_dislike['v_custom_text']){
					$current_likes = $vortex_like_dislike['v_custom_text_post_like'];
				}
				$response = array(
					'likes' => $current_likes,
					'both'   => 'no',
					'singular' => $singular,
					'plural'   => $plural,
					'title'	   => esc_html(get_the_title($post_id)),
					'url'	   => esc_url(get_permalink($post_id)),
					'id'	   => $post_id
				);
				echo json_encode($response);
				
				wp_die();
			
		}


	if(!$vortex_like_dislike['v-switch-dislike']){
		add_action( 'wp_ajax_nopriv_vortex_system_dislike_button', 'vortex_system_dislike_button' );
		add_action( 'wp_ajax_vortex_system_dislike_button', 'vortex_system_dislike_button' );
		function vortex_system_dislike_button() {
			
				$nonce = $_POST['nonce'];
				if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ){
					wp_die();
				}
			
				global $vortex_like_dislike;
				
				$post_id = absint($_POST['post_id']);

				$likes = 'vortex_system_likes';
				$dislikes = 'vortex_system_dislikes';
				
				if(is_user_logged_in()){
				
				$current_user_id = get_current_user_id();
				$user_key = 'vortex_system_user_'.$current_user_id;
				
				}elseif($vortex_like_dislike['v-switch-anon']){
					
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					
					$user_key = 'vortex_system_user_'.$user_ip;
					
				}else wp_die();		
				//defaults for user when he first time dislikes a post
				$user_data = array(
					'liked'    => 'liked',
					'disliked' => 'disliked'
				);
				
				if(get_post_meta ($post_id,$user_key,true) == ''){
					add_post_meta($post_id, $user_key, $user_data,true);
				}

				$user_data_new = array(
					'liked'    => 'liked',
					'disliked' => 'nodisliked',
				);
				
				$singular = sanitize_text_field($vortex_like_dislike['v-singular-text']);
				$plural = sanitize_text_field($vortex_like_dislike['v-plural-text']);
				
				$current_user = get_post_meta($post_id,$user_key,true);
				$current_user_disliked = $current_user['disliked'];
				$liked_value = $current_user['liked'];
				
				if($current_user_disliked == 'disliked' && $liked_value == 'noliked'){
					
					$current_likes = get_post_meta($post_id,$likes,true);
					$current_likes--;
					update_post_meta($post_id,$likes,$current_likes);
					
					$current_dislikes = get_post_meta($post_id,$dislikes,true);
					$current_dislikes++;
					update_post_meta($post_id,$dislikes,$current_dislikes);
					
					update_post_meta($post_id,$user_key,$user_data_new);
					
					if ($vortex_like_dislike['v_custom_text']){
						$current_dislikes = $vortex_like_dislike['v_custom_text_post_dislike'];
					}
					
					$response = array(
						'dislikes' => $current_dislikes,
						'likes'	   => $current_likes,
						'both'	   => 'yes',
						'singular' => $singular,
						'plural'   => $plural,
						'title'	   => esc_html(get_the_title($post_id)),
						'url'	   => esc_url(get_permalink($post_id)),
						'id'	   => $post_id
					);
					
					echo json_encode($response);
					exit();
					
				}elseif($current_user_disliked == 'disliked'){
					//he likes the post add +1 to likes
					//change the liked value so when he clicks again we can undo his vote
					$current_dislikes = get_post_meta($post_id,$dislikes,true);
					$current_dislikes++;
					update_post_meta($post_id,$dislikes,$current_dislikes);
					
					update_post_meta($post_id,$user_key,$user_data_new);
					
				}elseif($current_user_disliked == 'nodisliked'){
					//he doesn't like the post anymore let's undo his vote and change his meta so we can add his vote back 
					//if he changes his mind
					$current_dislikes = get_post_meta($post_id,$dislikes,true);
					$current_dislikes--;
					update_post_meta($post_id,$dislikes,$current_dislikes);
					
					update_post_meta($post_id,$user_key,$user_data);
					
					if ($vortex_like_dislike['v_custom_text']){

						$response = array(
							'dislikes' => $current_dislikes,
							'both'   => 'no',
							'singular' => $singular,
							'plural'   => $plural,
							'title'	   => esc_html(get_the_title($post_id)),
							'url'	   => esc_url(get_permalink($post_id)),
							'id'	   => $post_id
						);
						echo json_encode($response);
						
						wp_die();
					}
				}
				
				if ($vortex_like_dislike['v_custom_text']){
					$current_dislikes = $vortex_like_dislike['v_custom_text_post_dislike'];
				}
				
				$response = array(
					'dislikes' => $current_dislikes,
					'both'   => 'no',
					'singular' => $singular,
					'plural'   => $plural,
					'title'	   => esc_html(get_the_title($post_id)),
					'url'	   => esc_url(get_permalink($post_id)),
					'id'	   => $post_id
				);
				echo json_encode($response);
				
				wp_die();
			
		}
	}

		function vortex_system_add_dislike_class(){
				global $vortex_like_dislike;
			
				if(is_user_logged_in()){
					$current_user_id = get_current_user_id();
					$user_key = 'vortex_system_user_'.$current_user_id;
				}elseif(!is_user_logged_in() && $vortex_like_dislike['v-switch-anon']){
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					$user_key = 'vortex_system_user_'.$user_ip;
				};
				if(is_user_logged_in() || (!is_user_logged_in() && $vortex_like_dislike['v-switch-anon'])){
					if(!get_post_meta(get_the_ID(),$user_key,true) == ''){
						$current_user = get_post_meta(get_the_ID(),$user_key,true);
						$current_user_disliked = $current_user['disliked'];
							
						if($current_user_disliked == 'nodisliked'){
							return 'vortex-p-dislike-active';
						}
					}
				}
		}

		function vortex_system_add_like_class(){
				global $vortex_like_dislike;
				
				if(is_user_logged_in()){
					$current_user_id = get_current_user_id();
					$user_key = 'vortex_system_user_'.$current_user_id;
				}elseif(!is_user_logged_in() && $vortex_like_dislike['v-switch-anon']){
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					$user_key = 'vortex_system_user_'.$user_ip;
				};
				if(is_user_logged_in() || (!is_user_logged_in() && $vortex_like_dislike['v-switch-anon'])){
					if(!get_post_meta(get_the_ID(),$user_key,true) == ''){
						$current_user = get_post_meta(get_the_ID(),$user_key,true);
						$current_user_liked = $current_user['liked'];
					
					if($current_user_liked == 'noliked'){
							return 'vortex-p-like-active';
						}
					}
						
				}
		}

		function vortex_system_get_total_likes(){
			
				$likes = get_post_meta(get_the_ID(),'vortex_system_likes',true);
			
				if(empty($likes)){
					return 0;
				}elseif(!$likes == ''){
				 return $dislikes = get_post_meta(get_the_ID(),'vortex_system_likes',true);
				}
		}

		function vortex_system_get_total_dislikes(){
			
				$dislikes = get_post_meta(get_the_ID(),'vortex_system_dislikes',true);
			
				if(empty($dislikes)){
					return 0;
				}elseif(!$dislikes == ''){
				 return $dislikes = get_post_meta(get_the_ID(),'vortex_system_dislikes',true);
				}
		}
		
		function vortex_system_get_like_icon(){
			global $vortex_like_dislike;
			
			if($vortex_like_dislike['v_button_style'] == '1'){
				return 'icon-thumbs-up-1';
			}elseif($vortex_like_dislike['v_button_style'] == '2'){
				return 'icon-thumbs-up-alt';
			}elseif($vortex_like_dislike['v_button_style'] == '3'){
				return 'icon-thumbs-up';
			}elseif($vortex_like_dislike['v_button_style'] == '4'){
				return 'icon-thumbs-up-3';
			}elseif($vortex_like_dislike['v_button_style'] == '5'){
				return 'icon-thumbs-up-4';
			}elseif($vortex_like_dislike['v_button_style'] == '6'){
				return 'icon-thumbs-up-2';
			}elseif($vortex_like_dislike['v_button_style'] == '7'){
				return 'icon-plus-circled';
			}elseif($vortex_like_dislike['v_button_style'] == '8'){
				return 'icon-plus';
			}elseif($vortex_like_dislike['v_button_style'] == '9'){
				return 'icon-up';
			}elseif($vortex_like_dislike['v_button_style'] == '10'){
				return 'icon-up-big';
			}elseif($vortex_like_dislike['v_button_style'] == '11'){
				return 'icon-heart';
			}elseif($vortex_like_dislike['v_button_style'] == '12'){
				return 'icon-star';
			}elseif($vortex_like_dislike['v_button_style'] == '13'){
				return 'icon-ok-circle';
			}elseif($vortex_like_dislike['v_button_style'] == '14'){
				return 'icon-ok';
			}
			
			
		}
		
		function vortex_system_get_dislike_icon(){
			global $vortex_like_dislike;
			
			if($vortex_like_dislike['v_button_style'] == '1'){
				return 'icon-thumbs-down-1';
			}elseif($vortex_like_dislike['v_button_style'] == '2'){
				return 'icon-thumbs-down-alt';
			}elseif($vortex_like_dislike['v_button_style'] == '3'){
				return 'icon-thumbs-down';
			}elseif($vortex_like_dislike['v_button_style'] == '4'){
				return 'icon-thumbs-down-3';
			}elseif($vortex_like_dislike['v_button_style'] == '5'){
				return 'icon-thumbs-down-4';
			}elseif($vortex_like_dislike['v_button_style'] == '6'){
				return 'icon-thumbs-down-2';
			}elseif($vortex_like_dislike['v_button_style'] == '7'){
				return 'icon-minus-circled';
			}elseif($vortex_like_dislike['v_button_style'] == '8'){
				return 'icon-minus';
			}elseif($vortex_like_dislike['v_button_style'] == '9'){
				return 'icon-down';
			}elseif($vortex_like_dislike['v_button_style'] == '10'){
				return 'icon-down-big';
			}elseif($vortex_like_dislike['v_button_style'] == '11'){
				return 'icon-heart-broken';
			}elseif($vortex_like_dislike['v_button_style'] == '12'){
				return 'icon-star-empty';
			}elseif($vortex_like_dislike['v_button_style'] == '13'){
				return 'icon-cancel-circle';
			}elseif($vortex_like_dislike['v_button_style'] == '14'){
				return 'icon-cancel';
			}
			
			
		}
		
		function vortex_button_align(){
			global $vortex_like_dislike;

			if($vortex_like_dislike['vortex-button-align'] == '1'){
				return 'vortex-align-left';
			}elseif($vortex_like_dislike['vortex-button-align'] == '2'){
				return 'vortex-align-center';
			}else{
				return 'vortex-align-right';
			}
		}
		
		function vortex_system_dislike_counter(){
			
			global $vortex_like_dislike;
			if ($vortex_like_dislike['v_custom_text_post_keep'] && vortex_system_add_dislike_class() == 'vortex-p-dislike-active'){
				if(!$vortex_like_dislike['v-switch-anon-counter'] || is_user_logged_in()){
					return '<span class="vortex-p-dislike-counter '.get_the_ID(). '">'.$vortex_like_dislike['v_custom_text_post_dislike'].'</span>';
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-counter'] || is_user_logged_in()){
				return '<span class="vortex-p-dislike-counter '.get_the_ID(). '">'. vortex_system_get_total_dislikes().'</span>';
			}
			
		}
		
		function vortex_system_render_dislike_button(){
			/*dev use the same as below
			return	'<div class="vortex-container-dislike">	
					<input type="hidden" value="'.get_the_ID().'" ></input>
					<div class="vortex-p-dislike '.get_the_ID().' '. vortex_system_add_dislike_class() .' '.vortex_system_get_dislike_icon().'">
						'.vortex_system_dislike_counter().'
					</div>	
				</div>';
			
			*/
			return	'<div class="vortex-container-dislike"><input type="hidden" value="'.get_the_ID().'" ></input><div class="vortex-p-dislike '.get_the_ID().' '. vortex_system_add_dislike_class() .' '.vortex_system_get_dislike_icon().'">'.vortex_system_dislike_counter().'</div></div>';
			
		}
		
		function vortex_system_like_counter(){
			
			global $vortex_like_dislike;
			if ($vortex_like_dislike['v_custom_text_post_keep'] && vortex_system_add_like_class() == 'vortex-p-like-active'){
				if(!$vortex_like_dislike['v-switch-anon-counter'] || is_user_logged_in()){
					return 	'<span  class="vortex-p-like-counter '. get_the_ID().'">'.$vortex_like_dislike['v_custom_text_post_like'].'</span>';
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-counter'] || is_user_logged_in()){
				return 	'<span  class="vortex-p-like-counter '. get_the_ID().'">'.vortex_system_get_total_likes().'</span>';
			}	

			
		}
		
		function vortex_render_for_posts(){
			
			global $vortex_like_dislike;
			
			if(!$vortex_like_dislike['v-switch-dislike']){
				
			/*
			this is for dev the same as below
			$buttons = '	
			<div class="vortex-container-vote '.vortex_button_align().'">
					<div class="vortex-container-like">
						<input type="hidden" value="'.get_the_ID().'" ></input>
						<div class="vortex-p-like '.get_the_ID().' '.vortex_system_add_like_class().' '.vortex_system_get_like_icon().'">
						'.vortex_system_like_counter().'
						</div>
				</div>
				'.vortex_system_render_dislike_button().'
			</div>
			';*/
			//leave it inline, bbPress adds p tags for unkown reasons
			$buttons = '<div class="vortex-container-vote '.vortex_button_align().'"><div class="vortex-container-like"><input type="hidden" value="'.get_the_ID().'" ></input><div class="vortex-p-like '.get_the_ID().' '.vortex_system_add_like_class().' '.vortex_system_get_like_icon().'">'.vortex_system_like_counter().'</div></div>'.vortex_system_render_dislike_button().'</div>';
				
				return $buttons;
			}else {
				/* this is for dev the same as below 
				$buttons = '	
			<div class="vortex-container-vote '.vortex_button_align().'">
					<div class="vortex-container-like">
						<input type="hidden" value="'.get_the_ID().'" ></input>
						<div class="vortex-p-like '.get_the_ID().' '.vortex_system_add_like_class().' '.vortex_system_get_like_icon().'">
							'.vortex_system_like_counter().'
						</div>
				</div>
			</div>
			';
				
				
				*/
				$buttons = '<div class="vortex-container-vote '.vortex_button_align().'"><div class="vortex-container-like"><input type="hidden" value="'.get_the_ID().'" ></input><div class="vortex-p-like '.get_the_ID().' '.vortex_system_add_like_class().' '.vortex_system_get_like_icon().'">'.vortex_system_like_counter().'</div></div></div>';
				
				return $buttons;
			}
			
		}

		if($vortex_like_dislike['v-switch-columns']){
			
			add_filter( 'manage_edit-post_columns', 'vortex_system_columns' ) ;

			function vortex_system_columns( $columns ) {
				
				global $vortex_like_dislike;
				$domain = 'vortex_system_ld';
				$columns['likes'] = __('Likes',$domain);
				
				if(!$vortex_like_dislike['v-switch-dislike']){
					$columns['dislikes'] = __('Dislikes',$domain);
				}

				return $columns;
			}

			add_action( 'manage_post_posts_custom_column', 'vortex_system_columns_value', 10, 2 );

			function vortex_system_columns_value( $column, $post_id ) {
				global $post;
				
				switch( $column ) {

					case 'likes' :

						$likes = get_post_meta( $post_id, 'vortex_system_likes', true );

						if ( empty( $likes ) )
							echo '0';

						else
							echo $likes;

						break;
		
		
					case 'dislikes' :

						$dislikes = get_post_meta( $post_id, 'vortex_system_dislikes', true );

						if ( empty( $dislikes ) )
							echo '0';

						else
							echo $dislikes;

						break;
					
					
					/* Just break out of the switch statement for everything else. */
					default :
						break;
				}
			}

			add_filter( 'manage_edit-post_sortable_columns', 'vortex_system_sortable_columns' );

			function vortex_system_sortable_columns( $columns ) {
				global $vortex_like_dislike;
				
				$columns['likes'] = 'likes';

				if(!$vortex_like_dislike['v-switch-dislike']){
					$columns['dislikes'] = 'dislikes';
				}

				return $columns;
			}
		}
		
	function vortex_system_insert(){
		
		function vortex_system_before_post($content){
			global $vortex_like_dislike;
			
			if(!empty($vortex_like_dislike['v_exclude_category'])){
				$array = $vortex_like_dislike['v_exclude_category'];
				if(has_category($array)){
					return $content;
				}
			}
			
			if(!empty($vortex_like_dislike['v_exclude_post_types-p'])){
				$array = $vortex_like_dislike['v_exclude_post_types-p'];
				if(in_array(get_post_type(get_the_ID()),$array)){
					return $content;
				}
			}
			
			if($vortex_like_dislike['v_button_show'][1] && is_page() && is_main_query()){
				return vortex_render_for_posts().$content;
			}elseif($vortex_like_dislike['v_button_show'][2] && is_main_query() && !is_page() && !is_singular()){
				return vortex_render_for_posts().$content;
			}elseif($vortex_like_dislike['v_button_show'][3] && is_singular('post')){
				return vortex_render_for_posts().$content;
			}elseif($vortex_like_dislike['v_button_show'][4] && !is_main_query()){
				return vortex_render_for_posts().$content;
			}elseif($vortex_like_dislike['v_button_show'][5] && is_singular() && !is_singular('post')){
				return vortex_render_for_posts().$content;
			}else return $content;
			
		}
	
		function vortex_system_after_post($content){
			global $vortex_like_dislike;
			
			if(!empty($vortex_like_dislike['v_exclude_category'])){
				$array = $vortex_like_dislike['v_exclude_category'];
				if(has_category($array)){
					return $content;
				}
			}
			
			if(!empty($vortex_like_dislike['v_exclude_post_types-p'])){
				$array = $vortex_like_dislike['v_exclude_post_types-p'];
				if(in_array(get_post_type(get_the_ID()),$array)){
					return $content;
				}
			}
			
			if($vortex_like_dislike['v_button_show'][1] && is_page() && is_main_query()){
				return $content.vortex_render_for_posts();
			}elseif($vortex_like_dislike['v_button_show'][2] && is_main_query() && !is_page() && !is_singular()){
				return $content.vortex_render_for_posts();
			}elseif($vortex_like_dislike['v_button_show'][3] && is_singular('post')){
				return $content.vortex_render_for_posts();
			}elseif($vortex_like_dislike['v_button_show'][4] && !is_main_query()){
				return $content.vortex_render_for_posts();
			}elseif($vortex_like_dislike['v_button_show'][5] && is_singular() && !is_singular('post')){
				return $content.vortex_render_for_posts();
			}else return $content;
		}

		global $vortex_like_dislike;
		if(!post_password_required()){
			if($vortex_like_dislike['v_button_visibility'][1] && $vortex_like_dislike['v_button_visibility'][2] ){
				add_filter('the_content','vortex_system_before_post');
				add_filter('the_content','vortex_system_after_post');
				if($vortex_like_dislike['v_enable_bbpress'] && is_plugin_active( 'bbpress/bbpress.php' )){
					add_filter('bbp_get_reply_content','vortex_system_before_post');
					add_filter('bbp_get_reply_content','vortex_system_after_post');
				}
			}elseif($vortex_like_dislike['v_button_visibility'][1]){
				add_filter('the_content','vortex_system_before_post');
				if($vortex_like_dislike['v_enable_bbpress'] && is_plugin_active( 'bbpress/bbpress.php' )){
					add_filter('bbp_get_reply_content','vortex_system_before_post');
				}
			}elseif($vortex_like_dislike['v_button_visibility'][2]){
				add_filter('the_content','vortex_system_after_post');
				if($vortex_like_dislike['v_enable_bbpress'] && is_plugin_active( 'bbpress/bbpress.php' )){
					add_filter('bbp_get_reply_content','vortex_system_after_post');
				}
			}
		}
		
	}
	add_action('wp','vortex_system_insert');
	function vortex_system_styles_scripts(){
		global $vortex_like_dislike;
			
			if(is_user_logged_in()){
				wp_enqueue_script( 'jquery' );
				wp_enqueue_style( 'vortex_like_or_dislike', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
				if(!$vortex_like_dislike['v-switch-dislike']){
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_like_or_dislike_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_like_or_dislike_js', 'vortex_ajax_var', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
				}else{
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_no_dislike_js', plugin_dir_url( __FILE__ ).'assets/js/no-dislike.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_no_dislike_js', 'vortex_ajax_var', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' ),
						'color' => esc_js($vortex_like_dislike['v_default_color'])
						)
					);
				}
			}elseif($vortex_like_dislike['v-switch-anon']){
				wp_enqueue_style( 'vortex_like_or_dislike', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
				wp_enqueue_script( 'jquery' );
				if(!$vortex_like_dislike['v-switch-dislike']){
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_like_or_dislike_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_like_or_dislike_js', 'vortex_ajax_var', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
				}else{
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_no_dislike_js', plugin_dir_url( __FILE__ ).'assets/js/no-dislike.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_no_dislike_js', 'vortex_ajax_var', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' ),
						'color' => esc_js($vortex_like_dislike['v_default_color'])
						)
					);
				}
			}elseif(!$vortex_like_dislike['v-switch-anon'] && !is_user_logged_in()){
				wp_enqueue_style( 'vortex_like_or_dislike', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
			}
			
	}
	add_action('wp_enqueue_scripts','vortex_system_styles_scripts');
}