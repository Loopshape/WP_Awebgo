<?php
/*
Plugin Name: WP Fastest Cache
Plugin URI: http://wordpress.org/plugins/wp-fastest-cache/
Description: The simplest and fastest WP Cache system
Version: 0.8.5.5
Author: Emre Vona
Author URI: http://tr.linkedin.com/in/emrevona

Copyright (C)2013 Emre Vona

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/ 
	if (!defined('WPFC_WP_CONTENT_BASENAME')) {
		if (!defined('WPFC_WP_PLUGIN_DIR')) {
			define("WPFC_WP_PLUGIN_DIR", preg_replace("/(\/trunk\/|\/wp-fastest-cache\/)$/", "", plugin_dir_path( __FILE__ )));
		}
		define("WPFC_WP_CONTENT_DIR", dirname(WPFC_WP_PLUGIN_DIR));
		define("WPFC_WP_CONTENT_BASENAME", basename(WPFC_WP_CONTENT_DIR));
	}

	if (!defined('WPFC_MAIN_PATH')) {
		define("WPFC_MAIN_PATH", plugin_dir_path( __FILE__ ));
	}

	class WpFastestCache{
		private $systemMessage = "";
		private $options = array();

		public function __construct(){

			$optimize_image_ajax_requests = array("wpfc_revert_image_ajax_request", 
												  "wpfc_statics_ajax_request",
												  "wpfc_optimize_image_ajax_request",
												  "wpfc_update_image_list_ajax_request"
												  );


			add_action( 'wp_ajax_wpfc_save_timeout_pages', array($this, 'wpfc_save_timeout_pages_callback'));
			add_action( 'wp_ajax_wpfc_save_exclude_pages', array($this, 'wpfc_save_exclude_pages_callback'));
			add_action( 'wp_ajax_wpfc_cdn_options_ajax_request', array($this, 'wpfc_cdn_options_ajax_request_callback'));
			add_action( 'wp_ajax_wpfc_remove_cdn_integration_ajax_request', array($this, 'wpfc_remove_cdn_integration_ajax_request_callback'));
			add_action( 'wp_ajax_wpfc_save_cdn_integration_ajax_request', array($this, 'wpfc_save_cdn_integration_ajax_request_callback'));
			add_action( 'wp_ajax_wpfc_cdn_template_ajax_request', array($this, 'wpfc_cdn_template_ajax_request_callback'));




			add_action( 'wp_ajax_wpfc_check_url_ajax_request', array($this, 'wpfc_check_url_ajax_request_callback'));

			add_action( 'wp_ajax_wpfc_cache_statics_get', array($this, 'wpfc_cache_statics_get_callback'));

			add_action( 'wp_ajax_wpfc_update_premium', array($this, 'wpfc_update_premium_callback'));


			add_action( 'rate_post', array($this, 'wp_postratings_clear_fastest_cache'), 10, 2);

			if(isset($_GET) && isset($_GET["action"]) && in_array($_GET["action"], $optimize_image_ajax_requests)){
				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					include_once $this->get_premium_path("image.php");
					$img = new WpFastestCacheImageOptimisation();
					$img->hook();
				}
			}else{
				$this->setCustomInterval();

				$this->options = $this->getOptions();

				add_action('transition_post_status',  array($this, 'on_all_status_transitions'), 10, 3 );

				$this->commentHooks();

				$this->checkCronTime();

				register_deactivation_hook( __FILE__, array('WpFastestCache', 'deactivate') );

				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					include_once $this->get_premium_path("mobile-cache.php");
				}

				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					include_once $this->get_premium_path("powerful-html.php");
				}

				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					if(file_exists(WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium/pro/library/statics.php")){
						include_once $this->get_premium_path("statics.php");
					}
				}

				if(is_admin()){
					//for wp-panel
					$this->setRegularCron();
					
					if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
						include_once $this->get_premium_path("image.php");
					}

					if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
						include_once $this->get_premium_path("logs.php");
					}

					$this->admin();
				}else{
					//for cache
					$this->cache();
				}
			}
		}

		public function wpfc_update_premium_callback(){
			if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
				if(!file_exists(WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium/pro/library/update.php")){
					$res = array("success" => false, "error_message" => "update.php is not exist");
				}else{
					include_once $this->get_premium_path("update.php");
					
					if(!class_exists("WpFastestCacheUpdate")){
						$res = array("success" => false, "error_message" => "WpFastestCacheUpdate is not exist");
					}else{
						$wpfc_premium = new WpFastestCacheUpdate();
						$content = $wpfc_premium->download_premium();

						if($content["success"]){
							$wpfc_zip_data = $content["content"];

							$wpfc_zip_dest_path = WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium.zip";

							if(@file_put_contents($wpfc_zip_dest_path, $wpfc_zip_data)){

								include_once ABSPATH."wp-admin/includes/file.php";
								include_once ABSPATH."wp-admin/includes/plugin.php";

								if(function_exists("unzip_file")){
									$this->rm_folder_recursively(WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium");
									
									if(!function_exists('gzopen')){
										$res = array("success" => false, "error_message" => "Missing zlib extension"); 
									}else{
										WP_Filesystem();
										$unzipfile = unzip_file($wpfc_zip_dest_path, WPFC_WP_PLUGIN_DIR."/");

										if ($unzipfile) {
											$result = activate_plugin( 'wp-fastest-cache-premium/wpFastestCachePremium.php' );

											if ( is_wp_error( $result ) ) {
												$res = array("success" => false, "error_message" => "Error occured while the plugin was activated"); 
											}else{
												$res = array("success" => true);
												$this->deleteCache(true);
											}
										} else {
											$res = array("success" => false, "error_message" => 'Error occured while the file was unzipped');      
										}
									}
									
								}else{
									$res = array("success" => false, "error_message" => "unzip_file() is not found");
								}
							}else{
								$res = array("success" => false, "error_message" => "/wp-content/plugins/ is not writable");
							}
						}else{
							$res = array("success" => false, "error_message" => $content["error_message"]);
						}
					}
				}
			}else{
				$res = array("success" => false, "error_message" => "Premium is not active");

			}

			echo json_encode($res);
			exit;
		}

		public function wpfc_cache_statics_get_callback(){
			if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
				if(file_exists(WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium/pro/library/statics.php")){
					include_once $this->get_premium_path("statics.php");
					
					$cache_statics = new WpFastestCacheStatics();
					$res = $cache_statics->get();
					echo json_encode($res);
					exit;
				}
			}
		}

		public function wpfc_check_url_ajax_request_callback(){
			$_GET["url"] = strip_tags($_GET["url"]);
			$_GET["url"] = str_replace(array("'", '"'), "", $_GET["url"]);
			
			if(!preg_match("/^http/", $_GET["url"])){
				$_GET["url"] = "http://".$_GET["url"];
			}
			
			$response = wp_remote_get($_GET["url"], array('timeout' => 10 ) );

			$header = wp_remote_retrieve_headers($response);

			if ( !$response || is_wp_error( $response ) ) {
				$res = array("success" => false, "error_message" => $response->get_error_message());
				
				if($response->get_error_code() == "http_request_failed"){
					if($response->get_error_message() == "Failure when receiving data from the peer"){
						$res = array("success" => true);
					}
				}
			}else{
				$response_code = wp_remote_retrieve_response_code( $response );
				if($response_code == 200){
					$res = array("success" => true);
				}else{
					if(method_exists($response, "get_error_message")){
						$res = array("success" => false, "error_message" => $response->get_error_message());
					}else{
						$res = array("success" => false, "error_message" => wp_remote_retrieve_response_message($response));
					}

					if(isset($header["server"]) && preg_match("/squid/i", $header["server"])){
						$res = array("success" => true);
					}
				}
			}
			echo json_encode($res);
			exit;
		}

		public function wpfc_cdn_template_ajax_request_callback(){
			ob_start();
			include_once(WPFC_MAIN_PATH."templates/cdn/".$_POST["id"].".php");
			$content = ob_get_contents();
			ob_end_clean();

			$res = array("success" => false, "content" => "");

			if($data = @file_get_contents(WPFC_MAIN_PATH."templates/cdn/".$_POST["id"].".php")){
				$res["success"] = true;
				$res["content"] = $content;
			}

			echo json_encode($res);
			exit;
		}

		public function wpfc_save_cdn_integration_ajax_request_callback(){
			$values = json_encode($_POST["values"]);
			if(get_option("WpFastestCacheCDN")){
				update_option("WpFastestCacheCDN", $values);
			}else{
				add_option("WpFastestCacheCDN", $values, null, "yes");
			}
			echo json_encode(array("success" => true));
			exit;
		}

		public function wpfc_remove_cdn_integration_ajax_request_callback(){
			delete_option("WpFastestCacheCDN");
			echo json_encode(array("success" => true));
			exit;
		}

		public function wpfc_cdn_options_ajax_request_callback(){
			$cdn_values = get_option("WpFastestCacheCDN");
			if($cdn_values){
				echo $cdn_values;
			}else{
				echo json_encode(array("success" => false)); 
			}
			exit;
		}

		public function wpfc_save_exclude_pages_callback(){
			$data = json_encode($_POST["rules"]);

			if(get_option("WpFastestCacheExclude")){
				update_option("WpFastestCacheExclude", $data);
			}else{
				add_option("WpFastestCacheExclude", $data, null, "yes");
			}

			echo json_encode(array("success" => true));
			exit;
		}

		public function wpfc_save_timeout_pages_callback(){
			$this->setCustomInterval();
			
	    	$crons = _get_cron_array();

	    	foreach ($crons as $cron_key => $cron_value) {
	    		foreach ( (array) $cron_value as $hook => $events ) {
	    			if(preg_match("/^wp\_fastest\_cache(.*)/", $hook, $id)){
	    				if(!$id[1] || preg_match("/^\_(\d+)$/", $id[1])){
	    					foreach ( (array) $events as $event_key => $event ) {
		    					if($id[1]){
		    						wp_clear_scheduled_hook("wp_fastest_cache".$id[1], $event["args"]);
		    					}else{
		    						wp_clear_scheduled_hook("wp_fastest_cache", $event["args"]);
		    					}
	    					}
	    				}
	    			}
	    		}
	    	}

			if(count($_POST["rules"]) > 0){
				$i = 0;

				foreach ($_POST["rules"] as $key => $value) {
					$args = array("prefix" => $value["prefix"], "content" => $value["content"]);

					wp_schedule_event(time(), $value["schedule"], "wp_fastest_cache_".$i, array(json_encode($args)));
					$i = $i + 1;
				}
			}

			echo json_encode(array("success" => true));
			exit;

		}

		public function wp_postratings_clear_fastest_cache($rate_userid, $post_id){
			// to remove cache if vote is from homepage or category page or tag
			if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"]){
				$url =  parse_url($_SERVER["HTTP_REFERER"]);

				$url["path"] = isset($url["path"]) ? $url["path"] : "/index.html";

				if(isset($url["path"])){
					if($url["path"] == "/"){
						$this->rm_folder_recursively($this->getWpContentDir()."/cache/all/index.html");
					}else{
						$this->rm_folder_recursively($this->getWpContentDir()."/cache/all".$url["path"]);
					}
				}
			}

			if($post_id){
				$this->singleDeleteCache(false, $post_id);
			}
		}

		private function admin(){
			include_once('inc/admin.php');
			$wpfc = new WpFastestCacheAdmin();
			$wpfc->addMenuPage();
		}
		private function cache(){
			include_once('inc/cache.php');
			$wpfc = new WpFastestCacheCreateCache();
			$wpfc->createCache();
		}

		public function deactivate(){
			$wpfc = new WpFastestCache();
			$path = ABSPATH;
			
			if($wpfc->is_subdirectory_install()){
				$path = $wpfc->getABSPATH();
			}

			if(is_file($path.".htaccess") && is_writable($path.".htaccess")){
				$htaccess = file_get_contents($path.".htaccess");
				$htaccess = preg_replace("/#\s?BEGIN\s?WpFastestCache.*?#\s?END\s?WpFastestCache/s", "", $htaccess);
				$htaccess = preg_replace("/#\s?BEGIN\s?GzipWpFastestCache.*?#\s?END\s?GzipWpFastestCache/s", "", $htaccess);
				$htaccess = preg_replace("/#\s?BEGIN\s?LBCWpFastestCache.*?#\s?END\s?LBCWpFastestCache/s", "", $htaccess);
				file_put_contents($path.".htaccess", $htaccess);
			}

			wp_clear_scheduled_hook("wp_fastest_cache");
			wp_clear_scheduled_hook($wpfc->slug()."_regular");

			delete_option("WpFastestCache");
			delete_option("WpFcDeleteCacheLogs");
			$wpfc->deleteCache();
		}

		protected function slug(){
			return "wp_fastest_cache";
		}

		protected function getWpContentDir(){
			return WPFC_WP_CONTENT_DIR;
		}

		protected function getOptions(){
			if($data = get_option("WpFastestCache")){
				return json_decode($data);
			}
		}

		protected function getSystemMessage(){
			return $this->systemMessage;
		}

		// protected function detectNewPost(){
		// 	if(isset($this->options->wpFastestCacheNewPost) && isset($this->options->wpFastestCacheStatus)){
		// 		add_filter ('save_post', array($this, 'deleteCache'));
		// 	}
		// }

		public function on_all_status_transitions($new_status, $old_status, $post) {
			if(isset($this->options->wpFastestCacheNewPost) && isset($this->options->wpFastestCacheStatus)){
				if ( ! wp_is_post_revision($post->ID) ){
					if($new_status == "publish" && $old_status != "publish"){
						$this->deleteCache();
					}else if($new_status == "publish" && $old_status == "publish"){
						$this->singleDeleteCache(false, $post->ID);
					}else if($new_status == "trash" && $old_status == "publish"){
						$this->deleteCache();
					}else if(($new_status == "draft" || $new_status == "pending") && $old_status == "publish"){
						$this->deleteCache();
					}

				}
			}
		}

		protected function commentHooks(){
			//it works when the status of a comment changes
			add_filter ('wp_set_comment_status', array($this, 'singleDeleteCache'));

			//it works when a comment is saved in the database
			add_filter ('comment_post', array($this, 'detectNewComment'));
		}

		public function detectNewComment($comment_id){
			if(current_user_can( 'manage_options') || !get_option('comment_moderation')){
				$this->singleDeleteCache($comment_id);
			}
		}

		public function singleDeleteCache($comment_id = false, $post_id = false){
			if($comment_id){
				$comment = get_comment($comment_id);
				
				if($comment && $comment->comment_post_ID){
					$post_id = $comment->comment_post_ID;
				}
			}

			if($post_id){
				$permalink = get_permalink($post_id);

				if(preg_match("/https?:\/\/[^\/]+\/(.+)/", $permalink, $out)){
					$path = $this->getWpContentDir()."/cache/all/".$out[1];
					$mobile_path = $this->getWpContentDir()."/cache/wpfc-mobile-cache/".$out[1];

					if(is_dir($path)){
						if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
							include_once $this->get_premium_path("logs.php");
							$log = new WpFastestCacheLogs("delete");
							$log->action();
						}

						$this->rm_folder_recursively($path);
					}

					if(is_dir($mobile_path)){
						$this->rm_folder_recursively($mobile_path);
					}
				}
			}
		}

		public function deleteCache($minified = false){
			delete_option("WpFastestCacheHTML");
			delete_option("WpFastestCacheHTMLSIZE");
			delete_option("WpFastestCacheMOBILE");
			delete_option("WpFastestCacheMOBILESIZE");

			if(class_exists("WpFcMobileCache")){
				$wpfc_mobile = new WpFcMobileCache();
				$wpfc_mobile->delete_cache($this->getWpContentDir());

				wp_schedule_single_event(time() + 60, $this->slug()."_TmpDelete_".time());
			}

			$deleted = false;
			$cache_path = $this->getWpContentDir()."/cache/all";
			$minified_cache_path = $this->getWpContentDir()."/cache/wpfc-minified";

			if(!is_dir($this->getWpContentDir()."/cache/tmpWpfc")){
				if(@mkdir($this->getWpContentDir()."/cache/tmpWpfc", 0755, true)){
					//
				}else{
					$this->systemMessage = array("Permission of <strong>/wp-content/cache</strong> must be <strong>755</strong>", "error");
				}
			}

			if(is_dir($cache_path)){
				rename($cache_path, $this->getWpContentDir()."/cache/tmpWpfc/".time());
				$deleted = true;
				
			}

			if(is_dir($minified_cache_path)){
				if($minified){
					rename($minified_cache_path, $this->getWpContentDir()."/cache/tmpWpfc/m".time());
					$deleted = true;
				}
			}

			if($deleted){
				wp_schedule_single_event(time() + 60, $this->slug()."_TmpDelete_".time());
				$this->systemMessage = array("All cache files have been deleted","success");

				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					include_once $this->get_premium_path("logs.php");
					$log = new WpFastestCacheLogs("delete");
					$log->action();
				}
			}else{
				$this->systemMessage = array("Already deleted","success");
			}
		}

		public function checkCronTime(){
			$crons = _get_cron_array();

	    	foreach ($crons as $cron_key => $cron_value) {
	    		foreach ( (array) $cron_value as $hook => $events ) {
	    			if(preg_match("/^wp\_fastest\_cache(.*)/", $hook, $id)){
	    				if(!$id[1] || preg_match("/^\_(\d+)$/", $id[1])){
		    				foreach ( (array) $events as $event_key => $event ) {
		    					add_action("wp_fastest_cache".$id[1],  array($this, 'setSchedule'));
		    				}
		    			}
		    		}
		    	}
		    }

			add_action($this->slug()."_TmpDelete",  array($this, 'actionDelete'));
			add_action($this->slug()."_regular",  array($this, 'regularCrons'));
		}

		public function actionDelete(){
			if(is_dir($this->getWpContentDir()."/cache/tmpWpfc")){
				$this->rm_folder_recursively($this->getWpContentDir()."/cache/tmpWpfc");
				if(is_dir($this->getWpContentDir()."/cache/tmpWpfc")){
					wp_schedule_single_event(time() + 60, $this->slug()."_TmpDelete");
				}
			}
		}

		public function regularCrons(){
			$this->actionDelete();
		}

		public function setSchedule($args = ""){
			if($args){
				$rule = json_decode($args);

				if($rule->prefix == "all"){
					$this->deleteCache();
				}else if($rule->prefix == "homepage"){
					@unlink($this->getWpContentDir()."/cache/all/index.html");
					@unlink($this->getWpContentDir()."/cache/wpfc-mobile-cache/index.html");
				}else if($rule->prefix == "startwith"){


				}else if($rule->prefix == "exact"){
					if(!is_dir($this->getWpContentDir()."/cache/tmpWpfc")){
						if(@mkdir($this->getWpContentDir()."/cache/tmpWpfc", 0755, true)){}
					}

					@rename($this->getWpContentDir()."/cache/all/".$rule->content, $this->getWpContentDir()."/cache/tmpWpfc/".time());
					@rename($this->getWpContentDir()."/cache/wpfc-mobile-cache/".$rule->content, $this->getWpContentDir()."/cache/tmpWpfc/mobile_".time());

					wp_schedule_single_event(time() + 60, $this->slug()."_TmpDelete_".time());
				}

				if($rule->prefix != "all"){
					if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
						include_once $this->get_premium_path("logs.php");
						$log = new WpFastestCacheLogs("delete");
						$log->action($rule);
					}
				}
			}else{
				//for old cron job
				$this->deleteCache();
			}
		}

		public function setRegularCron(){
			if(!wp_next_scheduled($this->slug()."_regular")){
				wp_schedule_event( time() + 360, 'everyfiveminute', $this->slug()."_regular");
			}else{
				if(wp_get_schedule($this->slug()."_regular") == "everyfifteenminute"){
					wp_clear_scheduled_hook($this->slug()."_regular");
					wp_schedule_event( time() + 360, 'everyfiveminute', $this->slug()."_regular");
				}
			}
		}

		public function getABSPATH(){
			$path = ABSPATH;
			$siteUrl = site_url();
			$homeUrl = home_url();
			$diff = str_replace($homeUrl, "", $siteUrl);
			$diff = trim($diff,"/");

		    $pos = strrpos($path, $diff);

		    if($pos !== false){
		    	$path = substr_replace($path, "", $pos, strlen($diff));
		    	$path = trim($path,"/");
		    	$path = "/".$path."/";
		    }
		    return $path;
		}

		public function rm_folder_recursively($dir, $i = 1) {
			$files = @scandir($dir);
		    foreach((array)$files as $file) {
		    	if($i > 500){
		    		return true;
		    	}else{
		    		$i++;
		    	}
		        if ('.' === $file || '..' === $file) continue;
		        if (is_dir("$dir/$file")) $this->rm_folder_recursively("$dir/$file", $i);
		        else @unlink("$dir/$file");
		    }
		    
		    @rmdir($dir);
		    return true;
		}

		protected function is_subdirectory_install(){
			if(strlen(site_url()) > strlen(home_url())){
				return true;
			}
			return false;
		}

		protected function getMobileUserAgents(){
			/*
			$phone_devices = array(
						        'iPhone'        => '\biPhone\b|\biPod\b',
						        'BlackBerry'    => 'BlackBerry|\bBB10\b|rim[0-9]+',
						        'Nexus'         => 'Nexus One|Nexus S|Galaxy.*Nexus|Android.*Nexus.*Mobile|Nexus\s[456]',
						        'Alcatel'       => 'Alcatel', //http://www.alcatelonetouch.com/global-en/products/smartphone
						        'Wolfgang'      => 'AT-B24D|AT-AS50HD|AT-AS40W|AT-AS55HD|AT-AS45q2|AT-B26D|AT-AS50Q', // http://www.wolfgangmobile.com/
						        'Nintendo' 		=> 'Nintendo 3DS',
						        'Amoi'          => 'Amoi', // http://www.amoi.com/en/prd/prd_index.jspx
						        'HTC'           => 'HTC.*(Sensation|Evo|Vision|Explorer|6800|8100|8900|A7272|S510e|C110e|Legend|Desire|T8282)|APX515CKT|Qtek9090|APA9292KT|HD_mini|Sensation.*Z710e|PG86100|Z715e|Desire.*(A8181|HD)|ADR6200|ADR6400L|ADR6425|001HT|Inspire 4G|Android.*\bEVO\b|T-Mobile G1|Z520m',
						        'Motorola'      => 'Motorola|DROIDX|DROID BIONIC|\bDroid\b.*Build|HRI39|MOT-|A1260|A1680|A555|A853|A855|A953|A955|A956|Motorola.*ELECTRIFY|Motorola.*i1|i867|i940|\bMB[23568]\d{2}\b|\bME[5678]\d{2}\b|\bMT[6789]\d{2}\b|Motorola.*TITANIUM|WX435|WX445|\bXT[356789]\d{2}\b|XT1021|\bMoto E\b',
						        'Asus'          => 'Asus.*Galaxy|PadFone.*Mobile',
						        'INQ'           => 'INQ',
						        'iMobile'       => 'i-mobile (IQ|i-STYLE|idea|ZAA|Hitz)',
						        'Micromax'      => 'Micromax.*A[12]\d{2}|A[2356789]\d',
						        // http://www.micromaxinfo.com/mobiles/smartphones
						        // Added because the codes might conflict with Acer Tablets.
						        // @todo Complete the regex.
						        'Palm'          => 'PalmSource|Palm', // avantgo|blazer|elaine|hiptop|plucker|xiino ;
						        // http://www.fly-phone.com/devices/smartphones/ ; Included only smartphones.
						        'Fly'           => 'IQ[24][345678][024561]',
						        'Samsung'       => "Samsung|".
													"BGT-S5230|".
													"GT-19300|".
													"GT-[BCE]\d{4}[IK]?|".
													"GT-I[5678]\d{3}|".
													"GT-I9000|GT-I9001|GT-I9003|GT-I9010|GT-I9020|GT-I9023|GT-I9070|GT-I9082|GT-I9100|GT-I9103|GT-I9220|GT-I9250|GT-I9300|GT-I9305|GT-I9500|GT-I9505|GT-I9105|GT-I9295|GT-I9195|GT-I9205|".
													"GT-M\d{4}|".
													"GT-19300|GT-N7000|GT-N7100|GT-N7105|".
													"\bGT-S\d{4}[BDEN]?\b|".
													"SCH-[ALUNRT]|".
													"SCH-I100|SCH-I110|SCH-I400|SCH-I405|SCH-I500|SCH-I510|SCH-I515|SCH-I600|SCH-I730|SCH-I760|SCH-I770|SCH-I830|SCH-I910|SCH-I920|SCH-I959|SCH-i909|SCH-I535|SCH-P709|SCH-P729|".
													"SGH-[ABCDEFJLMNPQRSUVXZ]\S{3}|".
													"SGH-I337|SGH-I200|SGH-I300|SGH-I320|SGH-I550|SGH-I577|SGH-I600|SGH-I607|SGH-I617|SGH-I627|SGH-I637|SGH-I677|SGH-I700|SGH-I717|SGH-I727|SGH-i747M|SGH-I777|SGH-I780|SGH-I827|SGH-I847|SGH-I857|SGH-I896|SGH-I897|SGH-I900|SGH-I907|SGH-I917|SGH-I927|SGH-I937|SGH-I997|SGH-I317|".
													"SGH-T109|SGH-T119|SGH-T139|SGH-T209|SGH-T219|SGH-T229|SGH-T239|SGH-T249|SGH-T259|SGH-T309|SGH-T319|SGH-T329|SGH-T339|SGH-T349|SGH-T359|SGH-T369|SGH-T379|SGH-T409|SGH-T429|SGH-T439|SGH-T459|SGH-T469|SGH-T479|SGH-T499|SGH-T509|SGH-T519|SGH-T539|SGH-T559|SGH-T589|SGH-T609|SGH-T619|SGH-T629|SGH-T639|SGH-T659|SGH-T669|SGH-T679|SGH-T709|SGH-T719|SGH-T729|SGH-T739|SGH-T746|SGH-T749|SGH-T759|SGH-T769|SGH-T809|SGH-T819|SGH-T839|SGH-T919|SGH-T929|SGH-T939|SGH-T959|SGH-T989|SGH-T999L|".
													"SHV-E160K|".
													"SHW-M110|".
													"SM-G\d{3,4}|".
													"SM-N900A|SM-N9005|SM-C101|SM-T2558|".
													"SPH-[ADILMNZ]\d{3}",
						        'Dell'          => 'Dell.*Streak|Dell.*Aero|Dell.*Venue|DELL.*Venue Pro|Dell Flash|Dell Smoke|Dell Mini 3iX|XCD28|XCD35|\b001DL\b|\b101DL\b|\bGS01\b', // @todo: Is 'Dell Streak' a tablet or a phone? ;)
						        'LG'            => '\bLG\b;|LG[- ]?(C800|C900|E400|E610|E900|E-900|F160|F180K|F180L|F180S|730|855|L160|LS740|LS840|LS970|LU6200|MS690|MS695|MS770|MS840|MS870|MS910|P500|P700|P705|VM696|AS680|AS695|AX840|C729|E970|GS505|272|C395|E739BK|E960|L55C|L75C|LS696|LS860|P769BK|P350|P500|P509|P870|UN272|US730|VS840|VS950|LN272|LN510|LS670|LS855|LW690|MN270|MN510|P509|P769|P930|UN200|UN270|UN510|UN610|US670|US740|US760|UX265|UX840|VN271|VN530|VS660|VS700|VS740|VS750|VS910|VS920|VS930|VX9200|VX11000|AX840A|LW770|P506|P925|P999|E612|D955|D802)',
						        'Sony'          => 'SonyST|SonyLT|SonyEricsson|SonyEricssonLT15iv|LT18i|E10i|LT28h|LT26w|SonyEricssonMT27i|C5303|C6902|C6903|C6906|C6943|D2533',
						        // http://www.pantech.co.kr/en/prod/prodList.do?gbrand=VEGA (PANTECH)
						        // Most of the VEGA devices are legacy. PANTECH seem to be newer devices based on Android.
						        'Pantech'       => 'PANTECH|IM-A850S|IM-A840S|IM-A830L|IM-A830K|IM-A830S|IM-A820L|IM-A810K|IM-A810S|IM-A800S|IM-T100K|IM-A725L|IM-A780L|IM-A775C|IM-A770K|IM-A760S|IM-A750K|IM-A740S|IM-A730S|IM-A720L|IM-A710K|IM-A690L|IM-A690S|IM-A650S|IM-A630K|IM-A600S|VEGA PTL21|PT003|P8010|ADR910L|P6030|P6020|P9070|P4100|P9060|P5000|CDM8992|TXT8045|ADR8995|IS11PT|P2030|P6010|P8000|PT002|IS06|CDM8999|P9050|PT001|TXT8040|P2020|P9020|P2000|P7040|P7000|C790',
						        // http://fr.wikomobile.com
						        'Wiko'          => 'KITE 4G|HIGHWAY|GETAWAY|STAIRWAY|DARKSIDE|DARKFULL|DARKNIGHT|DARKMOON|SLIDE|WAX 4G|RAINBOW|BLOOM|SUNSET|GOA|LENNY|BARRY|IGGY|OZZY|CINK FIVE|CINK PEAX|CINK PEAX 2|CINK SLIM|CINK SLIM 2|CINK +|CINK KING|CINK PEAX|CINK SLIM|SUBLIM',
						        // http://en.wikipedia.org/wiki/INQ
						        // @Tapatalk is a mobile app; http://support.tapatalk.com/threads/smf-2-0-2-os-and-browser-detection-plugin-and-tapatalk.15565/#post-79039
						        'GenericPhone'  => 'Tapatalk|PDA;|SAGEM|\bmmp\b|pocket|\bpsp\b|symbian|Smartphone|smartfon|treo|up.browser|up.link|vodafone|\bwap\b|nokia|Series40|Series60|S60|SonyEricsson|N900|MAUI.*WAP.*Browser',
						    );


			$tabletDevices = array(
						        'iPad'              => 'iPad',
						        'BlackBerryTablet'  => 'PlayBook|RIM Tablet',
						        'NexusTablet'       => 'Android.*Nexus[\s]+(7|9|10)', 
						        'DellTablet'        => 'Venue 11|Venue 8|Venue 7|Dell Streak 10|Dell Streak 7',
						        'HTCtablet'         => 'HTC_Flyer_P512|HTC Flyer|HTC Jetstream|HTC-P715a|HTC EVO View 4G|PG41200|PG09410',
						        'MotorolaTablet'    => 'xoom|Xoom|sholest|MZ[56]\d{2}',
						        'AsusTablet'        => '^.*PadFone((?!Mobile).)*$|Transformer|TF101|TF101G|TF300T|TF300TG|TF300TL|TF700T|TF700KL|TF701T|TF810C|ME171|ME301T|ME302C|ME371MG|ME370T|ME372MG|ME172V|ME173X|ME400C|Slider SL101|\bK00F\b|\bK00C\b|\bK00E\b|\bK00L\b|TX201LA|ME176C|ME102A|\bM80TA\b|ME372CL|ME560CG|ME372CG|ME302KL| K010 | K017 |ME572C|ME103K|ME170C|ME171C|\bME70C\b|ME581C|ME581CL|ME8510C|ME181C',
						        'iMobileTablet'     => 'i-mobile i-note',
						        'MicromaxTablet'    => 'Funbook|Micromax.*\bP[2356]\d{2}\b',
						        'FlyTablet'         => 'IQ310|Fly Vision',



						        'SamsungTablet'     => 'SAMSUNG.*Tablet|Galaxy.*Tab|SC-01C|GT-P1000|GT-P1003|GT-P1010|GT-P3105|GT-P6210|GT-P6800|GT-P6810|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SCH-I800|SCH-I815|SCH-I905|SGH-I957|SGH-I987|SGH-T849|SGH-T859|SGH-T869|SPH-P100|GT-P3100|GT-P3108|GT-P3110|GT-P5100|GT-P5110|GT-P6200|GT-P7320|GT-P7511|GT-N8000|GT-P8510|SGH-I497|SPH-P500|SGH-T779|SCH-I705|SCH-I915|GT-N8013|GT-P3113|GT-P5113|GT-P8110|GT-N8010|GT-N8005|GT-N8020|GT-P1013|GT-P6201|GT-P7501|GT-N5100|GT-N5105|GT-N5110|SHV-E140K|SHV-E140L|SHV-E140S|SHV-E150S|SHV-E230K|SHV-E230L|SHV-E230S|SHW-M180K|SHW-M180L|SHW-M180S|SHW-M180W|SHW-M300W|SHW-M305W|SHW-M380K|SHW-M380S|SHW-M380W|SHW-M430W|SHW-M480K|SHW-M480S|SHW-M480W|SHW-M485W|SHW-M486W|SHW-M500W|GT-I9228|SCH-P739|SCH-I925|GT-I9200|GT-P5200|GT-P5210|GT-P5210X|SM-T311|SM-T310|SM-T310X|SM-T210|SM-T210R|SM-T211|SM-P600|SM-P601|SM-P605|SM-P900|SM-P901|SM-T217|SM-T217A|SM-T217S|SM-P6000|SM-T3100|SGH-I467|XE500|SM-T110|GT-P5220|GT-I9200X|GT-N5110X|GT-N5120|SM-P905|SM-T111|SM-T2105|SM-T315|SM-T320|SM-T320X|SM-T321|SM-T520|SM-T525|SM-T530NU|SM-T230NU|SM-T330NU|SM-T900|XE500T1C|SM-P605V|SM-P905V|SM-T337V|SM-T537V|SM-T707V|SM-T807V|SM-P600X|SM-P900X|SM-T210X|SM-T230|SM-T230X|SM-T325|GT-P7503|SM-T531|SM-T330|SM-T530|SM-T705|SM-T705C|SM-T535|SM-T331|SM-T800|SM-T700|SM-T537|SM-T807|SM-P907A|SM-T337A|SM-T537A|SM-T707A|SM-T807A|SM-T237|SM-T807P|SM-P607T|SM-T217T|SM-T337T|SM-T807T|SM-T116NQ|SM-P550|SM-T350|SM-T550|SM-T9000|SM-P9000|SM-T705Y|SM-T805|GT-P3113|SM-T710|SM-T810|SM-T360', // SCH-P709|SCH-P729|SM-T2558|GT-I9205 - Samsung Mega - treat them like a regular phone.
						        'Kindle'            => 'Kindle|Silk.*Accelerated|Android.*\b(KFOT|KFTT|KFJWI|KFJWA|KFOTE|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|WFJWAE|KFSAWA|KFSAWI|KFASWI)\b',
						        'SurfaceTablet'     => 'Windows NT [0-9.]+; ARM;.*(Tablet|ARMBJS)',
						        'HPTablet'          => 'HP Slate (7|8|10)|HP ElitePad 900|hp-tablet|EliteBook.*Touch|HP 8|Slate 21|HP SlateBook 10',
						        'NookTablet'        => 'Android.*Nook|NookColor|nook browser|BNRV200|BNRV200A|BNTV250|BNTV250A|BNTV400|BNTV600|LogicPD Zoom2',
						        'AcerTablet'        => 'Android.*; \b(A100|A101|A110|A200|A210|A211|A500|A501|A510|A511|A700|A701|W500|W500P|W501|W501P|W510|W511|W700|G100|G100W|B1-A71|B1-710|B1-711|A1-810|A1-811|A1-830)\b|W3-810|\bA3-A10\b|\bA3-A11\b',
						        'ToshibaTablet'     => 'Android.*(AT100|AT105|AT200|AT205|AT270|AT275|AT300|AT305|AT1S5|AT500|AT570|AT700|AT830)|TOSHIBA.*FOLIO',
						        'LGTablet'          => '\bL-06C|LG-V909|LG-V900|LG-V700|LG-V510|LG-V500|LG-V410|LG-V400|LG-VK810\b',
						        'FujitsuTablet'     => 'Android.*\b(F-01D|F-02F|F-05E|F-10D|M532|Q572)\b',
						        'PrestigioTablet'   => 'PMP3170B|PMP3270B|PMP3470B|PMP7170B|PMP3370B|PMP3570C|PMP5870C|PMP3670B|PMP5570C|PMP5770D|PMP3970B|PMP3870C|PMP5580C|PMP5880D|PMP5780D|PMP5588C|PMP7280C|PMP7280C3G|PMP7280|PMP7880D|PMP5597D|PMP5597|PMP7100D|PER3464|PER3274|PER3574|PER3884|PER5274|PER5474|PMP5097CPRO|PMP5097|PMP7380D|PMP5297C|PMP5297C_QUAD|PMP812E|PMP812E3G|PMP812F|PMP810E|PMP880TD|PMT3017|PMT3037|PMT3047|PMT3057|PMT7008|PMT5887|PMT5001|PMT5002',
						        'LenovoTablet'      => 'Idea(Tab|Pad)( A1|A10| K1|)|ThinkPad([ ]+)?Tablet|Lenovo.*(S2109|S2110|S5000|S6000|K3011|A3000|A3500|A1000|A2107|A2109|A1107|A5500|A7600|B6000|B8000|B8080)(-|)(FL|F|HV|H|)',
						        'YarvikTablet'      => 'Android.*\b(TAB210|TAB211|TAB224|TAB250|TAB260|TAB264|TAB310|TAB360|TAB364|TAB410|TAB411|TAB420|TAB424|TAB450|TAB460|TAB461|TAB464|TAB465|TAB467|TAB468|TAB07-100|TAB07-101|TAB07-150|TAB07-151|TAB07-152|TAB07-200|TAB07-201-3G|TAB07-210|TAB07-211|TAB07-212|TAB07-214|TAB07-220|TAB07-400|TAB07-485|TAB08-150|TAB08-200|TAB08-201-3G|TAB08-201-30|TAB09-100|TAB09-211|TAB09-410|TAB10-150|TAB10-201|TAB10-211|TAB10-400|TAB10-410|TAB13-201|TAB274EUK|TAB275EUK|TAB374EUK|TAB462EUK|TAB474EUK|TAB9-200)\b',
						        'MedionTablet'      => 'Android.*\bOYO\b|LIFE.*(P9212|P9514|P9516|S9512)|LIFETAB',
						        'ArnovaTablet'      => 'AN10G2|AN7bG3|AN7fG3|AN8G3|AN8cG3|AN7G3|AN9G3|AN7dG3|AN7dG3ST|AN7dG3ChildPad|AN10bG3|AN10bG3DT|AN9G2',
						        'IntensoTablet'     => 'INM8002KP|INM1010FP|INM805ND|Intenso Tab|TAB1004',
						        'IRUTablet'         => 'M702pro',
						        'MegafonTablet'     => 'MegaFon V9|\bZTE V9\b|Android.*\bMT7A\b',
						        'EbodaTablet'       => 'E-Boda (Supreme|Impresspeed|Izzycomm|Essential)',
						        'AllViewTablet'     => 'Allview.*(Viva|Alldro|City|Speed|All TV|Frenzy|Quasar|Shine|TX1|AX1|AX2)',
						        'ArchosTablet'      => '\b(101G9|80G9|A101IT)\b|Qilive 97R|Archos5|\bARCHOS (70|79|80|90|97|101|FAMILYPAD|)(b|)(G10| Cobalt| TITANIUM(HD|)| Xenon| Neon|XSK| 2| XS 2| PLATINUM| CARBON|GAMEPAD)\b',
						        'AinolTablet'       => 'NOVO7|NOVO8|NOVO10|Novo7Aurora|Novo7Basic|NOVO7PALADIN|novo9-Spark',
						        'SonyTablet'        => 'Sony.*Tablet|Xperia Tablet|Sony Tablet S|SO-03E|SGPT12|SGPT13|SGPT114|SGPT121|SGPT122|SGPT123|SGPT111|SGPT112|SGPT113|SGPT131|SGPT132|SGPT133|SGPT211|SGPT212|SGPT213|SGP311|SGP312|SGP321|EBRD1101|EBRD1102|EBRD1201|SGP351|SGP341|SGP511|SGP512|SGP521|SGP541|SGP551|SGP621|SGP612|SOT31',
						        'PhilipsTablet'     => '\b(PI2010|PI3000|PI3100|PI3105|PI3110|PI3205|PI3210|PI3900|PI4010|PI7000|PI7100)\b',
						        'CubeTablet'        => 'Android.*(K8GT|U9GT|U10GT|U16GT|U17GT|U18GT|U19GT|U20GT|U23GT|U30GT)|CUBE U8GT',
						        'CobyTablet'        => 'MID1042|MID1045|MID1125|MID1126|MID7012|MID7014|MID7015|MID7034|MID7035|MID7036|MID7042|MID7048|MID7127|MID8042|MID8048|MID8127|MID9042|MID9740|MID9742|MID7022|MID7010',
						        'MIDTablet'         => 'M9701|M9000|M9100|M806|M1052|M806|T703|MID701|MID713|MID710|MID727|MID760|MID830|MID728|MID933|MID125|MID810|MID732|MID120|MID930|MID800|MID731|MID900|MID100|MID820|MID735|MID980|MID130|MID833|MID737|MID960|MID135|MID860|MID736|MID140|MID930|MID835|MID733',
						        'MSITablet' 		=> 'MSI \b(Primo 73K|Primo 73L|Primo 81L|Primo 77|Primo 93|Primo 75|Primo 76|Primo 73|Primo 81|Primo 91|Primo 90|Enjoy 71|Enjoy 7|Enjoy 10)\b',
						        'SMiTTablet'        => 'Android.*(\bMID\b|MID-560|MTV-T1200|MTV-PND531|MTV-P1101|MTV-PND530)',
						        'RockChipTablet'    => 'Android.*(RK2818|RK2808A|RK2918|RK3066)|RK2738|RK2808A',
						        'bqTablet'          => 'Android.*(bq)?.*(Elcano|Curie|Edison|Maxwell|Kepler|Pascal|Tesla|Hypatia|Platon|Newton|Livingstone|Cervantes|Avant|Aquaris E10)|Maxwell.*Lite|Maxwell.*Plus',
						        'HuaweiTablet'      => 'MediaPad|MediaPad 7 Youth|IDEOS S7|S7-201c|S7-202u|S7-101|S7-103|S7-104|S7-105|S7-106|S7-201|S7-Slim',
						        'NecTablet'         => '\bN-06D|\bN-08D',
						        'PantechTablet'     => 'Pantech.*P4100',
						        'BronchoTablet'     => 'Broncho.*(N701|N708|N802|a710)',
						        'VersusTablet'      => 'TOUCHPAD.*[78910]|\bTOUCHTAB\b',
						        'ZyncTablet'        => 'z1000|Z99 2G|z99|z930|z999|z990|z909|Z919|z900',
						        'PositivoTablet'    => 'TB07STA|TB10STA|TB07FTA|TB10FTA',
						        'NabiTablet'        => 'Android.*\bNabi',
						        'KoboTablet'        => 'Kobo Touch|\bK080\b|\bVox\b Build|\bArc\b Build',
						        'DanewTablet'       => 'DSlide.*\b(700|701R|702|703R|704|802|970|971|972|973|974|1010|1012)\b',
						        'TexetTablet'       => 'NaviPad|TB-772A|TM-7045|TM-7055|TM-9750|TM-7016|TM-7024|TM-7026|TM-7041|TM-7043|TM-7047|TM-8041|TM-9741|TM-9747|TM-9748|TM-9751|TM-7022|TM-7021|TM-7020|TM-7011|TM-7010|TM-7023|TM-7025|TM-7037W|TM-7038W|TM-7027W|TM-9720|TM-9725|TM-9737W|TM-1020|TM-9738W|TM-9740|TM-9743W|TB-807A|TB-771A|TB-727A|TB-725A|TB-719A|TB-823A|TB-805A|TB-723A|TB-715A|TB-707A|TB-705A|TB-709A|TB-711A|TB-890HD|TB-880HD|TB-790HD|TB-780HD|TB-770HD|TB-721HD|TB-710HD|TB-434HD|TB-860HD|TB-840HD|TB-760HD|TB-750HD|TB-740HD|TB-730HD|TB-722HD|TB-720HD|TB-700HD|TB-500HD|TB-470HD|TB-431HD|TB-430HD|TB-506|TB-504|TB-446|TB-436|TB-416|TB-146SE|TB-126SE',
						        'PlaystationTablet' => 'Playstation.*(Portable|Vita)',
						        'TrekstorTablet'    => 'ST10416-1|VT10416-1|ST70408-1|ST702xx-1|ST702xx-2|ST80208|ST97216|ST70104-2|VT10416-2|ST10216-2A|SurfTab',
						        'PyleAudioTablet'   => '\b(PTBL10CEU|PTBL10C|PTBL72BC|PTBL72BCEU|PTBL7CEU|PTBL7C|PTBL92BC|PTBL92BCEU|PTBL9CEU|PTBL9CUK|PTBL9C)\b',
						        'AdvanTablet'       => 'Android.* \b(E3A|T3X|T5C|T5B|T3E|T3C|T3B|T1J|T1F|T2A|T1H|T1i|E1C|T1-E|T5-A|T4|E1-B|T2Ci|T1-B|T1-D|O1-A|E1-A|T1-A|T3A|T4i)\b ',
						        'DanyTechTablet' => 'Genius Tab G3|Genius Tab S2|Genius Tab Q3|Genius Tab G4|Genius Tab Q4|Genius Tab G-II|Genius TAB GII|Genius TAB GIII|Genius Tab S1',
						        'GalapadTablet'     => 'Android.*\bG1\b',
						        'KarbonnTablet'     => 'Android.*\b(A39|A37|A34|ST8|ST10|ST7|Smart Tab3|Smart Tab2)\b',
						        'AllFineTablet'     => 'Fine7 Genius|Fine7 Shine|Fine7 Air|Fine8 Style|Fine9 More|Fine10 Joy|Fine11 Wide',
						        'PROSCANTablet'     => '\b(PEM63|PLT1023G|PLT1041|PLT1044|PLT1044G|PLT1091|PLT4311|PLT4311PL|PLT4315|PLT7030|PLT7033|PLT7033D|PLT7035|PLT7035D|PLT7044K|PLT7045K|PLT7045KB|PLT7071KG|PLT7072|PLT7223G|PLT7225G|PLT7777G|PLT7810K|PLT7849G|PLT7851G|PLT7852G|PLT8015|PLT8031|PLT8034|PLT8036|PLT8080K|PLT8082|PLT8088|PLT8223G|PLT8234G|PLT8235G|PLT8816K|PLT9011|PLT9045K|PLT9233G|PLT9735|PLT9760G|PLT9770G)\b',
						        'YONESTablet' => 'BQ1078|BC1003|BC1077|RK9702|BC9730|BC9001|IT9001|BC7008|BC7010|BC708|BC728|BC7012|BC7030|BC7027|BC7026',
						        'ChangJiaTablet'    => 'TPC7102|TPC7103|TPC7105|TPC7106|TPC7107|TPC7201|TPC7203|TPC7205|TPC7210|TPC7708|TPC7709|TPC7712|TPC7110|TPC8101|TPC8103|TPC8105|TPC8106|TPC8203|TPC8205|TPC8503|TPC9106|TPC9701|TPC97101|TPC97103|TPC97105|TPC97106|TPC97111|TPC97113|TPC97203|TPC97603|TPC97809|TPC97205|TPC10101|TPC10103|TPC10106|TPC10111|TPC10203|TPC10205|TPC10503',
						        'GUTablet'          => 'TX-A1301|TX-M9002|Q702|kf026', // A12R|D75A|D77|D79|R83|A95|A106C|R15|A75|A76|D71|D72|R71|R73|R77|D82|R85|D92|A97|D92|R91|A10F|A77F|W71F|A78F|W78F|W81F|A97F|W91F|W97F|R16G|C72|C73E|K72|K73|R96G
						        'PointOfViewTablet' => 'TAB-P506|TAB-navi-7-3G-M|TAB-P517|TAB-P-527|TAB-P701|TAB-P703|TAB-P721|TAB-P731N|TAB-P741|TAB-P825|TAB-P905|TAB-P925|TAB-PR945|TAB-PL1015|TAB-P1025|TAB-PI1045|TAB-P1325|TAB-PROTAB[0-9]+|TAB-PROTAB25|TAB-PROTAB26|TAB-PROTAB27|TAB-PROTAB26XL|TAB-PROTAB2-IPS9|TAB-PROTAB30-IPS9|TAB-PROTAB25XXL|TAB-PROTAB26-IPS10|TAB-PROTAB30-IPS10',
						        'OvermaxTablet'     => 'OV-(SteelCore|NewBase|Basecore|Baseone|Exellen|Quattor|EduTab|Solution|ACTION|BasicTab|TeddyTab|MagicTab|Stream|TB-08|TB-09)',
						        'HCLTablet'         => 'HCL.*Tablet|Connect-3G-2.0|Connect-2G-2.0|ME Tablet U1|ME Tablet U2|ME Tablet G1|ME Tablet X1|ME Tablet Y2|ME Tablet Sync',
						        'DPSTablet'         => 'DPS Dream 9|DPS Dual 7',
						        'VistureTablet'     => 'V97 HD|i75 3G|Visture V4( HD)?|Visture V5( HD)?|Visture V10',
						        'CrestaTablet'     => 'CTP(-)?810|CTP(-)?818|CTP(-)?828|CTP(-)?838|CTP(-)?888|CTP(-)?978|CTP(-)?980|CTP(-)?987|CTP(-)?988|CTP(-)?989',
						        'MediatekTablet' => '\bMT8125|MT8389|MT8135|MT8377\b',
						        'ConcordeTablet' => 'Concorde([ ]+)?Tab|ConCorde ReadMan',
						        'GoCleverTablet' => 'GOCLEVER TAB|A7GOCLEVER|M1042|M7841|M742|R1042BK|R1041|TAB A975|TAB A7842|TAB A741|TAB A741L|TAB M723G|TAB M721|TAB A1021|TAB I921|TAB R721|TAB I720|TAB T76|TAB R70|TAB R76.2|TAB R106|TAB R83.2|TAB M813G|TAB I721|GCTA722|TAB I70|TAB I71|TAB S73|TAB R73|TAB R74|TAB R93|TAB R75|TAB R76.1|TAB A73|TAB A93|TAB A93.2|TAB T72|TAB R83|TAB R974|TAB R973|TAB A101|TAB A103|TAB A104|TAB A104.2|R105BK|M713G|A972BK|TAB A971|TAB R974.2|TAB R104|TAB R83.3|TAB A1042',
						        'ModecomTablet' => 'FreeTAB 9000|FreeTAB 7.4|FreeTAB 7004|FreeTAB 7800|FreeTAB 2096|FreeTAB 7.5|FreeTAB 1014|FreeTAB 1001 |FreeTAB 8001|FreeTAB 9706|FreeTAB 9702|FreeTAB 7003|FreeTAB 7002|FreeTAB 1002|FreeTAB 7801|FreeTAB 1331|FreeTAB 1004|FreeTAB 8002|FreeTAB 8014|FreeTAB 9704|FreeTAB 1003',
						        'VoninoTablet'  => '\b(Argus[ _]?S|Diamond[ _]?79HD|Emerald[ _]?78E|Luna[ _]?70C|Onyx[ _]?S|Onyx[ _]?Z|Orin[ _]?HD|Orin[ _]?S|Otis[ _]?S|SpeedStar[ _]?S|Magnet[ _]?M9|Primus[ _]?94[ _]?3G|Primus[ _]?94HD|Primus[ _]?QS|Android.*\bQ8\b|Sirius[ _]?EVO[ _]?QS|Sirius[ _]?QS|Spirit[ _]?S)\b',
						        'ECSTablet'     => 'V07OT2|TM105A|S10OT1|TR10CS1',
						        'StorexTablet'  => 'eZee[_\']?(Tab|Go)[0-9]+|TabLC7|Looney Tunes Tab',
						        'VodafoneTablet' => 'SmartTab([ ]+)?[0-9]+|SmartTabII10|SmartTabII7',
						        'EssentielBTablet' => 'Smart[ \']?TAB[ ]+?[0-9]+|Family[ \']?TAB2',
						        'RossMoorTablet' => 'RM-790|RM-997|RMD-878G|RMD-974R|RMT-705A|RMT-701|RME-601|RMT-501|RMT-711',
						        'TolinoTablet'  => 'tolino tab [0-9.]+|tolino shine',
						        'AudioSonicTablet' => '\bC-22Q|T7-QC|T-17B|T-17P\b',
						        'AMPETablet' => 'Android.* A78 ',
						        'SkkTablet' => 'Android.* (SKYPAD|PHOENIX|CYCLOPS)',
						        'TecnoTablet' => 'TECNO P9',
						        'JXDTablet' => 'Android.*\b(F3000|A3300|JXD5000|JXD3000|JXD2000|JXD300B|JXD300|S5800|S7800|S602b|S5110b|S7300|S5300|S602|S603|S5100|S5110|S601|S7100a|P3000F|P3000s|P101|P200s|P1000m|P200m|P9100|P1000s|S6600b|S908|P1000|P300|S18|S6600|S9100)\b',
						        'iJoyTablet' => 'Tablet (Spirit 7|Essentia|Galatea|Fusion|Onix 7|Landa|Titan|Scooby|Deox|Stella|Themis|Argon|Unique 7|Sygnus|Hexen|Finity 7|Cream|Cream X2|Jade|Neon 7|Neron 7|Kandy|Scape|Saphyr 7|Rebel|Biox|Rebel|Rebel 8GB|Myst|Draco 7|Myst|Tab7-004|Myst|Tadeo Jones|Tablet Boing|Arrow|Draco Dual Cam|Aurix|Mint|Amity|Revolution|Finity 9|Neon 9|T9w|Amity 4GB Dual Cam|Stone 4GB|Stone 8GB|Andromeda|Silken|X2|Andromeda II|Halley|Flame|Saphyr 9,7|Touch 8|Planet|Triton|Unique 10|Hexen 10|Memphis 4GB|Memphis 8GB|Onix 10)',
						        'FX2Tablet' => 'FX2 PAD7|FX2 PAD10',
						        'XoroTablet'        => 'KidsPAD 701|PAD[ ]?712|PAD[ ]?714|PAD[ ]?716|PAD[ ]?717|PAD[ ]?718|PAD[ ]?720|PAD[ ]?721|PAD[ ]?722|PAD[ ]?790|PAD[ ]?792|PAD[ ]?900|PAD[ ]?9715D|PAD[ ]?9716DR|PAD[ ]?9718DR|PAD[ ]?9719QR|PAD[ ]?9720QR|TelePAD1030|Telepad1032|TelePAD730|TelePAD731|TelePAD732|TelePAD735Q|TelePAD830|TelePAD9730|TelePAD795|MegaPAD 1331|MegaPAD 1851|MegaPAD 2151',
						        'ViewsonicTablet'   => 'ViewPad 10pi|ViewPad 10e|ViewPad 10s|ViewPad E72|ViewPad7|ViewPad E100|ViewPad 7e|ViewSonic VB733|VB100a',
						        'OdysTablet'        => 'LOOX|XENO10|ODYS[ -](Space|EVO|Xpress|NOON)|\bXELIO\b|Xelio10Pro|XELIO7PHONETAB|XELIO10EXTREME|XELIOPT2|NEO_QUAD10',
						        'CaptivaTablet'     => 'CAPTIVA PAD',
						        'IconbitTablet' => 'NetTAB|NT-3702|NT-3702S|NT-3702S|NT-3603P|NT-3603P|NT-0704S|NT-0704S|NT-3805C|NT-3805C|NT-0806C|NT-0806C|NT-0909T|NT-0909T|NT-0907S|NT-0907S|NT-0902S|NT-0902S',
						        'TeclastTablet' => 'T98 4G|\bP80\b|\bX90HD\b|X98 Air|X98 Air 3G|\bX89\b|P80 3G|\bX80h\b|P98 Air|\bX89HD\b|P98 3G|\bP90HD\b|P89 3G|X98 3G|\bP70h\b|P79HD 3G|G18d 3G|\bP79HD\b|\bP89s\b|\bA88\b|\bP10HD\b|\bP19HD\b|G18 3G|\bP78HD\b|\bA78\b|\bP75\b|G17s 3G|G17h 3G|\bP85t\b|\bP90\b|\bP11\b|\bP98t\b|\bP98HD\b|\bG18d\b|\bP85s\b|\bP11HD\b|\bP88s\b|\bA80HD\b|\bA80se\b|\bA10h\b|\bP89\b|\bP78s\b|\bG18\b|\bP85\b|\bA70h\b|\bA70\b|\bG17\b|\bP18\b|\bA80s\b|\bA11s\b|\bP88HD\b|\bA80h\b|\bP76s\b|\bP76h\b|\bP98\b|\bA10HD\b|\bP78\b|\bP88\b|\bA11\b|\bA10t\b|\bP76a\b|\bP76t\b|\bP76e\b|\bP85HD\b|\bP85a\b|\bP86\b|\bP75HD\b|\bP76v\b|\bA12\b|\bP75a\b|\bA15\b|\bP76Ti\b|\bP81HD\b|\bA10\b|\bT760VE\b|\bT720HD\b|\bP76\b|\bP73\b|\bP71\b|\bP72\b|\bT720SE\b|\bC520Ti\b|\bT760\b|\bT720VE\b|T720-3GE|T720-WiFi',
						        'OndaTablet' => '\b(V975i|Vi30|VX530|V701|Vi60|V701s|Vi50|V801s|V719|Vx610w|VX610W|V819i|Vi10|VX580W|Vi10|V711s|V813|V811|V820w|V820|Vi20|V711|VI30W|V712|V891w|V972|V819w|V820w|Vi60|V820w|V711|V813s|V801|V819|V975s|V801|V819|V819|V818|V811|V712|V975m|V101w|V961w|V812|V818|V971|V971s|V919|V989|V116w|V102w|V973|Vi40)\b[\s]+',
						        'JaytechTablet'     => 'TPC-PA762',
						        'BlaupunktTablet'   => 'Endeavour 800NG|Endeavour 1010',
						        'DigmaTablet' => '\b(iDx10|iDx9|iDx8|iDx7|iDxD7|iDxD8|iDsQ8|iDsQ7|iDsQ8|iDsD10|iDnD7|3TS804H|iDsQ11|iDj7|iDs10)\b',
						        'EvolioTablet' => 'ARIA_Mini_wifi|Aria[ _]Mini|Evolio X10|Evolio X7|Evolio X8|\bEvotab\b|\bNeura\b',
						        'LavaTablet' => 'QPAD E704|\bIvoryS\b|E-TAB IVORY|\bE-TAB\b',
						        'CelkonTablet' => 'CT695|CT888|CT[\s]?910|CT7 Tab|CT9 Tab|CT3 Tab|CT2 Tab|CT1 Tab|C820|C720|\bCT-1\b',
						        'WolderTablet' => 'miTab \b(DIAMOND|SPACE|BROOKLYN|NEO|FLY|MANHATTAN|FUNK|EVOLUTION|SKY|GOCAR|IRON|GENIUS|POP|MINT|EPSILON|BROADWAY|JUMP|HOP|LEGEND|NEW AGE|LINE|ADVANCE|FEEL|FOLLOW|LIKE|LINK|LIVE|THINK|FREEDOM|CHICAGO|CLEVELAND|BALTIMORE-GH|IOWA|BOSTON|SEATTLE|PHOENIX|DALLAS|IN 101|MasterChef)\b',
						        'MiTablet' => '\bMI PAD\b|\bHM NOTE 1W\b',
						        'NibiruTablet' => 'Nibiru M1|Nibiru Jupiter One',
						        'NexoTablet' => 'NEXO NOVA|NEXO 10|NEXO AVIO|NEXO FREE|NEXO GO|NEXO EVO|NEXO 3G|NEXO SMART|NEXO KIDDO|NEXO MOBI',
						        'LeaderTablet' => 'TBLT10Q|TBLT10I|TBL-10WDKB|TBL-10WDKBO2013|TBL-W230V2|TBL-W450|TBL-W500|SV572|TBLT7I|TBA-AC7-8G|TBLT79|TBL-8W16|TBL-10W32|TBL-10WKB|TBL-W100',
						        'UbislateTablet' => 'UbiSlate[\s]?7C',
						        'PocketBookTablet' => 'Pocketbook',
						        'Hudl'              => 'Hudl HT7S3',
						        'TelstraTablet'     => 'T-Hub2',
						        'GenericTablet'     => 'Android.*\b97D\b|Tablet(?!.*PC)|BNTV250A|MID-WCDMA|LogicPD Zoom2|\bA7EB\b|CatNova8|A1_07|CT704|CT1002|\bM721\b|rk30sdk|\bEVOTAB\b|M758A|ET904|ALUMIUM10|Smartfren Tab|Endeavour 1010|Tablet-PC-4|Tagi Tab|\bM6pro\b|CT1020W|arc 10HD|\bJolla\b|\bTP750\b'
						    );
			*/

			return "iphone|midp|sony|symbos|nokia|samsung|mobile|epoc|ericsson|panasonic|philips|sanyo|sharp|sie-|portalmmm|blazer|avantgo|danger|palm|series60|palmsource|pocketpc|android|blackberry|playbook|ipad|ipod|iemobile|palmos|webos|googlebot-mobile|bb10|xoom|p160u|nexus|touch|SCH-I800|opera\smini|SM-G900R4|LG-|HTC";
		}

		public function get_premium_path($name){
			return WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium/pro/library/".$name;
		}

		public function getProLibraryPath($file){
			$currentPath = plugin_dir_path( __FILE__ );
			$pluginMainPath = str_replace("inc/", "", $currentPath);

			return $pluginMainPath."pro/".$file;
		}

		public function cron_add_minute( $schedules ) {
			$schedules['everyfiveminute'] = array(
			    'interval' => 60*5,
			    'display' => __( 'Once Every 5 Minutes' ),
			    'wpfc' => false
		    );

		   	$schedules['everyfifteenminute'] = array(
			    'interval' => 60*15,
			    'display' => __( 'Once Every 15 Minutes' ),
			    'wpfc' => true
		    );

		    $schedules['twiceanhour'] = array(
			    'interval' => 60*30,
			    'display' => __( 'Twice an Hour' ),
			    'wpfc' => true
		    );

		    $schedules['onceanhour'] = array(
			    'interval' => 60*60,
			    'display' => __( 'Once an Hour' ),
			    'wpfc' => true
		    );

		    $schedules['everysixhours'] = array(
			    'interval' => 60*60*6,
			    'display' => __( 'Once Every 6 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['onceaday'] = array(
			    'interval' => 60*60*24,
			    'display' => __( 'Once a Day' ),
			    'wpfc' => true
		    );

		    $schedules['weekly'] = array(
			    'interval' => 60*60*24*7,
			    'display' => __( 'Once a Week' ),
			    'wpfc' => true
		    );

		    $schedules['montly'] = array(
			    'interval' => 60*60*24*30,
			    'display' => __( 'Once a Month' ),
			    'wpfc' => true
		    );

		    $schedules['yearly'] = array(
			    'interval' => 60*60*24*30*12,
			    'display' => __( 'Once a Year' ),
			    'wpfc' => true
		    );

		    return $schedules;
		}

		public function setCustomInterval(){
			add_filter( 'cron_schedules', array($this, 'cron_add_minute'));
		}

		public function isPluginActive( $plugin ) {
			return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || $this->isPluginActiveForNetwork( $plugin );
		}
		
		public function isPluginActiveForNetwork( $plugin ) {
			if ( !is_multisite() )
				return false;

			$plugins = get_site_option( 'active_sitewide_plugins');
			if ( isset($plugins[$plugin]) )
				return true;

			return false;
		}
	}

	$GLOBALS["wp_fastest_cache"] = new WpFastestCache();
?>