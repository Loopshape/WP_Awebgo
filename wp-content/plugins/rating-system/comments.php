<?php

global $vortex_like_dislike;

if($vortex_like_dislike['v-switch-comments']){
		add_action( 'wp_ajax_nopriv_vortex_system_comment_like_button', 'vortex_system_comment_like_button' );
		add_action( 'wp_ajax_vortex_system_comment_like_button', 'vortex_system_comment_like_button' );
		function vortex_system_comment_like_button(){
				
				global $vortex_like_dislike;
				
				$nonce = $_POST['nonce'];
				if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ){
					wp_die();
				}
				
				$post_id = absint($_POST['post_id']);
				
				$likes = 'vortex_system_likes';
				$dislikes = 'vortex_system_dislikes';
				
				if(is_user_logged_in()){
				
				$current_user_id = get_current_user_id();
				$user_key = 'vortex_system_user_'.$current_user_id;
				
				}elseif($vortex_like_dislike['v-switch-anon-comment']){
					
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					
					$user_key = 'vortex_system_user_'.$user_ip;
					
				}else wp_die();
				
				//defaults for user when he first time likes a post
				$user_data = array(
					'liked'    => 'liked',
					'disliked' => 'disliked'
				);
				
				//if this is the first time a user likes this post add the users data to the meta post
				if(get_comment_meta ($post_id,$user_key,true) == ''){
					add_comment_meta($post_id, $user_key, $user_data,true);
				}
				
				$user_data_new = array(
					'liked'    => 'noliked',
					'disliked' => 'disliked',
				);
				
				$current_user = get_comment_meta($post_id,$user_key,true);
				$disliked_value = $current_user['disliked'];
				$current_user_liked = $current_user['liked'];
				
				if($current_user_liked == 'liked' && $disliked_value == 'nodisliked'){
					$current_likes = get_comment_meta($post_id,$likes,true);
					$current_likes++;
					update_comment_meta($post_id,$likes,$current_likes);
					
					$current_dislikes = get_comment_meta($post_id,$dislikes,true);
					$current_dislikes--;
					update_comment_meta($post_id,$dislikes,$current_dislikes);
					
					update_comment_meta($post_id,$user_key,$user_data_new);
					do_action("vortex_com_dislike",'+likes','-dislikes',$current_user_id,$post_id);
					if ($vortex_like_dislike['v_custom_text_com']){
						$current_likes = $vortex_like_dislike['v_custom_text_com_like'];
					};
						$response = array(
						'dislikes' => $current_dislikes,
						'likes'	   => $current_likes,
						'both'	   => 'yes'
					);
					
					echo json_encode($response);
					exit();
					
				}elseif($current_user_liked == 'liked'){
					//he likes the post add +1 to likes
					//change the liked value so when he clicks again we can undo his vote
					$current_likes = get_comment_meta($post_id,$likes,true);
					$current_likes++;
					update_comment_meta($post_id,$likes,$current_likes);
					update_comment_meta($post_id,$user_key,$user_data_new);
					do_action("vortex_com_dislike",'+likes','nothing',$current_user_id,$post_id);
					
				}elseif($current_user_liked == 'noliked'){
					//he doesn't like the post anymore let's undo his vote and change his meta so we can add his vote back 
					//if he changes his mind
					$current_likes = get_comment_meta($post_id,$likes,true);
					$current_likes--;
					update_comment_meta($post_id,$likes,$current_likes);
					update_comment_meta($post_id,$user_key,$user_data);
					do_action("vortex_com_dislike",'-likes','nothing',$current_user_id,$post_id);
					if ($vortex_like_dislike['v_custom_text_com']){
						$current_likes = $vortex_like_dislike['v_custom_text_com_like'];
					};
						
						$response = array(
							'likes' => $current_likes,
							'both'   => 'no'
						);
						echo json_encode($response);
						
						wp_die();
				}
				if ($vortex_like_dislike['v_custom_text_com']){
					$current_likes = $vortex_like_dislike['v_custom_text_com_like'];
				}
				$response = array(
					'likes' => $current_likes,
					'both'   => 'no'
				);
				echo json_encode($response);
				
				wp_die();
			
		}


	if(!$vortex_like_dislike['v-switch-dislike-comment']){
		add_action( 'wp_ajax_nopriv_vortex_system_comment_dislike_button', 'vortex_system_comment_dislike_button' );
		add_action( 'wp_ajax_vortex_system_comment_dislike_button', 'vortex_system_comment_dislike_button' );
		function vortex_system_comment_dislike_button() {
			
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
				
				}elseif($vortex_like_dislike['v-switch-anon-comment']){
					
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					
					$user_key = 'vortex_system_user_'.$user_ip;
					
				}else wp_die();		
				
				//defaults for user when he first time dislikes a post
				$user_data = array(
					'liked'    => 'liked',
					'disliked' => 'disliked'
				);
				
				$user_data_new = array(
					'liked'    => 'liked',
					'disliked' => 'nodisliked',
				);
				
				//if this is the first time a user dislikes this post add the users data to the meta post
				if(get_comment_meta ($post_id,$user_key,true) == ''){
					add_comment_meta($post_id, $user_key, $user_data,true);
				}
				
				$current_user = get_comment_meta($post_id,$user_key,true);
				
				$current_user_disliked = $current_user['disliked'];
				$liked_value = $current_user['liked'];
				
				if($current_user_disliked == 'disliked' && $liked_value == 'noliked'){
					
					$current_likes = get_comment_meta($post_id,$likes,true);
					$current_likes--;
					update_comment_meta($post_id,$likes,$current_likes);
					
					$current_dislikes = get_comment_meta($post_id,$dislikes,true);
					$current_dislikes++;
					update_comment_meta($post_id,$dislikes,$current_dislikes);
					
					update_comment_meta($post_id,$user_key,$user_data_new);
					do_action("vortex_com_dislike",'-likes','+dislikes',$current_user_id,$post_id);
					if ($vortex_like_dislike['v_custom_text_com']){
						$current_dislikes = $vortex_like_dislike['v_custom_text_com_dislike'];
					}
					$response = array(
						'dislikes' => $current_dislikes,
						'likes'	   => $current_likes,
						'both'	   => 'yes'
					);
					
					echo json_encode($response);
					exit();
					
				}elseif($current_user_disliked == 'disliked'){
					//he likes the post add +1 to likes
					//change the liked value so when he clicks again we can undo his vote
					$current_dislikes = get_comment_meta($post_id,$dislikes,true);
					$current_dislikes++;
					update_comment_meta($post_id,$dislikes,$current_dislikes);
					
					update_comment_meta($post_id,$user_key,$user_data_new);
					do_action("vortex_com_dislike",'nothing','+dislikes',$current_user_id,$post_id);
				}elseif($current_user_disliked == 'nodisliked'){
					//he doesn't like the post anymore let's undo his vote and change his meta so we can add his vote back 
					//if he changes his mind
					$current_dislikes = get_comment_meta($post_id,$dislikes,true);
					$current_dislikes--;
					update_comment_meta($post_id,$dislikes,$current_dislikes);
					
					update_comment_meta($post_id,$user_key,$user_data);
					do_action("vortex_com_dislike",'nothing','-dislikes',$current_user_id,$post_id);
					if ($vortex_like_dislike['v_custom_text_com']){
						$current_dislikes = $vortex_like_dislike['v_custom_text_com_dislike'];
					}
						$response = array(
							'dislikes' => $current_dislikes,
							'both'   => 'no'
						);
						echo json_encode($response);
						
						wp_die();
				}
				
				if ($vortex_like_dislike['v_custom_text_com']){
					$current_dislikes = $vortex_like_dislike['v_custom_text_com_dislike'];
				}
				
				$response = array(
					'dislikes' => $current_dislikes,
					'both'   => 'no'
				);
				echo json_encode($response);
				
				wp_die();
		}
	}
	
		function vortex_system_add_dislike_class_comment(){
				global $vortex_like_dislike;
			
				if(is_user_logged_in()){
					$current_user_id = get_current_user_id();
					$user_key = 'vortex_system_user_'.$current_user_id;
				}elseif(!is_user_logged_in() && $vortex_like_dislike['v-switch-anon-comment']){
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					$user_key = 'vortex_system_user_'.$user_ip;
				};
				if(is_user_logged_in() || (!is_user_logged_in() && $vortex_like_dislike['v-switch-anon-comment'])){
					if(!get_comment_meta(get_comment_ID(),$user_key,true) == ''){
						$current_user = get_comment_meta(get_comment_ID(),$user_key,true);
						$current_user_disliked = $current_user['disliked'];
							
						if($current_user_disliked == 'nodisliked'){
							return 'vortex-p-dislike-active-comment';
						}else{
							return'';	
						}
					}
				}	
		}

		function vortex_system_add_like_class_comment(){
				global $vortex_like_dislike;
				
				if(is_user_logged_in()){
					$current_user_id = get_current_user_id();
					$user_key = 'vortex_system_user_'.$current_user_id;
				}elseif(!is_user_logged_in() && $vortex_like_dislike['v-switch-anon-comment']){
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					$user_key = 'vortex_system_user_'.$user_ip;
				};
				if(is_user_logged_in() || (!is_user_logged_in() && $vortex_like_dislike['v-switch-anon-comment'])){
					if(!get_comment_meta(get_comment_ID(),$user_key,true) == ''){
						$current_user = get_comment_meta(get_comment_ID(),$user_key,true);
						$current_user_liked = $current_user['liked'];
				
						if($current_user_liked == 'noliked'){
							return 'vortex-p-like-active-comment';
						}
					}
				}

		}

		function vortex_system_get_total_likes_comment(){
			
				$likes = get_comment_meta(get_comment_ID(),'vortex_system_likes',true);
			
				if(empty($likes)){
					return 0;
				}elseif(!$likes == ''){
				 return $dislikes = get_comment_meta(get_comment_ID(),'vortex_system_likes',true);
				}
		}

		function vortex_system_get_total_dislikes_comment(){
			
				$dislikes = get_comment_meta(get_comment_ID(),'vortex_system_dislikes',true);
			
				if(empty($dislikes)){
					return 0;
				}elseif(!$dislikes == ''){
				 return $dislikes = get_comment_meta(get_comment_ID(),'vortex_system_dislikes',true);
				}
		}
		
		function vortex_system_get_like_icon_comment(){
			global $vortex_like_dislike;
			
			if($vortex_like_dislike['v_button_style_comment'] == '1'){
				return 'icon-thumbs-up-1';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '2'){
				return 'icon-thumbs-up-alt';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '3'){
				return 'icon-thumbs-up';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '4'){
				return 'icon-thumbs-up-3';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '5'){
				return 'icon-thumbs-up-4';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '6'){
				return 'icon-thumbs-up-2';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '7'){
				return 'icon-plus-circled';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '8'){
				return 'icon-plus';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '9'){
				return 'icon-up';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '10'){
				return 'icon-up-big';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '11'){
				return 'icon-heart';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '12'){
				return 'icon-star';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '13'){
				return 'icon-ok-circle';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '14'){
				return 'icon-ok';
			}
			
		}
		
		function vortex_system_get_dislike_icon_comment(){
			global $vortex_like_dislike;
			
			if($vortex_like_dislike['v_button_style_comment'] == '1'){
				return 'icon-thumbs-down-1';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '2'){
				return 'icon-thumbs-down-alt';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '3'){
				return 'icon-thumbs-down';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '4'){
				return 'icon-thumbs-down-3';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '5'){
				return 'icon-thumbs-down-4';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '6'){
				return 'icon-thumbs-down-2';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '7'){
				return 'icon-minus-circled';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '8'){
				return 'icon-minus';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '9'){
				return 'icon-down';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '10'){
				return 'icon-down-big';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '11'){
				return 'icon-heart-broken';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '12'){
				return 'icon-star-empty';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '13'){
				return 'icon-cancel-circle';
			}elseif($vortex_like_dislike['v_button_style_comment'] == '14'){
				return 'icon-cancel';
			}
			
			
		}
	
		function vortex_system_dislike_counter_comment(){
			
			global $vortex_like_dislike;
			if ($vortex_like_dislike['v_custom_text_com_keep'] && vortex_system_add_dislike_class_comment() == 'vortex-p-dislike-active-comment'){
				if(!$vortex_like_dislike['v-switch-anon-counter-comment'] || is_user_logged_in()){
					return '<span class="vortex-p-dislike-counter-comment '.get_comment_ID(). '">'.$vortex_like_dislike['v_custom_text_com_dislike'].'</span>';
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-counter-comment'] || is_user_logged_in()){
					return '<span class="vortex-p-dislike-counter-comment '.get_comment_ID(). '">'. vortex_system_get_total_dislikes_comment().'</span>';
			}
		}
	
		function vortex_system_render_dislike_button_comment(){
			//leave it inline because wordpress will add <p> tags creating a space I don't know why
			return	'<div class="vortex-container-dislike-comment"><input type="hidden" value="'.get_comment_ID().'" ></input><div class="vortex-p-dislike-comment '.get_comment_ID().' '. vortex_system_add_dislike_class_comment() .' '.vortex_system_get_dislike_icon_comment().'">'.vortex_system_dislike_counter_comment().'</div></div>';
			
		}
		
		function vortex_system_like_counter_comment(){
			
			global $vortex_like_dislike;
			if ($vortex_like_dislike['v_custom_text_com_keep'] && vortex_system_add_like_class_comment() == 'vortex-p-like-active-comment'){
				if(!$vortex_like_dislike['v-switch-anon-counter-comment'] || is_user_logged_in()){
					return 	'<span  class="vortex-p-like-counter-comment '. get_comment_ID().'">'.$vortex_like_dislike['v_custom_text_com_like'].'</span>';
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-counter-comment'] || is_user_logged_in()){
				return 	'<span  class="vortex-p-like-counter-comment '. get_comment_ID().'">'.vortex_system_get_total_likes_comment().'</span>';
			}
			
		}
		
		function vortex_button_align_comment(){
			global $vortex_like_dislike;
			
			if($vortex_like_dislike['vortex-button-align-comment'] == '1'){
				return 'vortex-align-left';
			}elseif($vortex_like_dislike['vortex-button-align-comment'] == '2'){
				return 'vortex-align-center';
			}else{
				return 'vortex-align-right';
			}
		}
		
		function vortex_render_for_comments(){
			
			global $vortex_like_dislike;
			
			if(!$vortex_like_dislike['v-switch-dislike-comment']){
			//leave it inline because wordpress will add <p> tags creating a space I don't know why	
			$buttons = '<div class="vortex-container-vote-comment '.vortex_button_align_comment().'"><div class="vortex-container-like-comment"><input type="hidden" value="'.get_comment_ID().'" ></input><div class="vortex-p-like-comment '.get_comment_ID().' '.vortex_system_add_like_class_comment().' '.vortex_system_get_like_icon_comment().'">'.vortex_system_like_counter_comment().'</div></div>'.vortex_system_render_dislike_button_comment().'</div>';
				
				return $buttons;
			}else {
				//leave it inline because wordpress will add <p> tags creating a space I don't know why
				$buttons = '<div class="vortex-container-vote-comment '.vortex_button_align_comment().'"><div class="vortex-container-like-comment"><input type="hidden" value="'.get_comment_ID().'" ></input><div class="vortex-p-like-comment '.get_comment_ID().' '.vortex_system_add_like_class_comment().' '.vortex_system_get_like_icon_comment().'">'.vortex_system_like_counter_comment().'</div></div></div>';
				
				return $buttons;
			}
			
		}
	
	function vortex_system_insert_comments(){

	global $vortex_like_dislike;

		function vortex_system_before_comment($comment_text){
			
			global $vortex_like_dislike;
			
			if(!empty($vortex_like_dislike['v_exclude_category_comment'])){
				$array = $vortex_like_dislike['v_exclude_category_comment'];
				if(has_category($array)){
					return $comment_text;
				}
			}
			
			if(!empty($vortex_like_dislike['v_exclude_post_types'])){
				$array = $vortex_like_dislike['v_exclude_post_types'];
				if(in_array(get_post_type(get_the_ID()),$array)){
					return $comment_text;
				}
			}

			return vortex_render_for_comments().$comment_text;
			
		}
	
		function vortex_system_after_comment($comment_text){
			
			global $vortex_like_dislike;
			
			if(!empty($vortex_like_dislike['v_exclude_post_types'])){
				$array = $vortex_like_dislike['v_exclude_post_types'];
				if(in_array(get_post_type(get_the_ID()),$array)){
					return $comment_text;
				}
			}
			
			if(!empty($vortex_like_dislike['v_exclude_category_comment'])){
				$array = $vortex_like_dislike['v_exclude_category_comment'];
				if(has_category($array)){
					return $comment_text;
				}
			}
			
			return $comment_text.vortex_render_for_comments();
		}
		
		if($vortex_like_dislike['v_button_visibility_comments'][1] && $vortex_like_dislike['v_button_visibility_comments'][2] ){
			add_filter('comment_text','vortex_system_before_comment');
			add_filter('comment_text','vortex_system_after_comment');
		}elseif($vortex_like_dislike['v_button_visibility_comments'][1]){
			add_filter('comment_text','vortex_system_before_comment');
		}elseif($vortex_like_dislike['v_button_visibility_comments'][2]){
			add_filter('comment_text','vortex_system_after_comment');
		}

	}
	add_action('wp','vortex_system_insert_comments');
	
	$epoch = get_option('epoch');
	$epoch_var = $epoch['options']['theme'];
	
	if(!$vortex_like_dislike['v_enable_epoch']){	
		
	function vortex_print_styles_comments(){
		global $vortex_like_dislike;
		?> 
		<style>.vortex-container-like-comment,.vortex-container-dislike-comment{font-size:<?php echo $vortex_like_dislike['vortex-buttons-size-comment']['font-size']?>}.vortex-p-like-comment, .vortex-p-dislike-comment{color:<?php echo $vortex_like_dislike['v_default_color_comment'] ?>;}.vortex-p-like-comment:hover{color:<?php echo $vortex_like_dislike['v_like_color_comment'] ?>;}.vortex-p-like-active-comment{color: <?php echo $vortex_like_dislike['v_like_active_color_comment'] ?>;}.vortex-p-dislike-comment:hover{color: <?php echo $vortex_like_dislike['v_dislike_color_comment'] ?>;}.vortex-p-dislike-active-comment{color: <?php echo $vortex_like_dislike['v_dislike_active_color_comment'] ?>;}</style>
		<?php
	}
	add_action('wp_head','vortex_print_styles_comments');
		
	function vortex_system_styles_scripts_comments(){
		global $vortex_like_dislike;
			
			if(is_user_logged_in()){
				wp_enqueue_script( 'jquery' );
				wp_enqueue_style( 'vortex_like_or_dislike_comment', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
				if(!$vortex_like_dislike['v-switch-dislike-comment']){
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_like_or_dislike_comment_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_like_or_dislike_comment_js', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
				}else{
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_no_dislike_js_comment', plugin_dir_url( __FILE__ ).'assets/js/no-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_no_dislike_js_comment', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' ),
						'color' => esc_js($vortex_like_dislike['v_default_color_comment'])
						)
					);
				}
			}elseif($vortex_like_dislike['v-switch-anon-comment']){
				wp_enqueue_style( 'vortex_like_or_dislike_comment', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
				wp_enqueue_script( 'jquery' );
				if(!$vortex_like_dislike['v-switch-dislike-comment']){
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_like_or_dislike_comment_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_like_or_dislike_comment_js', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
				}else{
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_no_dislike_js_comment', plugin_dir_url( __FILE__ ).'assets/js/no-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_no_dislike_js_comment', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' ),
						'color' => esc_js($vortex_like_dislike['v_default_color_comment'])
						)
					);
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-comment'] && !is_user_logged_in()){
				wp_enqueue_style( 'vortex_like_or_dislike_comment', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
			}
	}
	add_action('wp_enqueue_scripts','vortex_system_styles_scripts_comments');
	}elseif($epoch_var == 'iframe' && $vortex_like_dislike['v_enable_epoch']){
		
		function vortex_epoch_css(){
			global $vortex_like_dislike;
			echo "<link rel='stylesheet' href='".plugin_dir_url( __FILE__ ).'assets/css/style.css'."' type='text/css' media='all'>";
			?> 
			<style>.vortex-container-like-comment,.vortex-container-dislike-comment{font-size:<?php echo $vortex_like_dislike['vortex-buttons-size-comment']['font-size']?>}.vortex-p-like-comment, .vortex-p-dislike-comment{color:<?php echo $vortex_like_dislike['v_default_color_comment'] ?>;}.vortex-p-like-comment:hover{color:<?php echo $vortex_like_dislike['v_like_color_comment'] ?>;}.vortex-p-like-active-comment{color: <?php echo $vortex_like_dislike['v_like_active_color_comment'] ?>;}.vortex-p-dislike-comment:hover{color: <?php echo $vortex_like_dislike['v_dislike_color_comment'] ?>;}.vortex-p-dislike-active-comment{color: <?php echo $vortex_like_dislike['v_dislike_active_color_comment'] ?>;}</style>
			<?php
		}
		add_action('epoch_iframe_footer','vortex_epoch_css');
		
		include(plugin_dir_path( __FILE__ ).'epoch.php');
		if($vortex_like_dislike['v_button_visibility_comments'][1] && $vortex_like_dislike['v_button_visibility_comments'][2] ){
			add_filter('comment_text','vortex_render_epoch_after',10,2);
			add_filter('comment_text','vortex_render_epoch_before',10,2);
		}elseif($vortex_like_dislike['v_button_visibility_comments'][1]){
			add_filter('comment_text','vortex_render_epoch_before',10,2);
		}elseif($vortex_like_dislike['v_button_visibility_comments'][2]){
			add_filter('comment_text','vortex_render_epoch_after',10,2);
		}
		
		if(is_user_logged_in()){
				if(!$vortex_like_dislike['v-switch-dislike-comment']){
					wp_register_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_register_script( 'vortex_like_or_dislike_comment_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_like_or_dislike_comment_js', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
					add_filter( 'epoch_iframe_scripts', 'vortex_iframe_scripts_1');
						function vortex_iframe_scripts_1($handles){
							$my_script_handles  = array( 'vortex_touchevents', 'vortex_like_or_dislike_comment_js' );
							if ( ! empty( $handles ) && is_array( $handles ) ) {
								$handles = array_merge( $handles, $my_script_handles );
							}else{
								$handles = $my_script_handles;
							}

							return $handles;
						}
				}else{
					wp_register_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_register_script( 'vortex_no_dislike_js_comment', plugin_dir_url( __FILE__ ).'assets/js/no-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_no_dislike_js_comment', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' ),
						'color' => esc_js($vortex_like_dislike['v_default_color_comment'])
						)
					);
					add_filter( 'epoch_iframe_scripts', 'vortex_iframe_scripts_2');
						function vortex_iframe_scripts_2($handles){
							$my_script_handles  = array( 'vortex_touchevents', 'vortex_no_dislike_js_comment' );
							if ( ! empty( $handles ) && is_array( $handles ) ) {
								$handles = array_merge( $handles, $my_script_handles );
							}else{
								$handles = $my_script_handles;
							}

							return $handles;
						}
				}
			}elseif($vortex_like_dislike['v-switch-anon-comment']){
				if(!$vortex_like_dislike['v-switch-dislike-comment']){
					wp_register_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_register_script( 'vortex_like_or_dislike_comment_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_like_or_dislike_comment_js', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
					add_filter( 'epoch_iframe_scripts','vortex_iframe_scripts_3');
						function vortex_iframe_scripts_3($handles){
							$my_script_handles  = array( 'vortex_touchevents', 'vortex_like_or_dislike_comment_js' );
							if ( ! empty( $handles ) && is_array( $handles ) ) {
								$handles = array_merge( $handles, $my_script_handles );
							}else{
								$handles = $my_script_handles;
							}

							return $handles;
						}
				}else{
					wp_register_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_register_script( 'vortex_no_dislike_js_comment', plugin_dir_url( __FILE__ ).'assets/js/no-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_no_dislike_js_comment', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' ),
						'color' => esc_js($vortex_like_dislike['v_default_color_comment'])
						)
					);
					add_filter( 'epoch_iframe_scripts', 'vortex_iframe_scripts_4');
						function vortex_iframe_scripts_4($handles){
							$my_script_handles  = array( 'vortex_touchevents', 'vortex_no_dislike_js_comment' );
							if ( ! empty( $handles ) && is_array( $handles ) ) {
								$handles = array_merge( $handles, $my_script_handles );
							}else{
								$handles = $my_script_handles;
							}

							return $handles;
						}
				}
			}
	}elseif($vortex_like_dislike['v_enable_epoch']){
		//Epoch support
		if($vortex_like_dislike['v_enable_epoch']){
			include(plugin_dir_path( __FILE__ ).'epoch.php');
			if($vortex_like_dislike['v_button_visibility_comments'][1] && $vortex_like_dislike['v_button_visibility_comments'][2] ){
				add_filter('comment_text','vortex_render_epoch_after',10,2);
				add_filter('comment_text','vortex_render_epoch_before',10,2);
			}elseif($vortex_like_dislike['v_button_visibility_comments'][1]){
				add_filter('comment_text','vortex_render_epoch_before',10,2);
			}elseif($vortex_like_dislike['v_button_visibility_comments'][2]){
				add_filter('comment_text','vortex_render_epoch_after',10,2);
			}
		}
		function vortex_print_styles_comments(){
		global $vortex_like_dislike;
		?> 
		<style>.vortex-container-like-comment,.vortex-container-dislike-comment{font-size:<?php echo $vortex_like_dislike['vortex-buttons-size-comment']['font-size']?>}.vortex-p-like-comment, .vortex-p-dislike-comment{color:<?php echo $vortex_like_dislike['v_default_color_comment'] ?>;}.vortex-p-like-comment:hover{color:<?php echo $vortex_like_dislike['v_like_color_comment'] ?>;}.vortex-p-like-active-comment{color: <?php echo $vortex_like_dislike['v_like_active_color_comment'] ?>;}.vortex-p-dislike-comment:hover{color: <?php echo $vortex_like_dislike['v_dislike_color_comment'] ?>;}.vortex-p-dislike-active-comment{color: <?php echo $vortex_like_dislike['v_dislike_active_color_comment'] ?>;}</style>
		<?php
	}
	add_action('wp_head','vortex_print_styles_comments');
		
	function vortex_system_styles_scripts_comments(){
		global $vortex_like_dislike;
			
			if(is_user_logged_in()){
				wp_enqueue_script( 'jquery' );
				wp_enqueue_style( 'vortex_like_or_dislike_comment', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
				if(!$vortex_like_dislike['v-switch-dislike-comment']){
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_like_or_dislike_comment_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_like_or_dislike_comment_js', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
				}else{
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_no_dislike_js_comment', plugin_dir_url( __FILE__ ).'assets/js/no-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_no_dislike_js_comment', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' ),
						'color' => esc_js($vortex_like_dislike['v_default_color_comment'])
						)
					);
				}
			}elseif($vortex_like_dislike['v-switch-anon-comment']){
				wp_enqueue_style( 'vortex_like_or_dislike_comment', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
				wp_enqueue_script( 'jquery' );
				if(!$vortex_like_dislike['v-switch-dislike-comment']){
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_like_or_dislike_comment_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_like_or_dislike_comment_js', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
				}else{
					wp_enqueue_script( 'vortex_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array('jquery'), '1.0',true);
					wp_enqueue_script( 'vortex_no_dislike_js_comment', plugin_dir_url( __FILE__ ).'assets/js/no-dislike-comments.js', array('jquery'), '1.0',true);
					wp_localize_script( 'vortex_no_dislike_js_comment', 'vortex_ajax_comment', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' ),
						'color' => esc_js($vortex_like_dislike['v_default_color_comment'])
						)
					);
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-comment'] && !is_user_logged_in()){
				wp_enqueue_style( 'vortex_like_or_dislike_comment', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
			}
	}
	add_action('wp_enqueue_scripts','vortex_system_styles_scripts_comments');
		//end epoch support
	}
	//end epoch support
	
	if($vortex_like_dislike['v-switch-columns-comment']){
			
			add_filter( 'manage_edit-comments_columns', 'vortex_system_columns_comments' ) ;

			function vortex_system_columns_comments( $columns ) {
				
				global $vortex_like_dislike;
				$domain = 'vortex_system_ld';
				$columns['likes'] = __('Likes',$domain);
				
				if(!$vortex_like_dislike['v-switch-dislike-comment']){
					$columns['dislikes'] = __('Dislikes',$domain);
				}

				return $columns;
			}

			add_action( 'manage_comments_custom_column', 'vortex_system_columns_value_comments', 10, 2 );

			function vortex_system_columns_value_comments( $column, $comment_ID ) {
				global $post;
				
				switch( $column ) {

					case 'likes' :

						$likes = get_comment_meta( $comment_ID, 'vortex_system_likes', true );

						if ( empty( $likes ) )
							echo '0';

						else
							echo $likes;

						break;
		
		
					case 'dislikes' :

						$dislikes = get_comment_meta( $comment_ID, 'vortex_system_dislikes', true );

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
		}

	if($vortex_like_dislike['v-switch-order-comment']){
		function vortex_system_order_comments($comments) {
			unset($comments);
			global $wp_query, $withcomments, $post, $wpdb, $id, $comment, $user_login, $user_ID, $user_identity, $overridden_cpage;

		if ( !(is_single() || is_page() || $withcomments) || empty($post) )
			return;

		if ( empty($file) )
			$file = '/comments.php';

		$req = get_option('require_name_email');

		/*
		 * Comment author information fetched from the comment cookies.
		 */
		$commenter = wp_get_current_commenter();

		/*
		 * The name of the current comment author escaped for use in attributes.
		 * Escaped by sanitize_comment_cookies().
		 */
		$comment_author = $commenter['comment_author'];

		/*
		 * The email address of the current comment author escaped for use in attributes.
		 * Escaped by sanitize_comment_cookies().
		 */
		$comment_author_email = $commenter['comment_author_email'];

		/*
		 * The url of the current comment author escaped for use in attributes.
		 */
		$comment_author_url = esc_url($commenter['comment_author_url']);

		$comment_args = array(
			'order'   => 'ASC',
			'orderby' => 'meta_value_num',
			'meta_key' => 'vortex_system_likes',
			'status'  => 'approve',
			'post_id' => $post->ID,
		);

		if ( $user_ID ) {
			$comment_args['include_unapproved'] = array( $user_ID );
		} elseif ( ! empty( $comment_author_email ) ) {
			$comment_args['include_unapproved'] = array( $comment_author_email );
		}

		$comments = get_comments( $comment_args );
		return $comments;
		}	
		add_filter ('comments_array', 'vortex_system_order_comments');
	}
}
