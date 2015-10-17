<?php
global $vortex_like_dislike;
function vortex_system_add_dislike_class_buddypress($id){
				global $vortex_like_dislike;
			
				if(is_user_logged_in()){
					$current_user_id = get_current_user_id();
					$user_key = 'vortex_system_user_'.$current_user_id;
				}elseif(!is_user_logged_in() && $vortex_like_dislike['v-switch-anon']){
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					$user_key = 'vortex_system_user_'.$user_ip;
				};
				if(is_user_logged_in() || (!is_user_logged_in() && $vortex_like_dislike['v-switch-anon'])){
					if(!get_post_meta($id,$user_key,true) == ''){
						$current_user = get_post_meta($id,$user_key,true);
						$current_user_disliked = $current_user['disliked'];
							
						if($current_user_disliked == 'nodisliked'){
							return 'vortex-p-dislike-active';
						}
					}
				}
		}

function vortex_system_get_total_dislikes_buddypress($id){
			
				$dislikes = get_post_meta($id,'vortex_system_dislikes',true);
			
				if(empty($dislikes)){
					return 0;
				}elseif(!$dislikes == ''){
				 return $dislikes = get_post_meta($id,'vortex_system_dislikes',true);
				}
		}

function vortex_system_dislike_counter_buddypress($id){
			
			global $vortex_like_dislike;
			if ($vortex_like_dislike['v_custom_text_post_keep'] && vortex_system_add_dislike_class_buddypress($id) == 'vortex-p-dislike-active'){
				if(!$vortex_like_dislike['v-switch-anon-counter'] || is_user_logged_in()){
					return '<span class="vortex-p-dislike-counter '.$id. '">'.$vortex_like_dislike['v_custom_text_post_dislike'].'</span>';
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-counter'] || is_user_logged_in()){
				return '<span class="vortex-p-dislike-counter '.$id. '">'. vortex_system_get_total_dislikes_buddypress($id).'</span>';
			}
			
		}

function vortex_system_render_dislike_button_buddypress($id){
			/*dev use the same as below
			return	'<div class="vortex-container-dislike">	
					<input type="hidden" value="'.get_the_ID().'" ></input>
					<div class="vortex-p-dislike '.get_the_ID().' '. vortex_system_add_dislike_class() .' '.vortex_system_get_dislike_icon().'">
						'.vortex_system_dislike_counter().'
					</div>	
				</div>';
			
			*/
			return	'<div class="vortex-container-dislike"><input type="hidden" value="'.$id.'" ></input><div class="vortex-p-dislike '.$id.' '. vortex_system_add_dislike_class_buddypress($id) .' '.vortex_system_get_dislike_icon().'">'.vortex_system_dislike_counter_buddypress($id).'</div></div>';
			
		}

function vortex_system_add_like_class_buddypress($id){
				global $vortex_like_dislike;
				
				if(is_user_logged_in()){
					$current_user_id = get_current_user_id();
					$user_key = 'vortex_system_user_'.$current_user_id;
				}elseif(!is_user_logged_in() && $vortex_like_dislike['v-switch-anon']){
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					$user_key = 'vortex_system_user_'.$user_ip;
				};
				if(is_user_logged_in() || (!is_user_logged_in() && $vortex_like_dislike['v-switch-anon'])){
					if(!get_post_meta($id,$user_key,true) == ''){
						$current_user = get_post_meta($id,$user_key,true);
						$current_user_liked = $current_user['liked'];
					
					if($current_user_liked == 'noliked'){
							return 'vortex-p-like-active';
						}
					}
						
				}
		}

function vortex_system_get_total_likes_buddypress($id){
			
				$likes = get_post_meta($id,'vortex_system_likes',true);
			
				if(empty($likes)){
					return 0;
				}elseif(!$likes == ''){
				 return $dislikes = get_post_meta($id,'vortex_system_likes',true);
				}
		}
function vortex_system_like_counter_buddypress($id){
			
			global $vortex_like_dislike;
			if ($vortex_like_dislike['v_custom_text_post_keep'] && vortex_system_add_like_class_buddypress($id) == 'vortex-p-like-active'){
				if(!$vortex_like_dislike['v-switch-anon-counter'] || is_user_logged_in()){
					return 	'<span  class="vortex-p-like-counter '. $id.'">'.$vortex_like_dislike['v_custom_text_post_like'].'</span>';
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-counter'] || is_user_logged_in()){
				return 	'<span  class="vortex-p-like-counter '. $id.'">'.vortex_system_get_total_likes_buddypress($id).'</span>';
			}	

			
		}

function vortex_buddypress_render($id){
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
			$buttons = '<div class="vortex-container-vote '.vortex_button_align().'"><div class="vortex-container-like"><input type="hidden" value="'.$id.'" ></input><div class="vortex-p-like '.$id.' '.vortex_system_add_like_class_buddypress($id).' '.vortex_system_get_like_icon().'">'.vortex_system_like_counter_buddypress($id).'</div></div>'.vortex_system_render_dislike_button_buddypress($id).'</div>';
				
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
				$buttons = '<div class="vortex-container-vote '.vortex_button_align().'"><div class="vortex-container-like"><input type="hidden" value="'.$id.'" ></input><div class="vortex-p-like '.$id.' '.vortex_system_add_like_class_buddypress($id).' '.vortex_system_get_like_icon().'">'.vortex_system_like_counter_buddypress($id).'</div></div></div>';
				
				return $buttons;
			}
}

function vortex_buddypress_after($content){
	return $content.vortex_buddypress_render(bp_get_activity_id());
}

function vortex_buddypress_before($content){
	return vortex_buddypress_render(bp_get_activity_id()).$content;
}

global $vortex_like_dislike;
if($vortex_like_dislike['v_button_visibility'][1] && $vortex_like_dislike['v_button_visibility'][2] ){
				add_filter('bp_get_activity_content_body','vortex_buddypress_after');
				add_filter('bp_get_activity_content_body','vortex_buddypress_before');
			}elseif($vortex_like_dislike['v_button_visibility'][1]){
				add_filter('bp_get_activity_content_body','vortex_buddypress_before');
			}elseif($vortex_like_dislike['v_button_visibility'][2]){
				add_filter('bp_get_activity_content_body','vortex_buddypress_after');
			}


