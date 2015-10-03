<?php

	add_action( 'wp_dashboard_setup', 'vortex_dashboard_setup' );
	add_action( 'admin_enqueue_scripts', 'vortex_dashboard_engine' );
	function vortex_statistics_posts($width,$height){
			
		$all_posts = get_posts(array('posts_per_page'=>-1));
		$likes = 0;
		$dislikes = 0;
		
		foreach ($all_posts as $post){
			$likes += get_post_meta($post->ID, 'vortex_system_likes',true);
			$dislikes += get_post_meta($post->ID, 'vortex_system_dislikes',true);
		}
		if($likes > 0 || $dislikes > 0){
			echo "<script type=\"text/javascript\">
			  google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});
			  google.setOnLoadCallback(drawChart);
			  function drawChart() {
				var data = google.visualization.arrayToDataTable([
				  ['Task', 'Posts'],
				  ['Likes',     ".absint($likes)."],
				  ['Dislikes',  ".absint($dislikes)."]
				]);

				var options = {
				  title: 'Posts',
				  pieHole: 0.4,
				  pieSliceTextStyle: {
					color: 'black',
				  },
				};

				var chart = new google.visualization.PieChart(document.getElementById('vortex-posts'));
				chart.draw(data, options);
			  }
			</script><div style=\"width: ".$width."; height:".$height.";\" id=\"vortex-posts\"></div>";
		}else return true;
	}

	function vortex_statistics_comments($width,$height){
			
		$likes = 0;
		$dislikes = 0;
		
		$all_comments = get_comments();
		foreach($all_comments as $comment){
			$likes += get_comment_meta($comment->comment_ID, 'vortex_system_likes',true);
			$dislikes += get_comment_meta($comment->comment_ID, 'vortex_system_dislikes',true);
		}
		if($likes > 0 || $dislikes > 0){
			echo "<script type=\"text/javascript\">
			  google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});
			  google.setOnLoadCallback(drawChart);
			  function drawChart() {
				var data = google.visualization.arrayToDataTable([
				  ['Task', 'Comments'],
				  ['Likes',     ".absint($likes)."],
				  ['Dislikes',  ".absint($dislikes)."]
				]);

				var options = {
				  title: 'Comments',
				  pieHole: 0.4,
				  pieSliceTextStyle: {
					color: 'black',
			     },
				};

				var chart = new google.visualization.PieChart(document.getElementById('vortex-comments'));
				chart.draw(data, options);
			  }
			</script><div style=\"width: ".$width."; height:".$height.";\" id=\"vortex-comments\"></div>";
		}else return true;
	}

	function vortex_dashboard_setup() {
		wp_add_dashboard_widget(
			'vortex-dashboard-widget',
			'Like and dislike statistics' ,
			'vortex_dashboard_content',
			$control_callback = null
		);
	} 

	function vortex_dashboard_content() {
		global $vortex_like_dislike;
		$domain = 'vortex_system_ld';
		if(isset($vortex_like_dislike)){
				if($vortex_like_dislike['v_button_statistic'][1] == '1' && $vortex_like_dislike['v_button_statistic'][2] == '1'){
				if(vortex_statistics_posts('50%','50%')){
					_e('No data for posts.',$domain);echo'<br>';
				}else vortex_statistics_posts('50%','50%');
				if(vortex_statistics_comments('50%','50%')){
					_e('No data for comments.',$domain);echo'<br>';
				}else vortex_statistics_comments('50%','50%');
			}elseif($vortex_like_dislike['v_button_statistic'][1] == '1'){
				if(vortex_statistics_posts('50%','50%')){
					_e('No data for posts.',$domain);echo'<br>';
				}else vortex_statistics_posts('50%','50%');
			}elseif($vortex_like_dislike['v_button_statistic'][2] == '1'){
				if(vortex_statistics_comments('50%','50%')){
					_e('No data for comments.',$domain);echo'<br>';
				}else vortex_statistics_comments('50%','50%');
			}
		}	
	} 

	function vortex_dashboard_engine( $hook ) {
		if( 'index.php' != $hook )
			return; 

		wp_enqueue_script(
			'google_chart_vortex',
			'https://www.google.com/jsapi',
			null, null, false
		);
	}