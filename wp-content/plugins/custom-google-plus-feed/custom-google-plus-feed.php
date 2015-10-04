<?php
/*
Plugin Name: Custom Google Plus Feed
Plugin URI: http://slickremix.com/
Description: Create and display custom feeds for your Google Plus Profile or Page accounts.
Version: 1.0.0
Author: SlickRemix
Author URI: http://slickremix.com/
Requires at least: wordpress 3.6.0
Tested up to: WordPress 4.2.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    		Custom Google Plus Feed
 * @category   		Core
 * @author     		SlickRemix
 * @copyright  		Copyright (c) 2012-2015 SlickRemix

If you need support or want to tell us thanks please contact us at support@slickremix.com or use our support forum on slickremix.com.
*/

define( 'GPFP_PLUGIN_PATH', plugins_url());

// Makes sure the plugin is defined before trying to use it
if ( ! function_exists( 'is_plugin_active' ) )
 require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	
// Returns current plugin version. SRL added
// @return string Plugin version
function gpfystem_version() {
	$plugin_data = get_plugin_data( __FILE__ );
	$plugin_version = $plugin_data['Version'];
	return $plugin_version;
}

// Usefull when making major update and need a notice. Disabeling for now.
// Define minimum premium version allowed to be active with Free Version
// global $gpf_versions_needed;
// $gpf_versions_needed = array(
//	'custom-google-plus-feed-premium/custom-google-plus-feed-premium.php' => '1.0.0',
// );

// Make sure php version is greater than 5.3
if ( function_exists( 'phpversion' ) )
					
					$phpversion = phpversion();
					$phpcheck = '5.2.9';

if ($phpversion > $phpcheck) {
						
function gpf_action_init()
{
// Localization
load_plugin_textdomain('custom-google-plus-feed', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
// Add actions
add_action('init', 'gpf_action_init');

$gpf_plugin_rel_url = plugin_dir_path( __FILE__ );

// Include admin
// include( $gpf_plugin_rel_url.'updates/update-functions.php' );
include( $gpf_plugin_rel_url.'admin/google-system-info.php' );
include( $gpf_plugin_rel_url.'admin/google-feed-settings-page.php' );
include( $gpf_plugin_rel_url.'admin/google-feed-style-options-page.php' );

// Include core files and classes
include( $gpf_plugin_rel_url.'includes/google-plus-feed-functions.php' );

$load_gpf = 'Google_Plus_Feed\Google_Plus_Feed_Functions';
$load_gpf = new $load_gpf;
$load_gpf->init();

include_once( $gpf_plugin_rel_url.'feeds/google-plus/google-plus-feed.php' );

// Include our own Settings link to plugin activation and update page.
					add_filter("plugin_action_links_".plugin_basename(__FILE__), "google_plus_plugin_actions", 10, 4);
						function google_plus_plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
							array_unshift($actions, "<a href=\"".menu_page_url('google-feed-settings-page', false)."\">".__("Settings")."</a>");
							return $actions;
					}
					
} // end if php version check

else  {
	// if the php version is not at least 5.3 do action
	deactivate_plugins( 'custom-google-plus-feed/custom-google-plus-feed.php' ); 
	
    	if ($phpversion < $phpcheck) {
		
	add_action( 'admin_notices', 'gpf_required_php_check1' );	
	function gpf_required_php_check1() {
			echo '<div class="error"><p>' . __( '<strong>Warning:</strong> Your php version is '.phpversion().'. You need to be running at least 5.3 or greater to use this plugin. Please upgrade the php by contacting your host provider. Some host providers will allow you to change this yourself in the hosting control panel too.<br/><br/>If you are hosting with BlueHost or Godaddy and the php version above is saying you are running 5.2.17 but you are really running something higher please <a href="https://wordpress.org/support/topic/php-version-difference-after-changing-it-at-bluehost-php-config?replies=4" target="_blank">click here for the fix</a>. If you cannot get it to work using the method described in the link please contact your host provider and explain the problem so they can fix it.', 'my-theme' ) . '</p></div>';
	}
   }
} // end gpf_required_php_check


// Include Leave feedback, Get support and Plugin info links to plugin activation and update page.
add_filter("plugin_row_meta", "google_plus_add_leave_feedback_link", 10, 2);

	function google_plus_add_leave_feedback_link( $links, $file ) {
		if ( $file === plugin_basename( __FILE__ ) ) {
			$links['feedback'] = '<a href="http://wordpress.org/support/view/plugin-reviews/google-plus-feed" target="_blank">' . __( 'Leave feedback', 'custom-google-plus-feed' ) . '</a>';
			$links['support']  = '<a href="http://www.slickremix.com/support-forum/" target="_blank">' . __( 'Get support', 'custom-google-plus-feed' ) . '</a>';
		}
		return $links;
}
?>