<?php

switch($cb_role)
{
	case "administrator":
		$cb_user_role_permission = "manage_options";
		break;
	case "editor":
		$cb_user_role_permission = "publish_pages";
		break;
	case "author":
		$cb_user_role_permission = "publish_posts";
		break;
}
if (!current_user_can($cb_user_role_permission))
{
	return;
}
else
{ 
	if(isset($_REQUEST["msg"]))
	{
		if(esc_attr($_REQUEST["msg"]) == "no") 
		{
		 update_option("contact-bank-banner", "no");
		 ?>
		 <style type="text/css" >
		  #ux_buy_pro
		  {
		   display:none;
		  }
		 </style>
		 <?php
		}
	}
	?>
	<form id="contact_bank_pricing" class="layout-form">
		<div id="poststuff" style="width: 99% !important;">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="postbox-container-2" class="postbox-container">
					<div id="advanced" class="meta-box-sortables">
						<div id="contact_bank_get_started" class="postbox" >
							<div class="handlediv" data-target="#ux_contact_bank_pricing" title="Click to toggle" data-toggle="collapse"><br></div>
							<h3 class="hndle"><span><?php _e("Contact Bank Pricing", contact_bank); ?></span></h3>
							<div class="inside">
								<div id="ux_contact_bank_pricing" class="contact_bank_layout">
									<div class="wpb_row wf-container" style="margin: 15px 0 15px 0;">
										<div class="wf-cell wf-span-12 wpb_column column_container ">
											<div class="wpb_text_column wpb_content_element ">
												<div class="wpb_wrapper">
													<div id="contact_pricing" class="p_table_responsive p_table_1 p_table_1_11 css3_grid_clearfix p_table_hover_disabled">
														<div class="caption_column column_0_responsive">
															<ul>
																<li style="text-align: left;" class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive radius5_topleft">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h2 class="caption">Choose <span>your</span> Plan</h2></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Number of websites that can use the plugin on purchase of a License.</span>Domains per License</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Automatic Plugin Update Notification with New Features, Bug Fixing and much more....</span><strong>Plugin Updates</strong></span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Technical Support by the Development Team for Installation, Bug Fixing, Plugin Compatibility Issues.</span><strong>Technical Support</strong></span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Multi-Lingual Facility allows the plugin to be used in 25 languages.</span>Multi-Lingual</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Number of Forms allowed to be Published.</span>Number of Forms</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Standard Fields allowed to be created in Contact Bank.</span>Standard Fields</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Advanced Fields allowed to be created in Contact Bank.</span>Advanced Fields </span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Notifications to Admin and Confirmation Notification to Clients are enabled.</span>Notifications</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Form Settings allows to modify and customize the controls according to your requirements.</span>Form Settings</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Email Settings would allow to edit and customize the emails sent automatically by the system.</span>Email Settings</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Customization to the layout of your Form.</span>Customization</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Entry Management to overview forms submitted by the customer.</span>Entry Management</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Limit Entries to maximize number of clients which could fill up the form.</span>Limit Entries</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Style &amp; Layout would allow customization of control and descriptions.</span>Style &amp; Layout</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Optional Filters to filter the User Input.</span>Optional Filters</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><span class="css3_grid_tooltip"><span>Tooltip to display relevant information for each control.</span>Tooltip</span></span></span></span>
																</li>
																<li style="text-align: left;" class="css3_grid_row_18 footer_row css3_grid_row_18_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"></span></span>
																</li>
															</ul>
														</div>
														<div class="column_2 column_2_responsive">
															<div class="column_ribbon ribbon_style1_save"></div>
															<ul>
																<li style="text-align: center;" class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h2 class="col2">Eco</h2></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h1 class="col1"> £<span>11</span></h1><h3 class="col1">one time</h3></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>1</span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/cross_02.png" alt="no"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>1 Week</span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>Unlimited</span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_18 footer_row css3_grid_row_18_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><a href="http://tech-banker.com/product/contact-bank-eco-edition/" target="_blank" class="sign_up sign_up_yellow radius3">Order Now!</a></span></span>
																</li>
															</ul>
														</div>
														<div class="column_3 column_3_responsive">
															<div class="column_ribbon ribbon_style2_best"></div>
															<ul>
																<li style="text-align: center;" class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h2 class="col1">Pro</h2></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h1 class="col1"> £<span>18</span></h1><h3 class="col1">one time</h3></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_2 row_style_3 css3_grid_row_2_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>1</span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_3 row_style_1 css3_grid_row_3_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_4 row_style_3 css3_grid_row_4_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>1 Month </span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_5 row_style_1 css3_grid_row_5_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_6 row_style_3 css3_grid_row_6_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>Unlimited</span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_7 row_style_1 css3_grid_row_7_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_8 row_style_3 css3_grid_row_8_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_9 row_style_1 css3_grid_row_9_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_10 row_style_3 css3_grid_row_10_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_11 row_style_1 css3_grid_row_11_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_12 row_style_3 css3_grid_row_12_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_13 row_style_1 css3_grid_row_13_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_14 row_style_3 css3_grid_row_14_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_15 row_style_1 css3_grid_row_15_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_16 row_style_3 css3_grid_row_16_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_17 row_style_1 css3_grid_row_17_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li style="text-align: center;" class="css3_grid_row_18 footer_row css3_grid_row_18_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><a href="http://tech-banker.com/product/contact-bank-pro-edition/" target="_blank" class="sign_up sign_up_yellow radius3">Order Now!</a></span></span>
																</li>
															</ul>
														</div>
														<div class="column_4 column_4_responsive">
															<div class="column_ribbon ribbon_style1_off30"></div>
															<ul>
																<li class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h2 class="col1">Developer</h2></span></span>
																</li>
																<li class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h1 class="col1"> £<span>63</span></h1><h3 class="col1">one time</h3></span></span>
																</li>
																<li class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>5</span></span></span>
																</li>
																<li class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>1 Year </span></span></span>
																</li>
																<li class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>Unlimited </span></span></span>
																</li>
																<li class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_18 footer_row css3_grid_row_18_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><a href="http://tech-banker.com/product/contact-bank-developer-edition/" target="_blank" class="sign_up sign_up_yellow radius3">Order Now!</a></span></span>
																</li>
															</ul>
														</div>
														<div class="column_1 column_5_responsive">
															<div class="column_ribbon ribbon_style1_off35"></div>
															<ul>
																<li class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive radius5_topright">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h2 class="col1">Extended</h2></span></span>
																</li>
																<li class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><h1 class="col1"> £<span>549</span></h1><h3 class="col1">one time</h3></span></span>
																</li>
																<li class="css3_grid_row_2 row_style_3 css3_grid_row_2_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>50</span></span></span>
																</li>
																<li class="css3_grid_row_3 row_style_1 css3_grid_row_3_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_4 row_style_3 css3_grid_row_4_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_5 row_style_1 css3_grid_row_5_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_6 row_style_3 css3_grid_row_6_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_7 row_style_1 css3_grid_row_7_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_8 row_style_3 css3_grid_row_8_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_9 row_style_1 css3_grid_row_9_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_10 row_style_3 css3_grid_row_10_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_11 row_style_1 css3_grid_row_11_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_12 row_style_3 css3_grid_row_12_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_13 row_style_1 css3_grid_row_13_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_14 row_style_3 css3_grid_row_14_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_15 row_style_1 css3_grid_row_15_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_16 row_style_3 css3_grid_row_16_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_17 row_style_1 css3_grid_row_17_responsive align_center">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span><img src="http://tech-banker.com/wp-content/plugins/css3_web_pricing_tables_grids/img/tick_02.png" alt="yes"></span></span></span>
																</li>
																<li class="css3_grid_row_18 footer_row css3_grid_row_18_responsive">
																	<span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><a href="http://tech-banker.com/product/contact-bank-extended-edition/" target="_blank" class="sign_up sign_up_yellow radius3">Order Now!</a></span></span>
																</li>
															</ul>
														</div>
													</div>
												</div> 
											</div> 
										</div> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="postbox-container-1" class="postbox-container">
					<div id="priority_side" class="meta-box-sortables">
						<div id="contact_bank_get_started" class="postbox" >
							<div class="handlediv" data-target="#uxdownload" title="Click to toggle" data-toggle="collapse"><br></div>
							<h3 class="hndle"><span><?php _e("Need Support Help?", contact_bank); ?></span></h3>
							<div class="inside">
								<div id="uxdownload" class="contact_bank_getting_started">
									<p>
										We’re interested in hearing from you.</p>
		
										<p>We will help you through the process and try to provide the answers.</p>
										
										<p>If you need to know more about our services or have something to share, please feel free to contact us.
									</p>
									<p>We commit to responses within 24 hours on weekdays – generally within hours during week day work hours.</p>
									<p>
										<a class="btn btn-danger" href="http://tech-banker.com/get-in-touch/" target="_blank" style="text-decoration: none;"><?php _e("Lets get in touch!", contact_bank); ?></a>
									</p>
									<img src="<?php echo plugins_url("/assets/images/img.png" , dirname(__FILE__));?>" style="max-width:100%;cursor: pointer;" />
									<p>
										<a class="btn btn-danger" href="http://tech-banker.com/contact-bank/" target="_blank" style="text-decoration: none;"><?php _e("Order Now!", contact_bank); ?></a>
									</p>
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
