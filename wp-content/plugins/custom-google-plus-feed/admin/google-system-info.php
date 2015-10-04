<?php
namespace Google_Plus_Feed;
class GF_system_info_page {
	function __construct() {
		if ( is_admin() ) {
			if (isset($_GET['page']) && $_GET['page'] == 'google-feed-system-info-submenu-page'){
				//Set Search to Page and Posts
				add_filter('pre_get_posts',  array($this,'search_filter'));
				//Filter for shortcodes
				add_shortcode('shortcodefinderSlick',  array($this,'wpb_find_shortcode'));
			}
		}
	}
	//**************************************************
	// System Info Page
	//**************************************************
	function google_feed_system_info_page() {
?>
		<div class="gpf-help-admin-wrap"> <a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/custom-google-plus-feed/" target="_blank">
		<?php _e( 'Get Extensions Here!', 'custom-google-plus-feed' ); ?>
		</a>
		<h2>
		<?php _e( 'System Info', 'custom-google-plus-feed' ); ?>
		</h2>
		<p>
		<?php _e( 'Please click the box below and copy the report. You will need to paste this information along with your question in our', 'custom-google-plus-feed' ); ?>
		<a href="http://www.slickremix.com/support-forum/" target="_blank">
		<?php _e( 'Support Forum', 'custom-google-plus-feed' ); ?>
		</a>.
		<?php _e( 'Ask your question then paste the copied text below it.  To copy the system info, click below then press Ctrl + C (PC) or Cmd + C (Mac).', 'custom-google-plus-feed' ); ?>
		</p>
		<form action="<?php echo esc_url( admin_url( 'admin.php?page=google-feed-system-info-submenu-page' ) ); ?>" method="post" dir="ltr" >
		<textarea readonly="readonly" onclick="this.focus();this.select()" id="system-info-textarea" name="gpf-sysinfo" title="<?php _e( 'To copy the system info, click here then press Ctrl + C (PC) or Cmd + C (Mac).', 'custom-google-plus-feed' ); ?>">
### Begin System Info ###
		<?php
			$theme_data = wp_get_theme();
			$theme      = $theme_data->Name . ' ' . $theme_data->Version; ?>

SITE_URL:                 <?php echo site_url() . "\n"; ?>
Google Plus Feed Version: <?php echo gpfystem_version(). "\n"; ?>
	
-- Wordpress Configuration
	
WordPress Version:        <?php echo get_bloginfo( 'version' ) . "\n"; ?>
Multisite:                <?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?>
Permalink Structure:      <?php echo get_option( 'permalink_structure' ) . "\n"; ?>
Active Theme:             <?php echo $theme . "\n"; ?>
PHP Memory Limit:         <?php echo ini_get( 'memory_limit' ) . "\n"; ?>
WP_DEBUG:                 <?php echo defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' . "\n" : 'Disabled' . "\n" : 'Not set' . "\n" ?>
	
-- Webserver Configuration
	
PHP Version:              <?php echo PHP_VERSION . "\n"; ?>
Web Server Info:          <?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?>
	
-- PHP Configuration:
	
Safe Mode:                <?php echo ini_get( 'safe_mode' ) ? "Yes" : "No\n"; ?>
Upload Max Size:          <?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?>
Post Max Size:            <?php echo ini_get( 'post_max_size' ) . "\n"; ?>
Upload Max Filesize:      <?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?>
Time Limit:               <?php echo ini_get( 'max_execution_time' ) . "\n"; ?>
Max Input Vars:           <?php echo ini_get( 'max_input_vars' ) . "\n"; ?>
Allow URL File Open:      <?php echo ( ini_get( 'allow_url_fopen' ) ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'; ?><?php echo "\n"; ?>
Display Erros:            <?php echo ( ini_get( 'display_errors' ) ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'; ?><?php echo "\n"; ?>
	
-- PHP Extensions:
	
FSOCKOPEN:                <?php echo ( function_exists( 'fsockopen' ) ) ? 'Your server supports fsockopen.' : 'Your server does not support fsockopen.'; ?><?php echo "\n"; ?>
cURL:                     <?php echo ( function_exists( 'curl_init' ) ) ? 'Your server supports cURL.' : 'Your server does not support cURL.'; ?><?php echo "\n"; ?>


-- Active Plugins:

<?php $plugins = get_plugins();
$active_plugins = get_option( 'active_plugins', array() );
foreach ( $plugins as $plugin_path => $plugin ) {
// If the plugin isn't active, don't show it.
if ( ! in_array( $plugin_path, $active_plugins ) )
continue;
echo $plugin['Name'] . ': ' . $plugin['Version'] ."\n";
			}
if ( is_multisite() ) :
?>
	
-- Network Active Plugins:
	
		<?php
				$plugins = wp_get_active_network_plugins();
			$active_plugins = get_site_option( 'active_sitewide_plugins', array() );
	
			foreach ( $plugins as $plugin_path ) {
				$plugin_base = plugin_basename( $plugin_path );
	
				// If the plugin isn't active, don't show it.
				if ( ! array_key_exists( $plugin_base, $active_plugins ) )
					continue;
	
				$plugin = get_plugin_data( $plugin_path );
	
				echo $plugin['Name'] . ' :' . $plugin['Version'] ."\n";
			}
	
			endif;
	 
			
			$youtubeOptions = get_option('youtube_custom_api_token') ?'Yes' :'No' ;
			$gpfDateTimeFormat = get_option('gpf-date-and-time-format') ? get_option('gpf-date-and-time-format') : 'No' ;
			$gpfTimezone = get_option('gpf-timezone') ? get_option('gpf-timezone') : 'No' ;
	
	?>
	
-- Custom Token or Keys added to Options Pages
-- You must have a custom token to use the feeds
	
Google App Token:       <?php echo $youtubeOptions      . "\n"; ?>
<?php if (is_plugin_active('custom-google-plus-feed-premium/custom-google-plus-feed-premium.php')) {
	
$gpfFixLoadmore = get_option('gpf_fix_loadmore') ? get_option('gpf_fix_loadmore') : 'No' ;
$google_plus_feed_premium_license_key = get_option('google_plus_feed_premium_license_key');

	?>
	
-- Load More Options
	
Override:                 <?php echo isset($gpfFixLoadmore) && $gpfFixLoadmore == 1 ? 'Yes'. "\n" : 'No'. "\n"; ?>
	
-- Premium License
	
Premium Active:           <?php echo isset($google_plus_feed_premium_license_key) && $google_plus_feed_premium_license_key !== '' ? 'Yes'. "\n" : 'No'. "\n"; } ?>
	
-- Google Date Format and Timezone
	
Date Format:              <?php echo $gpfDateTimeFormat     . "\n"; ?>
Timezone:                 <?php echo $gpfTimezone     . "\n"; ?>
	
-- Pages or Posts with Shortcode(s).
-- If you are using our shortcode in a widget you'll need to paste your shortcode in our support forum.
	
<?php echo do_shortcode("[shortcodefinderSlick find='[gpf google']"); ?>
	

### End System Info ###</textarea>
		</form>
		<a class="gpf-settings-admin-slick-logo" href="http://www.slickremix.com/support-forum/" target="_blank"></a> </div>
		<?php
		}
		//**************************************************
		// Search Filter
		//**************************************************
		function search_filter( $query ) {
			if ( $query->is_search ) {
				$query->set( 'post_type', array('post', 'page') );
			}
			return $query;
		}
		//**************************************************
		// Find Shortcode Filter
		//**************************************************
		function wpb_find_shortcode($atts, $content=null) {
			ob_start();
			extract( shortcode_atts( array(
						'find' => '',
					), $atts ) );
	
			$string = $atts['find'];
	
			$args = array(
				's' => $string,
				'posts_per_page'=>100,
			);
	
			$the_query = new \WP_Query( $args );
	
			$posts = $the_query->get_posts();
	
			foreach ($posts as $post) {
	  $the_query->the_post(); ?>
<<< <?php the_permalink(); ?> >>>
<?php remove_filter( 'the_content', 'do_shortcode', 11 ); the_content();
			}

		wp_reset_postdata();
		return ob_get_clean();
	}

}//End Class