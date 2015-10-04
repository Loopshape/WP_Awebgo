<?php
namespace Google_Plus_Feed;
class FTS_Google_Plus_Feed extends Google_Plus_Feed_Functions {
	function __construct() {
		add_shortcode( 'gpf google plus', array( $this,'gpf_google_plus_func' ));
		add_action('wp_enqueue_scripts', array( $this, 'gpf_google_plus_head'));
	}
	//**************************************************
	// Add Styles and Scripts functions
	//**************************************************
	function gpf_google_plus_head() {
		wp_enqueue_style( 'gpf-feeds', plugins_url( 'custom-google-plus-feed/feeds/css/styles.css'));
	}
	//**************************************************
	// Display Google Feed
	//**************************************************
	function gpf_google_plus_func($atts) { ?>
<?php
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		global $type, $grid;
		$developer_mode = 'on';

		//Google Follow Button Options
		$gpf_show_follow_btn = get_option('gpf_show_follow_btn');
		$gpf_show_follow_btn_where = get_option('gpf_show_follow_btn_where');
		if (isset($type) && $type == 'albums' || isset($type) && $type == 'albums_photos' || isset($grid) && $grid == 'yes' ) {
			wp_enqueue_script( 'gpf-masonry-pkgd', plugins_url( 'custom-google-plus-feed/feeds/js/masonry.pkgd.min.js'), array( 'jquery' ) );
		}
		//Make sure everything is reset
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		//Eventually add premium page file
		if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			include WP_CONTENT_DIR.'/plugins/custom-google-plus-feed-premium/feeds/google-plus/google-premium-feed.php';
			if ($gpf_gpf_popup == 'yes') {
				// it's ok if these styles & scripts load at the bottom of the page
				$gpf_fix_magnific = get_option('gpf_fix_magnific') ? get_option('gpf_fix_magnific') : '';
				if(isset($gpf_fix_magnific) && $gpf_fix_magnific !== '1'){
					wp_enqueue_style( 'gpf-popup', plugins_url( 'custom-google-plus-feed/feeds/css/magnific-popup.css'));
				}
				wp_enqueue_script( 'gpf-popup-js', plugins_url( 'custom-google-plus-feed/feeds/js/magnific-popup.js'));
				wp_enqueue_script( 'gpf-images-loaded', plugins_url( 'custom-google-plus-feed/feeds/js/imagesloaded.pkgd.min.js' ));
				wp_enqueue_script( 'gpf-global', plugins_url('custom-google-plus-feed/feeds/js/gpf-global.js'), array( 'jquery' ));

			}
		}
		else {
			extract( shortcode_atts( array(
						'id' => '',
						'type' => '',
						'posts_displayed' => '',
						'height' => '',
						'album_id' => '',
						'image_width' => '',
						'image_height' => '',
						'space_between_photos' => '',
						'hide_date_likes_comments' => '',
						'center_container' => '',
						'image_stack_animation' => '',
						'image_position_lr' => '',
						'image_position_top' => '',
					), $atts ) );
			$custom_name = $posts_displayed;
			$gpf_limiter = '5';
			$gpf_gpf_id = $id;
		}
		//API Access Token
		$custom_access_token = get_option('gpf_custom_api_token');
		if (!empty($custom_access_token)) {
			$access_token = $custom_access_token;
		}
		else {
			return 'Please make sure you have entered a Google API key on the Google Options page of our Custom Google Plus Feed plugin in your wp-admin area.';
		}
	//	else {
			//Randomizer
	//		$values = array(
	//			'817537814961507|HSQjMRcTKHfsqO4CSItHTrnyVBk',
	//		);
	//		$access_token = $values[array_rand($values, 1)];
	//	}
		//Error Check
		if (!$gpf_gpf_id) {
			return 'Please enter a username for this feed.';
		}
		
		
		ob_start();
		//URL to get page info
		switch ($type) {
		case 'album_photos':
			$gpf_data_cache = 'gpf_'.$type.'_'.$gpf_gpf_id.'_'.$album_id.'_num'.$gpf_limiter.'';
			break;
		default:
			$gpf_data_cache = 'gpf_'.$type.'_'.$gpf_gpf_id.'_num'.$gpf_limiter.'';
			break;
		}
		if (false !== ($transient_exists = $this->gpf_check_feed_cache_exists($gpf_data_cache)) and !isset($_GET['load_more_ajaxing'])) {
			$response = $this->gpf_get_feed_cache($gpf_data_cache);
		}
		else {
			//this check is in place because we used this option and it failed for many people because we use wp get contents instead of curl
			// this can be removed in a future update and just keep the $language_option = get_option('gpf_language', 'en_US');
			$language_option_check = get_option('gpf_language');

			if (isset($language_option_check) && $language_option_check !== 'Please Select Option') {
				$language_option = get_option('gpf_language', 'en_US');
			}
			else {
				$language_option = 'en_US';
			}


			$language = !empty($language_option) ? '&lang='.$language_option : '';
			$mulit_data = array('page_data' => 'https://www.googleapis.com/plus/v1/people/'.$gpf_gpf_id.'?'.$language.'&key='.$access_token);



			$mulit_data['feed_data'] = isset($_REQUEST['next_url']) ? $_REQUEST['next_url'] : 'https://www.googleapis.com/plus/v1/people/'.$gpf_gpf_id.'/activities/public?'.$language.'&maxResults='.$gpf_limiter.'&key='.$access_token;
			$response = $this->gpf_get_feed_json($mulit_data);
			//$response = json_decode($response['feed_data']);
			//echo'<pre>';
			//print_r($response);
			//echo'</pre>';


			//Make sure it's not ajaxing
			if (!isset($_GET['load_more_ajaxing']) && !empty($response['feed_data'])) {
				//Create Cache
				$this->gpf_create_feed_cache($gpf_data_cache, $response);
			}
		} // end main else
		//Json decode data and build it from cache or response
		$des = json_decode($response['page_data']);



		$data = json_decode($response['feed_data']);

		//  echo'<pre>';
		//  print_r($data);
		//  echo'<pre>';

		//Error Log
		if((array_key_exists("error",$data))){
			if($data->error->code == 403)
				echo'Please Setup Google Plus on your Google Account.';
		}


		if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			//Make sure it's not ajaxing and we will allow the omition of certain album covers from the list by using omit_album_covers=0,1,2,3 in the shortcode
			if (!isset($_GET['load_more_ajaxing'])) {
				if ($type == 'albums') {
					// omit_album_covers=0,1,2,3 for example
					$omit_album_covers = $omit_album_covers;
					$omit_album_covers_new = array();
					$omit_album_covers_new = explode(',', $omit_album_covers);

					foreach ($data->data as $d) {
						foreach ($omit_album_covers_new as $omit) {
							unset($data->data[$omit]);
						}
					}
				}
			}
		}

		//  echo'<pre>';
		//   print_r($data);
		//  echo'</pre>';

		//If events array Flip it so it's in proper order
		if ($type == 'events') {

			if($data->data){

				usort($data->data, function($a, $b) {
						$a = strtotime($a->start_time);
						$b = strtotime($b->start_time);
						return ($a == $b) ? (0) : (($a > $b) ? (1) : (-1));
					});
				//  $data->data = array_reverse($data->data);

			}
		}

		//Make sure it's not ajaxing
		if (!isset($_GET['load_more_ajaxing'])) {
			$_REQUEST['gpf_dynamic_name'] = trim($this->rand_string(10).'_'.$type);
			//Create Dynamic Class Name
			$gpf_dynamic_class_name =  '';
			if (isset($_REQUEST['gpf_dynamic_name'])) {
				$gpf_dynamic_class_name =  'feed_dynamic_class'.$_REQUEST['gpf_dynamic_name'];
			}
			print '<div class="gpf-jal-fb-header">';
			if ($gpf_grid !== 'yes') {	print '<div class="gpf-fb-header-wrapper">'; }
			//******************
			// SOCIAL BUTTON
			//******************
			if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
				$hide_like_option = isset($hide_like_option) ? $hide_like_option : 'no';
			}
			else {
				$hide_like_option = 'no';
			}
			if(isset($gpf_show_follow_btn) && $gpf_show_follow_btn !== 'no' && $gpf_show_follow_btn_where == 'facebook-follow-above' && $hide_like_option !== 'yes'){
				$like_option_align_final = isset($like_option_align) ? 'gpf-fb-social-btn-'.$like_option_align.'' : '';
				echo '<div class="fb-social-btn-top '.$like_option_align_final.'">';
				$this->social_follow_button('facebook', $id, $access_token);
				echo '</div>';
			}
			// so we can remove the gpf-jal-fb-header for our special album view
			if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
				$des->tagline = isset($des->tagline) ? $des->tagline : "";
				// gpf-fb-header-wrapper
				
				
				// Print our Google Page Title or About Text. Commented out the group description because in the future we will be adding the about description.
				if ($title == 'yes' or $title == '') {
					print '<h1><a href="'.$des->url.'" target="_blank">'.$des->displayName.'</a></h1>';
				}
				if ($description == 'yes' || $description == '') {
					print '<div class="gpf-jal-fb-group-header-desc">'.$this->gpf_facebook_tag_filter($des->tagline).'</div>';
				}
			
			if ($gpf_grid !== 'yes') {	print '</div>'; }
			}
			else {
				$des->tagline = isset($des->tagline) ? $des->tagline : "";
				print '<div class="gpf-jal-fb-header"><h1><a href="'.$des->url.'" target="_blank">'.$des->displayName.'</a></h1>';
				print '<div class="gpf-jal-fb-group-header-desc">'.$this->gpf_facebook_tag_filter($des->tagline).'</div>';
				print '</div><div class="clear"></div>';
			}
		} //End check
	 print '</div>';
		//Make sure it's not ajaxing
		if (!isset($_GET['load_more_ajaxing'])) {
			$gpf_grid = isset($gpf_grid) ? $gpf_grid : "";
			if (!isset($FBtype) && $type == 'albums' || !isset($FBtype) && $type == 'album_photos' || $gpf_grid == 'yes') {
				if(isset($video_album) && $video_album == 'yes' ){ } else {
					wp_enqueue_script( 'gpf-masonry-pkgd', plugins_url( 'custom-google-plus-feed/feeds/js/masonry.pkgd.min.js'), array( 'jquery' ) );
?>
<script>
		 jQuery(window).load(function(){
			 jQuery('.<?php echo $gpf_dynamic_class_name ?>').masonry({
              // select the items we want to mason
             itemSelector: '.gpf-jal-single-fb-post'
            });
		 });
        </script>
<?php }
				if (!isset($FBtype) && $type == 'albums' || !isset($FBtype) && $type == 'album_photos' ) {  ?>

<div class="gpf-slicker-facebook-photos gpf-slicker-facebook-albums <?php if (isset($video_album) && $video_album == 'yes') { echo 'popup-video-gallery-fb'; } else { echo ' popup-gallery-fb masonry js-masonry'; } if (isset($images_align)) { echo ' popup-video-gallery-align-'.$images_align.''; } ?> popup-gallery-fb <?php echo $gpf_dynamic_class_name ?>" style="margin:auto;" <?php if (isset($video_album) && $video_album !== 'yes') { ?>data-masonry-options='{ "isFitWidth": <?php if ($center_container == 'no') { ?>false<?php } else {?>true<?php } if ($image_stack_animation == 'no') { ?>, "transitionDuration": 0<?php } } ?> }'>
<?php } ?>
<?php if ($gpf_grid == 'yes') { ?>
<div class="gpf-slicker-facebook-posts masonry js-masonry <?php if ($gpf_gpf_popup == 'yes') { ?>popup-gallery-fb-posts <?php } echo $gpf_dynamic_class_name ?>" style="margin:auto" data-masonry-options='{ "isFitWidth": <?php if ($center_container == 'no') { ?>false<?php } else {?>true<?php } if ($image_stack_animation == 'no') { ?>, "transitionDuration": 0<?php } ?> }'>
<?php
				}
			}
			else { ?>
<div class="gpf-jal-fb-group-display gpf-simple-fb-wrapper <?php if ($gpf_gpf_popup == 'yes') { ?>popup-gallery-fb-posts <?php } echo $gpf_dynamic_class_name ?><?php if ($height !== 'auto' && empty($height) == NULL) {?> gpf-fb-scrollable<?php } ?>" <?php if ($height !== 'auto' && empty($height) == NULL) {?>style="height:<?php echo $height; ?>"<?php } ?>>
<?php }
		} //End ajaxing Check
		$gpf_post_data_cache = 'gpf_'.$type.'_post_'.$gpf_gpf_id.'_num'.$gpf_limiter.'';
		if (file_exists($gpf_post_data_cache) && !filesize($gpf_post_data_cache) == 0 && filemtime($gpf_post_data_cache) > time() - 900 && false !== strpos($gpf_post_data_cache, '-num'.$gpf_limiter.'' ) && !isset($_GET['load_more_ajaxing']) && $developer_mode !== 'on') {
			$response_post_array = $this->gpf_get_feed_cache($gpf_post_data_cache);
		}
		else {
			//Build the big post counter.
			$gpf_post_array = array();
			//Single Events Array
			$gpf_single_events_array = array();
			$set_zero = 0;

			//Response
			$response_post_array = $this->gpf_get_feed_json($gpf_post_array);
			//Make sure it's not ajaxing
			if (!isset($_GET['load_more_ajaxing'])) {
				//Create Cache
				$this->gpf_create_feed_cache($gpf_post_data_cache, $response_post_array);
			}
		} //End else
		//Single event info call
		if ($type == 'events') {
			$single_event_array_response = $this->gpf_get_feed_json($gpf_single_events_array);
		}
		$set_zero = 0;
		//THE MAIN FEED
		foreach ($data->items as $d) {

			$gpf_dynamic_vid_name_string = trim($this->rand_string(10).'_'.$type);

			if ($set_zero==$gpf_limiter)
				break;
			//Create Google Variables
			$FBfinalstory ='';
			$first_dir ='';
			$FBtype = isset($d->object->attachments[0]->objectType) ? $d->object->attachments[0]->objectType : "";
			$FBpicture = isset($d->object->attachments[0]->image->url) ? $d->object->attachments[0]->image->url : "";
			$FBpictureFull = isset($d->object->attachments[0]->fullImage->url) ? $d->object->attachments[0]->fullImage->url : "";
			$FBlink = isset($d->object->url) ? $d->object->url : "";
			$FBname = isset($d->object->title) ? $d->object->title : "";
			$FBcaption = isset($d->caption) ? $d->caption : "";
			$FBmessage = isset($d->object->content) ? $d->object->content : "";
			$FBdescription = isset($d->description) ? $d->description : "";
			$FBstory = isset($d->story) ? $d->story : "";
			$FBicon = isset($d->icon) ? $d->icon : "";
			$FBby = isset($d->properties->text) ? $d->properties->text : "";
			$FBbylink = isset($d->properties->href) ? $d->properties->href : "";
			$FBpost_share_count = isset($d->object->resharers->totalItems) ? $d->object->resharers->totalItems : "";
			$FBpost_like_count = isset($d->object->plusoners->totalItems) ? $d->object->plusoners->totalItems : "";
			$FBpost_comments_count = isset($d->object->replies->totalItems) ? $d->object->replies->totalItems : "";
			$FBpost_object_id = isset($d->object_id) ? $d->object_id : "";
			$FBalbum_photo_count = isset($d->count) ? $d->count : "";
			$FBalbum_cover = isset($d->cover_photo->id) ? $d->cover_photo->id : "";


			if ($FBalbum_cover) {
				$photo_data = json_decode($response_post_array[$FBalbum_cover.'_photo']);
			}
			if (isset($d->id)) {
				$FBpost_id = $d->id;
				$FBpost_full_ID = explode('_', $FBpost_id);
				if (isset($FBpost_full_ID[0])) {
					$FBpost_user_id = $FBpost_full_ID[0];
				}
				if (isset($FBpost_full_ID[1])) {
					$FBpost_single_id = $FBpost_full_ID[1];
				}
			}
			if ($type == 'albums' && !$FBalbum_cover) {
				unset($d);
				continue;
			}
			//Create Post Data Key
			if (isset($d->object_id)) {
				$post_data_key = $d->object_id;
			}
			else {
				$post_data_key = $d->id;
			}

			//Like Count

			if ($FBpost_like_count == '0') {
				$final_FBpost_like_count = "";
			}
			if ($FBpost_like_count == '1') {
				$final_FBpost_like_count = "<i class='icon-plus'></i> 1";
			}
			if ($FBpost_like_count > '1') {
				$final_FBpost_like_count = "<i class='icon-plus'></i> " . $FBpost_like_count;
			}

			//Shares Count
			if ($FBpost_share_count == '0') {
				$final_FBpost_share_count = "";
			}
			if ($FBpost_share_count == '1') {
				$final_FBpost_share_count = "<i class='icon-share'></i> 1";
			}
			if ($FBpost_share_count > '1') {
				$final_FBpost_share_count = "<i class='icon-share'></i> " . $FBpost_share_count;
			}


			//Comments Count
			if ($FBpost_comments_count == '0') {
				$final_FBpost_comments_count = "";
			}
			if ($FBpost_comments_count == '1') {
				$final_FBpost_comments_count = "<i class='icon-comment'></i> 1";
			}
			if ($FBpost_comments_count > '1') {
				$final_FBpost_comments_count = "<i class='icon-comment'></i> " . $FBpost_comments_count;
			}





			$FBlocation = isset($d->location) ? $d->location : "";
			$FBembed_vid = isset($d->embed_html) ? $d->embed_html : "";
			$FBfromName = isset($d->from->name) ? $d->from->name : "";
			$FBfromName = preg_quote($FBfromName, "/");;
			$FBstory = isset($d->story) ? $d->story : "";
			$CustomDateCheck = get_option('gpf-date-and-time-format');
			if ($CustomDateCheck) {
				$CustomDateFormat = get_option('gpf-date-and-time-format');
			}
			else {
				$CustomDateFormat = 'F jS, Y \a\t g:ia';
			}
			$d->published = isset($d->published) ? $d->published : '';
			$CustomTimeFormat = strtotime($d->published);
			if (!empty($FBstory)) {
				$FBfinalstory  = preg_replace('/\b'.$FBfromName.'s*?\b(?=([^"]*"[^"]*")*[^"]*$)/i', '', $FBstory, 1);
			}
			switch ($FBtype) {
			case 'video'  :
				print '<div class="gpf-jal-single-fb-post gpf-fb-video-post-wrap" ';
				$gpf_grid = isset($gpf_grid) ? $gpf_grid : "";
				if ($gpf_grid == 'yes') {
					print 'style="width:'.$gpf_colmn_width.'; margin:'.$space_between_posts.'"';
				}
				print '>';
				break;
			case 'app':
			case 'cover':
			case 'profile':
			case 'mobile':
			case 'wall':
			case 'normal':
			case 'photo':
				print '<div class="gpf-jal-single-fb-post  gpf-fb-photo-post-wrap" ';
				if ($type == 'album_photos' || $type == 'albums') {
					print 'style="width:'.$image_width.' !important; height:'.$image_height.'!important; margin:'.$space_between_photos.'!important"';
				}
				if ($gpf_grid == 'yes') {
					print 'style="width:'.$gpf_colmn_width.'; margin:'.$space_between_posts.'"';
				}
				print '>';
				break;
			case 'album':
			default:
				print '<div class="gpf-jal-single-fb-post" ';
				if ($gpf_grid == 'yes') {
					print 'style="width:'.$gpf_colmn_width.'; margin:'.$space_between_posts.'"';
				}
				print '>';
				break;
			}
			//Don't print if Events Feed
			if($type !== 'events'){
				print '<div class="gpf-jal-fb-right-wrap">';
				if ($type == 'album_photos' && $hide_date_likes_comments == 'yes' || $type == 'albums' && $hide_date_likes_comments == 'yes') { }
				else {
					print '<div class="gpf-jal-fb-top-wrap">';
				}
				print '<div class="gpf-jal-fb-user-thumb">';
				print '<a href="'.$d->actor->url.'" target="_blank"><img border="0" alt="'.$d->actor->displayName.'" src="'.$d->actor->image->url.'"/></a>';
				print '</div>';
				if ($type == 'album_photos' && $hide_date_likes_comments == 'yes' || $type == 'albums' && $hide_date_likes_comments == 'yes') { }
				else {
					date_default_timezone_set(get_option('gpf-timezone'));

					$gpf_hide_shared_by_etc_text = get_option('gpf_hide_shared_by_etc_text');
					$gpf_hide_shared_by_etc_text = isset($gpf_hide_shared_by_etc_text) && $gpf_hide_shared_by_etc_text == 'no' ? '' : $FBfinalstory;

					print '<span class="gpf-jal-fb-user-name"><a href="'.$d->actor->url.'" target="_blank">'.$d->actor->displayName.'</a>'. $gpf_hide_shared_by_etc_text .'</span>';
					print '<span class="gpf-jal-fb-post-time">'.date($CustomDateFormat, $CustomTimeFormat).'</span><div class="clear"></div>';
					//Comments Count
					$FBpost_id_final = substr($FBpost_id, strpos($FBpost_id, "_") + 1);
					//filter messages to have urls
					//Output Message
					if ($FBmessage) {
						if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
							// here we trim the words for the premium version. The $words string actually comes from the javascript
							if ($words !== '0') {
								$more = isset($more) ? $more : "";
								$trimmed_content = $this->gpf_custom_trim_words($FBmessage, $words, $more);
								print '<div class="gpf-jal-fb-message">'.$trimmed_content.'';
								if ($gpf_gpf_popup == 'yes') {
									print '<div class="gpf-fb-caption"><a href="'.$FBlink.'" class="gpf-view-on-facebook-link" target="_blank">'.__('View on Google', 'custom-google-plus-feed').'</a></div> ';
								}
								print '</div><div class="clear"></div> ';
							}
							else {
								$FB_final_message = $this->gpf_facebook_tag_filter($FBmessage);
								print '<div class="gpf-jal-fb-message">'; if ($words !== '0') { nl2br($FB_final_message);}
								if ($gpf_gpf_popup == 'yes') {
									print '<div class="gpf-fb-caption"><a href="'.$FBlink.'" class="gpf-view-on-facebook-link" target="_blank">'.__('View on Google', 'custom-google-plus-feed').'</a></div> ';
								}
								print '</div><div class="clear"></div> ';
							}
						} //END is_plugin_active
						// if the premium plugin is not active we will just show the regular full description
						else {
							$FB_final_message = $this->gpf_facebook_tag_filter($FBmessage);
							print '<div class="gpf-jal-fb-message">'.nl2br($FB_final_message).'</div><div class="clear"></div> ';
						}
					}//END Output Message
					elseif (!$FBmessage && $type == 'album_photos' || !$FBmessage && $type == 'albums') {

						print '<div class="gpf-jal-fb-description-wrap">';
						if ($FBname) {
							$words = isset($words) ? $words : "";
							print $this->gpf_facebook_post_desc($FBname, $words, $FBtype, NULL, $FBby, $type);
						};
						//Output Photo Caption
						if ($FBcaption) {
							print $this->gpf_facebook_post_cap($FBcaption, $words, $FBtype);
						};
						if ($FBalbum_photo_count) {
							print $FBalbum_photo_count.' Photos';
						};
						if ($FBlocation) {
							print $this->gpf_facebook_location($FBtype, $FBlocation);
						}
						//Output Photo Description
						if ($FBdescription) {
							print $this->gpf_facebook_post_desc($FBdescription, $words, $FBtype, NULL, $FBby);
						};
						//Output Photo Description
						if (isset($gpf_gpf_popup) && $gpf_gpf_popup == 'yes') {
							print '<div class="gpf-fb-caption gpf-fb-album-view-link" style="display:block;">';
							if ($FBalbum_cover) {
								print '<a href="https://graph.facebook.com/'.$FBalbum_cover.'/picture" class="gpf-view-album-photos-large" target="_blank">'.__('View Photo', 'custom-google-plus-feed').'</a></div>';
							}
							elseif(isset($video_album) && $video_album == 'yes') {
								if($play_btn !== 'yes'){
									print '<a href="'.$d->source.'"  data-poster="'.$d->format[3]->picture.'" id="gpf-view-vid1-'.$gpf_dynamic_vid_name_string.'" class="gpf-view-fb-videos-large gpf-view-fb-videos-btn fb-video-popup-'.$gpf_dynamic_vid_name_string.'">'.__('View Video', 'custom-google-plus-feed').'</a>';
								}
								print '</div>';
							}
							else {
								print '<a href="https://graph.facebook.com/'.$FBpost_id.'/picture" class="gpf-view-album-photos-large" target="_blank">'.__('View Photo', 'custom-google-plus-feed').'</a></div>';
							}
							print '<div class="gpf-fb-caption"><a class="view-on-facebook-albums-link" href="'.$FBlink.'" target="_blank">'.__('View on Google', 'custom-google-plus-feed').'</a></div>';
						};
						print '<div class="clear"></div></div>';
					}
					print '</div>'; // end .gpf-jal-fb-top-wrap
				}
			}; //end if for show name date and comments
			//Post Type Build
			switch ($FBtype) {
				//**************************************************
				// START STATUS POST
				//**************************************************
			case 'status':
				//  && !$FBpicture == '' makes it so the attachment unavailable message does not show up
				if (!$FBpicture && !$FBname && !$FBdescription && !$FBpicture == '' ) {
					print '<div class="gpf-jal-fb-link-wrap">';
					//Output Link Picture
					if ($FBpicture) {
						print $this->gpf_facebook_post_photo($FBlink, $FBtype, $d->from->name, $d->picture);
					};
					if ($FBname || $FBcaption || $FBdescription) {
						print '<div class="gpf-jal-fb-description-wrap">';
						//Output Link Name
						if ($FBname) {
							print $this->gpf_facebook_post_name($FBlink, $FBname, $FBtype);
						};
						//Output Link Caption
						if ($FBcaption  == 'Attachment Unavailable. This attachment may have been removed or the person who shared it may not have permission to share it with you.' ) {
							print '<div class="gpf-jal-fb-caption" style="width:100% !important">';
							_e('This user\'s permissions are keeping you from seeing this post. Please Click "View on Google" to view this post on this group\'s facebook wall.', 'custom-google-plus-feed');
							print '</div>';
						}
						else {
							print $this->gpf_facebook_post_cap($FBcaption, $words, $FBtype);
						};
						//Output Link Description
						if ($FBdescription) {
							print $this->gpf_facebook_post_desc($FBdescription, $words, $FBtype);
						};
						print '<div class="clear"></div></div>';
					}
					print '<div class="clear"></div></div>';
				}
				break;
				//**************************************************
				// Start Multiple Events
				//**************************************************
			case 'events':
				$single_event_id = $d->id;
				$single_event_info = json_decode($single_event_array_response['event_single_'.$single_event_id.'_info']);
				$single_event_location = json_decode($single_event_array_response['event_single_'.$single_event_id.'_location']);
				$single_event_cover_photo = json_decode($single_event_array_response['event_single_'.$single_event_id.'_cover_photo']);
				//echo'<pre>';
				//print_r($single_event_info);
				//echo'</pre>';
				//Event Cover Photo
				$event_cover_photo = isset($single_event_cover_photo->cover->source) ? $single_event_cover_photo->cover->source : "";
				$event_description = isset($single_event_info->description) ? $single_event_info->description : "";
				print '<div class="gpf-jal-fb-right-wrap gpf-events-list-wrap">';
				//Link Picture
				$FB_event_name = isset($single_event_info->name) ? $single_event_info->name : "";
				$FB_event_location = isset($single_event_location->place->name) ? $single_event_location->place->name : "";
				$FB_event_city = isset($single_event_location->place->location->city) ? $single_event_location->place->location->city.', ' : "";
				$FB_event_state = isset($single_event_location->place->location->state) ? $single_event_location->place->location->state : "";
				$FB_event_street = isset($single_event_location->place->location->street) ? $single_event_location->place->location->street : "";
				$FB_event_zip = isset($single_event_location->place->location->zip) ? ' '.$single_event_location->place->location->zip : "";
				$FB_event_latitude = isset($single_event_location->place->location->latitude) ? $single_event_location->place->location->latitude : "";
				$FB_event_longitude = isset($single_event_location->place->location->longitude) ? $single_event_location->place->location->longitude : "";
				date_default_timezone_set(get_option('gpf-timezone'));
				$FB_event_start_time = date($CustomDateFormat, strtotime($single_event_info->start_time));
				//Output Photo Description
				if (isset($gpf_gpf_popup) && $gpf_gpf_popup == 'yes' && is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
					print '<a href="'.$event_cover_photo.'" class="gpf-jal-fb-picture gpf-fb-large-photo" target="_blank"><img class="gpf-fb-event-photo" src="'.$event_cover_photo.'"></a>';
				}
				else {
					print '<a href="https://plus.google.com/events/'.$single_event_id.'" target="_blank" class="gpf-jal-fb-picture gpf-fb-large-photo"><img class="gpf-fb-event-photo" src="'.$event_cover_photo.'" /></a>';
				}
				print '<div class="gpf-jal-fb-message">';
				//Link Name
				if ($FB_event_name) {
					print $this->gpf_facebook_post_name('https://plus.google.com/events/'.$single_event_id.'', $FB_event_name, $FBtype);
				};
				//Link Caption
				if ($FB_event_start_time) {
					print '<div class="gpf-fb-event-time">'.$FB_event_start_time.'</div>';
				};
				//Link Description
				if (!empty($FB_event_location)) {
					print '<div class="gpf-fb-location"><span class="gpf-fb-location-title">'.$FB_event_location.'</span>';
					print $FB_event_street;
					if ($FB_event_city or $FB_event_state) {
						print '<br/>'.$FB_event_city.$FB_event_state.$FB_event_zip;
					}
					print '</div>';
				}
				//Get Directions
				if (!empty($FB_event_latitude) && !empty($FB_event_longitude)) {
					print '<a target="_blank" class="gpf-fb-get-directions" href="https://www.google.com/maps/dir/Current+Location/'.$FB_event_latitude.','.$FB_event_longitude.'
">Get Directions</a>';
				}
				if (!empty($single_event_ticket_info) && !empty($single_event_ticket_info)) {
					print '<a target="_blank" class="gpf-fb-ticket-info" href="'.$single_event_ticket_info->ticket_uri.'">Ticket Info</a>';
				}
				//Output Message
				if (!empty($words) && $event_description && is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
					// here we trim the words for the premium version. The $words string actually comes from the javascript
					print $this->gpf_facebook_post_desc($event_description, $words, $FBtype, NULL, $FBby, $type);
				} //END is_plugin_active
				// if the premium plugin is not active we will just show the regular full description
				else {
					print $this->gpf_facebook_post_desc($event_description, $FBtype, NULL, $FBby, $type);
				}
				print '<div class="clear"></div></div>';
				break;
				//**************************************************
				// START LINK POST
				//**************************************************
			case 'link':
				print '<div class="gpf-jal-fb-link-wrap">';
				//start url check
				$url = $FBlink;
				$url_parts = parse_url($url);
				$host = $url_parts['host'];
				if ($host == 'www.facebook.com') {
					$spliturl= $url_parts['path'];
					$path_components = explode('/', $spliturl);
					$first_dir = $path_components[1];
					$event_id_number = isset($path_components[2]) && $path_components[2] ? $path_components[2] : '';
				}
				//end url check
				if ($host == 'www.facebook.com' and $first_dir == 'events') {
					$event_url = 'https://graph.facebook.com/'.$event_id_number.'/?access_token='.$access_token.'';
					$event_data = json_decode(file_get_contents($event_url));
					$FB_event_name = isset($event_data->name) ? $event_data->name : "";
					$FB_event_location = isset($event_data->location) ? $event_data->location : "";
					$FB_event_city = isset($event_data->venue->city) ? $event_data->venue->city : "";
					$FB_event_state = isset($event_data->venue->state) ? $event_data->venue->state : "";
					date_default_timezone_set(get_option('gpf-timezone'));
					$date = date('Y-m-d');
					$FB_event_start_time = date($CustomDateFormat, strtotime($event_data->start_time));
					echo '<a href="'.$FBlink.'" target="_blank" class="gpf-jal-fb-picture"><img class="gpf-fb-event-photo" src="http://graph.facebook.com/'.$event_id_number.'/picture"></img></a>';
					print '<div class="gpf-jal-fb-description-wrap">';
					//Output Link Name
					if ($FB_event_name) {
						print $this->gpf_facebook_post_name($FBlink, $FB_event_name, $FBtype);
					};
					//Output Link Caption
					if ($FB_event_start_time) {
						print '<div class="gpf-fb-event-time">'.$FB_event_start_time.'</div>';
					};
					//Output Link Description
					if (!empty($FB_event_location)) {
						print '<div class="gpf-fb-location">'.$FB_event_location;
						if ($FB_event_city or $FB_event_state) {
							print ' in '.$FB_event_city.', '.$FB_event_state.'';
						}
						print '</div>';
					};
					print '<div class="clear"></div></div>';
				}//end if event
				//Output Link Picture
				if ($FBpicture) {
					print $this->gpf_facebook_post_photo($FBlink, $FBtype, $d->from->name, $d->picture);
				};
				$words = isset($words) ? $words : "";
				print '<div class="gpf-jal-fb-description-wrap">';
				//Output Link Name
				if ($FBname) {
					print $this->gpf_facebook_post_name($FBlink, $FBname, $FBtype);
				};
				//Output Link Caption
				if ($FBcaption) {
					print $this->gpf_facebook_post_cap($FBcaption, $words, $FBtype);
				};
				//Output Link Description
				if ($FBdescription) {
					print $this->gpf_facebook_post_desc($FBdescription, $words, $FBtype);
				};
				print '<div class="clear"></div></div>';
				print '<div class="clear"></div></div>';
				break;
				//**************************************************
				// START VIDEO POST
				//**************************************************
			case 'video'  :


				$FBvideo = isset($d->object->attachments[0]->url) ? $d->object->attachments[0]->url : "";
				$FBvideoEmbedUrl = isset($d->object->attachments[0]->embed->url) ? $d->object->attachments[0]->embed->url : "";
				$FBvideoPicture = isset($d->object->attachments[0]->image->url) ? $d->object->attachments[0]->image->url : "";

				print '<div class="gpf-jal-fb-vid-wrap">';
				//   if (empty($FBvideoEmbedUrl)) {
				//   if ((strpos($FBlink, 'facebook') > 0)) {
				//     if (!empty($video_data->format)) {
				//   foreach ($video_data->format as $video_data_format) {
				//     if ($video_data_format->filter == 'native') {
				//        print '<div class="gpf-fluid-videoWrapper-html5">';
				//        print '<video controls poster="'.$FBvideoPicture.'" width="100%;" style="max-width:100%;" >';
				//       print '<source src="'.$FBvideo.'" type="video/mp4">';
				//       print '</video>';
				//       print '</div>';
				//   }
				//   }
				//    print '<div class="slicker-facebook-album-photoshadow"></div>';

				//   print '<div class="gpf-jal-fb-vid-wrap">';
				//   if (empty($FBvideoEmbedUrl)) {
				// if ((strpos($FBvideo, 'plus.google') > 0)) {
				// if (!empty($video_data->format)) {
				//   foreach ($video_data->format as $video_data_format) { <video controls poster="'.$FBvideoPicture.'" width="100%;" style="max-width:100%;" >
				if (empty($FBvideoEmbedUrl)) {
					print '<div class="gpf-fluid-videoWrapper-html5">';
					print '<a href="'.$FBvideo.'" target="_blank"><img src="'.$FBvideoPicture.'"/></a>';
					//  print '<source src="'.$FBvideo.'" type="video/mp4">';
					//  print '</video>';
					print '</div>';
					//   }
					//  }
					print '<div class="slicker-facebook-album-photoshadow"></div>';
					// }
				}
				else {
					//Create Dynamic Class Name
					$gpf_dynamic_vid_name_string = trim($this->rand_string(10).'_'.$type);
					$gpf_dynamic_vid_name =  'feed_dynamic_video_class'.$gpf_dynamic_vid_name_string;
					print '<div class="gpf-jal-fb-vid-picture '.$gpf_dynamic_vid_name.'"><img border="0" alt="" src="'.$FBvideoPicture.'"/> <div class="gpf-jal-fb-vid-play-btn"></div></div>';



					//strip Youtube URL then ouput Iframe and script
					if (strpos($FBvideoEmbedUrl, 'youtube') > 0) {
						$pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
						preg_match($pattern, $FBvideoEmbedUrl, $matches);
						$youtubeURLfinal = $matches[1];
						print '<script>';
						print 'jQuery(document).ready(function() {';
						print 'jQuery(".'.$gpf_dynamic_vid_name.'").click(function() {';
						print 'jQuery(this).addClass("gpf-vid-div");';
						print 'jQuery(this).removeClass("gpf-jal-fb-vid-picture");';
						print 'jQuery(this).prepend(\'<div class="gpf-fluid-videoWrapper"><iframe height="281" class="video'.$FBpost_id.'" src="http://www.youtube.com/embed/'.$youtubeURLfinal.'?autoplay=1" frameborder="0" allowfullscreen></iframe></div>\');';
						if ($gpf_grid == 'yes') {
							print 'jQuery(".gpf-slicker-facebook-posts").masonry( "reloadItems");';
							print 'jQuery(".gpf-slicker-facebook-posts").masonry( "layout" );';
						}
						print '});';
						print '});';
						print '</script>';
					}
					//strip Youtube URL then ouput Iframe and script
					else if (strpos($FBvideoEmbedUrl, 'youtu.be') > 0) {
							$pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
							preg_match($pattern, $FBvideoEmbedUrl, $matches);
							$youtubeURLfinal = $matches[1];
							print '<script>';
							print 'jQuery(document).ready(function() {';
							print 'jQuery(".'.$gpf_dynamic_vid_name.'").click(function() {';
							print 'jQuery(this).addClass("gpf-vid-div");';
							print 'jQuery(this).removeClass("gpf-jal-fb-vid-picture");';
							print 'jQuery(this).prepend(\'<div class="gpf-fluid-videoWrapper"><iframe height="281" class="video'.$FBpost_id.'" src="http://www.youtube.com/embed/'.$youtubeURLfinal.'?autoplay=1" frameborder="0" allowfullscreen></iframe></div>\');';
							if ($gpf_grid == 'yes') {
								print 'jQuery(".gpf-slicker-facebook-posts").masonry( "reloadItems");';
								print 'jQuery(".gpf-slicker-facebook-posts").masonry( "layout" );';
							}
							print '});';
							print '});';
							print '</script>';
						}
					//strip Vimeo URL then ouput Iframe and script
					else if (strpos($FBvideoEmbedUrl, 'vimeo') > 0) {
							$pattern = '/(\d+)/';
							preg_match($pattern, $FBvideoEmbedUrl, $matches);
							$vimeoURLfinal = $matches[0];
							print '<script>';
							print 'jQuery(document).ready(function() {';
							print 'jQuery(".'.$gpf_dynamic_vid_name.'").click(function() {';
							print 'jQuery(this).addClass("gpf-vid-div");';
							print 'jQuery(this).removeClass("gpf-jal-fb-vid-picture");';
							print 'jQuery(this).prepend(\'<div class="gpf-fluid-videoWrapper"><iframe src="http://player.vimeo.com/video/'.$vimeoURLfinal.'?autoplay=1" class="video'.$FBpost_id.'" height="390" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>\');';
							if ($gpf_grid == 'yes') {
								print 'jQuery(".gpf-slicker-facebook-posts").masonry( "reloadItems");';
								print 'jQuery(".gpf-slicker-facebook-posts").masonry( "layout" );';
							}
							print '});';
							print '});';
							print '</script>';
						}
					else if (strpos($FBmessage, 'soundcloud') > 0) {
							//Get the SoundCloud URL
							$url = $FBmessage;
							//Get the JSON data of song details with embed code from SoundCloud oEmbed
							$getValues=file_get_contents('http://soundcloud.com/oembed?format=js&url='.$url.'&auto_play=true&iframe=true');
							//Clean the Json to decode
							$decodeiFrame=substr($getValues, 1, -2);
							//json decode to convert it as an array
							$jsonObj = json_decode($decodeiFrame);
							//Change the height of the embed player if you want else uncomment below line
							// echo str_replace('height="400"', 'height="140"', $jsonObj->html);
							print '<script>';
							print 'jQuery(document).ready(function() {';
							print 'jQuery(".'.$gpf_dynamic_vid_name.'").click(function() {';
							print 'jQuery(this).addClass("gpf-vid-div");';
							print 'jQuery(this).removeClass("gpf-jal-fb-vid-picture");';
							print '	jQuery(this).prepend(\'<div class="gpf-fluid-videoWrapper">'.$jsonObj->html.'</div>\');';
							if ($gpf_grid == 'yes') {
								print 'jQuery(".gpf-slicker-facebook-posts").masonry( "reloadItems");';
								print 'jQuery(".gpf-slicker-facebook-posts").masonry( "layout" );';
							}
							print '});';
							print '});';
							print '</script>';
						}
				}
				//  }
				if ($FBname || $FBcaption || $FBdescription) {
					print '<div class="gpf-jal-fb-description-wrap fb-id'.$FBpost_id.'">';
					//Output Video Name
					if ($FBname) {
						print $this->gpf_facebook_post_name($FBlink, $FBname, $FBtype, $FBpost_id);
					};
					//Output Video Caption
					if ($FBcaption) {
						$words = isset($words) ? $words : '';
						print $this->gpf_facebook_post_cap($FBcaption, $words, $FBtype, $FBpost_id);
					};
					//Output Video Description
					if ($FBdescription) {
						$words = isset($words) ? $words : '';
						print $this->gpf_facebook_post_desc($FBdescription, $words, $FBtype, $FBpost_id);
					};
					print '<div class="clear"></div></div>';
				}
				print '<div class="clear"></div></div>';
				break;
				//**************************************************
				//START PHOTO POST
				//**************************************************
			case 'photo'  :
				//   print $FBpicture;
				print '<div class="gpf-jal-fb-link-wrap gpf-album-photos-wrap"';
				//   if ($type == 'album_photos' || $type == 'albums') {
				//    print 'style="line-height:'.$image_height.' !important;"';
				//   }
				print '>';
				$gpf_gpf_popup = isset($gpf_gpf_popup) ? $gpf_gpf_popup : "";
				if ($gpf_gpf_popup == 'yes') {
					print '<div class="gpf-fb-caption"><a href="'.$FBlink.'" class="gpf-view-on-facebook-link" target="_blank">'.__('View on Google', 'custom-google-plus-feed').'</a></div> ';
				}
				//Output Photo Picture
				//  if ($FBpicture) {
				if ($FBpicture) {
					print '<a href="';
					if ($gpf_gpf_popup == 'yes') {
						print $FBpictureFull;
					}
					else {
						print $FBlink;
					}
					print '" target="_blank" class="gpf-jal-fb-picture gpf-fb-large-photo"><img border="0" alt="" src="'.$FBpicture.'"></a>';
				}
				//    else {
				//     print '<a href="';
				//     if ($gpf_gpf_popup == 'yes') {
				//      $FBpicture;
				//     }
				//     else {
				//      $FBpicture;
				//     }
				//     print '" target="_blank" class="gpf-jal-fb-picture gpf-fb-large-photo"><img border="0" alt="'.$d->from->name.'" src="'.$FBpicture.'"></a>';
				//    }
				//   }
				//   elseif ($FBpictures) {
				//    if ($FBpost_object_id) {
				//    print $this->gpf_facebook_post_photo($FBlink, $type, $d->from->name, 'https://graph.facebook.com/'.$FBpost_object_id.'/picture', $image_position_lr, $image_position_top);
				//   }
				//   else {
				//    if (isset($video_album) && $video_album == 'yes'){
				//    print $this->gpf_facebook_post_photo($FBlink, $type, $d->from->name, $d->format[1]->picture, $image_position_lr, $image_position_top);
				//    }
				//    else {
				//    print $this->gpf_facebook_post_photo($FBlink, $type, $d->from->name, 'https://graph.facebook.com/'.$FBpost_id.'/picture/', $image_position_lr, $image_position_top);
				//    }
				//  }
				//  };
				print '<div class="slicker-facebook-album-photoshadow"></div>';
				// FB Video play button for facebook videos. This button takes data from our a tag and along with additional js in the magnific-popup.js we can now load html5 videos. SO lightweight this way because no pre-loading of videos are on the page. We only show the posterboard on mobile devices because tablets and desktops will auto load the videos. SRL
				if(isset($video_album) && $video_album == 'yes') {
					if($play_btn == 'yes'){
						$gpf_play_btn_visible = isset($play_btn_visible) && $play_btn_visible== 'yes' ? ' visible-video-button' : '';
						print '<a href="'.$d->source.'" data-poster="'.$d->format[3]->picture.'" id="gpf-view-vid1-'.$gpf_dynamic_vid_name_string.'" title="'.$FBdescription.'" class="gpf-view-fb-videos-btn fb-video-popup-'.$gpf_dynamic_vid_name_string . $gpf_play_btn_visible.' gpf-slicker-backg" style="height:'.$play_btn_size.' !important; width:'.$play_btn_size.'; line-height: '.$play_btn_size.'; font-size:'.$play_btn_size.'"><span class="gpf-fb-video-icon" style="height:'.$play_btn_size.' width:'.$play_btn_size.'; line-height:'.$play_btn_size.'; font-size:'.$play_btn_size.'"></span></a>';
					}
				}
				if (!$type == 'album_photos') {
					print '<div class="gpf-jal-fb-description-wrap" style="display:none">';
					//Output Photo Name
					if ($FBname) {
						print $this->gpf_facebook_post_name($FBlink, $FBname, $FBtype);
					};
					//Output Photo Caption
					if ($FBcaption) {
						print $this->gpf_facebook_post_cap($FBcaption, $words, $FBtype);
					};
					//Output Photo Description
					if ($FBdescription) {
						print $this->gpf_facebook_post_desc($FBdescription, $words, $FBtype, NULL, $FBby);
					};
					print '<div class="clear"></div></div>';
				}
				print '<div class="clear"></div></div>';
				break;
				//**************************************************
				// START ALBUM POST
				//**************************************************
			case 'app':
			case 'cover':
			case 'profile':
			case 'mobile':
			case 'wall':
			case 'normal':
			case 'album':
				print '<div class="gpf-jal-fb-link-wrap gpf-album-photos-wrap"';
				if ($type == 'album_photos' || $type == 'albums') {
					print 'style="line-height:'.$image_height.' !important;"';
				}
				print '>';
				//Output Photo Picture
				if ($FBalbum_cover) {
					print $this->gpf_facebook_post_photo($FBlink, $type, $d->from->name, $d->cover_photo->id, $image_position_lr, $image_position_top);
				};
				print '<div class="slicker-facebook-album-photoshadow"></div>';
				if (!$type == 'albums') {
					print '<div class="gpf-jal-fb-description-wrap">';
					//Output Photo Name
					if ($FBname) {
						print $this->gpf_facebook_post_name($FBlink, $FBname, $FBtype);
					};
					//Output Photo Caption
					if ($FBcaption) {
						print $this->gpf_facebook_post_cap($FBcaption, $words, $FBtype);
					};
					//Output Photo Description
					if ($FBdescription) {
						print $this->gpf_facebook_post_desc($FBdescription, $words, $FBtype, NULL, $FBby);
					};
					print '<div class="clear"></div></div>';
				}
				print '<div class="clear"></div></div>';
				break;
			}
			print '<div class="clear"></div>';
			print '</div>';
			$FBpost_single_id = isset($FBpost_single_id) ? $FBpost_single_id : "";
			$final_FBpost_like_count = isset($final_FBpost_like_count) ? $final_FBpost_like_count : "";
			$final_FBpost_comments_count = isset($final_FBpost_comments_count) ? $final_FBpost_comments_count : "";
			$single_event_id = isset($single_event_id) ? $single_event_id : "";
			print $this->gpf_facebook_post_see_more($FBlink, $final_FBpost_like_count, $final_FBpost_share_count, $final_FBpost_comments_count,  $FBtype, $FBpost_id, $type, $hide_date_likes_comments, $FBpost_user_id, $FBpost_single_id,$single_event_id,$gpf_gpf_id);
			print '<div class="clear"></div>';
			print '</div>';
			$set_zero++;
		}
		if (isset($loadmore) && $loadmore == 'button' || isset($loadmore) && $loadmore == 'autoscroll') {
			//******************
			//Load More BUTTON Start
			//******************
			$build_shortcode = '[gpf google plus';
			foreach ($atts as $attribute => $value) {
				$build_shortcode .= ' '.$attribute.'='.$value;
			}
			$build_shortcode .= ']';
			$_REQUEST['next_url'] = isset($data->nextPageToken) ? 'https://www.googleapis.com/plus/v1/people/'.$gpf_gpf_id.'/activities/public?&pageToken='.$data->nextPageToken.'&maxResults='.$posts.'&key='.$custom_access_token : "";

?>
<script>
var nextURL_<?php echo $_REQUEST['gpf_dynamic_name']; ?>= "<?php echo $_REQUEST['next_url']; ?>";
</script>
<?php
			//Make sure it's not ajaxing
			if (!isset($_GET['load_more_ajaxing']) && !isset($_REQUEST['gpf_no_more_posts']) && !empty($loadmore)) {
				$gpf_dynamic_name = $_REQUEST['gpf_dynamic_name'];
				$time = time();
				$nonce = wp_create_nonce($time."load-more-nonce");
?>
<script>
	 jQuery(document).ready(function() {
		  <?php

				if ($scrollMore == 'autoscroll') { ?>
			// this is where we do SCROLL function to LOADMORE if = autoscroll in shortcode
			jQuery(".<?php echo $gpf_dynamic_class_name ?>").bind("scroll",function() {
   				 if(jQuery(this).scrollTop() + jQuery(this).innerHeight() >= jQuery(this)[0].scrollHeight) {
		 <?php }
				else { ?>
				// this is where we do CLICK function to LOADMORE if  = button in shortcode
				jQuery("#loadMore_<?php echo $gpf_dynamic_name ?>").click(function() {
			<?php } ?>
					jQuery("#loadMore_<?php echo $gpf_dynamic_name ?>").addClass('gpf-fb-spinner');
						var button = jQuery('#loadMore_<?php echo $gpf_dynamic_name ?>').html('<div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>');
						console.log(button);
						var build_shortcode = "<?php if (get_option('gpf_fix_loadmore')) { ?>[<?php print $build_shortcode;?>]<?php } else { print $build_shortcode; } ?>";
						var yes_ajax = "yes";
						var gpf_d_name = "<?php echo $gpf_dynamic_name;?>";
						var gpf_security = "<?php echo $nonce;?>";
						var gpf_time = "<?php echo $time;?>";
				//		var gpf_offset_posts = "< ?php echo $_REQUEST['next_offset'];?>";
					jQuery.ajax({
						data: {action: "my_gpf_gpf_load_more", next_url: nextURL_<?php echo $gpf_dynamic_name ?>, gpf_dynamic_name: gpf_d_name, rebuilt_shortcode: build_shortcode, load_more_ajaxing: yes_ajax, gpf_security: gpf_security, gpf_time: gpf_time},
						type: 'GET',
						url: myAjaxFTS,
						success: function( data ) {
							console.log('Well Done and got this from sever: ' + data);
				 <?php if ($FBtype && $type == 'albums'|| $FBtype && $type == 'album_photos' && $video_album !== 'yes' || $gpf_grid == 'yes') {  ?>
					 	jQuery('.<?php echo $gpf_dynamic_class_name ?>').append(data).filter('.<?php echo $gpf_dynamic_class_name ?>').html();
													jQuery('.<?php echo $gpf_dynamic_class_name ?>').masonry( 'reloadItems' );
												setTimeout(function() {
												// Do something after 3 seconds
												// This can be direct code, or call to some other function
									jQuery('.<?php echo $gpf_dynamic_class_name ?>').masonry( 'layout' );
											}, 500);
						if(!nextURL_<?php echo $_REQUEST['gpf_dynamic_name']; ?> || nextURL_<?php echo $_REQUEST['gpf_dynamic_name']; ?> == 'no more'){
						  jQuery('#loadMore_<?php echo $gpf_dynamic_name ?>').replaceWith('<div class="gpf-fb-load-more no-more-posts-gpf-fb"><?php _e('No More Photos', 'custom-google-plus-feed') ?></div>');
						  jQuery('#loadMore_<?php echo $gpf_dynamic_name ?>').removeAttr('id');
						  jQuery(".<?php echo $gpf_dynamic_class_name ?>").unbind('scroll');
						}
					<?php }
				else {

					if(isset($video_album) && $video_album == 'yes') { ?>
													var result = jQuery(data).insertBefore( jQuery('#output_<?php echo $gpf_dynamic_name ?>') );

					var result = jQuery('.feed_dynamic_<?php echo $gpf_dynamic_name ?>_album_photos').append(data).filter('#output_<?php echo $gpf_dynamic_name ?>').html();
												<?php }else{ ?>

					var result = jQuery('#output_<?php echo $gpf_dynamic_name ?>').append(data).filter('#output_<?php echo $gpf_dynamic_name ?>').html();

												<?php } ?>
						jQuery('#output_<?php echo $gpf_dynamic_name ?>').html(result);
						if(!nextURL_<?php echo $_REQUEST['gpf_dynamic_name']; ?> || nextURL_<?php echo $_REQUEST['gpf_dynamic_name']; ?> == 'no more'){
						  jQuery('#loadMore_<?php echo $gpf_dynamic_name ?>').replaceWith('<div class="gpf-fb-load-more no-more-posts-gpf-fb"><?php _e('No More Posts', 'custom-google-plus-feed') ?></div>');
						  jQuery('#loadMore_<?php echo $gpf_dynamic_name ?>').removeAttr('id');
						  jQuery(".<?php echo $gpf_dynamic_class_name ?>").unbind('scroll');
						}
					<?php } ?>
					 jQuery('#loadMore_<?php echo $gpf_dynamic_name ?>').html('<?php _e('Load More', 'custom-google-plus-feed') ?>');
					  //	jQuery('#loadMore_< ?php echo $gpf_dynamic_name ?>').removeClass('flip360-gpf-load-more');
					 jQuery("#loadMore_<?php echo $gpf_dynamic_name ?>").removeClass('gpf-fb-spinner');
						}
					}); // end of ajax()
					return false;
					<?php // string $scrollMore is at top of this js script. acception for scroll option closing tag
				if ($scrollMore == 'autoscroll' ) { ?>
								} // end of scroll ajax load.
					 <?php } ?>
		  }); // end of document.ready
	  }); // end of form.submit
</script>
<?php
			}//End Check
			// main closing div not included in ajax check so we can close the wrap at all times
			//Make sure it's not ajaxing
			if (!isset($_GET['load_more_ajaxing'])) {
				$gpf_dynamic_name = $_REQUEST['gpf_dynamic_name'];
				// this div returns outputs our ajax request via jquery appenc html from above  style="display:nonee;"
				print '<div id="output_'.$gpf_dynamic_name.'"></div>';
				if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php') && $scrollMore == 'autoscroll') {
					print '<div id="loadMore_'.$gpf_dynamic_name.'" class="gpf-fb-load-more gpf-fb-autoscroll-loader">Google</div>';
				}
			}

		}// end of if loadmore is button or autoscroll
		
		//******************
		// SOCIAL BUTTON
		//******************
		if (!isset($_GET['load_more_ajaxing'])) {
			if(isset($gpf_show_follow_btn) && $gpf_show_follow_btn !== 'no' && $gpf_show_follow_btn_where == 'facebook-follow-below' && $hide_like_option !== 'yes'){
				$like_option_align_final = isset($like_option_align) ? 'gpf-fb-social-btn-'.$like_option_align.'' : '';
				echo '<div class="fb-social-btn-bottom '.$like_option_align_final.'">';
				$this->social_follow_button('facebook', $id, $access_token);
				echo '</div>';
			}
		}
		print '</div>'; // closing main div for fb photos, groups etc
?>
<?php //only show this script if the height option is set to a number
		if ($height !== 'auto' && empty($height) == NULL) { ?>
<script>
											// this makes it so the page does not scroll if you reach the end of scroll bar or go back to top
											jQuery.fn.isolatedScrollFacebookFTS = function() {
													this.bind('mousewheel DOMMouseScroll', function (e) {
													var delta = e.wheelDelta || (e.originalEvent && e.originalEvent.wheelDelta) || -e.detail,
														bottomOverflow = this.scrollTop + jQuery(this).outerHeight() - this.scrollHeight >= 0,
														topOverflow = this.scrollTop <= 0;
													if ((delta < 0 && bottomOverflow) || (delta > 0 && topOverflow)) {
														e.preventDefault();
													}
												});
												return this;
											};
											jQuery('.gpf-fb-scrollable').isolatedScrollFacebookFTS();
										 </script>
<?php } //end $height !== 'auto' && empty($height) == NULL ?>
<?php
		//Make sure it's not ajaxing
		if (!isset($_GET['load_more_ajaxing'])) {
			print '<div class="clear"></div><div id="fb-root"></div>';
			if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php') && $scrollMore == 'button') {
				// gpf-fb-header-wrapper
				if ($gpf_grid !== 'yes' && $type !== 'album_photos' && $type !== 'albums') {  print '<div class="gpf-fb-load-more-wrapper">'; }
				print '<div id="loadMore_'.$gpf_dynamic_name.'" style="max-width:'.$loadmore_btn_maxwidth.';margin:'.$loadmore_btn_margin.' auto '.$loadmore_btn_margin.'" class="gpf-fb-load-more">'.__('Load More', 'custom-google-plus-feed').'</div>';
				if ($gpf_grid !== 'yes' && $type !== 'album_photos' && $type !== 'albums') {  print '</div>'; }
			}
		}//End Check
		unset($_REQUEST['next_url']);
		
		return ob_get_clean();
	}
	//**************************************************
	// Google Post Location
	//**************************************************
	function gpf_facebook_location($FBtype = NULL, $location) {
		switch ($FBtype) {
		case 'app':
		case 'cover':
		case 'profile':
		case 'mobile':
		case 'wall':
		case 'normal':
		case 'album':
			$output = '<div class="gpf-fb-location">'.$location.'</div>';
			return $output;
		}
	}
	//**************************************************
	// Google Post Photo
	//**************************************************
	function gpf_facebook_post_photo($FBlink, $type, $photo_from, $photo_source, $image_position_lr = NULL, $image_position_top = NULL) {
		if ($type == 'album_photos' || $type == 'albums') {
			$output =  '<a href="'.$FBlink.'" target="_blank" class="gpf-jal-fb-picture album-photo-gpf"';
			if ($image_position_lr !== '-0%' || $image_position_top !== '-0%') {
				$output .= 'style="right:'.$image_position_lr.';left:'.$image_position_lr.';top:'.$image_position_top.'"';
			}
			if ($type == 'albums') {
				$output .= '><img border="0" alt="' .$photo_from.'" src="https://graph.facebook.com/'.$photo_source.'/picture"/>';
			}
			else {
				$output .= '><img border="0" alt="' .$photo_from.'" src="'.$photo_source.'"/>';
			}
			$output .= '</a>';
		}
		else {
			$output =  '<a href="'.$FBlink.'" target="_blank" class="gpf-jal-fb-picture"><img border="0" alt="' .$photo_from.'" src="'.$photo_source.'"/></a>';
		}
		return $output;
	}
	//**************************************************
	// Google Post Name
	//**************************************************
	function gpf_facebook_post_name($FBlink, $FBname, $FBtype, $FBpost_id = NULL) {
		switch ($FBtype) {
		case 'video':
			$FBname = $this->gpf_facebook_tag_filter($FBname);
			$output = '<a href="'.$FBlink.'" target="_blank" class="gpf-jal-fb-name fb-id'.$FBpost_id.'">'.$FBname.'</a>';
			return $output;
		default:
			$FBname = $this->gpf_facebook_tag_filter($FBname);
			$output = '<a href="'.$FBlink.'" target="_blank" class="gpf-jal-fb-name">'.$FBname.'</a>';
			return $output;
		}
	}
	//**************************************************
	// Google Post Description
	//**************************************************
	function gpf_facebook_post_desc($FBdescription, $words, $FBtype, $FBpost_id = NULL, $FBby = NULL, $type = NULL) {
		switch ($FBtype) {
		case 'video':
			$FBdescription = $this->gpf_facebook_tag_filter($FBdescription);
			$output = '<div class="gpf-jal-fb-description fb-id'.$FBpost_id.'">'.$FBdescription.'</div>';
			return $output;
		case 'photo':
			if ($type == 'album_photos') {
				if ($words) {
					$more = isset($more) ? $more : "";
					$trimmed_content = $this->gpf_custom_trim_words($FBdescription, $words, $more);
					$output = '<div class="gpf-jal-fb-description">'.$trimmed_content.'</div>';
					return $output;
				}
				elseif($words !== '0') {
					$FBdescription = $this->gpf_facebook_tag_filter($FBdescription);
					$output = '<div class="gpf-jal-fb-description">'.nl2br($FBdescription).'</div>';
					return $output;
				}
			}
		case 'albums':
			if ($type == 'albums') {
				if ($words) {
					$more = isset($more) ? $more : "";
					$trimmed_content = $this->gpf_custom_trim_words($FBdescription, $words, $more);
					$output = '<div class="gpf-jal-fb-description">'.$trimmed_content.'</div>';
					return $output;
				}
				else {
					$FBdescription = $this->gpf_facebook_tag_filter($FBdescription);
					$output = '<div class="gpf-jal-fb-description">'.nl2br($FBdescription).'</div>';
					return $output;
				}
			}
			//Do for Default feeds or the video gallery feed
			else {
				$FBdescription = $this->gpf_facebook_tag_filter($FBdescription);
				if ($words && $words !== '0') {
					$more = isset($more) ? $more : "";
					$trimmed_content = $this->gpf_custom_trim_words($FBdescription, $words, $more);
					$output = '<div class="gpf-jal-fb-description">'.$trimmed_content.'</div>';
				}
				else {
					$output = '<div class="gpf-jal-fb-description">';
					$output .= nl2br($FBdescription);
					$output .= '</div>';
				}
				if (!empty($FBlink)) {
					$output .= '<div>By: <a href="'.$FBlink.'">'.$FBby.'<a/></div>';
				}
				if($words !== '0') {
					return $output;
				}
			}
		default:
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
			if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
				// here we trim the words for the links description text... for the premium version. The $words string actually comes from the javascript
				if ($words) {
					$more = isset($more) ? $more : "";
					$trimmed_content = $this->gpf_custom_trim_words($FBdescription, $words, $more);
					$output = '<div class="jal-fb-description">'.$trimmed_content.'</div>';
					return $output;
				}
				elseif($words !== '0') {
					$FBdescription = $this->gpf_facebook_tag_filter($FBdescription);
					$output = '<div class="jal-fb-description">'.nl2br($FBdescription).'</div>';
					return $output;
				}
			} //END is_plugin_active
			// if the premium plugin is not active we will just show the regular full description
			else {
				$FBdescription = $this->gpf_facebook_tag_filter($FBdescription);
				$output = '<div class="jal-fb-description">'.nl2br($FBdescription).'</div>';
				return $output;
			}
		}
	}
	//**************************************************
	// Generate Post Caption
	//**************************************************
	function gpf_facebook_post_cap($FBcaption, $words, $FBtype, $FBpost_id = NULL) {
		switch ($FBtype) {
		case 'video':


			$FBcaption = $this->gpf_facebook_tag_filter(str_replace('www.', '', $FBcaption));

			$output = '<div class="gpf-jal-fb-caption fb-id'.$FBpost_id.'">'.$FBcaption.'</div>';
			return $output;
		default:
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
			if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {


				// here we trim the words for the links description text... for the premium version. The $words string actually comes from the javascript
				if ($words) {
					$more = isset($more) ? $more : "";
					$trimmed_content = $this->gpf_custom_trim_words($FBcaption, $words, $more);
					$output = '<div class="jal-fb-caption">'.$trimmed_content.'</div>';
				}
				else {
					$FBcaption = $this->gpf_facebook_tag_filter($FBcaption);
					$output = '<div class="jal-fb-caption">'.nl2br($FBcaption).'</div>';
				}
			} //END is_plugin_active
			// if the premium plugin is not active we will just show the regular full description
			else {
				$FBcaption = $this->gpf_facebook_tag_filter($FBcaption);
				$output = '<div class="jal-fb-caption">'.nl2br($FBcaption).'</div>';
			}
			return $output;
		}
	}
	//**************************************************
	// Generate See More Button
	//**************************************************
	function gpf_facebook_post_see_more($FBlink, $final_FBpost_like_count, $final_FBpost_comments_count, $final_FBpost_share_count, $FBtype, $FBpost_id = NULL, $type, $hide_date_likes_comments, $FBpost_user_id = NULL, $FBpost_single_id = NULL, $single_event_id = null, $gpf_gpf_id) {
		switch ($FBtype) {
		case 'events':
			$output = '<a href="https://plus.google.com/events/'.$single_event_id.'" target="_blank" class="gpf-jal-fb-see-more">'.__('View on Google', 'custom-google-plus-feed').'</a>';
			return $output;
		case 'photo':
			if (!empty($FBlink)) {
				$output = '<a href="'.$FBlink.'" target="_blank" class="gpf-jal-fb-see-more">';
			}
			// exception for videos
			else {
				$output = '<a href="https://plus.google.com/'.$FBpost_id.'/" target="_blank" class="gpf-jal-fb-see-more">';
			}
			if ($type == 'album_photos' && $hide_date_likes_comments == 'yes') { }
			else {
				$output .= ''.$final_FBpost_like_count.' '.$final_FBpost_comments_count.' '.$final_FBpost_share_count.' &nbsp;&nbsp;';
			}
			$output .='&nbsp;'.__('View on Google', 'custom-google-plus-feed').'</a>';
			return $output;
		case 'app':
		case 'cover':
		case 'profile':
		case 'mobile':
		case 'wall':
		case 'normal':
		case 'album':
		case 'events':
			$output = '<a href="'.$FBlink.'" target="_blank" class="gpf-jal-fb-see-more">';
			if ($type = 'albums' && $hide_date_likes_comments == 'yes') { }
			else {
				$output .= ''.$final_FBpost_like_count.' '.$final_FBpost_comments_count.' &nbsp;&nbsp;';
			}
			$output .='&nbsp;'.__('View on Google', 'custom-google-plus-feed').'</a>';
			return $output;
		default:
			$output = '<a href="'.$FBlink.'" target="_blank" class="gpf-jal-fb-see-more">';
			$output .= ''.$final_FBpost_like_count.' '.$final_FBpost_comments_count.' '.$final_FBpost_share_count.' &nbsp;&nbsp;&nbsp;'.__('View on Google', 'custom-google-plus-feed').'</a>';
			return $output;
		}
	}
	//**************************************************
	// Trim Word
	//**************************************************
	function gpf_custom_trim_words( $text, $num_words = 45, $more) {

		isset($num_words) && $num_words !== 0 ? $more = __( '...' ) : '';

		$text = nl2br($text);
		//Filter for Hashtags and Mentions Before returning.
		$text= $this->gpf_facebook_tag_filter($text);
		$text = strip_shortcodes($text);
		// Add tags that you don't want stripped
		$text = strip_tags( $text, '<strong><br><em><i><a>' );
		$words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
		$sep = ' ';
		if ( count( $words_array ) > $num_words ) {
			array_pop( $words_array );
			$text = implode( $sep, $words_array );
			$text = $text . $more;
		} else {
			$text = implode( $sep, $words_array );
		}
		return wpautop( $text );
	}
	//**************************************************
	// Tags Filter (return clean tags)
	//**************************************************
	function gpf_facebook_tag_filter($FBdescription) {
		//Converts URLs to Links
		$FBdescription = preg_replace('@(?!(?!.*?<a)[^<]*<\/a>)(?:(?:https?|ftp|file)://|www\.|ftp\.)[-A-‌​Z0-9+&#/%=~_|$?!:,.]*[A-Z0-9+&#/%=~_|$]@i', '<a href="\0" target="_blank">\0</a>', $FBdescription);
		// Mentions
		$FBdescription = preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a target="_blank" href="https://plus.google.com/$1">@$1</a>', $FBdescription);
		//Hash tags
		$FBdescription = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a target="_blank" href="https://plus.google.com/hashtag/$1">#$1</a>', $FBdescription);
		return $FBdescription;
	}
	//**************************************************
	// Create a random string
	//**************************************************
	function rand_string( $length = 10) {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
new FTS_Google_Plus_Feed();
?>