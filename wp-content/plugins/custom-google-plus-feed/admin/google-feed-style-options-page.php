<?php
namespace Google_Plus_Feed;
class FTS_google_options_page {
	function __construct() {
	}
	//**************************************************
	// Youtube Options Page
	//**************************************************
	function google_feed_style_options_page() {
		$gpf_functions = new Google_Plus_Feed_Functions();
		$gpf_youtube_show_follow_btn = get_option('youtube_show_follow_btn');
		$gpf_youtube_show_follow_btn_where = get_option('youtube_show_follow_btn_where');

?>

<div class="google-plus-feed-admin-wrap">
<h1>
<?php _e('Google Feed Options', 'custom-google-plus-feed'); ?>
</h1>
<div class="use-of-plugin">
<?php _e('Change the Colors and more for your Google feed using the options below.', 'custom-google-plus-feed'); ?>
</div>

<!-- custom option for padding -->
<form method="post" class="gpf-youtube-feed-options-form" action="options.php">
<?php settings_fields('gpf-youtube-feed-style-options'); ?>
<div class="google-plus-feed-admin-input-wrap">
<div class="gpf-title-description-settings-page" style="padding-top:0; border:none;">


<br/>
<?php // get our registered settings from the gpf functions
		settings_fields('gpf-google-feed-style-options');
		//Language select
		$gpf_language = get_option('gpf_language', 'en_US');
		//share button
		$gpf_show_follow_btn = get_option('gpf_show_follow_btn');
		$gpf_show_follow_btn_where = get_option('gpf_show_follow_btn_where');
		$gpf_show_follow_btn_profile_pic = get_option('gpf_show_follow_btn_profile_pic');
		$gpf_follow_count = get_option('gpf_follow_count', 'yes');
		$gpf_hide_shared_by_etc_text = get_option('gpf_hide_shared_by_etc_text');


		// $lang_options_array = json_decode($gpf_functions->xml_json_parse('https://www.facebook.com/translations/FacebookLocales.xml'));
		//echo'<pre>';
		// print_r($lang_options_array);
		//echo'</pre>';

?>
<div class="google-plus-feed-admin-input-wrap" style="padding-top:0; border:none; display:none">
<div class="gpf-title-description-settings-page">
<h3>
<?php _e('Language Options', 'custom-google-plus-feed'); ?>
</h3>
<?php _e('You must have your Google API Token saved at the bottom of this page before this feature will work. This option will translate the Google Titles and Google+ Button. It will not tranlate your actual post. To tranlate the Feed in this plugin just set your language on the <a href="options-general.php" target="_blank">wordpress settings</a> page. If would like to help translate please visit our', 'custom-google-plus-feed'); ?> <a href="http://glotpress.slickremix.com/projects" target="_blank">GlottPress</a>. </div>
<div class="google-plus-feed-admin-input-label gpf-twitter-text-color-label">
<?php _e('Language For Google Feed', 'custom-google-plus-feed'); ?>
</div>

<?php
	//	foreach ($lang_options_array->locale as $language ) {
	//		echo'<option '.selected($gpf_language, $language->codes->code->standard->representation, true ).' value="'.$language->codes->code->standard->representation.'">'.$language->englishName.'</option>';
	//	}
?>
<select name="gpf_language" id="fb-lang-btn" class="google-plus-feed-admin-input">
<option value="en-US"> <?php _e('Please Select Option', 'custom-google-plus-feed'); ?></option>
<!--First row in google developers table-->
<!--https://developers.google.com/+/web/api/supported-languages-->
<option <?php echo selected($gpf_language, 'af', false ) ?> value="af">Afrikaans</option>
<option <?php echo selected($gpf_language, 'am', false ) ?> value="am">Amharic</option>
<option <?php echo selected($gpf_language, 'ar', false ) ?> value="ar">Arabic</option>
<option <?php echo selected($gpf_language, 'eu', false ) ?> value="eu">Basque</option>
<option <?php echo selected($gpf_language, 'bn', false ) ?> value="bn">Bengali</option>
<option <?php echo selected($gpf_language, 'bg', false ) ?> value="bg">Bulgarian</option>
<option <?php echo selected($gpf_language, 'ca', false ) ?> value="ca">Catalan</option>
<option <?php echo selected($gpf_language, 'zh-HK', false ) ?> value="zh-HK">Chinese (Hong Kong)</option>
<option <?php echo selected($gpf_language, 'zh-CN', false ) ?> value="zh-CN">Chinese (Simplified)</option>
<option <?php echo selected($gpf_language, 'zh-TW', false ) ?> value="zh-TW">Chinese (Traditional)</option>
<option <?php echo selected($gpf_language, 'hr', false ) ?> value="hr">Corsican</option>
<option <?php echo selected($gpf_language, 'cs', false ) ?> value="cs">Czech</option>
<option <?php echo selected($gpf_language, 'da', false ) ?> value="da">Danish</option>
<option <?php echo selected($gpf_language, 'nl', false ) ?> value="nl">Dutch</option>
<option <?php echo selected($gpf_language, 'en-GB', false ) ?> value="en-GB">English (UK)</option>
<option <?php echo selected($gpf_language, 'en-US', false ) ?> value="en-US">English (US)</option>
<option <?php echo selected($gpf_language, 'et', false ) ?> value="et">Estonian</option>
<option <?php echo selected($gpf_language, 'fil', false ) ?> value="fil">Filipino</option>
<option <?php echo selected($gpf_language, 'fi', false ) ?> value="fi">Finnish</option>
<option <?php echo selected($gpf_language, 'fr', false ) ?> value="fr">French</option>
<option <?php echo selected($gpf_language, 'fr-CA', false ) ?> value="fr-CA">French (Canadian)</option>
<!--Second row in google developers table-->
<!--https://developers.google.com/+/web/api/supported-languages-->
<option <?php echo selected($gpf_language, 'gl', false ) ?> value="gl">Galician</option>
<option <?php echo selected($gpf_language, 'de', false ) ?> value="de">German</option>
<option <?php echo selected($gpf_language, 'el', false ) ?> value="el">Greek</option>
<option <?php echo selected($gpf_language, 'gu', false ) ?> value="gu">Gujarati</option>
<option <?php echo selected($gpf_language, 'iw', false ) ?> value="iw">Hebrew</option>
<option <?php echo selected($gpf_language, 'hi', false ) ?> value="hi">Hindi</option>
<option <?php echo selected($gpf_language, 'hu', false ) ?> value="hu">Hungarian</option>
<option <?php echo selected($gpf_language, 'is', false ) ?> value="is">Icelandic</option>
<option <?php echo selected($gpf_language, 'id', false ) ?> value="id">Indonesian</option>
<option <?php echo selected($gpf_language, 'it', false ) ?> value="it">Italian</option>
<option <?php echo selected($gpf_language, 'ja', false ) ?> value="ja">Japanese</option>
<option <?php echo selected($gpf_language, 'kn', false ) ?> value="kn">Kannada</option>
<option <?php echo selected($gpf_language, 'ko', false ) ?> value="ko">Korean</option>
<option <?php echo selected($gpf_language, 'lv', false ) ?> value="lv">Latvian</option>
<option <?php echo selected($gpf_language, 'lt', false ) ?> value="lt">Lithuanian</option>
<option <?php echo selected($gpf_language, 'ms', false ) ?> value="ms">Malay</option>
<option <?php echo selected($gpf_language, 'ml', false ) ?> value="ml">Malayalam</option>
<option <?php echo selected($gpf_language, 'mr', false ) ?> value="mr">Marathi</option>
<option <?php echo selected($gpf_language, 'no', false ) ?> value="no">Norwegian</option>
<option <?php echo selected($gpf_language, 'fa', false ) ?> value="fa">Persian</option>
<option <?php echo selected($gpf_language, 'pl', false ) ?> value="pl">Polish</option>
<!--Third row in google developers table-->
<!--https://developers.google.com/+/web/api/supported-languages-->
<option <?php echo selected($gpf_language, 'pt-BR', false ) ?> value="pt-BR">Portuguese (Brazil)</option>
<option <?php echo selected($gpf_language, 'pt-PT', false ) ?> value="pt-PT">Portuguese (Portugal)</option>
<option <?php echo selected($gpf_language, 'ro', false ) ?> value="ro">Romanian</option>
<option <?php echo selected($gpf_language, 'ru', false ) ?> value="ru">Russian</option>
<option <?php echo selected($gpf_language, 'sr', false ) ?> value="sr">Serbian</option>
<option <?php echo selected($gpf_language, 'sk', false ) ?> value="sk">Slovak</option>
<option <?php echo selected($gpf_language, 'sl', false ) ?> value="sl">Slovenian</option>
<option <?php echo selected($gpf_language, 'es', false ) ?> value="es">Spanish</option>
<option <?php echo selected($gpf_language, 'es-419', false ) ?> value="es-419">Spanish (Latin America)</option>
<option <?php echo selected($gpf_language, 'sw', false ) ?> value="sw">Swahili</option>
<option <?php echo selected($gpf_language, 'sv', false ) ?> value="sv">Swedish</option>
<option <?php echo selected($gpf_language, 'ta', false ) ?> value="ta">Tamil</option>
<option <?php echo selected($gpf_language, 'te', false ) ?> value="te">Telugu</option>
<option <?php echo selected($gpf_language, 'th', false ) ?> value="th">Thai</option>
<option <?php echo selected($gpf_language, 'tr', false ) ?> value="tr">Turkish</option>
<option <?php echo selected($gpf_language, 'uk', false ) ?> value="uk">Ukrainian</option>
<option <?php echo selected($gpf_language, 'ur', false ) ?> value="ur">Urdu</option>
<option <?php echo selected($gpf_language, 'vi', false ) ?> value="vi">Vietnamese</option>
<option <?php echo selected($gpf_language, 'zu', false ) ?> value="zu">Zulu</option>
</select>
<div class="clear"></div>
</div>
<!--/gpf-twitter-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="gpf-title-description-settings-page" style="padding-top:0; border:none;">
<h3>
<?php _e('Google+ Button Options', 'custom-google-plus-feed'); ?>
</h3>
</div>
<div class="google-plus-feed-admin-input-label gpf-twitter-text-color-label">
<?php _e('Show Google+ Button', 'custom-google-plus-feed'); ?>
</div>
<select name="gpf_show_follow_btn" id="fb-show-follow-btn" class="google-plus-feed-admin-input">
<option '<?php echo selected($gpf_show_follow_btn, 'no', false ) ?>' value="no">
<?php _e('No', 'custom-google-plus-feed'); ?>
</option>
<option '<?php echo selected($gpf_show_follow_btn, 'yes', false ) ?>' value="yes">
<?php _e('Yes', 'custom-google-plus-feed'); ?>
</option>
</select>
<div class="clear"></div>
</div>
<!--/gpf-twitter-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-twitter-text-color-label">
<?php _e('Placement of the Buttons', 'custom-google-plus-feed'); ?>
</div>
<select name="gpf_show_follow_btn_where" id="fb-show-follow-btn-where" class="google-plus-feed-admin-input">
<option >
<?php _e('Please Select Option', 'custom-google-plus-feed'); ?>
</option>
<option '<?php echo selected($gpf_show_follow_btn_where, 'facebook-follow-above', false ) ?>' value="facebook-follow-above">
<?php _e('Show Above Feed', 'custom-google-plus-feed'); ?>
</option>
<option '<?php echo selected($gpf_show_follow_btn_where, 'facebook-follow-below', false ) ?>' value="facebook-follow-below">
<?php _e('Show Below Feed', 'custom-google-plus-feed'); ?>
</option>
</select>
<div class="clear"></div>
</div>
<!--/gpf-twitter-feed-styles-input-wrap--> 


<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-twitter-text-color-label">
<?php _e('Show Follow Count', 'custom-google-plus-feed'); ?>
</div>
<select name="gpf_follow_count" id="fb-follow-count" class="google-plus-feed-admin-input">
<option value="yes">
<?php _e('Please Select Option', 'custom-google-plus-feed'); ?>
</option>
<option <?php echo selected($gpf_follow_count, 'bubble', false ) ?> value="bubble">
<?php _e('Yes', 'custom-google-plus-feed'); ?>
</option>
<option <?php echo selected($gpf_follow_count, 'none', false ) ?> value="none">
<?php _e('No', 'custom-google-plus-feed'); ?>
</option>
</select>
<div class="clear"></div>
</div>
<!--/gpf-twitter-feed-styles-input-wrap-->

 



 
<div class="gpf-title-description-settings-page" style="margin-top:0; ">
<h3>
<?php _e('Style Options', 'custom-google-plus-feed'); ?>
</h3>
</div>

<div class="clear"></div> 


<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-text-color-label">
<?php _e('Feed Text Color', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_text_color" class="google-plus-feed-admin-input fb-text-color-input color {hash:true,caps:false,required:false,adjust:false,pickerFaceColor:'#eee',pickerFace:3,pickerBorder:0,pickerInsetColor:'white'}"  id="fb-text-color-input" placeholder="#222" value="<?php echo get_option('gpf_text_color');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-link-color-label">
<?php _e('Feed Link Color', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_link_color" class="google-plus-feed-admin-input fb-link-color-input color {hash:true,caps:false,required:false,adjust:false,pickerFaceColor:'#eee',pickerFace:3,pickerBorder:0,pickerInsetColor:'white'}"  id="fb-link-color-input" placeholder="#222" value="<?php echo get_option('gpf_link_color');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-link-color-hover-label">
<?php _e('Feed Link Color Hover', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_link_color_hover" class="google-plus-feed-admin-input fb-link-color-hover-input color {hash:true,caps:false,required:false,adjust:false,pickerFaceColor:'#eee',pickerFace:3,pickerBorder:0,pickerInsetColor:'white'}"  id="fb-link-color-hover-input" placeholder="#ddd" value="<?php echo get_option('gpf_link_color_hover');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-feed-width-label">
<?php _e('Feed Width', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_feed_width" class="google-plus-feed-admin-input fb-feed-width-input"  id="fb-feed-width-input" placeholder="500px" value="<?php echo get_option('gpf_feed_width');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-feed-margin-label">
<?php _e('Feed Margin <br/><small>To center feed type auto</small>', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_feed_margin" class="google-plus-feed-admin-input fb-feed-margin-input"  id="fb-feed-margin-input" placeholder="10px" value="<?php echo get_option('gpf_feed_margin');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-feed-padding-label">
<?php _e('Feed Padding', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_feed_padding" class="google-plus-feed-admin-input fb-feed-padding-input"  id="fb-feed-padding-input" placeholder="10px" value="<?php echo get_option('gpf_feed_padding');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-feed-background-color-label">
<?php _e('Feed Background Color', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_feed_background_color" class="google-plus-feed-admin-input fb-feed-background-color-input color {hash:true,caps:false,required:false,adjust:false,pickerFaceColor:'#eee',pickerFace:3,pickerBorder:0,pickerInsetColor:'white'}"  id="fb-feed-background-color-input" placeholder="#ddd" value="<?php echo get_option('gpf_feed_background_color');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-grid-posts-background-color-label">
<?php _e('Feed Grid Posts Background Color (Grid style feeds ONLY)', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_grid_posts_background_color" class="google-plus-feed-admin-input fb-grid-posts-background-color-input color {hash:true,caps:false,required:false,adjust:false,pickerFaceColor:'#eee',pickerFace:3,pickerBorder:0,pickerInsetColor:'white'}"  id="fb-grid-posts-background-color-input" placeholder="#ddd" value="<?php echo get_option('gpf_grid_posts_background_color');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->

<div class="google-plus-feed-admin-input-wrap">
<div class="google-plus-feed-admin-input-label gpf-fb-border-bottom-color-label">
<?php _e('Feed Border Bottom Color', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_border_bottom_color" class="google-plus-feed-admin-input fb-border-bottom-color-input color {hash:true,caps:false,required:false,adjust:false,pickerFaceColor:'#eee',pickerFace:3,pickerBorder:0,pickerInsetColor:'white'}"  id="fb-border-bottom-color-input" placeholder="#ddd" value="<?php echo get_option('gpf_border_bottom_color');?>"/>
<div class="clear"></div>
</div>
<!--/gpf-facebook-feed-styles-input-wrap-->
 

<?php
		$googleAPIkey = get_option('gpf_custom_api_token');

		$youtube_userID_data = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=slickremix&key='.$googleAPIkey;

		//Get Data for Youtube
		$response = wp_remote_fopen($youtube_userID_data);
		//Error Check
		$test_app_token_response = json_decode($response);

		// echo'<pre>';
		// print_r($test_app_token_response);
		// echo'</pre>';
		?>
<div class="google-plus-feed-admin-input-wrap">
<div class="gpf-title-description-settings-page">
<h3>
<?php _e('Google API Key', 'custom-google-plus-feed'); ?>
</h3>
<?php _e('Read here and learn how to <a href="http://www.slickremix.com/docs/get-api-key-for-google/" target="_blank">GET AN API KEY</a>.', 'custom-google-plus-feed'); ?>
</div>
<div class="google-plus-feed-admin-input-wrap" style="margin-bottom:0px;">
<div class="google-plus-feed-admin-input-label gpf-twitter-border-bottom-color-label">
<?php _e('API Key Required', 'custom-google-plus-feed'); ?>
</div>
<input type="text" name="gpf_custom_api_token" class="google-plus-feed-admin-input"  id="gpf_custom_api_token" value="<?php echo get_option('gpf_custom_api_token');?>"/>
<div class="clear"></div>
</div>
<?php
		foreach($test_app_token_response as $userID) {
			// Error Check
			if(!isset($userID->errors[0]->reason) && !empty($googleAPIkey)){
				echo'<div class="gpf-successful-api-token">'. __('Your API key is working!', 'custom-google-plus-feed').'</div>';
			}
			elseif(isset($userID->errors[0]->reason) && !empty($googleAPIkey)){
				echo'<div class="gpf-failed-api-token">'. __('This API key does not appear to be valid. Google responded with: ', 'custom-google-plus-feed').' '.$userID->errors[0]->reason.'</div>';
			}
			if ($googleAPIkey == ''){
				echo'<div class="gpf-failed-api-token">'. __('You must register for an API token to use the Google feed.', 'custom-google-plus-feed').'</div>';
			}
			break;
		}
?></div>
<div class="clear"></div>
<input type="submit" class="google-plus-feed-admin-submit-btn" value="<?php _e('Save All Changes') ?>" />
</div>
</form>
</div>
<!--/google-plus-feed-admin-wrap-->
<?php }
}//END Class

