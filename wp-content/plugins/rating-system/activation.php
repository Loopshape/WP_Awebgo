<?php
function vortex_system_activate_plugin() {

    $all_comments = get_comments();
	foreach($all_comments as $comment){
		
		add_comment_meta($comment->comment_ID, 'vortex_system_likes', 0, true);
		add_comment_meta($comment->comment_ID, 'vortex_system_dislikes', 0, true);
	}
	
	$all_posts = get_posts(array('posts_per_page'=>-1));
	foreach ($all_posts as $post){
		add_post_meta($post->ID, 'vortex_system_likes', 0, true);
		add_post_meta($post->ID, 'vortex_system_dislikes', 0, true);
	}

}
register_activation_hook( plugin_dir_path( __FILE__ ).'rating-system.php', 'vortex_system_activate_plugin' );