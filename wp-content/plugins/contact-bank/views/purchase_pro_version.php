<?php 
switch($cb_role)
{
	case "administrator":
		$user_role_permission = "manage_options";
		break;
	case "editor":
		$user_role_permission = "publish_pages";
		break;
	case "author":
		$user_role_permission = "publish_posts";
		break;
}
if (!current_user_can($user_role_permission))
{
	return;
}
else
{
?>
<form id="frm_purchase_pro" class="layout-form">
	<div id="poststuff" style="width: 99% !important;">
		<div id="post-body" class="metabox-holder">
			<div id="postbox-container-2" class="postbox-container">
				<div id="advanced" class="meta-box-sortables">
					<div id="contact_bank_get_started" class="postbox">
						<div class="handlediv" data-target="ux_purchase_pro"
							title="Click to toggle" data-toggle="collapse">
							<br>
						</div>
						<h3 class="hndle">
							<span><?php _e("Premium Editions", contact_bank); ?></span>
						</h3>
						<div class="inside">
							<div id="ux_purchase_pro" class="contact_bank_layout">
								<a class="btn btn-info" href="admin.php?page=contact_dashboard"><?php _e("Back to Dashboard", contact_bank);?></a>
								<div class="separator-doubled"></div>
								<div class="fluid-layout">
									<div class="layout-span12">
										<h1 style="text-align: center; margin-bottom: 40px">
											<?php _e("WP Contact Bank is an one time Investment. Its Worth it!", contact_bank); ?>
										</h1>
										<div id="contact_bank_pricing"
											class="p_table_responsive p_table_hide_caption_column p_table_1 p_table_1_1 css3_grid_clearfix">
											<div class="caption_column column_0_responsive"
												style="width: 20%;">
												<ul>
													<li
														class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive radius5_topleft"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"></span></span></li>
													<li
														class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><h2 class="caption">
																	choose <span>your</span> plan
																</h2></span></span></li>
													<li
														class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Installation per License</span><span
																	class="css3_grid_tooltip"><span>Number of websites that
																			can use the plugin on purchase of a License.</span>Installation
																		per License</span></span></span></span></li>
													<li
														class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multisite Compatibility*</span><span
																	class="css3_grid_tooltip"><span>Allows you to use this
																			Plugin with network of sites / Multisites WordPress.
																			But you need to have separate license for each
																			domain. </span>Multisite Compatibility*</span></span></span></span></li>
													<li
														class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Technical Support</span><span
																	class="css3_grid_tooltip"><span>Technical Support by
																			the Development Team for Installation, Bug Fixing,
																			Plugin Compatibility Issues.</span>Technical Support</span></span></span></span></li>
													<li
														class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Plugin Updates</span><span
																	class="css3_grid_tooltip"><span>Automatic Plugin Update
																			Notification with New Features, Bug Fixing and much
																			more.</span>Plugin Updates</span></span></span></span></li>
													<li
														class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multi-Lingual</span><span
																	class="css3_grid_tooltip"><span>Multi-Lingual Facility
																			allows the plugin to be used in 48 languages.</span>Multi-Lingual</span></span></span></span></li>
													<li
														class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Standard Fields</span><span
																	class="css3_grid_tooltip"><span>Standard Fields allowed
																			to be created in Contact Bank.</span>Standard Fields</span></span></span></span></li>
													<li
														class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Notifications</span><span
																	class="css3_grid_tooltip"><span>Notifications to Admin
																			and Confirmation Notification to Clients are enabled.</span>Notifications</span></span></span></span></li>
													<li
														class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Settings</span><span
																	class="css3_grid_tooltip"><span>Form Settings allows to
																			modify and customize the controls according to your
																			requirements.</span>Form Settings</span></span></span></span></li>
													<li
														class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Email Settings</span><span
																	class="css3_grid_tooltip"><span>Email Settings would
																			allow to edit and customize the emails sent
																			automatically by the system.</span>Email Settings</span></span></span></span></li>
													<li
														class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Widgets</span><span
																	class="css3_grid_tooltip"><span>Widgets allows forms to
																			be shown in your sidebar, footer, header etc.</span>Widgets</span></span></span></span></li>
													<li
														class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Admin Notifications</span><span
																	class="css3_grid_tooltip"><span>Email Notifications to
																			the Administrator.</span>Admin Notifications</span></span></span></span></li>
													<li
														class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Client Notifications</span><span
																	class="css3_grid_tooltip"><span>Email Notifications to
																			the Client.</span>Client Notifications</span></span></span></span></li>
													<li
														class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Drag &amp; Drop</span><span
																	class="css3_grid_tooltip"><span>Controls allows to
																			simply Drag &amp; Drop fields to the Forms.</span>Drag
																		&amp; Drop</span></span></span></span></li>
													<li
														class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">No Coding Knowledge</span><span
																	class="css3_grid_tooltip"><span>No knowledge of coding
																			is required to set up the Form.</span>No Coding
																		Knowledge</span></span></span></span></li>
													<li
														class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Builder</span><span
																	class="css3_grid_tooltip"><span>Allow to prepare Forms
																			as per your need.</span>Form Builder</span></span></span></span></li>
													<li
														class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Advanced Fields</span><span
																	class="css3_grid_tooltip"><span>Advanced Fields allowed
																			to be created in Contact Bank.</span>Advanced Fields</span></span></span></span></li>
													<li
														class="css3_grid_row_18 row_style_4 css3_grid_row_18_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Entry Management</span><span
																	class="css3_grid_tooltip"><span>Entry Management to
																			overview forms submitted by the customer.</span>Entry
																		Management</span></span></span></span></li>
													<li
														class="css3_grid_row_19 row_style_2 css3_grid_row_19_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Tooltips</span><span
																	class="css3_grid_tooltip"><span>Allows you to set
																			different tooltips for your fields of Contact Form</span>Tooltips</span></span></span></span></li>
													<li
														class="css3_grid_row_20 row_style_4 css3_grid_row_20_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Limit Entries</span><span
																	class="css3_grid_tooltip"><span>Limit Entries to
																			maximize number of clients which could fill up the
																			form.</span>Limit Entries</span></span></span></span></li>
													<li
														class="css3_grid_row_21 row_style_2 css3_grid_row_21_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">File Uploader</span><span
																	class="css3_grid_tooltip"><span>Upload the file as per
																			your need.</span>File Uploader</span></span></span></span></li>
													<li
														class="css3_grid_row_22 row_style_4 css3_grid_row_22_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Layout Settings</span><span
																	class="css3_grid_tooltip"><span>Layout Settings provide
																			Styling to the forms.</span>Layout Settings</span></span></span></span></li>
													<li
														class="css3_grid_row_23 row_style_2 css3_grid_row_23_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Customization</span><span
																	class="css3_grid_tooltip"><span>Customization to the
																			layout of your Form.</span>Customization</span></span></span></span></li>
													<li
														class="css3_grid_row_24 row_style_4 css3_grid_row_24_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Optional Filters</span><span
																	class="css3_grid_tooltip"><span>Optional Filters to
																			filter the User Input.</span>Optional Filters</span></span></span></span></li>
													<li
														class="css3_grid_row_25 row_style_2 css3_grid_row_25_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Custom Notifications</span><span
																	class="css3_grid_tooltip"><span>Email Notifications to
																			the Custom needs.</span>Custom Notifications</span></span></span></span></li>
													<li
														class="css3_grid_row_26 row_style_4 css3_grid_row_26_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form to DB</span><span
																	class="css3_grid_tooltip"><span>Save Contact Form data
																			back to the Data Base.</span>Form to DB</span></span></span></span></li>
													<li
														class="css3_grid_row_27 row_style_2 css3_grid_row_27_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Captcha with Contact Bank</span><span
																	class="css3_grid_tooltip"><span>Implement Captcha Bank
																			with Contact Bank forms.</span>Captcha with Contact
																		Bank</span></span></span></span></li>
													<li
														class="css3_grid_row_28 footer_row css3_grid_row_28_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"></span></span></li>
												</ul>
											</div>
											<div class="column_1 column_1_responsive" style="width: 16%;">
												<div class="column_ribbon ribbon_style2_free"></div>
												<ul>
													<li
														class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><h2 class="col1">Lite</h2></span></span></li>
													<li
														class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><h1 class="col1">
																	<span>FREE</span>
																</h1></span></span></li>
													<li
														class="css3_grid_row_2 row_style_3 css3_grid_row_2_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Installation per License</span>1</span></span></span></li>
													<li
														class="css3_grid_row_3 row_style_1 css3_grid_row_3_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multisite Compatibility*</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_4 row_style_3 css3_grid_row_4_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Technical Support</span>None</span></span></span></li>
													<li
														class="css3_grid_row_5 row_style_1 css3_grid_row_5_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Plugin Updates</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_6 row_style_3 css3_grid_row_6_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multi-Lingual</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_7 row_style_1 css3_grid_row_7_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Standard Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_8 row_style_3 css3_grid_row_8_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Notifications</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_9 row_style_1 css3_grid_row_9_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_10 row_style_3 css3_grid_row_10_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Email Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_11 row_style_1 css3_grid_row_11_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Widgets</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_12 row_style_3 css3_grid_row_12_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Admin Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_13 row_style_1 css3_grid_row_13_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Client Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_14 row_style_3 css3_grid_row_14_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Drag &amp; Drop</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_15 row_style_1 css3_grid_row_15_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">No Coding Knowledge</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_16 row_style_3 css3_grid_row_16_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Builder</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_17 row_style_1 css3_grid_row_17_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Advanced Fields</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_18 row_style_3 css3_grid_row_18_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Entry Management</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_19 row_style_1 css3_grid_row_19_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Tooltips</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_20 row_style_3 css3_grid_row_20_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Limit Entries</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_21 row_style_1 css3_grid_row_21_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">File Uploader</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_22 row_style_3 css3_grid_row_22_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Layout Settings</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_23 row_style_1 css3_grid_row_23_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Customization</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_24 row_style_3 css3_grid_row_24_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Optional Filters</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_25 row_style_1 css3_grid_row_25_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Custom Notifications</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_26 row_style_3 css3_grid_row_26_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form to DB</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_27 row_style_1 css3_grid_row_27_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Captcha with Contact Bank</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_28 footer_row css3_grid_row_28_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><a
																href="https://wordpress.org/plugins/contact-bank/stats/"
																class="sign_up sign_up_orange radius3">Download Now!</a></span></span></li>
												</ul>
											</div>
											<div class="column_2 column_2_responsive" style="width: 16%;">
												<div class="column_ribbon ribbon_style2_heart"></div>
												<ul>
													<li
														class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><h2 class="col1">Eco</h2></span></span></li>
													<li
														class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span
																class="css3_grid_tooltip"><span>You just need to pay for
																		once for life time.</span>
																<h1 class="col1">
																		&pound;<span>17</span>
																	</h1>
																	<h3 class="col1">one time</h3></span></span></span></li>
													<li
														class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Installation per License</span>1</span></span></span></li>
													<li
														class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multisite Compatibility*</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Technical Support</span>1
																	Week</span></span></span></li>
													<li
														class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Plugin Updates</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multi-Lingual</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Standard Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Notifications</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Email Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Widgets</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Admin Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Client Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Drag &amp; Drop</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">No Coding Knowledge</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Builder</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Advanced Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_18 row_style_4 css3_grid_row_18_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Entry Management</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_19 row_style_2 css3_grid_row_19_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Tooltips</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_20 row_style_4 css3_grid_row_20_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Limit Entries</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_21 row_style_2 css3_grid_row_21_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">File Uploader</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_22 row_style_4 css3_grid_row_22_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Layout Settings</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_23 row_style_2 css3_grid_row_23_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Customization</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_24 row_style_4 css3_grid_row_24_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Optional Filters</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_25 row_style_2 css3_grid_row_25_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Custom Notifications</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_26 row_style_4 css3_grid_row_26_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form to DB</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_27 row_style_2 css3_grid_row_27_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Captcha with Contact Bank</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_28 footer_row css3_grid_row_28_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><a
																href="http://tech-banker.com/shop/wp-contact-bank/contact-bank-eco-edition/"
																class="sign_up sign_up_orange radius3">Order Now!</a></span></span></li>
												</ul>
											</div>
											<div class="column_3 active_column column_3_responsive"
												style="width: 16%;">
												<div class="column_ribbon ribbon_style2_best"></div>
												<ul>
													<li
														class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><h2 class="col2">Pro</h2></span></span></li>
													<li
														class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span
																class="css3_grid_tooltip"><span>You just need to pay for
																		once for life time.</span>
																<h1 class="col1">
																		&pound;<span>22</span>
																	</h1>
																	<h3 class="col1">one time</h3></span></span></span></li>
													<li
														class="css3_grid_row_2 row_style_3 css3_grid_row_2_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Installation per License</span>1</span></span></span></li>
													<li
														class="css3_grid_row_3 row_style_1 css3_grid_row_3_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multisite Compatibility*</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_4 row_style_3 css3_grid_row_4_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Technical Support</span>1
																	Month</span></span></span></li>
													<li
														class="css3_grid_row_5 row_style_1 css3_grid_row_5_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Plugin Updates</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_6 row_style_3 css3_grid_row_6_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multi-Lingual</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_7 row_style_1 css3_grid_row_7_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Standard Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_8 row_style_3 css3_grid_row_8_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Notifications</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_9 row_style_1 css3_grid_row_9_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_10 row_style_3 css3_grid_row_10_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Email Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_11 row_style_1 css3_grid_row_11_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Widgets</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_12 row_style_3 css3_grid_row_12_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Admin Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_13 row_style_1 css3_grid_row_13_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Client Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_14 row_style_3 css3_grid_row_14_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Drag &amp; Drop</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_15 row_style_1 css3_grid_row_15_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">No Coding Knowledge</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_16 row_style_3 css3_grid_row_16_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Builder</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_17 row_style_1 css3_grid_row_17_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Advanced Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_18 row_style_3 css3_grid_row_18_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Entry Management</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_19 row_style_1 css3_grid_row_19_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Tooltips</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_20 row_style_3 css3_grid_row_20_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Limit Entries</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_21 row_style_1 css3_grid_row_21_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">File Uploader</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_22 row_style_3 css3_grid_row_22_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Layout Settings</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_23 row_style_1 css3_grid_row_23_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Customization</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_24 row_style_3 css3_grid_row_24_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Optional Filters</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_25 row_style_1 css3_grid_row_25_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Custom Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_26 row_style_3 css3_grid_row_26_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form to DB</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_27 row_style_1 css3_grid_row_27_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Captcha with Contact Bank</span><img
																	src="<?php echo plugins_url("/assets/img/cross_04.png" , dirname(__FILE__)); ?>"
																	alt="no"></span></span></span></li>
													<li
														class="css3_grid_row_28 footer_row css3_grid_row_28_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><a
																href="http://tech-banker.com/shop/wp-contact-bank/contact-bank-pro-edition/"
																class="sign_up sign_up_orange radius3">Order Now!</a></span></span></li>
												</ul>
											</div>
											<div class="column_4 column_4_responsive" style="width: 16%;">
												<div class="column_ribbon ribbon_style2_hot"></div>
												<ul>
													<li
														class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><h2 class="col1">Developer</h2></span></span></li>
													<li
														class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span
																class="css3_grid_tooltip"><span>You just need to pay for
																		once for life time.</span>
																<h1 class="col1">
																		&pound;<span>66</span>
																	</h1>
																	<h3 class="col1">one time</h3></span></span></span></li>
													<li
														class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Installation per License</span>5</span></span></span></li>
													<li
														class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multisite Compatibility*</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Technical Support</span>1
																	Year</span></span></span></li>
													<li
														class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Plugin Updates</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multi-Lingual</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Standard Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Notifications</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Email Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Widgets</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Admin Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Client Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Drag &amp; Drop</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">No Coding Knowledge</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Builder</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Advanced Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_18 row_style_4 css3_grid_row_18_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Entry Management</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_19 row_style_2 css3_grid_row_19_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Tooltips</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_20 row_style_4 css3_grid_row_20_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Limit Entries</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_21 row_style_2 css3_grid_row_21_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">File Uploader</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_22 row_style_4 css3_grid_row_22_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Layout Settings</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_23 row_style_2 css3_grid_row_23_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Customization</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_24 row_style_4 css3_grid_row_24_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Optional Filters</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_25 row_style_2 css3_grid_row_25_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Custom Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_26 row_style_4 css3_grid_row_26_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form to DB</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_27 row_style_2 css3_grid_row_27_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Captcha with Contact Bank</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_28 footer_row css3_grid_row_28_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><a
																href="http://tech-banker.com/shop/wp-contact-bank/contact-bank-developer-edition/"
																class="sign_up sign_up_orange radius3">Order Now!</a></span></span></li>
												</ul>
											</div>
											<div class="column_1 column_5_responsive" style="width: 16%;">
												<div class="column_ribbon ribbon_style2_save"></div>
												<ul>
													<li
														class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive radius5_topright"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><h2 class="col1">Extended</h2></span></span></li>
													<li
														class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span
																class="css3_grid_tooltip"><span>You just need to pay for
																		once for life time.</span>
																<h1 class="col1">
																		&pound;<span>577</span>
																	</h1>
																	<h3 class="col1">one time</h3></span></span></span></li>
													<li
														class="css3_grid_row_2 row_style_3 css3_grid_row_2_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Installation per License</span>50</span></span></span></li>
													<li
														class="css3_grid_row_3 row_style_1 css3_grid_row_3_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multisite Compatibility*</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_4 row_style_3 css3_grid_row_4_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Technical Support</span>1
																	Year</span></span></span></li>
													<li
														class="css3_grid_row_5 row_style_1 css3_grid_row_5_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Plugin Updates</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_6 row_style_3 css3_grid_row_6_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Multi-Lingual</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_7 row_style_1 css3_grid_row_7_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Standard Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_8 row_style_3 css3_grid_row_8_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Notifications</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_9 row_style_1 css3_grid_row_9_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_10 row_style_3 css3_grid_row_10_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Email Settings</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_11 row_style_1 css3_grid_row_11_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Widgets</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_12 row_style_3 css3_grid_row_12_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Admin Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_13 row_style_1 css3_grid_row_13_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Client Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_14 row_style_3 css3_grid_row_14_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Drag &amp; Drop</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_15 row_style_1 css3_grid_row_15_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">No Coding Knowledge</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_16 row_style_3 css3_grid_row_16_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form Builder</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_17 row_style_1 css3_grid_row_17_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Advanced Fields</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_18 row_style_3 css3_grid_row_18_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Entry Management</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_19 row_style_1 css3_grid_row_19_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Tooltips</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_20 row_style_3 css3_grid_row_20_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Limit Entries</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_21 row_style_1 css3_grid_row_21_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">File Uploader</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_22 row_style_3 css3_grid_row_22_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Layout Settings</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_23 row_style_1 css3_grid_row_23_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Customization</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_24 row_style_3 css3_grid_row_24_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Optional Filters</span><img
																	src="<?php echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_25 row_style_1 css3_grid_row_25_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Custom Notifications</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_26 row_style_3 css3_grid_row_26_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Form to DB</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_27 row_style_1 css3_grid_row_27_responsive align_center"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><span><span
																	class="css3_hidden_caption">Captcha with Contact Bank</span><img
																	src="<?php  echo plugins_url("/assets/img/tick_10.png" , dirname(__FILE__)); ?>"
																	alt="yes"></span></span></span></li>
													<li
														class="css3_grid_row_28 footer_row css3_grid_row_28_responsive"><span
														class="css3_grid_vertical_align_table"><span
															class="css3_grid_vertical_align"><a
																href="http://tech-banker.com/shop/wp-contact-bank/contact-bank-extended-edition/"
																class="sign_up sign_up_orange radius3">Order Now!</a></span></span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="wpb_text_column wpb_content_element ">
									<div class="wpb_wrapper">
										<strong><span style="text-decoration: underline;">NOTE FOR MULTISITE*</span> :</strong>   Allows you to use this Plugin with network of sites / Multisites WordPress. But you need to purchase separate license for each Installation / Instance.
									</div> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<?php
}
?>