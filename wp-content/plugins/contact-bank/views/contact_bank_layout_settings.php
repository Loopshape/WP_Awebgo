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
?> 
<form id="ux_frm_form_settings" class="layout-form">
	<div id="poststuff" style="width: 99% !important;">
		<div id="post-body" class="metabox-holder">
			<div id="postbox-container" class="postbox-container">
				<div id="advanced" class="meta-box-sortables">
					<div id="contact_bank_get_started" class="postbox" >
						<div class="handlediv" data-target="#ux_form_email_div" title="Click to toggle" data-toggle="collapse"><br></div>
						<h3 class="hndle"><span><?php _e( "Global Settings", contact_bank ); ?></span><i class="widget_premium_feature_contact"><?php _e(" (Premium Features available in Paid Edition)", contact_bank); ?></i></h4>   </h3>
						<div class="inside">
							<div id="ux_form_email_div" class="contact_bank_layout">
								<a class="btn btn-info" href="admin.php?page=contact_dashboard"><?php _e("Back to Dashboard", contact_bank);?></a>
								<a class="btn btn-danger" href="#" onclick="ux_button_pro_version();"><?php _e("Restore Global Settings", contact_bank); ?>
								</a>
								<input  class="btn btn-info layout-span1" type="button" onclick="ux_button_pro_version();"  id="submit_button" name="submit_button" style="float: right;"  value="<?php _e("Save", contact_bank); ?>" />
								<div class="separator-doubled"></div>
								<div id="form_success_message" class="custom-message green" style="display: none;">
									<span>
										<strong><?php _e("Form Settings Saved. Kindly wait for the redirect.", contact_bank); ?></strong>
									</span>
								</div>
								<div class="fluid-layout">
									<div class="layout-span12">
										<div class="layout-control-group">
											<label class="layout-control-label"><?php _e( "Select Form", contact_bank ); ?> :<span id="txt_required_" class="error" style="visibility:visible;">*</span></label>
											<div class="layout-controls">
												<?php
												global $wpdb;
												$forms = $wpdb->get_results
												(
													"SELECT form_id,form_name FROM " .contact_bank_contact_form()
												);
												?>
												<select class=" layout-span12" id="ux_ddl_select_form" name="ux_ddl_select_form" onchange="select_form_layout();" style="margin-top: 5px;">
													<option value=""><?php _e("Select Form",contact_bank); ?></option>
													<?php
														for($flag=0;$flag<count($forms);$flag++)
														{
															if(isset($_REQUEST["form_id"]) && $_REQUEST["form_id"] == $forms[$flag]->form_id)
															{
																?>
														 		<option value="<?php echo $forms[$flag]->form_id ;?>" selected="selected"><?php echo $forms[$flag]->form_name ;?></option>
																<?php
															}
															else
															{
															?>
																<option value="<?php echo $forms[$flag]->form_id ;?>"><?php echo $forms[$flag]->form_name ;?></option>
																<?php
															}
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="fluid-layout">
									<div class="layout-span6">
										<div class="widget-layout">
											<div class="widget-layout-title">
												<h4><?php _e( "Label Settings", contact_bank ); ?>
													<i class="widget_premium_feature_contact"><?php _e(" (Available in Premium Edition)", contact_bank); ?></i>
												</h4>
												<span class="tools">
													<a data-target="#label_settings" data-toggle="collapse">
														<i class="icon-chevron-down"></i>
													</a>
												</span>
											</div>
											<div id="label_settings" class="collapse in">
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Font Family :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_family" name="ux_ddl_font_family">
																<option selected="selected" value="inherit">inherit</option>
																<option value="arial">Arial</option>
																<option value="helvetica">Helvetica</option>
																<option value="sans-serif">Sans-serif</option>
																<option value="lucida Grande">Lucida Grande</option>
																<option value="lucida Sans Unicode">Lucida Sans Unicode</option>
																<option value="tahoma">Tahoma</option>
																<option value="times New Roman">Times New Roman</option>
																<option value="courier New">Courier New</option>
																<option value="verdana">Verdana</option>
																<option value="geneva">Geneva</option>
																<option value="courier">Courier</option>
																<option value="monospace">Monospace</option>
																<option value="times">Times</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Font Color :", contact_bank);?>
															<span class="error">*</span>
														</label>
													 	<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_font_color" name="ux_clr_font_color" onclick="ux_clr_font_color_label_setting();" value="#000000" style="background-color:#000000;color:#fff;" /><img onclick="ux_clr_font_color_label_setting();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__)); ?>" />
															<div id="clr_font_color"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Font Style :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_style" name="ux_ddl_font_style">
																<option value="normal">Normal</option>
																<option value="bold">Bold</option>
																<option value="italic">Italic</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Font Size (px) :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_txt_font_size" name="ux_txt_font_size">
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11">11</option>
																<option value="12">12</option>
																<option value="13">13</option>
																<option value="14">14</option>
																<option value="15">15</option>
																<option value="16" selected="selected">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="22">22</option>
																<option value="24">24</option>
																<option value="26">26</option>
																<option value="28">28</option>
																<option value="32">32</option>
																<option value="36">36</option>
																<option value="40">40</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label" ><?php _e("Text Align :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls" style="margin-top:5px">
															<input type="radio" id="ux_rdl_font_align_left" checked="checked" value="0" name="ux_rdl_font_align" />
															<label class="rdl">Left</label>
															<input type="radio" id="ux_rdl_font_align_right" value="1" name="ux_rdl_font_align" />
															<label class="rdl">Right</label>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Label Position :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls" >
															<select class="layout-span12" id="ux_ddl_label_position" name="ux_ddl_label_position">
																<option value="right">Right</option>
																<option value="top" selected="selected">Top</option>
																<option value="left">Left</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Field Desc Font Size :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_field_size" name="ux_ddl_field_size">
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11" selected="selected">11</option>
																<option value="12">12</option>
																<option value="13">13</option>
																<option value="14">14</option>
																<option value="15">15</option>
																<option value="16">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="22">22</option>
																<option value="24">24</option>
																<option value="26">26</option>
																<option value="28">28</option>
																<option value="32">32</option>
																<option value="36">36</option>
																<option value="40">40</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Field Description Align :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_field_align" name="ux_ddl_field_align">
																<option value="left" selected="selected">Left</option>
																<option value="right">Right</option>
																<option value="center">Center</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Hide Labels :", contact_bank);?> </label>
														<div class="layout-controls" style=" padding : 7px;">
															<input type="checkbox" id="ux_chk_hide_label" name="ux_chk_hide_label" value="1"/>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Text Direction :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_direction" name="ux_ddl_direction">
																<option value="inherit">Default</option>
																<option value="ltr">Left to Right</option>
																<option value="rtl">Right to Left</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="widget-layout">
											<div class="widget-layout-title">
												<h4><?php _e( "Input Field Settings", contact_bank ); ?><i class="widget_premium_feature_contact"><?php _e(" (Available in Premium Edition)", contact_bank); ?></i></h4>
												<span class="tools">
													<a data-target="#input_settings" data-toggle="collapse">
														<i class="icon-chevron-down"></i>
													</a>
												</span>
											</div>
											<div id="input_settings" class="collapse in">
												<div class="widget-layout-body">
													<div class="layout-control-group " >
														<label class="layout-control-label"><?php _e("Font Family :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_family_input_field" name="ux_ddl_font_family_input_field">
																<option value="inherit">inherit</option>
																<option value="arial">Arial</option>
																<option value="helvetica">Helvetica</option>
																<option value="sans-serif">Sans-serif</option>
																<option value="lucida Grande">Lucida Grande</option>
																<option value="lucida Sans Unicode">Lucida Sans Unicode</option>
																<option value="tahoma">Tahoma</option>
																<option value="times New Roman">Times New Roman</option>
																<option value="courier New">Courier New</option>
																<option value="verdana">Verdana</option>
																<option value="geneva">Geneva</option>
																<option value="courier">Courier</option>
																<option value="monospace">Monospace</option>
																<option value="times">Times</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Text Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_text_color_input_field" name="ux_clr_text_color_input_field" onclick="ux_clr_font_color_input_settings();" value="#000000"  style="background-color:#000000;color:#fff;"/><img onclick="ux_clr_font_color_input_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
															<div id="clr_text_color"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Font Style :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_style_input_field" name="ux_ddl_font_style_input_field">
																<option value="normal">Normal</option>
																<option value="bold">Bold</option>
																<option value="italic">Italic</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Font Size (px) :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_txt_font_size_input_field" name="ux_txt_font_size_input_field">
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11">11</option>
																<option value="12">12</option>
																<option value="13">13</option>
																<option value="14" selected="selected">14</option>
																<option value="15">15</option>
																<option value="16">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="22">22</option>
																<option value="24">24</option>
																<option value="26">26</option>
																<option value="28">28</option>
																<option value="32">32</option>
																<option value="36">36</option>
																<option value="40">40</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Border Radius (px) :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span12" id="ux_txt_border_radius_input_field" name="ux_txt_border_radius_input_field" value="0" onkeypress="return OnlyNumbers(event)"/>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Border Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_border_color_input_field" name="ux_clr_border_color_input_field" onclick="ux_clr_border_color_input_settings()" value="#e5e5e5" style="background-color:#e5e5e5;color:#fff;"/><img onclick="ux_clr_border_color_input_settings()" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
															<div id="clr_border_color"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Border Size (px) :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span12" id="ux_txt_border_size_input_field" name="ux_txt_border_size_input_field" value="1" onkeypress="return OnlyNumbers(event)"/>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Border Style :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_border_style_input_field" name="ux_ddl_border_style_input_field">
																<option value="solid">Solid</option>
																<option value="dotted">Dotted</option>
																<option value="dashed">Dashed</option>
															</select>
														</div>
													</div>
												</div>
												
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Background Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_bg_color_input_field" name="ux_clr_bg_color_input_field" onclick="ux_clr_BG_color_input_settings();" value="#ffffff" /><img onclick="ux_clr_BG_color_input_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__)); ?>" />
															<div id="clr_bg_color"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Radio Buttons :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls" style="padding :5px">
															<input type="radio" id="ux_rdl_multiple_row_input_field" value="0" name="ux_rdl_radio_button"/>
															<label class="rdl"><?php _e("Multiple Rows", contact_bank);?></label>
															<input type="radio" id="ux_rdl_single_row_input_field" checked="checked" value="1"  name="ux_rdl_radio_button" />
															<label class="rdl"><?php _e("Single Row", contact_bank);?></label>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label" ><?php _e("Text Align :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls" style="padding :5px">
															<input type="radio" id="ux_rdl_font_align_left_input_field" checked="checked" value="0" name="ux_rdl_font_align_input_field" />
															<label class="rdl">Left</label>
															<input type="radio" id="ux_rdl_font_align_right_input_field" value="1" name="ux_rdl_font_align_input_field" />
															<label class="rdl">Right</label>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Text Direction :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_input_field_direction" name="ux_ddl_input_field_direction">
																<option value="inherit">Default</option>
																<option value="ltr">Left to Right</option>
																<option value="rtl">Right to Left</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Input Size :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_input_size_input_field" name="ux_input_size_input_field">
																<option value="layout-span2">Extra Small</option>
																<option value="layout-span4">Small</option>
																<option value="layout-span6" selected="selected">Normal</option>
																<option value="layout-span8">Medium</option>
																<option value="layout-span10">Large</option>
																<option value="layout-span12">Extra Large</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										
									</div>
									<div class="layout-span6">
										<div class="widget-layout">
											<div class="widget-layout-title">
											 	<h4><?php _e( "Submit Button Settings", contact_bank ); ?><i class="widget_premium_feature_contact"><?php _e(" (Available in Premium Edition)", contact_bank); ?></i></h4>
											 	<span class="tools">
													<a data-target="#submit_settings" data-toggle="collapse">
														<i class="icon-chevron-down"></i>
													</a>
												</span>
											</div>
											<div id="submit_settings" class="collapse in">
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Font Family :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_family_submit_button" name="ux_ddl_font_family_submit_button">
																<option value="inherit">inherit</option>
																<option value="arial">Arial</option>
																<option value="helvetica">Helvetica</option>
																<option value="sans-serif">Sans-serif</option>
																<option value="lucida Grande">Lucida Grande</option>
																<option value="lucida Sans Unicode">Lucida Sans Unicode</option>
																<option value="tahoma">Tahoma</option>
																<option value="times New Roman">Times New Roman</option>
																<option value="courier New">Courier New</option>
																<option value="verdana">Verdana</option>
																<option value="geneva">Geneva</option>
																<option value="courier">Courier</option>
																<option value="monospace">Monospace</option>
																<option value="times">Times</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Text:", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span12" id="ux_txt_text_submit_button" name="ux_txt_text_submit_button" value="<?php _e("Save",contact_bank);?> "/>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Style :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_style_submit_button" name="ux_ddl_font_style_submit_button">
																<option value="normal">Normal</option>
																<option value="bold">Bold</option>
																<option value="italic">Italic</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Font Size (px) :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_size_submit_button" name="ux_ddl_font_size_submit_button">
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11">11</option>
																<option value="12" selected="selected">12</option>
																<option value="13">13</option>
																<option value="14">14</option>
																<option value="15">15</option>
																<option value="16">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="22">22</option>
																<option value="24">24</option>
																<option value="26">26</option>
																<option value="28">28</option>
																<option value="32">32</option>
																<option value="36">36</option>
																<option value="40">40</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Button Width (px) :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span12" id="ux_txt_button_width_submit_button" name="ux_txt_button_width_submit_button" value="100" onkeypress="return OnlyNumbers(event)"/>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Background Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_bg_color_submit_button" name="ux_clr_bg_color_submit_button" onclick="ux_clr_BG_color_submit_btn_settings();" value="#24890d"  style="background-color:#24890d;color:#fff;"/><img onclick="ux_clr_BG_color_submit_btn_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
														<div id="clr_bg_color_submit_button"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Hover Background Color:", contact_bank);?> 
															<span  class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_hover_bg_color_submit_button" name="ux_clr_hover_bg_color_submit_button" onclick="ux_clr_hover_BG_color_submit_btn_settings();" value="#3dd41a" style="background-color:#000000;color:#fff;"  /><img onclick="ux_clr_hover_BG_color_submit_btn_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
														<div id="clr_hover_bg_color_submit_button"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Text Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
												 			<input type="text" class="layout-span11" id="ux_clr_text_color_submit_button" name="ux_clr_text_color_submit_button" onclick="ux_clr_text_color_submit_btn_settings();" value="#ffffff" /><img onclick="ux_clr_text_color_submit_btn_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
															<div id="clr_text_color_submit_button"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Border Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_border_color_submit_button" name="ux_clr_border_color_submit_button" onclick="ux_clr_hover_border_color_submit_btn_settings();" value="#000000" style="background-color:#000000;color:#fff;" /><img onclick="ux_clr_hover_border_color_submit_btn_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
														<div id="clr_border_color_submit_button"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group " >
														<label class="layout-control-label"><?php _e("Border Size (px) :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span12" id="ux_clr_border_size_submit_button" name="ux_clr_border_size_submit_button" value="0" onkeypress="return OnlyNumbers(event)"/>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Border Radius (px) :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span12" id="ux_txt_border_radius_submit_button" name="ux_txt_border_radius_submit_button" value="0" onkeypress="return OnlyNumbers(event)"/>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label" ><?php _e("Text Align :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls" style="padding :5px">
															<input type="radio" id="ux_rdl_font_align_left_submit_button" checked="checked" value="0" name="ux_rdl_font_align_submit_button" />
															<label class="rdl">Left</label>
															<input type="radio" id="ux_rdl_font_align_right_submit_button" value="1" name="ux_rdl_font_align_submit_button" />
															<label class="rdl">Right</label>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Text Direction :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_submit_button_direction" name="ux_ddl_submit_button_direction">
																<option value="inherit">Default</option>
																<option value="ltr">Left to Right</option>
																<option value="rtl">Right to Left</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="widget-layout">
											<div class="widget-layout-title">
												<h4><?php _e( "Success Message Settings", contact_bank ); ?><i class="widget_premium_feature_contact"><?php _e(" (Available in Premium Edition)", contact_bank); ?></i></h4>
												<span class="tools">
													<a data-target="#success_settings" data-toggle="collapse">
														<i class="icon-chevron-down"></i>
													</a>
												</span>
										 	</div>
										 	<div id="success_settings" class="collapse in">
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Font Family :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_family_success_msg" name="ux_ddl_font_family_success_msg">
																<option value="inherit">inherit</option>
																<option value="arial">Arial</option>
																<option value="helvetica">Helvetica</option>
																<option value="sans-serif">Sans-serif</option>
																<option value="lucida Grande">Lucida Grande</option>
																<option value="lucida Sans Unicode">Lucida Sans Unicode</option>
																<option value="tahoma">Tahoma</option>
																<option value="times New Roman">Times New Roman</option>
																<option value="courier New">Courier New</option>
																<option value="verdana">Verdana</option>
																<option value="geneva">Geneva</option>
																<option value="courier">Courier</option>
																<option value="monospace">Monospace</option>
																<option value="times">Times</option>
											 				</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Font Size (px) :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_size_success_msg" name="ux_ddl_font_size_success_msg">
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11">11</option>
																<option value="12" selected="selected">12</option>
																<option value="13">13</option>
																<option value="14">14</option>
																<option value="15">15</option>
																<option value="16">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="22">22</option>
																<option value="24">24</option>
																<option value="26">26</option>
																<option value="28">28</option>
																<option value="32">32</option>
																<option value="36">36</option>
																<option value="40">40</option>
															</select>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Background Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														 <div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_bg_color_success_msg" name="ux_clr_bg_color_success_msg" onclick="ux_clr_bg_color_sucess_msg_settings();" value="#e5ffd5" style="background-color:#e5ffd5;color:#fff;"/><img onclick="ux_clr_bg_color_sucess_msg_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
											 			<div id="clr_bg_color_success_msg"></div>
														</div>
													</div>
												</div>
											 	<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Border Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_border_color_success_msg" name="ux_clr_border_color_success_msg" onclick="ux_clr_border_color_sucess_msg_settings();" value="#e5ffd5" style="background-color:#e5ffd5;color:#fff;"/><img onclick="ux_clr_border_color_sucess_msg_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
														<div id="clr_border_color_success_msg"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e("Text Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_text_color_success_msg" name="ux_clr_text_color_success_msg" onclick="ux_clr_text_color_sucess_msg_settings();" value="#6aa500" style="background-color:#6aa500;color:#fff;"/><img onclick="ux_clr_text_color_sucess_msg_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
														<div id="clr_text_color_success_msg"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label" ><?php _e("Text Align :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls" style="padding :5px">
															<input type="radio" id="ux_rdl_font_align_left_success_msg" checked="checked" value="0" name="ux_rdl_font_align_success_msg" />
															<label class="rdl">Left</label>
															<input type="radio" id="ux_rdl_font_align_right_success_msg" value="1" name="ux_rdl_font_align_success_msg" />
															<label class="rdl">Right</label>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Text Direction :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_success_msg_direction" name="ux_ddl_success_msg_direction">
																<option value="inherit">Default</option>
																<option value="ltr">Left to Right</option>
																<option value="rtl">Right to Left</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="widget-layout">
											<div class="widget-layout-title">
												<h4><?php _e( "Error Message Settings", contact_bank ); ?><i class="widget_premium_feature_contact"><?php _e(" (Available in Premium Edition)", contact_bank); ?></i></h4>
												<span class="tools">
													<a data-target="#error_settings" data-toggle="collapse">
														<i class="icon-chevron-down"></i>
													</a>
												</span>
											</div>
											<div id="error_settings" class="collapse in">
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Font Family :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_family_error_msg" name="ux_ddl_font_family_error_msg">
																<option value="inherit">inherit</option>
																<option value="arial">Arial</option>
																<option value="helvetica">Helvetica</option>
																<option value="sans-serif">Sans-serif</option>
																<option value="lucida Grande">Lucida Grande</option>
																<option value="lucida Sans Unicode">Lucida Sans Unicode</option>
																<option value="tahoma">Tahoma</option>
																<option value="times New Roman">Times New Roman</option>
																<option value="courier New">Courier New</option>
																<option value="verdana">Verdana</option>
																<option value="geneva">Geneva</option>
																<option value="courier">Courier</option>
																<option value="monospace">Monospace</option>
																<option value="times">Times</option>
															</select>
														</div>
													</div>
													</div>
												<div class="widget-layout-body">
													<div class="layout-control-group " >
														<label class="layout-control-label"><?php _e("Font Size (px) :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_font_size_error_msg" name="ux_ddl_font_size_error_msg">
																<option value="8">8</option>
																<option value="9">9</option>
																<option value="10">10</option>
																<option value="11">11</option>
																<option value="12" selected="selected">12</option>
																<option value="13">13</option>
																<option value="14">14</option>
																<option value="15">15</option>
																<option value="16">16</option>
																<option value="17">17</option>
																<option value="18">18</option>
																<option value="19">19</option>
																<option value="20">20</option>
																<option value="22">22</option>
																<option value="24">24</option>
																<option value="26">26</option>
																<option value="28">28</option>
																<option value="32">32</option>
																<option value="36">36</option>
																<option value="40">40</option>
															</select>
														</div>
													</div>
												</div>
											 	<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Background Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_bg_color_error_msg" name="ux_clr_bg_color_error_msg" onclick="ux_clr_BG_color_error_msg_settings();" value="#ffcaca" style="background-color:#ffcaca;color:#fff;"/><img onclick="ux_clr_BG_color_error_msg_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
															<div id="clr_bg_color_error_msg"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Border Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_border_color_error_msg" onclick="ux_clr_border_color_error_msg_settings();" name="ux_clr_border_color_error_msg" value="#ffcaca" style="background-color:#ffcaca;color:#fff;"/><img onclick="ux_clr_border_color_error_msg_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
															<div id="clr_border_color_error_msg"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group ">
														<label class="layout-control-label"><?php _e("Text Color :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<input type="text" class="layout-span11" id="ux_clr_text_color_error_msg" value="#ff2c38" onclick="ux_clr_text_color_error_msg_settings();" name="ux_clr_text_color_error_msg" style="background-color:#ff2c38;color:#fff;"/><img onclick="ux_clr_text_color_error_msg_settings();" style="vertical-align: middle;margin-left: 5px;" src="<?php echo plugins_url("/assets/images/color.png" , dirname(__FILE__));?>" />
															<div id="clr_text_color_error_msg"></div>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group">
														<label class="layout-control-label" ><?php _e("Text Align :", contact_bank);?>
															<span class="error">*</span>
														</label>
														<div class="layout-controls" style="padding :5px">
															<input type="radio" id="ux_rdl_font_align_left_error_msg" checked="checked" value="0" name="ux_rdl_font_align_error_msg" />
															<label class="rdl">Left</label>
															<input type="radio" id="ux_rdl_font_align_right_error_msg" value="1" name="ux_rdl_font_align_error_msg" />
															<label class="rdl">Right</label>
														</div>
													</div>
												</div>
												<div class="widget-layout-body">
													<div class="layout-control-group" >
														<label class="layout-control-label"><?php _e("Text Direction :", contact_bank);?> 
															<span class="error">*</span>
														</label>
														<div class="layout-controls">
															<select class="layout-span12" id="ux_ddl_error_msg_direction" name="ux_ddl_error_msg_direction">
																<option value="inherit">Default</option>
																<option value="ltr">Left to Right</option>
																<option value="rtl">Right to Left</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="separator-doubled"></div>
								<div class="layout-control-group" style="margin-top: 10px;">
									<input style="margin-left:0px ;" class="btn btn-info layout-span1" type="button" onclick="ux_button_pro_version();" id="submit_button" name="submit_button"  value="<?php _e("Save", contact_bank); ?>" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form> 	
<script type="text/javascript">

function ux_button_pro_version()
{
	alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
}
function ux_clr_font_color_label_setting()
{
	jQuery("#clr_font_color").farbtastic("#ux_clr_font_color").slideDown();
	jQuery("#ux_clr_font_color").focus();
}
function ux_clr_font_color_input_settings()
{
	jQuery("#clr_text_color").farbtastic("#ux_clr_text_color_input_field").slideDown();
	jQuery("#ux_clr_text_color_input_field").focus();
}
function ux_clr_border_color_input_settings()
{
	jQuery("#clr_border_color").farbtastic("#ux_clr_border_color_input_field").slideDown();
	jQuery("#ux_clr_border_color_input_field").focus();
}
function ux_clr_BG_color_input_settings()
{
	jQuery("#clr_bg_color").farbtastic("#ux_clr_bg_color_input_field").slideDown();
	jQuery("#ux_clr_bg_color_input_field").focus();
}
function ux_clr_BG_color_submit_btn_settings()
{
	jQuery("#clr_bg_color_submit_button").farbtastic("#ux_clr_bg_color_submit_button").slideDown();
	jQuery("#ux_clr_bg_color_submit_button").focus();
}
function ux_clr_hover_BG_color_submit_btn_settings()
{
	jQuery("#clr_hover_bg_color_submit_button").farbtastic("#ux_clr_hover_bg_color_submit_button").slideDown();
	jQuery("#ux_clr_hover_bg_color_submit_button").focus();
}
function ux_clr_text_color_submit_btn_settings()
{
	jQuery("#clr_text_color_submit_button").farbtastic("#ux_clr_text_color_submit_button").slideDown();
	jQuery("#ux_clr_text_color_submit_button").focus();	
}
function ux_clr_hover_border_color_submit_btn_settings()
{
	jQuery("#clr_border_color_submit_button").farbtastic("#ux_clr_border_color_submit_button").slideDown();
	jQuery("#ux_clr_border_color_submit_button").focus();	
}
function ux_clr_bg_color_sucess_msg_settings()
{
	jQuery("#clr_bg_color_success_msg").farbtastic("#ux_clr_bg_color_success_msg").slideDown();
	jQuery("#ux_clr_bg_color_success_msg").focus();		
}
function ux_clr_border_color_sucess_msg_settings()
{
	jQuery("#clr_border_color_success_msg").farbtastic("#ux_clr_border_color_success_msg").slideDown();
	jQuery("#ux_clr_border_color_success_msg").focus();		
}
function ux_clr_text_color_sucess_msg_settings()
{
	jQuery("#clr_text_color_success_msg").farbtastic("#ux_clr_text_color_success_msg").slideDown();
	jQuery("#ux_clr_text_color_success_msg").focus();		
}
function ux_clr_BG_color_error_msg_settings()
{
	jQuery("#clr_bg_color_error_msg").farbtastic("#ux_clr_bg_color_error_msg").slideDown();
	jQuery("#ux_clr_bg_color_error_msg").focus();
}
function ux_clr_border_color_error_msg_settings() 
{
	jQuery("#clr_border_color_error_msg").farbtastic("#ux_clr_border_color_error_msg").slideDown();
	jQuery("#ux_clr_border_color_error_msg").focus();
}
function ux_clr_text_color_error_msg_settings() 
{
	jQuery("#clr_text_color_error_msg").farbtastic("#ux_clr_text_color_error_msg").slideDown();
	jQuery("#ux_clr_text_color_error_msg").focus();
}
jQuery("#ux_clr_font_color").blur(function(){jQuery("#clr_font_color").slideUp()});
jQuery("#ux_clr_text_color_input_field").blur(function(){jQuery("#clr_text_color").slideUp()});
jQuery("#ux_clr_border_color_input_field").blur(function(){jQuery("#clr_border_color").slideUp()});
jQuery("#ux_clr_bg_color_input_field").blur(function(){jQuery("#clr_bg_color").slideUp()});
jQuery("#ux_clr_bg_color_submit_button").blur(function(){jQuery("#clr_bg_color_submit_button").slideUp()});
jQuery("#ux_clr_hover_bg_color_submit_button").blur(function(){jQuery("#clr_hover_bg_color_submit_button").slideUp()});
jQuery("#ux_clr_text_color_submit_button").blur(function(){jQuery("#clr_text_color_submit_button").slideUp()});
jQuery("#ux_clr_border_color_submit_button").blur(function(){jQuery("#clr_border_color_submit_button").slideUp()});
jQuery("#ux_clr_bg_color_success_msg").blur(function(){jQuery("#clr_bg_color_success_msg").slideUp()});
jQuery("#ux_clr_border_color_success_msg").blur(function(){jQuery("#clr_border_color_success_msg").slideUp()});
jQuery("#ux_clr_text_color_success_msg").blur(function(){jQuery("#clr_text_color_success_msg").slideUp()});
jQuery("#ux_clr_bg_color_error_msg").blur(function(){jQuery("#clr_bg_color_error_msg").slideUp()});
jQuery("#ux_clr_border_color_error_msg").blur(function(){jQuery("#clr_border_color_error_msg").slideUp()});
jQuery("#ux_clr_text_color_error_msg").blur(function(){jQuery("#clr_text_color_error_msg").slideUp()});

function OnlyNumbers(e) ///////////////////////////////////allow only digits
{
	var regex = new RegExp("^[0-9 \b]*$");
	var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
	if (regex.test(str)) {
	return true;
	}
	e.preventDefault();
	return false;
}
function select_form_layout()
{
    var form_id = jQuery("#ux_ddl_select_form").val();
   
    jQuery.post(ajaxurl, "form_id="+form_id+"&param=fetch_control_values&action=layout_settings_contact_library", function(data)
	{
		
		if(data != "undefined")
		{
			
			var dataJson = jQuery.parseJSON(data);
	        jQuery("#ux_ddl_font_family").val(dataJson.label_setting_font_family);
	        jQuery("#ux_clr_font_color").val(dataJson.label_setting_font_color);
	        jQuery("#ux_clr_font_color").css("background-color",dataJson.label_setting_font_color);
	        jQuery("#ux_clr_font_color").css("color","#ffffff");
	        jQuery("#ux_ddl_font_style").val(dataJson.label_setting_font_style);
	        jQuery("#ux_txt_font_size").val(dataJson.label_setting_font_size);
	        dataJson.label_setting_font_align_left == "0" ? jQuery("#ux_rdl_font_align_left").attr("checked","checked") : jQuery("#ux_rdl_font_align_right").attr("checked","checked") ;
	        jQuery("#ux_ddl_label_position").val(dataJson.label_setting_label_position);
	        jQuery("#ux_ddl_field_size").val(dataJson.label_setting_field_size);
	        jQuery("#ux_ddl_field_align").val(dataJson.label_setting_field_align);
	        dataJson.label_setting_hide_label == "1" ? jQuery("#ux_chk_hide_label").attr("checked","checked") : jQuery("#ux_chk_hide_label").removeAttr("checked");
			jQuery("#ux_ddl_direction").val(dataJson.label_setting_text_direction);
			
	        jQuery("#ux_ddl_font_family_input_field").val(dataJson.input_field_font_family);
	        jQuery("#ux_clr_text_color_input_field").val(dataJson.input_field_font_color);
	        jQuery("#ux_clr_text_color_input_field").css("background-color",dataJson.input_field_font_color);
	        jQuery("#ux_clr_text_color_input_field").css("color","#ffffff");
	        jQuery("#ux_ddl_font_style_input_field").val(dataJson.input_field_font_style);
	        jQuery("#ux_txt_font_size_input_field").val(dataJson.input_field_font_size);
	        jQuery("#ux_txt_border_radius_input_field").val(dataJson.input_field_border_radius);
	        jQuery("#ux_clr_border_color_input_field").val(dataJson.input_field_border_color);
	        jQuery("#ux_clr_border_color_input_field").css("background-color",dataJson.input_field_border_color);
	        jQuery("#ux_clr_border_color_input_field").css("color","#ffffff");
	        jQuery("#ux_txt_border_size_input_field").val(dataJson.input_field_border_size);
	        jQuery("#ux_ddl_border_style_input_field").val(dataJson.input_field_border_style);
	        jQuery("#ux_clr_bg_color_input_field").val(dataJson.input_field_clr_bg_color);
	        jQuery("#ux_clr_bg_color_input_field").css("background-color",dataJson.input_field_clr_bg_color);
	        jQuery("#ux_clr_bg_color_input_field").css("color","#000000");
	        dataJson.input_field_rdl_multiple_row == "0" ? jQuery("#ux_rdl_multiple_row_input_field").attr("checked","checked") : jQuery("#ux_rdl_single_row_input_field").attr("checked","checked");
			dataJson.input_field_rdl_text_align == "0" ? jQuery("#ux_rdl_font_align_left_input_field").attr("checked","checked") : jQuery("#ux_rdl_font_align_right_input_field").attr("checked","checked") ;
	        jQuery("#ux_ddl_input_field_direction").val(dataJson.input_field_text_direction);
	        jQuery("#ux_input_size_input_field").val(dataJson.input_field_input_size);
	
	
			jQuery("#ux_ddl_font_family_submit_button").val(dataJson.submit_button_font_family);
	        jQuery("#ux_txt_text_submit_button").val(dataJson.submit_button_text);
	        jQuery("#ux_ddl_font_style_submit_button").val(dataJson.submit_button_font_style);
	        jQuery("#ux_ddl_font_size_submit_button").val(dataJson.submit_button_font_size);
	        jQuery("#ux_txt_button_width_submit_button").val(dataJson.submit_button_button_width);
	        jQuery("#ux_clr_bg_color_submit_button").val(dataJson.submit_button_bg_color);
	        jQuery("#ux_clr_bg_color_submit_button").css("background-color",dataJson.submit_button_bg_color);
	        jQuery("#ux_clr_bg_color_submit_button").css("color","#ffffff");
	        jQuery("#ux_clr_hover_bg_color_submit_button").val(dataJson.submit_button_hover_bg_color);
	        jQuery("#ux_clr_hover_bg_color_submit_button").css("background-color",dataJson.submit_button_hover_bg_color);
	        jQuery("#ux_clr_hover_bg_color_submit_button").css("color","#ffffff");
	        jQuery("#ux_clr_text_color_submit_button").val(dataJson.submit_button_text_color);
	        jQuery("#ux_clr_text_color_submit_button").css("background-color",dataJson.submit_button_text_color);
	        jQuery("#ux_clr_text_color_submit_button").css("color","#000000");
	        jQuery("#ux_clr_border_color_submit_button").val(dataJson.submit_button_border_color);
	        jQuery("#ux_clr_border_color_submit_button").css("background-color",dataJson.submit_button_border_color);
	        jQuery("#ux_clr_border_color_submit_button").css("color","#ffffff");
	        jQuery("#ux_clr_border_size_submit_button").val(dataJson.submit_button_border_size);
	        jQuery("#ux_txt_border_radius_submit_button").val(dataJson.submit_button_border_radius);
	        dataJson.submit_button_rdl_text_align == "0" ? jQuery("#ux_rdl_font_align_left_submit_button").attr("checked","checked") : jQuery("#ux_rdl_font_align_right_submit_button").attr("checked","checked") ;
	        jQuery("#ux_ddl_submit_button_direction").val(dataJson.submit_button_text_direction);
	
	        jQuery("#ux_ddl_font_family_success_msg").val(dataJson.success_msg_font_family);
	        jQuery("#ux_ddl_font_size_success_msg").val(dataJson.success_msg_font_size);
	        jQuery("#ux_clr_bg_color_success_msg").val(dataJson.success_msg_bg_color);
	        jQuery("#ux_clr_bg_color_success_msg").css("background-color",dataJson.success_msg_bg_color);
	        jQuery("#ux_clr_bg_color_success_msg").css("color","#ffffff");
	        jQuery("#ux_clr_border_color_success_msg").val(dataJson.success_msg_border_color);
	        jQuery("#ux_clr_border_color_success_msg").css("background-color",dataJson.success_msg_border_color);
	        jQuery("#ux_clr_border_color_success_msg").css("color","#ffffff");
	        jQuery("#ux_clr_text_color_success_msg").val(dataJson.success_msg_text_color);
	        jQuery("#ux_clr_text_color_success_msg").css("background-color",dataJson.success_msg_text_color);
	        jQuery("#ux_clr_text_color_success_msg").css("color","#ffffff");
	        dataJson.success_msg_rdl_text_align == "0" ? jQuery("#ux_rdl_font_align_left_success_msg").attr("checked","checked") : jQuery("#ux_rdl_font_align_right_success_msg").attr("checked","checked") ;
	        jQuery("#ux_ddl_success_msg_direction").val(dataJson.success_msg_text_direction);
	
	        jQuery("#ux_ddl_font_family_error_msg").val(dataJson.error_msg_font_family);
	        jQuery("#ux_ddl_font_size_error_msg").val(dataJson.error_msg_font_size);
	        jQuery("#ux_clr_bg_color_error_msg").val(dataJson.error_msg_bg_color);
	        jQuery("#ux_clr_bg_color_error_msg").css("background-color",dataJson.error_msg_bg_color);
	        jQuery("#ux_clr_bg_color_error_msg").css("color","#ffffff");
	        jQuery("#ux_clr_border_color_error_msg").val(dataJson.error_msg_border_color);
	        jQuery("#ux_clr_border_color_error_msg").css("background-color",dataJson.error_msg_border_color);
	        jQuery("#ux_clr_border_color_error_msg").css("color","#ffffff");
	        jQuery("#ux_clr_text_color_error_msg").val(dataJson.error_msg_text_color);
	        jQuery("#ux_clr_text_color_error_msg").css("background-color",dataJson.error_msg_text_color);
	        jQuery("#ux_clr_text_color_error_msg").css("color","#ffffff");
	        dataJson.error_msg_rdl_text_align == "0" ? jQuery("#ux_rdl_font_align_left_error_msg").attr("checked","checked") : jQuery("#ux_rdl_font_align_right_error_msg").attr("checked","checked") ;
	        jQuery("#ux_ddl_error_msg_direction").val(dataJson.error_msg_text_direction);
		}
   });
}

jQuery(document).ready(function()
{
	<?php
	if(isset($_REQUEST["form_id"]))
	{
		?>
		var form_id = "<?php echo intval($_REQUEST["form_id"]);?>";
		<?php
	}
	else {
		?>
		var form_id = "0";
		<?php
	}
	?>
	if(form_id > 0)
	{
		select_form_layout();
	}
});
</script>
<?php 
}
?>