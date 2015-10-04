<?php
namespace Google_Plus_Feed;
class Google_Plus_Feed_Functions {
	public $output = "";
	function __construct() {
		$root_file = plugin_dir_path(dirname( __FILE__));
		$this->premium = str_replace('custom-google-plus-feed/', 'custom-google-plus-feed-premium/', $root_file);
		//Google Activation Function. Commenting out for future use. SRL
		// register_activation_hook( FEED_THEM_MAIN_FILE , array( $this, 'gpf_plugin_activation'));

		//$load_gpf->gpf_get_check_plugin_version('custom-google-plus-feed.php', '1.3.0');
		register_deactivation_hook( __FILE__, array( $this, 'gpf_get_check_plugin_version' ));
		// Widget Code
		add_filter('widget_text', 'do_shortcode');
		// This is for the gpf_clear_cache_ajax submission
		add_action( 'init', array( $this, 'gpf_clear_cache_script'));
		add_action( 'wp_head', array($this, 'my_gpf_ajaxurl'));
		add_action( 'wp_ajax_gpf_clear_cache_ajax', array($this, 'gpf_clear_cache_ajax'));
		// If Premium is actuive
		if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			// Load More Options
			// add_action( 'init', array($this, 'my_gpf_gpf_script_enqueuer'));
			add_action( 'wp_ajax_my_gpf_gpf_load_more', array($this, 'my_gpf_gpf_load_more'));
			add_action( 'wp_ajax_nopriv_my_gpf_gpf_load_more', array($this, 'my_gpf_gpf_load_more'));
		}//END if premium

		// 1.8.3 is where we changed everything to be namespaced.
		$plugins_proper_vs = '1.0.0';
		// gpfystem_version() function is coming from feed-them.php our main page
		$plugins_newer_check = gpfystem_version();
		$old_plugs = $this->old_extenstions_check();
		//If there are old plugins Display notice!
		if($old_plugs == true && $plugins_proper_vs > $plugins_newer_check){
			add_action('admin_notices', array($this,'gpf_old_plugin_admin_notice'));
			add_action('admin_init', array($this, 'gpf_old_plugins_ignore'));
		}
		if( $plugins_proper_vs > $plugins_newer_check) {
			add_action( 'admin_init', array($this, 'gpf_old_extenstions_block'));
		}
	}
	//**************************************************
	// Add FTS options on activation. Commenting out for future use. SRL
	//**************************************************
	// function gpf_plugin_activation() {
	//Options List
	//    $activation_options = array(
	//     'gpf_language' => 'en_US',
	//    );
	//    foreach($activation_options as $option_key => $option_value){
	//     add_option($option_key, $option_value);
	//    }
	// }

	//**************************************************
	// Block for Old Extenstions
	//**************************************************
	function gpf_old_extenstions_block() {
		global $current_user;
		$user_id = $current_user->ID;
		$list_old_plugins = array(
			'custom-google-plus-feed-premium/custom-google-plus-feed-premium.php',
		);
		$plugins = get_plugins();
		foreach($list_old_plugins as $single_plugin){
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
			if(isset($plugins[$single_plugin])) {
				global $gpf_versions_needed;
				if ($plugins[$single_plugin]['Version'] < $gpf_versions_needed[$single_plugin]) {
					//Don't Let Old Plugins Activate
					deactivate_plugins($single_plugin);
					if (isset( $_GET['activate'] ) ) {
						delete_user_meta( $user_id, 'gpf_old_plugins_ignore');
						unset( $_GET['activate'] );
					}
				}
			}
		}
	}
	//**************************************************
	// Check for Old Extenstions
	//**************************************************
	function old_extenstions_check() {
		// Check if get_plugins() function exists. This is required on the front end of the
		// site, since it is in a file that is normally only loaded in the admin.
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$all_plugins = get_plugins();
		$list_old_plugins = array(
			'custom-google-plus-feed-premium/custom-google-plus-feed-premium.php',
		);

		$any_old_plugins = false;
		if($all_plugins){
			foreach($all_plugins as $single_plugin => $single_plugin_info){
				//Are there old plugins Install in WordPress
				$any_old_plugins = in_array($single_plugin, $list_old_plugins);
				if($any_old_plugins){
					return true;
				}
			}
		}
	}
	//**************************************************
	// Old Extenstions List
	//**************************************************
	function gpf_old_plugin_admin_notice() {
		global $current_user ;
		$is_an_admin = in_array('administrator', $current_user->roles);
		$user_id = $current_user->ID;
		/* Check that the user hasn't already clicked to ignore the message */
		if (!get_user_meta($user_id, 'gpf_old_plugins_ignore') && !isset($_POST['gpf-prem-notice']) && $is_an_admin == true) {
			echo '<div class="gpf-update-message gpf_old_plugins_message">';
			printf(__('Please update ALL Premium Extensions for Google Plus Feed because they will no longer work with this version of Google Plus Feed. We have made some Major Changes to the Core of the plugin to help with plugin conflicts. Please update your extensions from your <a href="http://www.slickremix.com/my-account" target="_blank">My Account</a> page on our website if you are not receiving notifications for updates on the premium extensions. Thanks again for using our plugin! | <a href="%1$s">HIDE NOTICE</a>'), '?gpf_old_plugins_ignore=0');
			echo "</div>";
			$_POST['gpf-prem-notice']= 1;
		}
	}
	//**************************************************
	// Ignore Old Extenstions List
	//**************************************************
	function gpf_old_plugins_ignore() {
		global $current_user;
		$is_an_admin = in_array('administrator', $current_user->roles);
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset($_GET['gpf_old_plugins_ignore']) && '0' == $_GET['gpf_old_plugins_ignore'] && $is_an_admin == true) {
			add_user_meta($user_id, 'gpf_old_plugins_ignore', 'true', true);
			//delete_user_meta( $user_id, 'das_old_plugins_ignore');
		}
	}

	//**************************************************
	// For Loading in the Admin.
	//**************************************************
	function init() {
		if ( is_admin() ) {
			// Register Settings
			add_action('admin_init', array($this, 'gpf_settings_page_register_settings' ));
			add_action('admin_init', array($this, 'gpf_google_style_options_page' ));

			// Adds setting page to FTS menu
			add_action('admin_menu', array($this, 'Feed_Them_Main_Menu'));
			add_action('admin_menu', array($this, 'Feed_Them_Submenu_Pages'));
			// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
			add_action('admin_enqueue_scripts', array($this, 'google_plus_feed_admin_css'));
			//Main Settings Page
			if (isset($_GET['page']) && $_GET['page'] == 'google-feed-settings-page' or isset($_GET['page']) && $_GET['page'] == 'google-feed-styles-submenu-page' or isset($_GET['page'])) {
				add_action('admin_enqueue_scripts',  array( $this, 'google_plus_feed_settings'));
			}
			//System Info Page
			if (isset($_GET['page']) && $_GET['page'] == 'google-feed-system-info-submenu-page') {
				add_action('admin_enqueue_scripts', array( $this, 'google_plus_feed_system_info_css'));
			}
		}//end if admin
		//FTS Admin Bar
		add_action('wp_before_admin_bar_render', array( $this, 'gpf_admin_bar_menu'), 999);
		//Settings option. Add Custom CSS to the header of FTS pages only
		$gpf_include_custom_css_checked_css =  get_option( 'gpf-color-options-settings-custom-css' );
		if ($gpf_include_custom_css_checked_css == '1') {
			add_action('wp_enqueue_scripts', array( $this, 'gpf_color_options_head_css'));
		}
		//Google Settings option. Add Custom CSS to the header of FTS pages only
		$gpf_include_gpf_custom_css_checked_css =  '1'; //get_option( 'gpf-color-options-settings-custom-css' );
		if ($gpf_include_gpf_custom_css_checked_css == '1') {
			add_action('wp_enqueue_scripts', array( $this, 'gpf_gpf_color_options_head_css'));
		}
		//Settings option. Custom Powered by Google Plus Feed Option
		$gpf_powered_text_options_settings =  get_option( 'gpf-powered-text-options-settings' );
		if ($gpf_powered_text_options_settings != '1') {
			add_action('wp_enqueue_scripts', array( $this, 'gpf_powered_by_js'));
		}
	}//end if init
	//**************************************************
	// ajax var on front end for twitter videos and loadmore button (if premium active)
	function my_gpf_ajaxurl() {
		wp_enqueue_script( 'jquery' ); ?>
<script type="text/javascript">
var myAjaxFTS = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
	}
	//**************************************************
	// enqueue and localise scripts
	// THE AJAX ADD ACTIONS
	// this function is being called from the fb feed... it calls the ajax in this case.
	//**************************************************
	function my_gpf_gpf_load_more() {
		if ( !wp_verify_nonce( $_REQUEST['gpf_security'], $_REQUEST['gpf_time'].'load-more-nonce')) {
			exit( 'Sorry, You can\'t do that!' );
		}
		else {
			if (preg_match('/\[gpf google plus/', $_REQUEST['rebuilt_shortcode']) || preg_match('/\[gpf instagram/', $_REQUEST['rebuilt_shortcode'])) {
				$object = do_shortcode($_REQUEST['rebuilt_shortcode']);
				echo $object;
			}
			else {
				exit( 'That is not an Google shortcode!' );
			}
		}
		die();
	}
	//**************************************************
	// This is for the gpf_clear_cache_ajax submission
	//**************************************************
	function gpf_clear_cache_script() {
		isset($gpfDevModeCache) ? $gpfDevModeCache : "";
		isset($gpfAdminBarMenu) ? $gpfAdminBarMenu : "";
		$gpfAdminBarMenu = get_option('gpf_admin_bar_menu');
		$gpfDevModeCache = get_option('gpf_clear_cache_developer_mode');
		if ($gpfDevModeCache == '1') {
			wp_enqueue_script( 'gpf_clear_cache_script', WP_PLUGIN_URL .'/custom-google-plus-feed/admin/js/developer-admin.js', array( 'jquery' ) );
			wp_localize_script( 'gpf_clear_cache_script', 'gpfAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'gpf_clear_cache_script' );
		}
		if (!$gpfDevModeCache == 'hide-admin-bar-menu' && !$gpfDevModeCache == '1') {
			wp_enqueue_script( 'gpf_clear_cache_script', WP_PLUGIN_URL .'/custom-google-plus-feed/admin/js/admin.js', array( 'jquery' ) );
			wp_enqueue_script( 'gpf_clear_cache_script', WP_PLUGIN_URL .'/custom-google-plus-feed/admin/js/developer-admin.js', array( 'jquery' ) );
			wp_localize_script( 'gpf_clear_cache_script', 'gpfAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'gpf_clear_cache_script' );
		}
	}
	//**************************************************
	// Admin menu buttons
	//**************************************************
	function Feed_Them_Main_Menu() {
		//Main Settings Page
		$main_settings_page = new google_feed_settings_page();
		add_menu_page('Google Plus Feed', 'Google Feed', 'manage_options', 'google-feed-settings-page', array($main_settings_page,'google_feed_settings_page'), '');
		add_submenu_page('google-feed-settings-page', __('Settings', 'custom-google-plus-feed'),  __('Settings', 'custom-google-plus-feed'), 'manage_options', 'google-feed-settings-page' );
	}
	//**************************************************
	// Admin Submenu buttons // add the word setting in place of the default menu page name 'Feed Them'
	//**************************************************
	function Feed_Them_Submenu_Pages() {
		//Google Options Page
		$facebook_options_page = new FTS_google_options_page();
		add_submenu_page(
			'google-feed-settings-page',
			__('Google Options', 'custom-google-plus-feed'),
			__('Google Options', 'custom-google-plus-feed'),
			'manage_options',
			'google-feed-styles-submenu-page',
			array($facebook_options_page,'google_feed_style_options_page')
		);
		//System Info
		$system_info_page = new GF_system_info_page();
		add_submenu_page(
			'google-feed-settings-page',
			__('System Info', 'custom-google-plus-feed'),
			__('System Info', 'custom-google-plus-feed'),
			'manage_options',
			'google-feed-system-info-submenu-page',
			array($system_info_page,'google_feed_system_info_page')
		);
	}
	//**************************************************
	// Admin CSS
	//**************************************************
	function google_plus_feed_admin_css() {
		wp_register_style( 'google_plus_feed_admin', plugins_url( 'admin/css/admin.css', dirname(__FILE__) ) );
		wp_enqueue_style('google_plus_feed_admin');
	}
	//**************************************************
	// Admin System Info CSS
	//**************************************************
	function google_plus_feed_system_info_css() {
		wp_register_style( 'gpf-settings-admin-css', plugins_url( 'admin/css/admin-settings.css',  dirname(__FILE__) ) );
		wp_enqueue_style('gpf-settings-admin-css');
	}
	//**************************************************
	// Admin Settings Scripts and CSS
	//**************************************************
	function google_plus_feed_settings() {
		wp_register_style( 'google_plus_feed_settings_css', plugins_url( 'admin/css/settings-page.css',  dirname(__FILE__) ) );
		wp_enqueue_style('google_plus_feed_settings_css');
		if (isset($_GET['page']) && $_GET['page'] == 'google-feed-styles-submenu-page' or isset($_GET['page']) && $_GET['page'] == 'gpf-twitter-feed-styles-submenu-page') {
			wp_enqueue_script( 'google_plus_feed_style_options_color_js', plugins_url( 'admin/js/jscolor/jscolor.js',  dirname(__FILE__) ) );
		}
	}
	//**************************************************
	// Admin Premium Settings Fields
	//**************************************************
	function need_gpf_premium_fields($fields) {
		$output = isset($output) ? $output : "";
		foreach ($fields as $key => $label) {
			$output .= '<div class="google-plus-feed-admin-input-wrap">';
			$output .= '<div class="google-plus-feed-admin-input-label">'.$label.'</div>';
			$output .= '<div class="google-plus-feed-admin-input-default">Must have <a target="_blank" href="http://www.slickremix.com/downloads/custom-google-plus-feed-premium/">premium version</a> to edit.</div>';
			$output .= '<div class="clear"></div>';
			$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		}//END Foreach
		return $output;
	}
	//**************************************************
	// Generic Register Settings function
	//**************************************************
	function register_settings($settings_name , $settings) {
		foreach ($settings as $key => $setting) {
			register_setting( $settings_name, $setting);
		}
	}
	//**************************************************
	// Register Google Style Options.
	//**************************************************
	function gpf_google_style_options_page() {
		$gpf_style_options = array(
			'gpf_app_ID',
			'gpf_follow_count',
			'gpf_language',
			'gpf_show_follow_btn',
			'gpf_show_follow_like_box_cover',
			'gpf_show_follow_btn_where',
			'gpf_header_extra_text_color',
			'gpf_text_color',
			'gpf_link_color',
			'gpf_link_color_hover',
			'gpf_feed_width',
			'gpf_feed_margin',
			'gpf_feed_padding',
			'gpf_feed_background_color',
			'gpf_grid_posts_background_color',
			'gpf_border_bottom_color',
			'gpf_custom_api_token',
			'gpf_event_title_color',
			'gpf_event_title_size',
			'gpf_event_maplink_color',
			'gpf_events_title_color',
			'gpf_events_title_size',
			'gpf_events_map_link_color',
			'gpf_hide_shared_by_etc_text',
		);
		$this->register_settings('gpf-google-feed-style-options', $gpf_style_options);
	}
	//**************************************************
	// Register Google Free Version Settings.
	//**************************************************
	function gpf_settings_page_register_settings() {
		$settings = array(
			'instagram_show_follow_btn',
			'gpf_admin_bar_menu',
			'gpf_clear_cache_developer_mode',
			'gpf-date-and-time-format',
			'gpf-timezone',
			'gpf_fix_magnific',
			'gpf-color-options-settings-custom-css',
			'gpf-color-options-main-wrapper-css-input',
			'gpf-powered-text-options-settings',
			'gpf-slicker-instagram-icon-center',
			'gpf-slicker-instagram-container-image-size',
			'gpf-slicker-instagram-container-hide-date-likes-comments',
			'gpf-slicker-instagram-container-position',
			'gpf-slicker-instagram-container-animation',
			'gpf-slicker-instagram-container-margin',
			'gpf_fix_loadmore',
		);
		$this->register_settings('google-plus-feed-settings', $settings);
	}
	//**************************************************
	// Social Follow Button.
	//**************************************************
	function social_follow_button($feed, $user_id, $access_token = NULL) {
		global $channel_id, $playlist_id, $username_subscribe_btn, $username;
		$output = '';
		switch ($feed) {
		case 'facebook':
			//Google settings options for follow button
			$gpf_show_follow_btn = get_option('gpf_show_follow_btn');
			$gpf_show_follow_like_box_cover = get_option('gpf_show_follow_like_box_cover');
			$gpf_follow_count = get_option('gpf_follow_count', 'none');

			$language_option_check = get_option('gpf_language');
			$gpf_app_ID = get_option('gpf_app_ID');

			if (isset($language_option_check) && $language_option_check !== 'Please Select Option') {
				$language_option = get_option('gpf_language', 'en_US');
			}
			else {
				$language_option = 'en_US';
			}
			$gpf_like_btn_color = get_option('gpf_like_btn_color', 'light');
			// var_dump( $gpf_like_btn_color ); /* outputs 'default_value' */

			$show_faces = $gpf_show_follow_btn == 'like-button-share-faces' || $gpf_show_follow_btn == 'like-button-faces' || $gpf_show_follow_btn == 'like-box-faces' ? 'true' : 'false';
			$share_button = $gpf_show_follow_btn == 'like-button-share-faces' || $gpf_show_follow_btn == 'like-button-share' ? 'true' : 'false';
			$page_cover = $gpf_show_follow_like_box_cover == 'gpf_like_box_cover-yes' ? 'true' : 'false';
			//  if(!isset($_POST['gpf_facebook_script_loaded'])){
			$output .='<script src="https://apis.google.com/js/platform.js" async defer></script>';
			$output .='<div class="g-follow" data-href="https://plus.google.com/'.$user_id.'" data-rel="author" data-annotation="'.$gpf_follow_count.'"></div>';
			$_POST['gpf_facebook_script_loaded'] = 'yes';
			//   }
			print $output;
			break;
		}
	}
	//**************************************************
	// Color Options for Google.
	//**************************************************
	function gpf_color_options_head_css() { ?>
		<style type="text/css"><?php echo get_option('gpf-color-options-main-wrapper-css-input');?></style>
	<?php
	}
	//**************************************************
	// Color Options CSS for Google.
	//**************************************************
	function gpf_gpf_color_options_head_css() {
		$gpf_header_extra_text_color = get_option('gpf_header_extra_text_color');
		$gpf_text_color = get_option('gpf_text_color');
		$gpf_link_color = get_option('gpf_link_color');
		$gpf_link_color_hover = get_option('gpf_link_color_hover');
		$gpf_feed_width = get_option('gpf_feed_width');
		$gpf_feed_margin = get_option('gpf_feed_margin');
		$gpf_feed_padding = get_option('gpf_feed_padding');
		$gpf_feed_background_color = get_option('gpf_feed_background_color');
		$gpf_grid_posts_background_color = get_option('gpf_grid_posts_background_color');
		$gpf_border_bottom_color = get_option('gpf_border_bottom_color'); ?>

			<style type="text/css">
			<?php if (!empty($gpf_header_extra_text_color)) { ?>
			.gpf-jal-single-fb-post .gpf-jal-fb-user-name { color:<?php echo $gpf_header_extra_text_color ?>!important; }
			<?php }
		if (!empty($gpf_text_color)) { ?>
			.gpf-simple-fb-wrapper .gpf-jal-single-fb-post,
			.gpf-simple-fb-wrapper .gpf-jal-fb-description-wrap,
			.gpf-simple-fb-wrapper .gpf-jal-fb-post-time,
			.gpf-slicker-facebook-posts .gpf-jal-single-fb-post,
			.gpf-slicker-facebook-posts .gpf-jal-fb-description-wrap,
			.gpf-slicker-facebook-posts .gpf-jal-fb-post-time { color:<?php echo $gpf_text_color ?>!important; }
			<?php }
		if (!empty($gpf_link_color)) { ?>
			.gpf-simple-fb-wrapper .gpf-jal-single-fb-post a,
			.gpf-fb-load-more-wrapper .gpf-fb-load-more,
			.gpf-slicker-facebook-posts .gpf-jal-single-fb-post a,
			.gpf-fb-load-more-wrapper .gpf-fb-load-more { color:<?php echo $gpf_link_color ?>!important; }
			<?php }
		if (!empty($gpf_link_color_hover)) { ?>
			.gpf-simple-fb-wrapper .gpf-jal-single-fb-post a:hover,
			.gpf-simple-fb-wrapper .gpf-fb-load-more:hover,
			.gpf-slicker-facebook-posts .gpf-jal-single-fb-post a:hover,
			.gpf-slicker-facebook-posts .gpf-fb-load-more:hover { color:<?php echo $gpf_link_color_hover ?>!important; }
			<?php }
		if (!empty($gpf_feed_width)) { ?>
			.gpf-simple-fb-wrapper, .gpf-fb-header-wrapper, .gpf-fb-load-more-wrapper { max-width:<?php echo $gpf_feed_width ?> !important; }
			<?php }
		if (!empty($gpf_feed_margin)) { ?>
			.gpf-simple-fb-wrapper, .gpf-fb-header-wrapper, .gpf-fb-load-more-wrapper { margin:<?php echo $gpf_feed_margin ?> !important; }
			<?php }
		if (!empty($gpf_feed_padding)) { ?>
			.gpf-simple-fb-wrapper { padding:<?php echo $gpf_feed_padding ?>!important; }
			<?php }
		if (!empty($gpf_feed_background_color)) { ?>
			.gpf-simple-fb-wrapper, .gpf-fb-load-more-wrapper .gpf-fb-load-more { background:<?php echo $gpf_feed_background_color ?>!important; }
			<?php }
		if (!empty($gpf_grid_posts_background_color)) { ?>
			.gpf-slicker-facebook-posts .gpf-jal-single-fb-post { background:<?php echo $gpf_grid_posts_background_color ?>!important; }
			<?php }
		if (!empty($gpf_border_bottom_color)) { ?>
			.gpf-slicker-facebook-posts .gpf-jal-single-fb-post, .gpf-jal-single-fb-post { border-bottom:1px solid <?php echo $gpf_border_bottom_color ?>!important; }
			<?php } ?>
			</style>
	<?php
	}
	//**************************************************
	// FTS Powered By.
	//**************************************************
	function gpf_powered_by_js() {
		wp_enqueue_script( 'gpf_powered_by_js', plugins_url( 'feeds/js/powered-by.js',  dirname(__FILE__) ), array( 'jquery' )
		);
	}
	//**************************************************
	// Google List of Events Form.
	//**************************************************
	function gpf_facebook_list_of_events_form($save_options = false) {
		if ($save_options) {
			$gpf_event_id_option = get_option('gpf_event_id');
			$gpf_event_post_count_option = get_option('gpf_event_post_count');
			$gpf_event_title_option = get_option('gpf_event_title_option');
			$gpf_event_description_option = get_option('gpf_event_description_option');
			$gpf_event_word_count_option = get_option('gpf_event_word_count_option');
			$gpf_bar_gpf_prefix = 'gpf_event_';
			$gpf_load_more_option = get_option('gpf_event_gpf_load_more_option');
			$gpf_load_more_style = get_option('gpf_event_gpf_load_more_style');
			$facebook_popup = get_option('gpf_event_facebook_popup');
		}
		$gpf_event_id_option = isset($gpf_event_id_option) ? $gpf_event_id_option : "";
		$output = '<div class="gpf-facebook_event-shortcode-form">';
		if ($save_options == false) {
			$output .= '<form method="post" class="google-plus-feed-admin-form shortcode-generator-form fb-event-shortcode-form" id="gpf-fb-event-form" action="options.php">';
			$output .= '<h2>'.__('Google List of Events Shortcode Generator', 'custom-google-plus-feed').'</h2>';
		}
		$output .= '<div class="instructional-text inst-text-facebook-page">'.__('Copy your', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/2013/09/09/how-to-get-your-facebook-page-vanity-url/" target="_blank">'.__('Google Page ID', 'custom-google-plus-feed').'</a> '.__('and paste it in the first input below.', 'custom-google-plus-feed').'</div>';
		$output .= '<div class="google-plus-feed-admin-input-wrap gpf_page_list_of_events_id">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Google Event ID (required)', 'custom-google-plus-feed').'</div>';
		$output .= '<input type="text" name="gpf_page_list_of_events_id" id="gpf_page_list_of_events_id" class="google-plus-feed-admin-input" value="'.$gpf_event_id_option.'" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		// Google Height Option
		$output .= '<div class="google-plus-feed-admin-input-wrap twitter_name">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Google Fixed Height', 'custom-google-plus-feed').'<br/><small>'.__('Leave blank for auto height', 'custom-google-plus-feed').'</small></div>';
		$output .= '<input type="text" name="facebook_event_height" id="facebook_event_height" class="google-plus-feed-admin-input" value="" placeholder="450px '.__('for example', 'custom-google-plus-feed').'e" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			include $this->premium.'admin/facebook-event-settings-fields.php';
			if (isset($_GET['page']) && $_GET['page'] == 'gpf-bar-settings-page') {
				//PREMIUM LOAD MORE SETTINGS & LOADS in FTS BAR
				include $this->premium.'admin/facebook-loadmore-settings-fields.php';
			}
		}
		else {
			$fields = array(
				__('# of Posts (default 5)', 'custom-google-plus-feed'),
				__('Show the Event Title', 'custom-google-plus-feed'),
				__('Show the Event Description', 'custom-google-plus-feed'),
				__('Amount of words per post', 'custom-google-plus-feed'),
				__('Load More Posts', 'custom-google-plus-feed'),
				__('Display Photos in Popup', 'custom-google-plus-feed'),
				__('Display Posts in Grid', 'custom-google-plus-feed'),
			);
			$output .=  $this->need_gpf_premium_fields($fields);
		}
		if ($save_options == false) {
			$output .=  $this->generate_shortcode('updateTextArea_gpf_list_of_events();', 'Google List of Events Feed Shortcode', 'facebook-event-final-shortcode');
			$output .= '</form>';
		}
		else {
			$output .= '<input type="submit" class="google-plus-feed-admin-submit-btn" value="'.__('Save Changes', 'custom-google-plus-feed').'" />';
		}
		$output .= '</div><!--/gpf-facebook_group-shortcode-form-->';
		return $output;
	}

	//**************************************************
	// Google Single Event Form.
	//**************************************************
	function gpf_facebook_event_form($save_options = false) {
		if ($save_options) {
			$gpf_event_id_option = get_option('gpf_event_id');
			$gpf_event_post_count_option = get_option('gpf_event_post_count');
			$gpf_event_title_option = get_option('gpf_event_title_option');
			$gpf_event_description_option = get_option('gpf_event_description_option');
			$gpf_event_word_count_option = get_option('gpf_event_word_count_option');
			$gpf_bar_gpf_prefix = 'gpf_event_';
			$gpf_load_more_option = get_option('gpf_event_gpf_load_more_option');
			$gpf_load_more_style = get_option('gpf_event_gpf_load_more_style');
			$facebook_popup = get_option('gpf_event_facebook_popup');
		}
		$gpf_event_id_option = isset($gpf_event_id_option) ? $gpf_event_id_option : "";
		$output = '<div class="gpf-facebook_event-shortcode-form">';
		if ($save_options == false) {
			$output .= '<form method="post" class="google-plus-feed-admin-form shortcode-generator-form fb-event-shortcode-form" id="gpf-fb-event-form" action="options.php">';
			$output .= '<h2>'.__('Google Event Shortcode Generator', 'custom-google-plus-feed').'</h2>';
		}
		$output .= '<div class="instructional-text inst-text-facebook-page">'.__('Copy your', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/2012/12/14/how-to-get-your-facebook-event-id/" target="_blank">'.__('Google Page Event ID', 'custom-google-plus-feed').'</a> '.__('and paste it in the first input below.', 'custom-google-plus-feed').'</div>';
		$output .= '<div class="google-plus-feed-admin-input-wrap gpf_event_id">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Google Event ID (required)', 'custom-google-plus-feed').'</div>';
		$output .= '<input type="text" name="gpf_event_id" id="gpf_event_id" class="google-plus-feed-admin-input" value="'.$gpf_event_id_option.'" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		// Google Height Option
		$output .= '<div class="google-plus-feed-admin-input-wrap twitter_name">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Google Fixed Height', 'custom-google-plus-feed').'<br/><small>'.__('This creates a scrolling feed', 'custom-google-plus-feed').'</small></div>';
		$output .= '<input type="text" name="facebook_event_height" id="facebook_event_height" class="google-plus-feed-admin-input" value="" placeholder="450px '.__('for example', 'custom-google-plus-feed').'e" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			include $this->premium.'admin/facebook-event-settings-fields.php';
			if (isset($_GET['page']) && $_GET['page'] == 'gpf-bar-settings-page') {
				//PREMIUM LOAD MORE SETTINGS & LOADS in FTS BAR
				include $this->premium.'admin/facebook-loadmore-settings-fields.php';
			}
		}
		else {
			$fields = array(
				__('# of Posts (default 5)', 'custom-google-plus-feed'),
				__('Show the Event Title', 'custom-google-plus-feed'),
				__('Show the Event Description', 'custom-google-plus-feed'),
				__('Amount of words per post', 'custom-google-plus-feed'),
				__('Load More Posts', 'custom-google-plus-feed'),
				__('Display Photos in Popup', 'custom-google-plus-feed'),
				__('Display Posts in Grid', 'custom-google-plus-feed'),
			);
			$output .=  $this->need_gpf_premium_fields($fields);
		}
		if ($save_options == false) {
			$output .=  $this->generate_shortcode('updateTextArea_gpf_event();', 'Google Event Feed Shortcode', 'facebook-list-of-events-final-shortcode');
			$output .= '</form>';
		}
		else {
			$output .= '<input type="submit" class="google-plus-feed-admin-submit-btn" value="'.__('Save Changes', 'custom-google-plus-feed').'" />';
		}
		$output .= '</div><!--/gpf-facebook_group-shortcode-form-->';
		return $output;
	}
	//**************************************************
	// Google Group Form.
	//**************************************************
	function gpf_facebook_group_form($save_options = false) {
		if ($save_options) {
			$gpf_group_id_option = get_option('gpf_group_id');
			$gpf_group_post_count_option = get_option('gpf_group_post_count');
			$gpf_group_title_option = get_option('gpf_group_title_option');
			$gpf_group_description_option = get_option('gpf_group_description_option');
			$gpf_group_word_count_option = get_option('gpf_group_word_count_option');
			$gpf_bar_gpf_prefix = 'gpf_group_';
			$gpf_load_more_option = get_option('gpf_group_gpf_load_more_option');
			$gpf_load_more_style = get_option('gpf_group_gpf_load_more_style');
			$facebook_popup = get_option('gpf_group_facebook_popup');
		}
		$gpf_group_id_option = isset($gpf_group_id_option) ? $gpf_group_id_option : "";
		$output = '<div class="gpf-facebook_group-shortcode-form">';
		if ($save_options == false) {
			$output .= '<form class="google-plus-feed-admin-form shortcode-generator-form fb-group-shortcode-form" id="gpf-fb-group-form">';
			$output .= '<h2>'.__('Google Group Shortcode Generator', 'custom-google-plus-feed').'</h2>';
		}
		$output .= '<div class="instructional-text">'.__('You must copy your ', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/2012/12/14/how-to-get-your-facebook-group-id/" target="_blank">'.__('Google Group ID ', 'custom-google-plus-feed').'</a> '.__('and paste it in the first input below.', 'custom-google-plus-feed').'</div>';
		$output .= '<div class="google-plus-feed-admin-input-wrap gpf_group_id">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Google Group ID (required)', 'custom-google-plus-feed').'</div>';
		$output .= '<input type="text" name="gpf_group_id" id="gpf_group_id" class="google-plus-feed-admin-input" value="'.$gpf_group_id_option.'" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		// Google Height Option
		$output .= '<div class="google-plus-feed-admin-input-wrap twitter_name">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Google Fixed Height', 'custom-google-plus-feed').'<br/><small>'.__('Leave blank for auto height', 'custom-google-plus-feed').'</small></div>';
		$output .= '<input type="text" name="facebook_group_height" id="facebook_group_height" class="google-plus-feed-admin-input" value="" placeholder="450px '.__('for example', 'custom-google-plus-feed').'" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		//  $output .= '<!-- Using this for a future update <div class="google-plus-feed-admin-input-wrap">
		//   <div class="google-plus-feed-admin-input-label">'.__('Customized Group Name', 'custom-google-plus-feed').'</div>
		//  <select id="gpf_group_custom_name" class="google-plus-feed-admin-input">
		//   <option selected="selected" value="yes">'.__('My group name is custom', 'custom-google-plus-feed').'</option>
		//  <option value="no">'.__('My group name is number based', 'custom-google-plus-feed').'</option>
		// </select>
		// <div class="clear"></div>
		// </div>
		// /google-plus-feed-admin-input-wrap-->';
		if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			include $this->premium.'admin/facebook-group-settings-fields.php';
			if (isset($_GET['page']) && $_GET['page'] == 'gpf-bar-settings-page') {
				//PREMIUM LOAD MORE SETTINGS & LOADS in FTS BAR
				include $this->premium.'admin/facebook-loadmore-settings-fields.php';
			}
		}
		else {
			//Create Need Premium Fields
			$fields = array(
				__('# of Posts (default 5)', 'custom-google-plus-feed'),
				__('Show the Group Title', 'custom-google-plus-feed'),
				__('Show the Group Description', 'custom-google-plus-feed'),
				__('Amount of words per post', 'custom-google-plus-feed'),
				__('Load More Posts', 'custom-google-plus-feed'),
				__('Display Photos in Popup', 'custom-google-plus-feed'),
				__('Display Posts in Grid', 'custom-google-plus-feed'),
			);
			$output .= $this->need_gpf_premium_fields($fields);
		}
		if ($save_options == false) {
			$output .= $this->generate_shortcode('updateTextArea_gpf_group();', 'Google Group Feed Shortcode', 'facebook-group-final-shortcode');
			$output .= '</form>';
		}
		else {
			$output .= '<input type="submit" class="google-plus-feed-admin-submit-btn" value="'.__('Save Changes', 'custom-google-plus-feed').'" />';
		}
		$output .= '</div><!--/gpf-facebook_group-shortcode-form-->';
		return $output;
	}
	//**************************************************
	// Google Page Form.
	//**************************************************
	function gpf_facebook_page_form($save_options = false) {
		if ($save_options) {
			$gpf_page_id_option = get_option('gpf_page_id');
			$gpf_page_posts_displayed_option = get_option('gpf_page_posts_displayed');
			$gpf_page_post_count_option = get_option('gpf_page_post_count');
			$gpf_page_title_option = get_option('gpf_page_title_option');
			$gpf_page_description_option = get_option('gpf_page_description_option');
			$gpf_page_word_count_option = get_option('gpf_page_word_count_option');
			$gpf_bar_gpf_prefix = 'gpf_page_';
			$gpf_load_more_option = get_option('gpf_page_gpf_load_more_option');
			$gpf_load_more_style = get_option('gpf_page_gpf_load_more_style');
			$facebook_popup = get_option('gpf_page_facebook_popup');
		}
		$output = '<div class="gpf-facebook_page-shortcode-form">';
		if ($save_options == false) {
			$output .= '<form class="google-plus-feed-admin-form shortcode-generator-form fb-page-shortcode-form" id="gpf-fb-page-form">';
			$output .= '<h2>'.__('Google Page Shortcode Generator', 'custom-google-plus-feed').'</h2>';
		}
		$gpf_page_id_option = isset($gpf_page_id_option) ? $gpf_page_id_option : "";
		// ONLY SHOW SUPER GALLERY OPTIONS ON FTS SETTINGS PAGE FOR NOW, NOT FTS BAR
		if (isset($_GET['page']) && $_GET['page'] == 'google-feed-settings-page') {
			// FACEBOOK FEED TYPE
			$output .= '<div class="google-plus-feed-admin-input-wrap" id="gpf-social-selector">';
			$output .= '<div class="google-plus-feed-admin-input-label">'.__('Feed Type', 'custom-google-plus-feed').'</div>';
			$output .= '<select name="facebook-messages-selector" id="facebook-messages-selector" class="google-plus-feed-admin-input">';
			$output .= '<option value="page">'.__('Google+ Profile or Page Feed', 'custom-google-plus-feed').'</option>';
			$output .= '<option value="album_videos">'.__('Google+ Collection Feed', 'custom-google-plus-feed').'</option>';
			$output .= '<option value="album_videos">'.__('Google+ Reviews Feed', 'custom-google-plus-feed').'</option>';
			//  $output .= '<option value="event">'.__('Google Single Event', 'custom-google-plus-feed').'</option>';
			//  $output .= '<option value="album_videos">'.__('Google Videos', 'custom-google-plus-feed').'</option>';
			//  $output .= '<option value="album_photos">'.__('Google Album Photos', 'custom-google-plus-feed').'</option>';
			//  $output .= '<option value="albums">'.__('Google Album Covers', 'custom-google-plus-feed').'</option>';
			// $output .= '<option value="hashtag">'.__('Google Hashtag', 'custom-google-plus-feed').'</option>';
			$output .= '</select>';
			$output .= '<div class="clear"></div>';
			$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		};
		// INSTRUCTIONAL TEXT FOR FACEBOOK TYPE SELECTION. PAGE, GROUP, EVENT, ALBUMS, ALBUM COVERS AND HASH TAGS
		$output .= '<div class="instructional-text facebook-message-generator page inst-text-facebook-page" style="display:block;">'.__('Copy your', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/docs/how-to-get-your-google-plus-id/" target="_blank">'.__('Google+ ID', 'custom-google-plus-feed').'</a> '.__('and paste it in the first input below.', 'custom-google-plus-feed').'</div>
			<div class="instructional-text facebook-message-generator group inst-text-facebook-group">'.__('Copy your', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/2012/12/14/how-to-get-your-facebook-group-id/" target="_blank">'.__('Google Group ID', 'custom-google-plus-feed').'</a> '.__('and paste it in the first input below.', 'custom-google-plus-feed').'</div>
			<div class="instructional-text facebook-message-generator event inst-text-facebook-event">'.__('Copy your', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/2012/12/14/how-to-get-your-facebook-event-id/" target="_blank">'.__('Google Event ID', 'custom-google-plus-feed').'</a> '.__('and paste it in the first input below.', 'custom-google-plus-feed').'</div>
			<div class="instructional-text facebook-message-generator album_photos inst-text-facebook-album-photos">'.__('Copy your', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/docs/how-to-get-your-facebook-photo-gallery-id/" target="_blank">'.__('Google Album ID', 'custom-google-plus-feed').'</a> '.__('and paste it in the first input below.', 'custom-google-plus-feed').'</div>
			<div class="instructional-text facebook-message-generator albums inst-text-facebook-albums">'.__('Copy your', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/docs/how-to-get-your-facebook-photo-gallery-id/" target="_blank">'.__('Google Album Covers ID', 'custom-google-plus-feed').'</a> '.__('and paste it in the first input below.', 'custom-google-plus-feed').'</div>
			<div class="instructional-text facebook-message-generator video inst-text-facebook-video">'.__('Copy your', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/docs/how-to-get-your-facebook-id-and-video-gallery-id" target="_blank">'.__('Google ID and Video Album ID', 'custom-google-plus-feed').'</a> '.__('and paste them below.', 'custom-google-plus-feed').'</div>';
		if (isset($_GET['page']) && $_GET['page'] == 'google-feed-settings-page') {
			// this is for the facebook videos
			$output .= '<div class="google-plus-feed-admin-input-wrap gpf-premium-options-message" style="display:none;"><a target="_blank" href="javascript:;">Coming Soon!</a><br/>We are gearing up to make some more Feeds so stay tuned! If you like our plugin and really want to see this feed please connect with us on Google and leave a message telling us. <a href="https://plus.google.com/u/0/b/107205121462037290529/107205121462037290529/posts/p/pub" target="_blank">SlickRemix on Google Plus</a></div>';
		}
		// FACEBOOK PAGE ID
		if (isset($_GET['page']) && $_GET['page'] !== 'gpf-bar-settings-page') {
			$output .= '<div class="fb-options-wrap">';
		}
		$output .= '<div class="google-plus-feed-admin-input-wrap gpf_page_id ">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Google+ ID (required)', 'custom-google-plus-feed').'</div>';
		$output .= '<input type="text" name="gpf_page_id" id="gpf_page_id" class="google-plus-feed-admin-input" value="'.$gpf_page_id_option.'" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		// FACEBOOK ALBUM PHOTOS ID
		$output .= '<div class="google-plus-feed-admin-input-wrap gpf_album_photos_id" style="display:none;">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Album ID (required)', 'custom-google-plus-feed').'</div>';
		$output .= '<input type="text" name="gpf_album_id" id="gpf_album_id" class="google-plus-feed-admin-input" value="" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		$gpf_page_posts_displayed_option = isset($gpf_page_posts_displayed_option) ? $gpf_page_posts_displayed_option : "";
		// FACEBOOK PAGE POST TYPE VISIBLE
		//  $output .= '<div class="google-plus-feed-admin-input-wrap facebook-post-type-visible" style="display:none">';
		//  $output .= '<div class="google-plus-feed-admin-input-label">'.__('Post Type Visible', 'custom-google-plus-feed').'</div>';
		//  $output .= '<select name="gpf_page_posts_displayed" id="gpf_page_posts_displayed" class="google-plus-feed-admin-input">';
		//  $output .= '<option '.selected($gpf_page_posts_displayed_option, 'page_only', false ) .' value="page_only">'.__('Display Posts made by Page only', 'custom-google-plus-feed').'</option>';
		//  $output .= '<option '.selected($gpf_page_posts_displayed_option, 'others_only', false ) .' value="others_only">'.__('Display Posts made by Others', 'custom-google-plus-feed').'</option>';
		//  $output .= '</select>';
		//  $output .= '<div class="clear"></div>';
		//  $output .= '</div><!--/google-plus-feed-admin-input-wrap-->';

		// FACEBOOK HEIGHT OPTION
		$output .= '<div class="google-plus-feed-admin-input-wrap twitter_name fixed_height_option">';
		$output .= '<div class="google-plus-feed-admin-input-label">'.__('Google Fixed Height', 'custom-google-plus-feed').'<br/><small>'.__('This creates a scrolling feed', 'custom-google-plus-feed').'</small></div>';
		$output .= '<input type="text" name="facebook_page_height" id="facebook_page_height" class="google-plus-feed-admin-input" value="" placeholder="450px '.__('for example', 'custom-google-plus-feed').'" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';


		if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
			include $this->premium.'admin/facebook-page-settings-fields.php';
			if (isset($_GET['page']) && $_GET['page'] == 'gpf-bar-settings-page') {
				//PREMIUM LOAD MORE SETTINGS & LOADS in FTS BAR
				include $this->premium.'admin/facebook-loadmore-settings-fields.php';
			}
		}
		else {

			//Create Need Premium Fields
			$fields = array(
				__('# of Posts (default 5)', 'custom-google-plus-feed'),
				__('Show the Page Title', 'custom-google-plus-feed'),
				__('Show the Page Description', 'custom-google-plus-feed'),
				__('Amount of words per post', 'custom-google-plus-feed'),
				__('Load More Posts', 'custom-google-plus-feed'),
				__('Display Photos in Popup', 'custom-google-plus-feed'),
				__('Display Posts in Grid', 'custom-google-plus-feed'),
				__('Center Grid', 'custom-google-plus-feed'),
				__('Grid Stack Animation', 'custom-google-plus-feed'),
				__('Align Follow Button', 'custom-google-plus-feed'),
				__('Hide Follow Button', 'custom-google-plus-feed'),
			);
			$output .= $this->need_gpf_premium_fields($fields);
		}
		// ONLY SHOW SUPER GALLERY OPTIONS ON FTS SETTINGS PAGE FOR NOW, NOT FTS BAR
		if (isset($_GET['page']) && $_GET['page'] == 'google-feed-settings-page') {

			// FACEBOOK super gallery
			// $output .= '<div class="google-plus-feed-admin-input-wrap facebook_name" style="display:none">';
			// $output .= '<div class="google-plus-feed-admin-input-label">Super Google Gallery</div>';
			// $output .= '<select id="facebook-custom-gallery" name="facebook-custom-gallery" class="google-plus-feed-admin-input"><option value="no" >No</option><option value="yes" >Yes. See Super Google Gallery Options below.</option></select>';
			// $output .= '<div class="clear"></div>';
			// $output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
			// These options are only for FB album photos and covers
			// SUPER FACEBOOK GALLERY OPTIONS
			$output .= '<div class="gpf-super-facebook-options-wrap" style="display:none">';
			// FACEBOOK IMAGE HEIGHT
			$output .= '<div class="google-plus-feed-admin-input-wrap facebook_name"><div class="google-plus-feed-admin-input-label">'.__('Google Image Width', 'custom-google-plus-feed').'<br/><small>'.__('Max width is 640px', 'custom-google-plus-feed').'</small></div>
	           <input type="text" name="gpf-slicker-instagram-container-image-width" id="gpf-slicker-facebook-container-image-width" class="google-plus-feed-admin-input" value="250px" placeholder="">
	           <div class="clear"></div> </div>';
			// FACEBOOK IMAGE WIDTH
			$output .= '<div class="google-plus-feed-admin-input-wrap facebook_name"><div class="google-plus-feed-admin-input-label">'.__('Google Image Height', 'custom-google-plus-feed').'<br/><small>'.__('Max width is 640px', 'custom-google-plus-feed').'</small></div>
	           <input type="text" name="gpf-slicker-instagram-container-image-height" id="gpf-slicker-facebook-container-image-height" class="google-plus-feed-admin-input" value="250px" placeholder="">
	           <div class="clear"></div> </div>';
			// FACEBOOK SPACE BETWEEN PHOTOS
			$output .= '<div class="google-plus-feed-admin-input-wrap facebook_name"><div class="google-plus-feed-admin-input-label">'.__('The space between photos', 'custom-google-plus-feed').'</div>
	           <input type="text" name="gpf-slicker-facebook-container-margin" id="gpf-slicker-facebook-container-margin" class="google-plus-feed-admin-input" value="1px" placeholder="">
	           <div class="clear"></div></div>';
			// HIDE DATES, LIKES AND COMMENTS ETC
			$output .= '<div class="google-plus-feed-admin-input-wrap facebook_name"><div class="google-plus-feed-admin-input-label">'.__('Hide Date, Likes and Comments', 'custom-google-plus-feed').'<br/><small>'.__('Good for image sizes under 120px', 'custom-google-plus-feed').'</small></div>
	       		 <select id="gpf-slicker-facebook-container-hide-date-likes-comments" name="gpf-slicker-facebook-container-hide-date-likes-comments" class="google-plus-feed-admin-input">
	        	  <option value="no">'.__('No', 'custom-google-plus-feed').'</option><option value="yes">'.__('Yes', 'custom-google-plus-feed').'</option></select><div class="clear"></div></div>';

			// CENTER THE FACEBOOK CONTAINER
			$output .= '<div class="google-plus-feed-admin-input-wrap" id="facebook_super_gallery_container"><div class="google-plus-feed-admin-input-label">'.__('Center Google Container', 'custom-google-plus-feed').'</div>
	        	<select id="gpf-slicker-facebook-container-position" name="gpf-slicker-facebook-container-position" class="google-plus-feed-admin-input"><option value="no">'.__('No', 'custom-google-plus-feed').'</option><option value="yes">'.__('Yes', 'custom-google-plus-feed').'</option></select><div class="clear"></div></div>';
			// ANIMATE PHOTO POSITIONING
			$output .= ' <div class="google-plus-feed-admin-input-wrap" id="facebook_super_gallery_animate"><div class="google-plus-feed-admin-input-label">'.__('Image Stacking Animation On', 'custom-google-plus-feed').'<br/><small>'.__('This happens when resizing browsert', 'custom-google-plus-feed').'</small></div>
	        	 <select id="gpf-slicker-facebook-container-animation" name="gpf-slicker-facebook-container-animation" class="google-plus-feed-admin-input"><option value="no">'.__('No', 'custom-google-plus-feed').'</option><option value="yes">'.__('Yes', 'custom-google-plus-feed').'</option></select><div class="clear"></div></div>';
			// POSITION IMAGE LEFT RIGHT
			$output .= '<div class="instructional-text" style="display: block;">'.__('These options allow you to make the thumbnail larger if you do not want to see black bars above or below your photos.', 'custom-google-plus-feed').' <a href="http://www.slickremix.com/docs/fit-thumbnail-on-facebook-galleries/" target="_blank">'.__('View Examples', 'custom-google-plus-feed').'</a> '.__('and simple details or leave default options.', 'custom-google-plus-feed').'</div>
			<div class="google-plus-feed-admin-input-wrap facebook_name"><div class="google-plus-feed-admin-input-label">'.__('Make photo larger', 'custom-google-plus-feed').'<br/><small>'.__('Helps with blackspace', 'custom-google-plus-feed').'</small></div>
				<input type="text" id="gpf-slicker-facebook-image-position-lr" name="gpf-slicker-facebook-image-position-lr" class="google-plus-feed-admin-input" value="-0%" placeholder="eg. -50%. -0% '.__('is default', 'custom-google-plus-feed').'">
	           <div class="clear"></div></div>';
			// POSITION IMAGE TOP
			$output .= ' <div class="google-plus-feed-admin-input-wrap facebook_name"><div class="google-plus-feed-admin-input-label">'.__('Image Position Top', 'custom-google-plus-feed').'<br/><small>'.__('Helps center image', 'custom-google-plus-feed').'</small></div>
				<input type="text" id="gpf-slicker-facebook-image-position-top" name="gpf-slicker-facebook-image-position-top" class="google-plus-feed-admin-input" value="-0%" placeholder="eg. -10%. -0% '.__('is default', 'custom-google-plus-feed').'">
				<div class="clear"></div></div>';
			$output .= '</div><!--gpf-super-facebook-options-wrap-->';
			if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
				//PREMIUM LOAD MORE SETTINGS
				include $this->premium.'admin/facebook-loadmore-settings-fields.php';
			}
		}
		if ($save_options == false) {
			$output .= $this->generate_shortcode('updateTextArea_gpf_page();', 'Google Page Feed Shortcode', 'facebook-page-final-shortcode');
			if (isset($_GET['page']) && $_GET['page'] !== 'gpf-bar-settings-page') {
				$output .= '</div>'; // END fb-options-wrap
			}
			$output .= '</form>';
		}
		else {
			$output .= '<input type="submit" class="google-plus-feed-admin-submit-btn" value="Save Changes" />';
		}
		$output .= '</div><!--/gpf-facebook_page-shortcode-form-->';
		return $output;
	}
	//**************************************************
	// Generate Shorecode Button and Input for FTS settings Page.
	//**************************************************
	function generate_shortcode($onclick, $label, $input_class) {
		$output = '<input type="button" class="google-plus-feed-admin-submit-btn" value="'.__('Generate Shortcode', 'custom-google-plus-feed').'" onclick="'.$onclick.'" tabindex="4" style="margin-right:1em;" />';
		$output .= '<div class="google-plus-feed-admin-input-wrap final-shortcode-textarea">';
		$output .= '<h4>'.__('Copy the ShortCode below and paste it on a page or post that you want to display your feed.', 'custom-google-plus-feed').'</h4>';
		$output .= '<div class="google-plus-feed-admin-input-label">'.$label.'</div>';
		$output .= '<input class="copyme '.$input_class.' google-plus-feed-admin-input" value="" />';
		$output .= '<div class="clear"></div>';
		$output .= '</div><!--/google-plus-feed-admin-input-wrap-->';
		return $output;
	}
	//**************************************************
	// Generate Get Json (includes MultiCurl)
	//**************************************************
	function gpf_get_feed_json($feeds_mulit_data) {
		// data to be returned
		$response = array();
		$curl_success = true;
		if (is_callable('curl_init')) {
			if(is_array($feeds_mulit_data)){
				// array of curl handles
				$curly = array();
				// multi handle
				$mh = curl_multi_init();
				// loop through $data and create curl handles
				// then add them to the multi-handle
				foreach ($feeds_mulit_data as $id => $d) {
					$curly[$id] = curl_init();
					$url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
					curl_setopt($curly[$id], CURLOPT_URL,            $url);
					curl_setopt($curly[$id], CURLOPT_HEADER,         0);
					curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curly[$id], CURLOPT_SSL_VERIFYHOST, 0);
					// post?
					if (is_array($d)) {
						if (!empty($d['post'])) {
							curl_setopt($curly[$id], CURLOPT_POST,       1);
							curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
						}
					}
					// extra options?
					if (!empty($options)) {
						curl_setopt_array($curly[$id], $options);
					}
					curl_multi_add_handle($mh, $curly[$id]);
				}
				// execute the handles
				$running = null;
				do {
					$curl_status = curl_multi_exec($mh, $running);
					// Check for errors
					$info = curl_multi_info_read($mh);
					if (false !== $info) {
						// Add connection info to info array:
						if (!$info['result']) {
							//$multi_info[(integer) $info['handle']]['error'] = 'OK';
						} else {
							$multi_info[(integer) $info['handle']]['error'] = curl_error($info['handle']);
							$curl_success = false;
						}
					}
				} while ($running > 0);
				// get content and remove handles
				foreach ($curly as $id => $c) {
					$response[$id] = curl_multi_getcontent($c);
					curl_multi_remove_handle($mh, $c);
				}
				curl_multi_close($mh);
			}//END Is_ARRAY
			//NOT ARRAY SINGLE CURL
			else{
				$ch = curl_init($feeds_mulit_data);
				curl_setopt_array($ch, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_HEADER => 0,
						CURLOPT_POST => true,
						CURLOPT_SSL_VERIFYPEER => false,
						CURLOPT_SSL_VERIFYHOST => 0
					));
				$response = curl_exec($ch);
				curl_close($ch);
			}

		}
		//File_Get_Contents if Curl doesn't work
		if (!$curl_success && ini_get('allow_url_fopen') == 1 || ini_get('allow_url_fopen') === TRUE) {
			foreach ($feeds_mulit_data as $id => $d) {
				$response[$id] = @file_get_contents($d);
			}
		} else {
			//If nothing else use wordpress http API
			if (!$curl_success && !class_exists( 'WP_Http' )) {
				include_once ABSPATH . WPINC. '/class-http.php';
				$wp_http_class = new WP_Http;
				foreach ($feeds_mulit_data as $id => $d) {
					$wp_http_result = $wp_http_class->request($d);
					$response[$id] = $wp_http_result['body'];
				}
			}
			//Do nothing if Curl was Successful
		}
		return $response;
	}
	//**************************************************
	// Create feed cache
	//**************************************************
	function gpf_create_feed_cache($transient_name, $response) {
		set_transient('gpf_'.$transient_name, $response, 900);
	}
	//**************************************************
	// gpf_get_feed_cache
	//**************************************************
	function gpf_get_feed_cache($transient_name) {
		$returned_cache_data = get_transient('gpf_'.$transient_name);
		return $returned_cache_data;
	}
	//**************************************************
	// gpf_check_feed_cache_exists
	//**************************************************
	function gpf_check_feed_cache_exists($transient_name) {
		if(false === ($special_query_results = get_transient('gpf_'.$transient_name))){
			return false;
		}
		return true;
	}
	//**************************************************
	// this function is being called from the twitter feed it calls the ajax in this case.
	//**************************************************
	function gpf_clear_cache_ajax() {
		global $wpdb;
		$not_expired= $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s ", '_transient_gpf_%'));
		$expired = $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s ", '_transient_timeout_gpf_%'));
		wp_reset_query();
		return;
	} // end of my_ajax_callback()
	//**************************************************
	// Clear Cache Folder.
	//**************************************************
	function google_plus_feed_clear_cache() {
		global $wpdb;
		$not_expired = $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s ", '_transient_gpf_%'));
		$expired = $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s ", '_transient_timeout_gpf_%'));
		wp_reset_query();
		return 'Cache for all Google Feeds cleared!';
	}
	//**************************************************
	// Create our custom menu in the admin bar.
	//**************************************************
	function gpf_admin_bar_menu() {
		global $wp_admin_bar;
		isset($gpfDevModeCache) ? $gpfDevModeCache : "";
		isset($gpfAdminBarMenu) ? $gpfAdminBarMenu : "";
		$gpfAdminBarMenu = get_option('gpf_admin_bar_menu');
		$gpfDevModeCache = get_option('gpf_clear_cache_developer_mode');
		if ( !is_super_admin() || !is_admin_bar_showing() || $gpfAdminBarMenu == 'hide-admin-bar-menu')
			return;
		$wp_admin_bar->add_menu( array(
				'id' => 'google_plus_feed_admin_bar',
				'title' => __( 'Google Plus Feed', 'custom-google-plus-feed'),
				'href' => FALSE ) );
		if ($gpfDevModeCache == '1') {
			$wp_admin_bar->add_menu( array(
					'id' => 'google_plus_feed_admin_bar_clear_cache',
					'parent' => 'google_plus_feed_admin_bar',
					'title' => __( 'Cache clears on page refresh now', 'custom-google-plus-feed'),
					'href' => FALSE )
			);
		}
		else {
			$wp_admin_bar->add_menu(
				array(
					'id' => 'google_plus_feed_admin_bar_clear_cache',
					'parent' => 'google_plus_feed_admin_bar',
					'title' => __( 'Clear Cache', 'custom-google-plus-feed'),
					'href' => '#' )
			);
		}
		$wp_admin_bar->add_menu( array(
				'id' => 'google_plus_feed_admin_bar_settings',
				'parent' => 'google_plus_feed_admin_bar',
				'title' => __( 'Settings', 'custom-google-plus-feed'),
				'href' => admin_url( 'admin.php?page=google-feed-settings-page') )
		);
	}
	function xml_json_parse($url) {
		$url_to_get['url'] = $url;
		$fileContents_returned = $this->gpf_get_feed_json($url_to_get);
		$fileContents = $fileContents_returned['url'];
		$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
		$fileContents = trim(str_replace('"', "'", $fileContents));
		$simpleXml = simplexml_load_string($fileContents);
		$json = json_encode($simpleXml);

		return $json;
	}
}//END Class
new Google_Plus_Feed_Functions();
?>