<?php
namespace Google_Plus_Feed;
class google_feed_settings_page {
	function __construct() {
	}
	//**************************************************
	// Main Settings Page
	//**************************************************
	function google_feed_settings_page() {
		$gpf_functions = new Google_Plus_Feed_Functions();

		if(!function_exists( 'curl_init' )) {
			print '<div class="error"><p>'.__('Warning: cURL is not installed on this server. It is required to use this plugin. Please contact your host provider to install this.', 'custom-google-plus-feed').'</p></div>';
		} ?>

		<div class="google-plus-feed-admin-wrap">
  <div class="gpf-backg"></div>
  <div class="gpf-content">
		  <h1><?php _e('Google Plus Feed', 'custom-google-plus-feed'); ?></h1>
		  <div class="use-of-plugin"><?php _e('Please select what type of feed you would like to see. Then you can copy and paste the shortcode to a page, post or widget.', 'custom-google-plus-feed'); ?></div>
		  <div class="google-plus-feed-icon-wrap">
		   <a href="https://plus.google.com/+SlickremixPlugins" target="_blank" class="google-icon">Google+</a>
		    <?php
		//show the js for the discount option under social icons on the settings page
		if(!is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) { ?>
				 <div id="discount-for-review"><?php _e('15% off Premium Version', 'custom-google-plus-feed'); ?></div>
		    <div class="discount-review-text"><a href="http://www.slickremix.com/downloads/custom-google-plus-feed-premium/" target="_blank"><?php _e('Share here', 'custom-google-plus-feed'); ?></a> <?php _e('and receive 15% OFF your total order.', 'custom-google-plus-feed'); ?></div>
		<?php } ?>
		  </div>
			<form class="google-plus-feed-admin-form">
		    	<select id="shortcode-form-selector">
		        	<option value=""><?php _e('Select an option to get started', 'custom-google-plus-feed'); ?> </option>
		            <option value="fb-page-shortcode-form"><?php _e('Google Feed', 'custom-google-plus-feed'); ?></option>
		        </select>
		    </form><!--/google-plus-feed-admin-form-->
			 <?php
		// these is our form option from the functions page
		echo $gpf_functions->gpf_facebook_page_form(false);
?>
		    <div class="clear"></div>
		 <div class="google-plus-feed-clear-cache">
		 <h2><?php _e('Clear All Cache Options', 'custom-google-plus-feed'); ?></h2>
		    <div class="use-of-plugin"><?php _e('Please Clear Cache if you have changed a Google Shortcode. This will Allow you to see the changes right away.', 'custom-google-plus-feed'); ?></div>
		<?php if(isset($_GET['cache']) && $_GET['cache']=='clearcache'){
			echo '<div class="google-plus-feed-clear-cache-text">'.$gpf_functions->google_plus_feed_clear_cache().'</div>';
		}
		isset($gpfDevModeCache) ? $gpfDevModeCache : "";
		isset($gpfAdminBarMenu) ? $gpfAdminBarMenu : "";
		$gpfDevModeCache = get_option('gpf_clear_cache_developer_mode');
		$gpfAdminBarMenu = get_option('gpf_admin_bar_menu');
?>




		    <form method="post" action="?page=google-feed-settings-page&cache=clearcache">
		       <input class="google-plus-feed-admin-submit-btn" type="submit" value="<?php _e('Clear All Google Feeds Cache', 'custom-google-plus-feed'); ?>" />
		    </form>
		  </div><!--/google-plus-feed-clear-cache-->
		  <!-- custom option for padding -->
		  <form method="post" class="gpf-color-settings-admin-form" action="options.php">
			 <p>
		     <input name="gpf_clear_cache_developer_mode" class="gpf-color-settings-admin-input gpf_clear_cache_developer_mode" type="checkbox"  id="gpf-color-options-settings-custom-css" value="1" <?php echo checked( '1', get_option( 'gpf_clear_cache_developer_mode' ) ); ?>/>
		        <?php
		if (get_option( 'gpf_clear_cache_developer_mode' ) == '1') { ?>
		                          <?php _e('Cache will clear on every page load now', 'custom-google-plus-feed'); ?> <?php
		}
		else { ?>
		                          <?php _e('Developer Mode: Clear cache on every page load', 'custom-google-plus-feed'); ?> <?php
		}
?>
		         </p>
		        <select id="gpf_admin_bar_menu" name="gpf_admin_bar_menu">
		            <option value="show-admin-bar-menu" <?php if ($gpfAdminBarMenu == 'show-admin-bar-menu' ) echo 'selected="selected"'; ?>><?php _e('Show Admin Bar Menu', 'custom-google-plus-feed'); ?></option>
		            <option value="hide-admin-bar-menu" <?php if ($gpfAdminBarMenu == 'hide-admin-bar-menu' ) echo 'selected="selected"'; ?>><?php _e('Hide Admin Bar Menu', 'custom-google-plus-feed'); ?></option>
		        </select>
		   <div class="google-plus-feed-custom-css">
		  <?php // get our registered settings from the gpf functions
		settings_fields('google-plus-feed-settings'); ?>
		  <?php
		isset($gpfDateTimeFormat) ? $gpfDateTimeFormat : "";
		isset($gpfTimezone) ? $gpfTimezone : "";
		$gpfDateTimeFormat = get_option('gpf-date-and-time-format');
		$gpfTimezone = get_option('gpf-timezone');
		date_default_timezone_set(get_option('gpf-timezone', 'America/Los_Angeles'));
?>
		  <div style="float:left; max-width:400px; margin-right:30px;"><h2><?php _e('Google Feed Date Format', 'custom-google-plus-feed'); ?></h2>
		   <fieldset>
		        <select id="gpf-date-and-time-format" name="gpf-date-and-time-format">
		            <option value="l, F jS, Y \a\t g:ia" <?php if ($gpfDateTimeFormat == 'l, F jS, Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('l, F jS, Y \a\t g:ia'); ?></option>
		            <option value="F j, Y \a\t g:ia" <?php if ($gpfDateTimeFormat == 'F j, Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('F j, Y \a\t g:ia'); ?></option>
		            <option value="F j, Y g:ia" <?php if ($gpfDateTimeFormat == 'F j, Y g:ia' ) echo 'selected="selected"'; ?>><?php echo date('F j, Y g:ia'); ?></option>
		            <option value="F, Y \a\t g:ia" <?php if ($gpfDateTimeFormat == 'F, Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('F, Y \a\t g:ia'); ?></option>
		            <option value="M j, Y @ g:ia" <?php if ($gpfDateTimeFormat == 'M j, Y @ g:ia' ) echo 'selected="selected"'; ?>><?php echo date('M j, Y @ g:ia'); ?></option>
		            <option value="M j, Y @ G:i" <?php if ($gpfDateTimeFormat == 'M j, Y @ G:i' ) echo 'selected="selected"'; ?>><?php echo date('M j, Y @ G:i'); ?></option>
		            <option value="m/d/Y \a\t g:ia" <?php if ($gpfDateTimeFormat == 'm/d/Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('m/d/Y \a\t g:ia'); ?></option>
		            <option value="m/d/Y @ G:i" <?php if ($gpfDateTimeFormat == 'm/d/Y @ G:i' ) echo 'selected="selected"'; ?>><?php echo date('m/d/Y @ G:i'); ?></option>
		            <option value="d/m/Y \a\t g:ia" <?php if ($gpfDateTimeFormat == 'd/m/Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('d/m/Y \a\t g:ia'); ?></option>
		            <option value="d/m/Y @ G:i" <?php if ($gpfDateTimeFormat == 'd/m/Y @ G:i' ) echo 'selected="selected"'; ?>><?php echo date('d/m/Y @ G:i'); ?></option>
		            <option value="Y/m/d \a\t g:ia" <?php if ($gpfDateTimeFormat == 'Y/m/d \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('Y/m/d \a\t g:ia'); ?></option>
		            <option value="Y/m/d @ G:i" <?php if ($gpfDateTimeFormat == 'Y/m/d @ G:i' ) echo 'selected="selected"'; ?>><?php echo date('Y/m/d @ G:i'); ?></option>
		        </select>
			</fieldset>
		</div>
		<div style="float:left; max-width:330px"> <h2><?php _e('TimeZone', 'custom-google-plus-feed'); ?></h2>
		    <fieldset>
		        <select id="gpf-timezone" name="gpf-timezone">
		          <option value="Kwajalein" <?php if($gpfTimezone == "Kwajalein") echo 'selected="selected"' ?> >
		          <?php _e('UTC-12:00'); ?>
		          </option>
		          <option value="Pacific/Midway" <?php if($gpfTimezone == "Pacific/Midway") echo 'selected="selected"' ?> >
		          <?php _e('UTC-11:00'); ?>
		          </option>
		          <option value="Pacific/Honolulu" <?php if($gpfTimezone == "Pacific/Honolulu") echo 'selected="selected"' ?> >
		          <?php _e('UTC-10:00'); ?>
		          </option>
		          <option value="America/Anchorage" <?php if($gpfTimezone == "America/Anchorage") echo 'selected="selected"' ?> >
		          <?php _e('UTC-09:00'); ?>
		          </option>
		          <option value="America/Los_Angeles" <?php if($gpfTimezone == "America/Los_Angeles") echo 'selected="selected"' ?> >
		          <?php _e('UTC-08:00'); ?>
		          </option>
		          <option value="America/Denver" <?php if($gpfTimezone == "America/Denver") echo 'selected="selected"' ?> >
		          <?php _e('UTC-07:00'); ?>
		          </option>
		          <option value="America/Chicago" <?php if($gpfTimezone == "America/Chicago") echo 'selected="selected"' ?> >
		          <?php _e('UTC-06:00'); ?>
		          </option>
		          <option value="America/New_York" <?php if($gpfTimezone == "America/New_York") echo 'selected="selected"' ?> >
		          <?php _e('UTC-05:00'); ?>
		          </option>
		          <option value="America/Caracas" <?php if($gpfTimezone == "America/Caracas") echo 'selected="selected"' ?> >
		          <?php _e('UTC-04:30'); ?>
		          </option>
		          <option value="America/Halifax" <?php if($gpfTimezone == "America/Halifax") echo 'selected="selected"' ?> >
		          <?php _e('UTC-04:00'); ?>
		          </option>
		          <option value="America/St_Johns" <?php if($gpfTimezone == "America/St_Johns") echo 'selected="selected"' ?> >
		          <?php _e('UTC-03:30'); ?>
		          </option>
		          <option value="America/Sao_Paulo" <?php if($gpfTimezone == "America/Sao_Paulo") echo 'selected="selected"' ?> >
		          <?php _e('UTC-03:00'); ?>
		          </option>
		          <option value="America/Noronha" <?php if($gpfTimezone == "America/Noronha") echo 'selected="selected"' ?> >
		          <?php _e('UTC-02:00'); ?>
		          </option>
		          <option value="Atlantic/Cape_Verde" <?php if($gpfTimezone == "Atlantic/Cape_Verde") echo 'selected="selected"' ?> >
		          <?php _e('UTC-01:00'); ?>
		          </option>
		          <option value="Europe/Belfast" <?php if($gpfTimezone == "Europe/Belfast") echo 'selected="selected"' ?> >
		          <?php _e('UTC'); ?>
		          <option value="Europe/Amsterdam" <?php if($gpfTimezone == "Europe/Amsterdam") echo 'selected="selected"' ?> >
		          <?php _e('UTC+01:00'); ?>
		          </option>
		          <option value="Asia/Beirut" <?php if($gpfTimezone == "Asia/Beirut") echo 'selected="selected"' ?> >
		          <?php _e('UTC+02:00'); ?>
		          </option>
		          <option value="Europe/Moscow" <?php if($gpfTimezone == "Europe/Moscow") echo 'selected="selected"' ?> >
		          <?php _e('UTC+03:00'); ?>
		          </option>
		          <option value="Asia/Tehran" <?php if($gpfTimezone == "Asia/Tehran") echo 'selected="selected"' ?> >
		          <?php _e('UTC+03:30'); ?>
		          </option>
		          <option value="Asia/Yerevan" <?php if($gpfTimezone == "Asia/Yerevan") echo 'selected="selected"' ?> >
		          <?php _e('UTC+04:00'); ?>
		          </option>
		          <option value="Asia/Kabul" <?php if($gpfTimezone == "Asia/Kabul") echo 'selected="selected"' ?> >
		          <?php _e('UTC+04:30'); ?>
		          </option>
		          <option value="Asia/Tashkent" <?php if($gpfTimezone == "Asia/Tashkent") echo 'selected="selected"' ?> >
		          <?php _e('UTC+05:00'); ?>
		          </option>
		          <option value="Asia/Kolkata" <?php if($gpfTimezone == "Asia/Kolkata") echo 'selected="selected"' ?> >
		          <?php _e('UTC+05:30'); ?>
		          </option>
		          <option value="Asia/Katmandu" <?php if($gpfTimezone == "Asia/Katmandu") echo 'selected="selected"' ?> >
		          <?php _e('UTC+05:45'); ?>
		          </option>
		          <option value="Asia/Dhaka" <?php if($gpfTimezone == "Asia/Dhaka") echo 'selected="selected"' ?> >
		          <?php _e('UTC+06:00'); ?>
		          </option>
		          <option value="Asia/Novosibirsk" <?php if($gpfTimezone == "Asia/Novosibirsk") echo 'selected="selected"' ?> >
		          <?php _e('UTC+06:00'); ?>
		          </option>
		          <option value="Asia/Rangoon" <?php if($gpfTimezone == "Asia/Rangoon") echo 'selected="selected"' ?> >
		          <?php _e('UTC+06:30'); ?>
		          </option>
		          <option value="Asia/Bangkok" <?php if($gpfTimezone == "Asia/Bangkok") echo 'selected="selected"' ?> >
		          <?php _e('UTC+07:00'); ?>
		          </option>
		          <option value="Australia/Perth" <?php if($gpfTimezone == "Australia/Perth") echo 'selected="selected"' ?> >
		          <?php _e('UTC+08:00'); ?>
		          </option>
		          <option value="Australia/Eucla" <?php if($gpfTimezone == "Australia/Eucla") echo 'selected="selected"' ?> >
		          <?php _e('UTC+08:45'); ?>
		          </option>
		          <option value="Asia/Tokyo" <?php if($gpfTimezone == "Asia/Tokyo") echo 'selected="selected"' ?> >
		          <?php _e('UTC+09:00'); ?>
		          </option>
		          <option value="Australia/Adelaide" <?php if($gpfTimezone == "Australia/Adelaide") echo 'selected="selected"' ?> >
		          <?php _e('UTC+09:30'); ?>
		          </option>
		          <option value="Australia/Hobart" <?php if($gpfTimezone == "Australia/Hobart") echo 'selected="selected"' ?> >
		          <?php _e('UTC+10:00'); ?>
		          </option>
		          <option value="Australia/Lord_Howe" <?php if($gpfTimezone == "Australia/Lord_Howe") echo 'selected="selected"' ?> >
		          <?php _e('UTC+10:30'); ?>
		          </option>
		          <option value="Asia/Magadan" <?php if($gpfTimezone == "Asia/Magadan") echo 'selected="selected"' ?> >
		          <?php _e('UTC+11:00'); ?>
		          </option>
		          <option value="Pacific/Norfolk" <?php if($gpfTimezone == "Pacific/Norfolk") echo 'selected="selected"' ?> >
		          <?php _e('UTC+11:30'); ?>
		          </option>
		          <option value="Asia/Anadyr" <?php if($gpfTimezone == "Asia/Anadyr") echo 'selected="selected"' ?> >
		          <?php _e('UTC+12:00'); ?>
		          </option>
		          <option value="Pacific/Chatham" <?php if($gpfTimezone == "Pacific/Chatham") echo 'selected="selected"' ?> >
		          <?php _e('UTC+12:45'); ?>
		          </option>
		          <option value="Pacific/Tongatapu" <?php if($gpfTimezone == "Pacific/Tongatapu") echo 'selected="selected"' ?> >
		          <?php _e('UTC+13:00'); ?>
		          </option>
		          <option value="Pacific/Kiritimati" <?php if($gpfTimezone == "Pacific/Kiritimati") echo 'selected="selected"' ?> >
		          <?php _e('UTC+14:00'); ?>
		          </option>
		        </select>
		    </fieldset>
		</div>
		<div class="clear"></div>
		<br/>
		   <h2><?php _e('Custom CSS Option', 'custom-google-plus-feed'); ?></h2>
		     <p>
		        <input name="gpf-color-options-settings-custom-css" class="gpf-color-settings-admin-input" type="checkbox"  id="gpf-color-options-settings-custom-css" value="1" <?php echo checked( '1', get_option( 'gpf-color-options-settings-custom-css' ) ); ?>/>
		        <?php
		if (get_option( 'gpf-color-options-settings-custom-css' ) == '1') { ?>
		                           <strong><?php _e('Checked:', 'custom-google-plus-feed'); ?></strong> <?php _e('Custom CSS option is being used now.', 'custom-google-plus-feed'); ?> <?php
		}
		else { ?>
		                          <strong><?php _e('Not Checked:', 'custom-google-plus-feed'); ?></strong> <?php _e('You are using the default CSS.', 'custom-google-plus-feed'); ?> <?php
		}
?>
		       </p>
		         <label class="toggle-custom-textarea-show"><span><?php _e('Show', 'custom-google-plus-feed'); ?></span><span class="toggle-custom-textarea-hide"><?php _e('Hide', 'custom-google-plus-feed'); ?></span> <?php _e('custom CSS', 'custom-google-plus-feed'); ?></label>
		          <div class="clear"></div>
		       <div class="gpf-custom-css-text"><?php _e('Thanks for using our plugin :) Add your custom CSS additions or overrides below.', 'custom-google-plus-feed'); ?></div>
		      <textarea name="gpf-color-options-main-wrapper-css-input" class="gpf-color-settings-admin-input" id="gpf-color-options-main-wrapper-css-input"><?php echo get_option('gpf-color-options-main-wrapper-css-input'); ?></textarea>
		      </div><!--/google-plus-feed-custom-css-->


      <div class="google-plus-feed-custom-logo-css">

          <?php if(is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) { ?>

      <h2><?php _e('Disable Magnific Popup CSS', 'custom-google-plus-feed'); ?></h2>
		     <p>
		        <input name="gpf_fix_magnific" class="gpf-powered-by-settings-admin-input" type="checkbox" id="gpf_fix_magnific" value="1" <?php echo checked( '1', get_option( 'gpf_fix_magnific' ) ); ?>/> <?php _e('Check this if you are experiencing problems with your theme(s) or other plugin(s) popups.', 'custom-google-plus-feed'); ?>
		      </p>
		     <br/>



		     <h2><?php _e('Load More Options', 'custom-google-plus-feed'); ?></h2>
		     <p>
		        <input name="gpf_fix_loadmore" class="gpf-powered-by-settings-admin-input" type="checkbox" id="gpf_fix_loadmore" value="1" <?php echo checked( '1', get_option( 'gpf_fix_loadmore' ) ); ?>/> <?php _e('Check this if you are using the loadmore button for Google or Instagram and are seeing a bunch of code under it.', 'custom-google-plus-feed'); ?>
		      </p>
		     <br/>
		     <?php } ?>

		   <h2><?php _e('Powered by Text', 'custom-google-plus-feed'); ?></h2>
		     <p>
		        <input name="gpf-powered-text-options-settings" class="gpf-powered-by-settings-admin-input" type="checkbox" id="gpf-powered-text-options-settings" value="1" <?php echo checked( '1', get_option( 'gpf-powered-text-options-settings' ) ); ?>/>
		        <?php
		if (get_option( 'gpf-powered-text-options-settings' ) == '1') { ?>
					   <strong><?php _e('Checked:', 'custom-google-plus-feed'); ?></strong> <?php _e('You are not showing the Powered by Logo.', 'custom-google-plus-feed'); ?> <?php
		}
		else { ?>
					  <strong><?php _e('Not Checked:', 'custom-google-plus-feed'); ?></strong> <?php _e('The Powered by text will appear in the site. Awesome! Thanks so much for sharing.', 'custom-google-plus-feed'); ?> <?php
		}
?>
		      </p>
		     <br/>
		          <input type="submit" class="google-plus-feed-admin-submit-btn" value="<?php _e('Save All Changes', 'custom-google-plus-feed') ?>" />
		      <div class="clear"></div>
		      </div><!--/google-plus-feed-custom-logo-css-->
		       </form>
  </div><!--/font-content-->
</div><!--/google-plus-feed-admin-wrap-->

  <h1 class="plugin-author-note"><?php _e('Plugin Authors Note', 'custom-google-plus-feed'); ?></h1>
  <div class="gpf-plugin-reviews">
			<div class="gpf-plugin-reviews-rate"><?php _e('Google Plus Feed was created by 2 Brothers, Spencer and Justin Labadie. That’s it, 2 people! We spend all our time creating and supporting this plugin. Show us some love if you like our plugin and leave a quick review for us, it will make our day!', 'custom-google-plus-feed'); ?> <a href="https://wordpress.org/support/view/plugin-reviews/google-plus-feed" target="_blank"><?php _e('Leave us a Review', 'custom-google-plus-feed'); ?> ★★★★★</a>
			</div>
			<div class="gpf-plugin-reviews-support"><?php _e('If you\'re having troubles getting setup please contact us. We will respond within 24hrs, but usually within 1-6hrs.', 'custom-google-plus-feed'); ?>
				 <a href="http://www.slickremix.com/support-forum/forum/google-plus-feed-2" target="_blank"><?php _e('Support Forum', 'custom-google-plus-feed'); ?></a>
		  	<div class="gpf-text-align-center"><a class="google-plus-feed-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a></div>
			</div>
		</div>

		<script>
		jQuery(function() {
			// Master feed selector
		    jQuery('#shortcode-form-selector').change(function(){
		        jQuery('.shortcode-generator-form').hide();
		        jQuery('.' + jQuery(this).val()).fadeIn('fast');

		    });

								jQuery('#gpf_hide_like_box_button').change(function(){
								jQuery('.gpf_align_likebox').toggle();
						});

								jQuery('#facebook_show_video_button').change(function(){
								jQuery('.fb-video-play-btn-options-content').toggle();
						});


			 // change the feed type 'how to' message when a feed type is selected
			jQuery('#facebook-messages-selector').change(function(){
		        jQuery('.facebook-message-generator').hide();
		        jQuery('.' + jQuery(this).val()).fadeIn('fast');
				// if the facebook type select is changed we hide the shortcode code so not to confuse people
				jQuery('.final-shortcode-textarea').hide();
			// only show the Super Gallery Options if the facebook ablum or album covers feed type is selected
			 var facebooktype = jQuery("select#facebook-messages-selector").val();

				<?php
		// changing this slightly for now.
		if (is_plugin_active('custom-google-plus-feed-premium/google-plus-feed.php')) { ?>


					if (facebooktype == 'album_videos') {
						jQuery('.gpf-premium-options-message, .gpf-photos-popup, #facebook_super_gallery_container, #facebook_super_gallery_animate').hide();
				 	jQuery('.video, .fb-video-play-btn-options-wrap, #facebook_video_align_images_wrapper').show();
				 	jQuery(".google-plus-feed-admin-input-label:contains('Album')").html("<?php _e('Video Album ID (required)', 'custom-google-plus-feed') ?>");
				  jQuery(".google-plus-feed-admin-input-label:contains('# of Posts')").html("<?php _e('# of Videos', 'custom-google-plus-feed') ?>");
						}
					else {
					 jQuery('.video, .fb-video-play-btn-options-wrap, #facebook_video_align_images_wrapper').hide();
						jQuery('.gpf-photos-popup, #facebook_super_gallery_container, #facebook_super_gallery_animate').show();
				  jQuery(".google-plus-feed-admin-input-label:contains('Video Album ID (required)')").html("<?php _e('Album ID (required)', 'custom-google-plus-feed') ?>");
				  jQuery(".google-plus-feed-admin-input-label:contains('# of Videos')").html("<?php _e('# of Posts', 'custom-google-plus-feed') ?>");
					}
			<?php }
		else { ?>
					if (facebooktype == 'album_videos') {
						// we are hiding all fields in the free verison and adding am upgrade message, much easier this way as the options add up.
						jQuery('.fb-options-wrap').hide();
						jQuery('.gpf-premium-options-message').show();

					}
					else {
						jQuery('.fb-options-wrap').show();
					 	jQuery('.gpf-premium-options-message, .video').hide();
					}
					<?php } ?>

					if (facebooktype == 'page') {
						jQuery('.inst-text-facebook-page').show();
					}
					else {
						jQuery('.inst-text-facebook-page').hide();
					}

					if (facebooktype == 'albums' || facebooktype == 'album_photos' || facebooktype == 'album_videos') {
		    jQuery('.gpf-super-facebook-options-wrap').show();
						jQuery('.fixed_height_option').hide();
						jQuery('.fb-posts-in-grid-option-wrap').hide();
						jQuery('.fixed_height_option').hide();
						jQuery(".google-plus-feed-admin-input-label:contains('<?php _e('Display Posts in Grid', 'custom-google-plus-feed'); ?>')").parent('div').hide();
		 		 }
				 else {
		    jQuery('.gpf-super-facebook-options-wrap').hide();
					 jQuery('.fixed_height_option').show();
					 jQuery('.fb-posts-in-grid-option-wrap').show();
					 jQuery(".google-plus-feed-admin-input-label:contains('<?php _e('Display Posts in Grid', 'custom-google-plus-feed'); ?>')").parent('div').show();
				 }
				 // only show the post type visible if the facebook page feed type is selected
				 jQuery('.facebook-post-type-visible').hide();
				  if (facebooktype == 'page' ) {
		 		 	jQuery('.facebook-post-type-visible').show();
				 }
			var gpf_feed_type_option = jQuery("select#facebook-messages-selector").val();
				if (gpf_feed_type_option == 'album_photos' || gpf_feed_type_option == 'album_videos') {
						jQuery('.gpf_album_photos_id').show();
					}
					else {
						jQuery('.gpf_album_photos_id').hide();
					}
		    });


		   // facebook show grid options
		  jQuery('#fb-grid-option').bind('change', function (e) {
		    if( jQuery('#fb-grid-option').val() == 'yes') {
		      jQuery('.gpf-facebook-grid-options-wrap').show();
			  jQuery(".google-plus-feed-admin-input-label:contains('<?php _e('Center Google Container?', 'custom-google-plus-feed'); ?>')").parent('div').show();
		    }
		    else{
		      jQuery('.gpf-facebook-grid-options-wrap').hide();
		    }
		  });
		  // facebook Super Gallery option
		  jQuery('#facebook-custom-gallery').bind('change', function (e) {
		    if( jQuery('#facebook-custom-gallery').val() == 'yes') {
		      jQuery('.gpf-super-facebook-options-wrap').show();
		    }
		    else{
		      jQuery('.gpf-super-facebook-options-wrap').hide();
		    }
		  });
		   // facebook show load more options
		  jQuery('#gpfload_more_option').bind('change', function (e) {
		    if( jQuery('#gpfload_more_option').val() == 'yes') {

											if(jQuery('#facebook-messages-selector').val() !== 'album_videos') {
												jQuery('.gpf-facebook-load-more-options-wrap').show();
											}
												jQuery('.gpf-facebook-load-more-options2-wrap').show();
										}

		    else{
		      jQuery('.gpf-facebook-load-more-options-wrap, .gpf-facebook-load-more-options2-wrap').hide();
		    }
		  });

		  });
		// JS

		function updateTextArea_gpf_page() {
			var gpf_feed_type = ' type=' + jQuery("select#facebook-messages-selector").val();
			var gpf_page_id = ' id=' + jQuery("input#gpf_page_id").val();
			var gpf_album_id = ' album_id=' + jQuery("input#gpf_album_id").val();
			var gpf_page_posts_displayed = ' posts_displayed=' + jQuery("select#gpf_page_posts_displayed").val();
			var facebook_height = jQuery("input#facebook_page_height").val();
			// var super_gallery = ' super_gallery=' + jQuery("select#facebook-custom-gallery").val();
			var image_width = ' image_width=' + jQuery("input#gpf-slicker-facebook-container-image-width").val();
			var image_height = ' image_height=' + jQuery("input#gpf-slicker-facebook-container-image-height").val();
			var space_between_photos = ' space_between_photos=' + jQuery("input#gpf-slicker-facebook-container-margin").val();
			var hide_date_likes_comments = ' hide_date_likes_comments=' + jQuery("select#gpf-slicker-facebook-container-hide-date-likes-comments").val();
			var center_container = ' center_container=' + jQuery("select#gpf-slicker-facebook-container-position").val();
			var image_stack_animation = ' image_stack_animation=' + jQuery("select#gpf-slicker-facebook-container-animation").val();
			var position_lr = ' image_position_lr=' + jQuery("input#gpf-slicker-facebook-image-position-lr").val();
			var position_top = ' image_position_top=' + jQuery("input#gpf-slicker-facebook-image-position-top").val();
			if (gpf_page_id == " id=") {
			  	 jQuery(".gpf_page_id").addClass('gpf-empty-error');
		      	 jQuery("input#gpf_page_id").focus();
				 return false;
			}
			if (gpf_page_id != " id=") {
			  	 jQuery(".gpf_page_id").removeClass('gpf-empty-error');
			}
			if (gpf_album_id == " album_id=" && gpf_feed_type == " type=album_photos" || gpf_album_id == " album_id=" && gpf_feed_type == " type=album_videos") {
			  	 jQuery(".gpf_album_photos_id").addClass('gpf-empty-error');
		      	 jQuery("input#gpf_album_id").focus();
				 return false;
			}
			if (gpf_album_id != " album_id=") {
			  	 jQuery(".gpf_album_photos_id").removeClass('gpf-empty-error');
			}
			if (facebook_height)	{
				var facebook_height_final = ' height=' + jQuery("input#facebook_page_height").val();
			}
			else {
				var facebook_height_final = '';
			}
			var super_gallery_option = jQuery("select#facebook-custom-gallery").val();
				var albums_photos_option = jQuery("select#facebook-messages-selector").val();
			<?php
		//Premium Plugin
		if(is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			include WP_CONTENT_DIR.'/plugins/custom-google-plus-feed-premium/admin/js/facebook-page-settings-js.js';
		}
		else  { ?>
						if (albums_photos_option == "page") {
							var final_gpf_page_shortcode = '[gpf google plus' + gpf_page_id + facebook_height_final + gpf_feed_type + ']';
						}
		<?php } ?>
			jQuery('.facebook-page-final-shortcode').val(final_gpf_page_shortcode);
			jQuery('.fb-page-shortcode-form .final-shortcode-textarea').slideDown();
		}
		//END Google Page//

		//select all
		jQuery(".copyme").focus(function() {
		    var jQuerythis = jQuery(this);
		    jQuerythis.select();
		    // Work around Chrome's little problem
		    jQuerythis.mouseup(function() {
		        // Prevent further mouseup intervention
		        jQuerythis.unbind("mouseup");
		        return false;
		    });
		});
		jQuery( document ).ready(function() {
		  jQuery( ".toggle-custom-textarea-show" ).click(function() {
				 jQuery('textarea#gpf-color-options-main-wrapper-css-input').slideToggle();
				  jQuery('.toggle-custom-textarea-show span').toggle();
				  jQuery('.gpf-custom-css-text').toggle();
		});
		<?php
		//show the js for the discount option under social icons on the settings page
		if(is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			// do not show the js below
		}
		else { ?>
				jQuery( "#discount-for-review" ).click(function() {
					 jQuery('.discount-review-text').slideToggle();
				});
		<?php } ?>
		  }); //end document ready

		  <?php
		//Premium JS
		if(is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			// include WP_CONTENT_DIR.'/plugins/custom-google-plus-feed-premium/admin/js/youtube-settings-js.js';
		}
?>
</script>
<?php }
}//END Class