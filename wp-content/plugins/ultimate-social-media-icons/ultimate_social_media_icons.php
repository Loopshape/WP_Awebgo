<?php
/*
Plugin Name: Social Media and Share Icons (Ultimate Social Media)
Plugin URI: http://ultimatelysocial.com
Description: Easy to use and 100% FREE social media plugin which adds social media icons to your website with tons of customization features!. 
Author: UltimatelySocial
Author URI: http://ultimatelysocial.com
Version: 1.2.8
License: GPLv2 or later
*/
global $wpdb;

/* define the Root for URL and Document */
define('SFSI_DOCROOT',    dirname(__FILE__));
define('SFSI_PLUGURL',    plugin_dir_url(__FILE__));
define('SFSI_WEBROOT',    str_replace(getcwd(), home_url(), dirname(__FILE__)));

/* load all files  */
include(SFSI_DOCROOT.'/libs/controllers/sfsi_socialhelper.php');
include(SFSI_DOCROOT.'/libs/sfsi_install_uninstall.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsi_buttons_controller.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsi_iconsUpload_contoller.php');
include(SFSI_DOCROOT.'/libs/sfsi_Init_JqueryCss.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsi_floater_icons.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsi_frontpopUp.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsiocns_OnPosts.php');
include(SFSI_DOCROOT.'/libs/sfsi_widget.php');
include(SFSI_DOCROOT.'/libs/sfsi_subscribe_widget.php');

/* plugin install and uninstall hooks */
register_activation_hook(__FILE__, 'sfsi_activate_plugin' );
register_deactivation_hook(__FILE__, 'sfsi_deactivate_plugin');
register_uninstall_hook(__FILE__, 'sfsi_Unistall_plugin');

if(!get_option('sfsi_pluginVersion') || get_option('sfsi_pluginVersion') < 1.28)
{
	add_action("init", "sfsi_update_plugin");
}
//shortcode for the ultimate social icons {Monad}
add_shortcode("DISPLAY_ULTIMATE_SOCIAL_ICONS", "DISPLAY_ULTIMATE_SOCIAL_ICONS");
function DISPLAY_ULTIMATE_SOCIAL_ICONS($args = null, $content = null)
{
	$instance = array("showf" => 1, "title" => '');
	$return = '';
	if(!isset($before_widget)): $before_widget =''; endif;
	if(!isset($after_widget)): $after_widget =''; endif;
	
	/*Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	$show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;
	global $is_floter;	      
	$return.= $before_widget;
		/* Display the widget title */
		if ( $title ) $return .= $before_title . $title . $after_title;
		$return .= '<div class="sfsi_widget">';
			$return .= '<div id="sfsi_wDiv"></div>';
			/* Link the main icons function */
			$return .= sfsi_check_visiblity(0);
	   		$return .= '<div style="clear: both;"></div>';
	    $return .= '</div>';
	$return .= $after_widget;
	return $return;
}

//adding some meta tags for facebook news feed {Monad}
function sfsi_checkmetas()
{
	if ( ! function_exists( 'get_plugins' ) )
	{
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$all_plugins = get_plugins();
	foreach($all_plugins as $key => $plugin)
	{
		if(is_plugin_active($key))
		{
			if(preg_match("/(seo|search engine optimization|meta tag|open graph|opengraph|og tag|ogtag)/im", $plugin['Name']) || preg_match("/(seo|search engine optimization|meta tag|open graph|opengraph|og tag|ogtag)/im", $plugin['Description']))
			{
				update_option("adding_tags", "no");
				break;
			}
			else
			{
				update_option("adding_tags", "yes");
			}
		}
	}	
}
if ( ! is_admin() )
{
	sfsi_checkmetas();
}

add_action('wp_head', 'ultimatefbmetatags');
function ultimatefbmetatags()
{
	$metarequest = get_option("adding_tags");
	$post_id = get_the_ID();
	if($metarequest == 'yes' && !empty($post_id))
	{
		$post = get_post( $post_id );
		$attachment_id = get_post_thumbnail_id($post_id);
		$title = str_replace('"', "", strip_tags(get_the_title($post_id)));
		$url = get_permalink($post_id);
		$description = $post->post_content;
		$description = str_replace('"', "", strip_tags($description));
		
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		
		if($attachment_id)
		{
		   $feat_image = wp_get_attachment_url( $attachment_id );
		   if (preg_match('/https/',$feat_image))
		   {
				echo '<meta property="og:image:secure_url" content="'.$feat_image.'" data-id="sfsi">';
		   }
		   else
		   {
				echo '<meta property="og:image" content="'.$feat_image.'" data-id="sfsi">';
		   }
		   $metadata = wp_get_attachment_metadata( $attachment_id );
		   if(isset($metadata) && !empty($metadata))
		   {
			   if(isset($metadata['sizes']['post-thumbnail']))
			   {
					$image_type = $metadata['sizes']['post-thumbnail']['mime-type'];
			   }
			   else
			   {
					$image_type = '';  
			   }
			   if(isset($metadata['width']))
			   {
					$width = $metadata['width'];
			   }
			   else
			   {
					$width = '';  
			   }
			   if(isset($metadata['height']))
			   {
					$height = $metadata['height'];
			   }
			   else
			   {
					$height = '';  
			   }
		   }
		   else
		   {
				$image_type = '';
				$width = '';
				$height = '';  
		   }  
		   echo '<meta property="og:image:type" content="'.$image_type.'" data-id="sfsi" />';
		   echo '<meta property="og:image:width" content="'.$width.'" data-id="sfsi" />';
		   echo '<meta property="og:image:height" content="'.$height.'" data-id="sfsi" />';
		   echo '<meta property="og:url" content="'.$url.'" data-id="sfsi" />'; 
		   echo '<meta property="og:description" content="'.$description.'" data-id="sfsi" />';
		   echo '<meta property="og:title" content="'.$title.'" data-id="sfsi" />';
		}
	}
}

//checking for the youtube username and channel id option
add_action('admin_init', 'check_sfsfiupdatedoptions');
function check_sfsfiupdatedoptions()
{
	$option4=  unserialize(get_option('sfsi_section4_options',false));
	if(isset($option4['sfsi_youtubeusernameorid']) && !empty($option4['sfsi_youtubeusernameorid']))
	{
	}
	else
	{
		$option4['sfsi_youtubeusernameorid'] = 'name';
		update_option('sfsi_section4_options',serialize($option4));
	}
}

//sanitizing values
function string_sanitize($s) {
    $result = preg_replace("/[^a-zA-Z0-9]+/", " ", html_entity_decode($s, ENT_QUOTES));
    return $result;
}

//Add Subscriber form css
add_action("wp_head", "addStyleFunction");
function addStyleFunction()
{
	$option8 = unserialize(get_option('sfsi_section8_options',false));
	$sfsi_feediid = get_option('sfsi_feed_id');
	$url = "http://www.specificfeeds.com/widgets/subscribeWidget/";
	echo $return = '';
	?>
    	<script>
			function sfsi_processfurther(ref) {
				var feed_id = '<?php echo $sfsi_feediid?>';
				var feedtype = 8;
				var email = jQuery(ref).find('input[name="data[Widget][email]"]').val();
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if ((email != "Enter your email") && (filter.test(email))) {
					if (feedtype == "8") {
						var url = "'.$url.'"+feed_id+"/"+feedtype;
						window.open(url, "popupwindow", "scrollbars=yes,width=1080,height=760");
						return true;
					}
				} else {
					alert("Please enter email address");
					jQuery(ref).find('input[name="data[Widget][email]"]').focus();
					return false;
				}
			}
		</script>
    	<style type="text/css" aria-selected="true">
			.sfsi_subscribe_Popinner
			{
				<?php if($option8['sfsi_form_adjustment'] == 'yes') : ?>
				width: 100% !important;
				height: auto !important;
				<?php else: ?>
				width: <?php echo $option8['sfsi_form_width'] ?>px !important;
				height: <?php echo $option8['sfsi_form_height'] ?>px !important;
				<?php endif;?>
				<?php if($option8['sfsi_form_border'] == 'yes') : ?>
				border: <?php echo $option8['sfsi_form_border_thickness']."px solid ".$option8['sfsi_form_border_color'];?> !important;
				<?php endif;?>
				padding: 18px 0px !important;
				background-color: <?php echo $option8['sfsi_form_background'] ?> !important;
			}
			.sfsi_subscribe_Popinner form
			{
				margin: 0 20px !important;
			}
			.sfsi_subscribe_Popinner h5
			{
				font-family: <?php echo $option8['sfsi_form_heading_font'] ?> !important;
				<?php if($option8['sfsi_form_heading_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option8['sfsi_form_heading_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option8['sfsi_form_heading_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option8['sfsi_form_heading_fontcolor'] ?> !important;
				font-size: <?php echo $option8['sfsi_form_heading_fontsize']."px" ?> !important;
				text-align: <?php echo $option8['sfsi_form_heading_fontalign'] ?> !important;
				margin: 0 0 10px !important;
    			padding: 0 !important;
			}
			.sfsi_subscription_form_field {
				margin: 5px 0 !important;
				width: 100% !important;
				display: inline-flex;
				display: -webkit-inline-flex;
			}
			.sfsi_subscription_form_field input {
				width: 100% !important;
				padding: 10px 0px !important;
			}
			.sfsi_subscribe_Popinner input[type=email]
			{
				font-family: <?php echo $option8['sfsi_form_field_font'] ?> !important;
				<?php if($option8['sfsi_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option8['sfsi_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option8['sfsi_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option8['sfsi_form_field_fontalign'] ?> !important;
			}
			.sfsi_subscribe_Popinner input[type=email]::-webkit-input-placeholder {
			   font-family: <?php echo $option8['sfsi_form_field_font'] ?> !important;
				<?php if($option8['sfsi_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option8['sfsi_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option8['sfsi_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option8['sfsi_form_field_fontalign'] ?> !important;
			}
			
			.sfsi_subscribe_Popinner input[type=email]:-moz-placeholder { /* Firefox 18- */
			    font-family: <?php echo $option8['sfsi_form_field_font'] ?> !important;
				<?php if($option8['sfsi_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option8['sfsi_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option8['sfsi_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option8['sfsi_form_field_fontalign'] ?> !important;
			}
			
			.sfsi_subscribe_Popinner input[type=email]::-moz-placeholder {  /* Firefox 19+ */
			    font-family: <?php echo $option8['sfsi_form_field_font'] ?> !important;
				<?php if($option8['sfsi_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option8['sfsi_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option8['sfsi_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option8['sfsi_form_field_fontalign'] ?> !important;
			}
			
			.sfsi_subscribe_Popinner input[type=email]:-ms-input-placeholder {  
			  	font-family: <?php echo $option8['sfsi_form_field_font'] ?> !important;
				<?php if($option8['sfsi_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option8['sfsi_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option8['sfsi_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option8['sfsi_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option8['sfsi_form_field_fontalign'] ?> !important;
			}
			.sfsi_subscribe_Popinner input[type=submit]
			{
				font-family: <?php echo $option8['sfsi_form_button_font'] ?> !important;
				<?php if($option8['sfsi_form_button_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option8['sfsi_form_button_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option8['sfsi_form_button_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option8['sfsi_form_button_fontcolor'] ?> !important;
				font-size: <?php echo $option8['sfsi_form_button_fontsize']."px" ?> !important;
				text-align: <?php echo $option8['sfsi_form_button_fontalign'] ?> !important;
				background-color: <?php echo $option8['sfsi_form_button_background'] ?> !important;
			}
		</style>
	<?php
}
add_action('admin_notices', 'sfsi_admin_notice', 10);
function sfsi_admin_notice()
{
	if(isset($_GET['page']) && $_GET['page'] == "sfsi-options")
	{
		$style = "overflow: hidden; margin:12px 3px 0px;";
	}
	else
	{
		$style = "overflow: hidden;"; 
	}
	if(get_option("show_notification_plugin") == "yes")
	{ 
		$url = "?sfsi-dismiss-notice=true";
		?>
		<div class="updated" style="<?php echo $style; ?>">
			<div class="alignleft" style="margin: 9px 0;">
				<b>New feature in the Ultimate Social Media Icons plugin:</b> You can now add a subscription form to increase sign-ups (under question 8). <a href="<?php echo site_url();?>/wp-admin/admin.php?page=sfsi-options" style="color:#7AD03A; font-weight:bold;">Check it out</a>
			</div>
			<p class="alignright">
				<a href="<?php echo $url; ?>">Dismiss</a>
			</p>
		</div>
	<?php }
}
add_action('admin_init', 'sfsi_dismiss_admin_notice');
function sfsi_dismiss_admin_notice()
{
	if ( isset($_REQUEST['sfsi-dismiss-notice']) && $_REQUEST['sfsi-dismiss-notice'] == 'true' )
	{
		update_option( 'show_notification_plugin', "no" );
		header("Location: ".site_url()."/wp-admin/admin.php?page=sfsi-options");
	}
}
?>