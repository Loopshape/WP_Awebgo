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
	$form_settings = array();
	$control_id = $wpdb->get_var
	(
		$wpdb->prepare
		(
			"SELECT control_id FROM " .create_control_Table(). " where form_id= %d and field_id = %d and column_dynamicId = %d",
			$form_id,
			$field_type,
			$dynamicId
		)
	);
	if(count($control_id) != 0)
	{
		$form_data = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT * FROM " .contact_bank_dynamic_settings_form(). " where dynamicId= %d",
				$control_id
			)
		);
		$form_settings[$dynamicId]["dynamic_id"] = $dynamicId;
		$form_settings[$dynamicId]["control_type"] = "1";
		for($flag = 0; $flag<count($form_data);$flag++)
		{
			$form_settings[$dynamicId][$form_data[$flag]->dynamic_settings_key] = $form_data[$flag]->dynamic_settings_value;
		}
	}
	?>
	<form id="ux_frm_check_box_control" action="#" method="post" class="layout-form">
		<div class="fluid-layout">
			<div class="layout-span12">
				<div class="widget-layout">
					<div class="widget-layout-title">
						<h4><?php _e( "Check Boxes", contact_bank ); ?></h4>
					</div>
					<div class="widget-layout-body">
						<div class="layout-control-group">
							<label class="layout-control-label"><?php _e( "Label", contact_bank ); ?> :</label>
							<div class="layout-controls">
								<input type="text" class="layout-span12" id="ux_label_text_<?php echo $dynamicId; ?>" onkeyup="enter_admin_label(<?php echo $dynamicId; ?>);" value="<?php echo isset($form_settings[$dynamicId]["cb_label_value"])  ? $form_settings[$dynamicId]["cb_label_value"] :  _e( "Untitled", contact_bank ); ?>" name="ux_label_text_<?php echo $dynamicId; ?>" />
							</div>
						</div>
						<div class="layout-control-group">
							<label class="layout-control-label"><?php _e( "Required", contact_bank ); ?> :</label>
							<div class="layout-controls" style="margin-top:7px;">
								<?php
									if(isset($form_settings[$dynamicId]["cb_control_required"]))
									{
										if($form_settings[$dynamicId]["cb_control_required"] == "1")
										{
											?>
											<input type="radio" id="ux_required_control_<?php echo $dynamicId; ?>" name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="1" checked="checked" />
											<label style="vertical-align: text-bottom;">
													<?php _e( "Required", contact_bank ); ?>
											</label>
											<input type="radio" id="ux_required_<?php echo $dynamicId; ?>" name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="0"/>
											<label style="vertical-align: text-bottom;">
												<?php _e( "Not Required", contact_bank ); ?>
											</label>
											<?php
										}
										else if($form_settings[$dynamicId]["cb_control_required"] == "0")
										{
											?>
											<input type="radio" id="ux_required_control_<?php echo $dynamicId; ?>" name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="1" />
											<label style="vertical-align: text-bottom;">
												<?php _e( "Required", contact_bank ); ?>
											</label>
											<input type="radio" id="ux_required_<?php echo $dynamicId; ?>" name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="0" checked="checked" />
											<label style="vertical-align: text-bottom;">
												<?php _e( "Not Required", contact_bank ); ?>
											</label>
											<?php
										}
									}
									else
									{
									?>
										<input type="radio" id="ux_required_control_<?php echo $dynamicId; ?>" name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="1" />
										<label style="vertical-align: text-bottom;">
											<?php _e( "Required", contact_bank ); ?>
										</label>
										<input type="radio" checked="checked" id="ux_required_<?php echo $dynamicId; ?>" name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="0" checked="checked" />
										<label style="vertical-align: text-bottom;">
											<?php _e( "Not Required", contact_bank ); ?>
										</label>
									<?php
									}
								?>
							</div>
						</div>
						<div class="layout-control-group">
							<label class="layout-control-label"><?php _e("Tooltip Text", contact_bank); ?> :</label>
							<div class="layout-controls">
								<input type="text" class="layout-span12" readonly="readonly" id="ux_tooltip_control_<?php echo $dynamicId; ?>" placeholder="<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>" name="ux_tooltip_control_<?php echo $dynamicId; ?>" value="<?php echo isset($form_settings[$dynamicId]["cb_tooltip_txt"]) ? $form_settings[$dynamicId]["cb_tooltip_txt"] : ""; ?>"/>
							</div>
						</div>
						<div class="layout-control-group">
							<label class="layout-control-label"><?php _e("Options", contact_bank); ?> :</label>
							<div class="layout-controls">
								<input type="text" class="layout-span9" id="chk_options_<?php echo $dynamicId; ?>" placeholder="<?php _e( "Enter Options", contact_bank ); ?>" name="chk_options_<?php echo $dynamicId; ?>" />
								<input  value="<?php _e( "Add", contact_bank ); ?>" type="button" style="margin-left:10px;" class="btn btn-info layout-span2" id="chk_options_button_<?php echo $dynamicId; ?>" onclick="add_chk_options(<?php echo $dynamicId; ?>);"  name="chk_options_button_<?php echo $dynamicId; ?>" />
							</div>
						</div>
						<?php
						if(isset($form_settings[$dynamicId]["cb_checkbox_option_id"]) && isset($form_settings[$dynamicId]["cb_checkbox_option_val"]))
						{
							$options_value = unserialize($form_settings[$dynamicId]["cb_checkbox_option_val"]);
							if(count($options_value) > 0)
							{
							?>
								<div class="layout-control-group" style="overflow: hidden;max-height: 110px;" id="bind_dropdown_<?php echo $dynamicId; ?>">
							<?php
							}
							else
							{
								?>
								<div class="layout-control-group" style="overflow: hidden;max-height: 110px;display:none" id="bind_dropdown_<?php echo $dynamicId; ?>">
								<?php
							}
							?>
									<div class="layout-controls">
										<select id="dropdown_ddl_option_<?php echo $dynamicId; ?>" class="layout-span9">
											<?php
												foreach(unserialize($form_settings[$dynamicId]["cb_checkbox_option_id"]) as $key => $value )
												{
													?>
													<option value="<?php echo $value; ?>"><?php echo $options_value[$key]; ?></option>
													<?php
												}
											?>
										</select>
										<input class="btn btn-info layout-span2" style="margin-left:10px;"  value="<?php _e( "Delete", contact_bank ); ?>" type="button" id="ddl_options_btn_del_<?php echo $dynamicId; ?>" onclick="delete_ddl_options(<?php echo $dynamicId; ?>);"  name="ddl_options_btn_del_<?php echo $dynamicId; ?>" />
									</div>
								</div>
							<?php
							}
							?>
							<div class="layout-control-group">
								<label class="layout-control-label"><?php _e( "Admin Label", contact_bank ); ?> :</label>
								<div class="layout-controls">
									<input type="text" value="<?php echo isset($form_settings[$dynamicId]["cb_admin_label"])  ? $form_settings[$dynamicId]["cb_admin_label"] :  _e( "Untitled", contact_bank ); ?>" class="layout-span12" id="ux_admin_label_<?php echo $dynamicId; ?>" class="layout-span12" id="ux_admin_label_<?php echo $dynamicId; ?>" placeholder="<?php _e( "Enter Admin Label", contact_bank ); ?>" name="ux_admin_label_<?php echo $dynamicId; ?>" />
								</div>
							</div>
							<div class="layout-control-group">
								<label class="layout-control-label"><?php _e( "Do not show in the email", contact_bank ); ?> :</label>
								<div class="layout-controls">
								<?php
									if(isset($form_settings[$dynamicId]["cb_show_email"]))
									{
										if($form_settings[$dynamicId]["cb_show_email"] == "1")
										{
									 	?>
											<input type="checkbox" checked="checked"  id="ux_show_email_<?php echo $dynamicId; ?>" name="ux_show_email_<?php echo $dynamicId; ?>" style="margin-top: 10px;" value="1">
										<?php
										}
										else
										{
										?>
											<input type="checkbox" id="ux_show_email_<?php echo $dynamicId; ?>" name="ux_show_email_<?php echo $dynamicId; ?>" style="margin-top: 10px;" value="0">
										<?php
										}
									}
									else
									{
										?>
										<input type="checkbox" id="ux_show_email_<?php echo $dynamicId; ?>" name="ux_show_email_<?php echo $dynamicId; ?>" style="margin-top: 10px;" value="0">
									<?php
									}
									?>
								</div>
							</div>
							<input type="hidden" id="ux_hd_textbox_dynamic_id" name="ux_hd_textbox_dynamic_id" value="<?php echo $dynamicId; ?>"/>
						</div>
					</div>
					<div class="layout-control-group">
						<input type="submit" class="btn btn-info layout-span3" value="<?php _e( "Save Settings", contact_bank ); ?>" />
					</div>
				</div>
			</div>
		</div>
	</form>
	<a class="closeButtonLightbox" onclick="CloseLightbox();"></a>
	
	<script type="text/javascript">
	
	var dynamicId = "<?php echo $dynamicId; ?>";
	var controlId = "<?php echo $control_id; ?>";
	var form_id = "<?php echo $form_id;?>";
	var options_ddl = [];
	var options_value = [];
	jQuery("#ux_frm_check_box_control").validate
	({
		submitHandler: function(form)
		{
			if(jQuery("#dropdown_ddl_option_"+dynamicId).val() != null)
			{
				jQuery("#ux_chk_checkbox_control_"+dynamicId).hide();
			}
			else
			{
				jQuery("#ux_chk_checkbox_control_"+dynamicId).show();
			}
			jQuery("#add_chk_options_here_"+dynamicId).empty();
			jQuery("#dropdown_ddl_option_"+dynamicId+" option").each(function()
			{
				jQuery("#add_chk_options_here_"+dynamicId).append("<span id=\"input_id_"+this.value+"\"><input id=\"ux_chk_checkbox_control_"+this.value+"\" name=\"ux_chk_checkbox_control_"+this.value+"\" type=\"checkbox\"/><label class=\"rdl\">"+this.text+"</label></span>");
				options_ddl.push(this.value);
				options_value.push(this.text);
			});
			jQuery.post(ajaxurl, jQuery(form).serialize() + "&controlId="+controlId+"&form_id="+form_id+"&ddl_options_id="+JSON.stringify(options_ddl)+"&options_value="+encodeURIComponent(JSON.stringify(options_value))+"&form_settings="+JSON.stringify(<?php echo json_encode($form_settings) ?>)+"&event=update&param=save_check_box_control&action=add_contact_form_library", function(data)
			{
				jQuery("#control_label_"+dynamicId).html(jQuery("#ux_label_text_"+dynamicId).val()+" :");
				jQuery("#post_back_checkbox_"+dynamicId).attr("data-original-title",jQuery("#ux_tooltip_control_"+dynamicId).val());
				if(jQuery("#ux_required_control_"+dynamicId).prop("checked") == true)
				{
					jQuery("#control_label_"+dynamicId).append("<span class=\"error\">*</span>");
				}
				CloseLightbox();
			});
		}
	});
	function add_chk_options(dynamicId)
	{
		var ddl_options = jQuery("#chk_options_"+dynamicId).val();
		if(ddl_options=="")
		{
			alert("<?php _e( "Please Fill an Option.", contact_bank ); ?>");
		}
		else
		{
			var optionsId = Math.floor((Math.random()*10000)+1);
			jQuery("#dropdown_ddl_option_"+dynamicId).append("<option value=\""+optionsId+"\">"+ddl_options+"</option>");
			jQuery("#bind_dropdown_"+dynamicId).css("display","");
			jQuery("#chk_options_"+dynamicId).val("");
		}
	}
	function delete_ddl_options(dynamicId)
	{
		var value = jQuery("#dropdown_ddl_option_"+dynamicId).val();
		jQuery("#dropdown_ddl_option_"+dynamicId+ " option[value=\""+value+"\"]").remove();
		if(jQuery("#dropdown_ddl_option_"+dynamicId).val() == null)
		{
			jQuery("#bind_dropdown_"+dynamicId).css("display","none");
		}
	}
	</script>
<?php 
}
?>