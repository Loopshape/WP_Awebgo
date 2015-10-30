<?php 

		function vortex_system_add_dislike_class_comment_epoch($id){
				global $vortex_like_dislike;
			
				if(is_user_logged_in()){
					$current_user_id = get_current_user_id();
					$user_key = 'vortex_system_user_'.$current_user_id;
				}elseif(!is_user_logged_in() && $vortex_like_dislike['v-switch-anon-comment']){
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					$user_key = 'vortex_system_user_'.$user_ip;
				};
				if(is_user_logged_in() || (!is_user_logged_in() && $vortex_like_dislike['v-switch-anon-comment'])){
					if(!get_comment_meta($id,$user_key,true) == ''){
						$current_user = get_comment_meta($id,$user_key,true);
						$current_user_disliked = $current_user['disliked'];
							
						if($current_user_disliked == 'nodisliked'){
							return 'vortex-p-dislike-active-comment';
						}else{
							return'';	
						}
					}
				}	
		}

		function vortex_system_add_like_class_comment_epoch($id){
				global $vortex_like_dislike;
				
				if(is_user_logged_in()){
					$current_user_id = get_current_user_id();
					$user_key = 'vortex_system_user_'.$current_user_id;
				}elseif(!is_user_logged_in() && $vortex_like_dislike['v-switch-anon-comment']){
					$user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
					$user_key = 'vortex_system_user_'.$user_ip;
				};
				if(is_user_logged_in() || (!is_user_logged_in() && $vortex_like_dislike['v-switch-anon-comment'])){
					if(!get_comment_meta($id,$user_key,true) == ''){
						$current_user = get_comment_meta($id,$user_key,true);
						$current_user_liked = $current_user['liked'];
				
						if($current_user_liked == 'noliked'){
							return 'vortex-p-like-active-comment';
						}
					}
				}

		}

		function vortex_system_get_total_likes_comment_epoch($id){
			
				$likes = get_comment_meta($id,'vortex_system_likes',true);
			
				if(empty($likes)){
					return 0;
				}elseif(!$likes == ''){
				 return $dislikes = get_comment_meta($id,'vortex_system_likes',true);
				}
		}

		function vortex_system_get_total_dislikes_comment_epoch($id){
			
				$dislikes = get_comment_meta($id,'vortex_system_dislikes',true);
			
				if(empty($dislikes)){
					return 0;
				}elseif(!$dislikes == ''){
				 return $dislikes = get_comment_meta($id,'vortex_system_dislikes',true);
				}
		}

		function vortex_system_dislike_counter_comment_epoch($id){
			
			global $vortex_like_dislike;
			if ($vortex_like_dislike['v_custom_text_com_keep'] && vortex_system_add_dislike_class_comment_epoch($id) == 'vortex-p-dislike-active-comment'){
				if(!$vortex_like_dislike['v-switch-anon-counter-comment'] || is_user_logged_in()){
					return '<span class="vortex-p-dislike-counter-comment '.$id. '">'.$vortex_like_dislike['v_custom_text_com_dislike'].'</span>';
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-counter-comment'] || is_user_logged_in()){
					return '<span class="vortex-p-dislike-counter-comment '.$id. '">'. vortex_system_get_total_dislikes_comment_epoch($id).'</span>';
			}
		}

		function vortex_system_like_counter_comment_epoch($id){
			
			global $vortex_like_dislike;
			if ($vortex_like_dislike['v_custom_text_com_keep'] && vortex_system_add_like_class_comment_epoch($id) == 'vortex-p-like-active-comment'){
				if(!$vortex_like_dislike['v-switch-anon-counter-comment'] || is_user_logged_in()){
					return 	'<span  class="vortex-p-like-counter-comment '.$id.'">'.$vortex_like_dislike['v_custom_text_com_like'].'</span>';
				}
			}elseif(!$vortex_like_dislike['v-switch-anon-counter-comment'] || is_user_logged_in()){
				return 	'<span  class="vortex-p-like-counter-comment '. $id.'">'.vortex_system_get_total_likes_comment_epoch($id).'</span>';
			}
			
		}

		function vortex_system_render_dislike_button_comment_epoch($id){
			//leave it inline because wordpress will add <p> tags creating a space I don't know why
			return	'<div class="vortex-container-dislike-comment"><input type="hidden" value="'.$id.'" ></input><div class="vortex-p-dislike-comment '.$id.' '. vortex_system_add_dislike_class_comment_epoch($id) .' '.vortex_system_get_dislike_icon_comment().'">'.vortex_system_dislike_counter_comment_epoch($id).'</div></div>';
			
		}

function vortex_render_for_comments_epoch($id){
			
			global $vortex_like_dislike;

			if(!$vortex_like_dislike['v-switch-dislike-comment']){
			//leave it inline because wordpress will add <p> tags creating a space I don't know why	
			$buttons = '<div class="vortex-container-vote-comment '.vortex_button_align_comment().'"><div class="vortex-container-like-comment"><input type="hidden" value="'.$id.'" ></input><div class="vortex-p-like-comment '.$id.' '.vortex_system_add_like_class_comment_epoch($id).' '.vortex_system_get_like_icon_comment().'">'.vortex_system_like_counter_comment_epoch($id).'</div></div>'.vortex_system_render_dislike_button_comment_epoch($id).'</div>';
				
				return $buttons;
			}else {
				//leave it inline because wordpress will add <p> tags creating a space I don't know why
				$buttons = '<div class="vortex-container-vote-comment '.vortex_button_align_comment().'"><div class="vortex-container-like-comment"><input type="hidden" value="'.$id.'" ></input><div class="vortex-p-like-comment '.$id.' '.vortex_system_add_like_class_comment_epoch($id).' '.vortex_system_get_like_icon_comment().'">'.vortex_system_like_counter_comment_epoch($id).'</div></div></div>';
				
				return $buttons;
			}
			
}
function vortex_render_epoch_before($comment_text,$comment){
	$temp = (array)$comment;
	return vortex_render_for_comments_epoch($temp['comment_ID']).$comment_text;
}

function vortex_render_epoch_after($comment_text,$comment){
	$temp = (array)$comment;
	return $comment_text.vortex_render_for_comments_epoch($temp['comment_ID']);
}
?>