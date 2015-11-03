<?php
$cb_lang = array();
$cb_lang_translated_languages = array();
array_push($cb_lang_translated_languages,"fr_BE","fr_BE","fr_CA","fr_CH","fr_FR","ru_RU","ru_UA","en_US","en_GB","es_ES","es_CL","es_PE","es_PR","es_VE","es_CO","nl_NL","nl_BE",
"hu_HU","de_DE", "pt_BR","pt_PT","he_IL", "tr_TR","it_IT", "da_DK", "pl_PL", "sv_SE", "zh_CN","zh_HK","zh_sg","zh_TW","zh","cs_CZ","sk_SK","el","hr","fi");

array_push($cb_lang, "ar", "et", "bg_BG", "id_ID", "ja", "ko_KR", "ms_MY", "ro_RO", "sl_SL", "sq", "sr_RS", "th", "et");
$cb_language = get_locale();
?>
<script>
jQuery(document).ready(function()
{
	jQuery(".nav-tab-wrapper > a#<?php echo $_REQUEST["page"];?>").addClass("nav-tab-active");
});
</script>
<div id="welcome-panel" class="welcome-panel" style="padding:0px !important;background-color: #f9f9f9 !important">
	<div class="welcome-panel-content">
		<img src="<?php echo plugins_url("/assets/images/contact-bank.png" , dirname(__FILE__)); ?>" />
		<div class="welcome-panel-column-container">
			<div class="welcome-panel-column" style="width:240px !important;">
				<h4 class="welcome-screen-margin">
					<?php _e("Get Started", contact_bank); ?>
				</h4>
				<a class="button button-primary button-hero" target="_blank" href="http://vimeo.com/92488992">
					<?php _e("Watch Contact Video!", contact_bank); ?>
				</a>
				<p>or, 
					<a target="_blank" href="http://tech-banker.com/products/wp-contact-bank/knowledge-base/">
						<?php _e("read documentation here", contact_bank); ?>
					</a>
				</p>
			</div>
			<div class="welcome-panel-column" style="width:250px !important;">
				<h4 class="welcome-screen-margin"><?php _e("Go Premium", contact_bank); ?></h4>
				<ul>
					<li>
						<a href="http://tech-banker.com/products/wp-contact-bank/" target="_blank" class="welcome-icon">
							<?php _e("Feature", contact_bank); ?>
						</a>
					</li>
					<li>
						<a href="http://tech-banker.com/products/wp-contact-bank/demo/" target="_blank" class="welcome-icon">
							<?php _e("Online Demos", contact_bank); ?>
						</a>
					</li>
					<li>
						<a href="http://tech-banker.com/products/wp-contact-bank/pricing/" target="_blank" class="welcome-icon">
							<?php _e("Premium Pricing Plan ?", contact_bank); ?>
						</a>
					</li>
				</ul>
			</div>
			<div class="welcome-panel-column" style="width:240px !important;">
				<h4 class="welcome-screen-margin">
					<?php _e("Knowledge Base", contact_bank); ?>
				</h4>
				<ul>
					<li>
						<a href="http://tech-banker.com/forums/forum/contact-bank-support/" target="_blank" class="welcome-icon">
							<?php _e("Support Forum", contact_bank); ?>
						</a>
					</li>
					<li>
						<a href="http://tech-banker.com/products/wp-contact-bank/knowledge-base/" target="_blank" class="welcome-icon">
							<?php _e("FAQ's", contact_bank); ?>
						</a>
					</li>
					<li>
						<a href="http://tech-banker.com/products/wp-contact-bank/" target="_blank" class="welcome-icon">
							<?php _e("Detailed Features", contact_bank); ?>
						</a>
					</li>
				</ul>
			</div>
			<div class="welcome-panel-column welcome-panel-last" style="width:250px !important;">
				<h4 class="welcome-screen-margin"><?php _e("More Actions", contact_bank); ?></h4>
				<ul>
					<li>
						<a href="http://tech-banker.com/shop/plugin-customization/order-customization-wp-contact-bank/" target="_blank" class="welcome-icon">
							<?php _e("Plugin Customization", contact_bank); ?>
						</a>
					</li>
					<li>
						<a href="admin.php?page=contact_bank_recommended_plugins" class="welcome-icon">
							<?php _e("Recommendations", contact_bank); ?>
						</a>
					</li>
					<li>
						<a href="admin.php?page=contact_bank_other_services" class="welcome-icon">
							<?php _e("Our Other Services", contact_bank); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
global $wpdb,$current_user;
if (is_super_admin())
{
	$cb_role = "administrator";
}
else
{
	$cb_role = $wpdb->prefix . "capabilities";
	$current_user->role = array_keys($current_user->$cb_role);
	$cb_role = $current_user->role[0];
}

switch ($cb_role) {
	case "administrator":
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab custom-nav-tab" id="dashboard" href="admin.php?page=contact_dashboard"><?php _e("Dashboard",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_short_code" href="admin.php?page=contact_short_code"><?php _e("Short-Codes",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_frontend_data" href="admin.php?page=contact_frontend_data"><?php _e("Form Entries",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_email" href="admin.php?page=contact_email"><?php _e("Email Settings",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_layout_settings" href="admin.php?page=contact_layout_settings"><?php _e("Global Settings",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_bank_recommended_plugins" href="admin.php?page=contact_bank_recommended_plugins"><?php _e("Recommendations",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_pro_version" href="admin.php?page=contact_pro_version"><?php _e("Premium Editions",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_bank_other_services" href="admin.php?page=contact_bank_other_services"><?php _e("Our Other Services",contact_bank) ;?></a>
		</h2>
		<?php
	break;
	case "editor":
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab custom-nav-tab" id="dashboard" href="admin.php?page=contact_dashboard"><?php _e("Dashboard",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_short_code" href="admin.php?page=contact_short_code"><?php _e("Short-Codes",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_frontend_data" href="admin.php?page=contact_frontend_data"><?php _e("Form Entries",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_email" href="admin.php?page=contact_email"><?php _e("Email Settings",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_layout_settings" href="admin.php?page=contact_layout_settings"><?php _e("Global Settings",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_bank_recommended_plugins" href="admin.php?page=contact_bank_recommended_plugins"><?php _e("Recommendations",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_pro_version" href="admin.php?page=contact_pro_version"><?php _e("Premium Editions",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_bank_other_services" href="admin.php?page=contact_bank_other_services"><?php _e("Our Other Services",contact_bank) ;?></a>
		</h2>
		<?php
	break;
	case "author":
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab custom-nav-tab" id="dashboard" href="admin.php?page=contact_dashboard"><?php _e("Dashboard",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_short_code" href="admin.php?page=contact_short_code"><?php _e("Short-Codes",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_frontend_data" href="admin.php?page=contact_frontend_data"><?php _e("Form Entries",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_email" href="admin.php?page=contact_email"><?php _e("Email Settings",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_layout_settings" href="admin.php?page=contact_layout_settings"><?php _e("Global Settings",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_bank_recommended_plugins" href="admin.php?page=contact_bank_recommended_plugins"><?php _e("Recommendations",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_pro_version" href="admin.php?page=contact_pro_version"><?php _e("Premium Editions",contact_bank) ;?></a>
			<a class="nav-tab custom-nav-tab" id="contact_bank_other_services" href="admin.php?page=contact_bank_other_services"><?php _e("Our Other Services",contact_bank) ;?></a>
		</h2>
		<?php
	break;
}
if($_REQUEST["page"] != "contact_feature_request")
{
	?>
	<div class="custom-message green" style="display: block;margin-top:30px">
		<div style="padding: 4px 0;">
			<p style="font:12px/1.0em Arial !important;font-weight:bold;">If you don't find any features you were looking for in this Plugin, 
				please write us <a target="_self" href="admin.php?page=contact_feature_request">here</a> and we shall try to implement this for you as soon as possible! We are looking forward for your valuable <a target="_self" href="admin.php?page=contact_feature_request">Feedback</a></p>
		</div>
	</div>
	<?php
}
if(in_array($cb_language, $cb_lang))
{
	?>
	<div class="custom-message red" style="display: block;margin-top:10px">
		<span style="padding: 4px 0;">
			<strong><p style="font:12px/1.0em Arial !important;">This plugin language is translated with the help of Google Translator.</p>
				<p style="font:12px/1.0em Arial !important;">If you would like to translate & help us, we will reward you with a free Eco Edition License of Contact Bank.</p>
				<p style="font:12px/1.0em Arial !important;">Contact Us at <a target="_blank" href="http://tech-banker.com">http://tech-banker.com</a> or email us at <a href="mailto:support@tech-banker.com">support@tech-banker.com</a></p>
			</strong>
		</span>
	</div>
	<?php
}
elseif(!(in_array($cb_language, $cb_lang_translated_languages)) && !(in_array($cb_language, $cb_lang)) && $cb_language != "")
{
	?>
	<div class="custom-message red" style="display: block;margin-top:10px">
		<span style="padding: 4px 0;">
			<strong><p style="font:12px/1.0em Arial !important;">If you would like to translate Contact Bank in your native language, we will reward you with a free Eco Edition License of Contact Bank.</p>
				<p style="font:12px/1.0em Arial !important;">Contact Us at <a target="_blank" href="http://tech-banker.com">http://tech-banker.com</a> or email us at <a href="mailto:support@tech-banker.com">support@tech-banker.com</a></p>
			</strong>
		</span>
	</div>
	<?php	
}
?>
<div class="custom-message red" style="display: block;margin-top:10px;">
 <span>
  <strong>You will be only allowed to add 2 Forms. Kindly purchase Premium Edition for full access.</strong>
 </span>
</div>