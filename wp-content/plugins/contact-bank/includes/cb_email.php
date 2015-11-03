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
<form id="ux_frm_email_control" action="#" method="post" class="layout-form">
	<div class="fluid-layout">
		<div class="layout-span12">
			<div class="widget-layout">
				<div class="widget-layout-title">
					<h4><?php _e( "Email Address", contact_bank ); ?></h4>
				</div>
				<div class="widget-layout-body" >
					<div class="layout-control-group">
						<label class="layout-control-label"><?php _e( "Label", contact_bank ); ?> :</label>
						<div class="layout-controls">
							<input type="text" onkeyup="enter_admin_label(<?php echo $dynamicId; ?>);" 
								value="<?php echo isset($form_settings[$dynamicId]["cb_label_value"])  ? $form_settings[$dynamicId]["cb_label_value"] :  _e( "Untitled", contact_bank ); ?>" 
								class="layout-span12" id="ux_label_text_<?php echo $dynamicId; ?>" placeholder="<?php _e( "Enter Label", contact_bank ); ?>"  
								name="ux_label_text_<?php echo $dynamicId; ?>"/>
						</div>
					</div>
					<div class="layout-control-group">
						<label class="layout-control-label"><?php _e("Description", contact_bank); ?> :</label>
						<div class="layout-controls">
							<textarea class="layout-span12" id="ux_description_control_<?php echo $dynamicId; ?>"
								placeholder="<?php _e( "Enter Description", contact_bank ); ?>"  
								name="ux_description_control_<?php echo $dynamicId; ?>" ><?php echo isset($form_settings[$dynamicId]["cb_description"]) ? $form_settings[$dynamicId]["cb_description"] : ""; ?></textarea>
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
										<input type="radio" id="ux_required_control_<?php echo $dynamicId; ?>" 
										name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="1" checked="checked" />
										<label style="vertical-align: text-bottom;">
											<?php _e( "Required", contact_bank ); ?>
										</label>
										<input type="radio" id="ux_required_<?php echo $dynamicId; ?>" 
											name="ux_required_control_radio_<?php echo $dynamicId; ?>" disabled="disabled" value="0"/>
										<label style="vertical-align: text-bottom;">
											<?php _e( "Not Required", contact_bank ); ?>
										</label>
									<?php
									}
									else if($form_settings[$dynamicId]["cb_control_required"] == "0")
									{
										?>
										<input type="radio" id="ux_required_control_<?php echo $dynamicId; ?>" 
											name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="1" />
										<label style="vertical-align: text-bottom;">
											<?php _e( "Required", contact_bank ); ?>
										</label>
										<input type="radio" id="ux_required_<?php echo $dynamicId; ?>" 
											name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="0" disabled="disabled" checked="checked" />
										<label style="vertical-align: text-bottom;">
											<?php _e( "Not Required", contact_bank ); ?>
										</label>
									<?php
									}
								}
								else
								{
								?>
									<input type="radio" id="ux_required_control_<?php echo $dynamicId; ?>" 
										name="ux_required_control_radio_<?php echo $dynamicId; ?>" value="1" />
									<label style="vertical-align: text-bottom;">
										<?php _e( "Required", contact_bank ); ?>
									</label>
									<input type="radio" id="ux_required_<?php echo $dynamicId; ?>" 
										name="ux_required_control_radio_<?php echo $dynamicId; ?>" disabled="disabled" value="0" checked="checked" />
									<label style="vertical-align: text-bottom;">
										<?php _e( "Not Required", contact_bank ); ?>
									</label>
								<?php
								}
							?>
						</div>
					</div>
					<div class="layout-control-group">
						<label class="layout-control-label"><?php _e("Tooltip Text", contact_bank); ?> : </label>
						<div class="layout-controls">
							<input type="text" class="layout-span12" id="ux_tooltip_control_<?php echo $dynamicId; ?>" 
								placeholder="<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>" 
								name="ux_tooltip_control_<?php echo $dynamicId; ?>" readonly="readonly"
								value="<?php echo isset($form_settings[$dynamicId]["cb_tooltip_txt"]) ? $form_settings[$dynamicId]["cb_tooltip_txt"] : ""; ?>" />
						</div>
					</div>
					<div class="layout-control-group">
						<label class="layout-control-label"><?php _e( "Place Holder", contact_bank ); ?> :</label>
						<div class="layout-controls">
							<input type="text" class="layout-span12" id="ux_default_value_<?php echo $dynamicId; ?>" 
								placeholder="<?php _e( "Enter Place Holder", contact_bank ); ?>"  
								name="ux_default_value_<?php echo $dynamicId; ?>" 
								value="<?php echo isset($form_settings[$dynamicId]["cb_default_txt_val"]) ? $form_settings[$dynamicId]["cb_default_txt_val"] : ""; ?>"/>
						</div>
					</div>
					<div class="layout-control-group">
						<label class="layout-control-label"><?php _e( "Admin Label", contact_bank ); ?> : </label>
						<div class="layout-controls">
							<input type="text" class="layout-span12" 
								value="<?php echo isset($form_settings[$dynamicId]["cb_admin_label"])  ? $form_settings[$dynamicId]["cb_admin_label"] :  _e( "Untitled", contact_bank ); ?>" 
								id="ux_admin_label_<?php echo $dynamicId; ?>" placeholder="<?php _e( "Enter Admin Label", contact_bank ); ?>" 
								name="ux_admin_label_<?php echo $dynamicId; ?>" />
						</div>
					</div>
					<div class="layout-control-group">
						<label class="layout-control-label"><?php _e( "Do not show in the email", contact_bank ); ?> : </label>
						<div class="layout-controls">
							<?php
							if(isset($form_settings[$dynamicId]["cb_show_email"]))
							{
								if($form_settings[$dynamicId]["cb_show_email"] == "1")
								{
								?>
									<input type="checkbox" checked="checked"  id="ux_show_email_<?php echo $dynamicId; ?>" 
									name="ux_show_email_<?php echo $dynamicId; ?>" style="margin-top: 10px;" value="1">
								<?php
								}
								else
								{
								?>
									<input type="checkbox" id="ux_show_email_<?php echo $dynamicId; ?>" 
									name="ux_show_email_<?php echo $dynamicId; ?>" style="margin-top: 10px;" value="0">
								<?php
								}
							}
							else
							{
								?>
								<input type="checkbox" id="ux_show_email_<?php echo $dynamicId; ?>" 
								name="ux_show_email_<?php echo $dynamicId; ?>" style="margin-top: 10px;" value="0">
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
</form>
<a class="closeButtonLightbox" onclick="CloseLightbox();"></a>
<script type="text/javascript">
	var dynamicId = "<?php echo $dynamicId; ?>";
	var controlId = "<?php echo $control_id; ?>";
	var form_id = "<?php echo $form_id;?>";
	jQuery("#ux_frm_email_control").validate
	({
		submitHandler: function(form)
		{
			jQuery.post(ajaxurl, jQuery(form).serialize() + "&controlId="+controlId+"&form_id="+form_id+"&form_settings="+JSON.stringify(<?php echo json_encode($form_settings) ?>)+"&event=update&param=save_email_control&action=add_contact_form_library", function(data)
			{
				jQuery("#control_label_"+dynamicId).html(jQuery("#ux_label_text_"+dynamicId).val()+" :");
				jQuery("#txt_description_"+dynamicId).html(jQuery("#ux_description_control_"+dynamicId).val());
				jQuery("#show_tooltip"+dynamicId).attr("data-original-title",jQuery("#ux_tooltip_control_"+dynamicId).val());
				jQuery("#ux_txt_email_"+dynamicId).attr("placeholder",jQuery("#ux_default_value_"+dynamicId).val());
				if(jQuery("#ux_required_control_"+dynamicId).prop("checked") == true)
				{
				  jQuery("#control_label_"+dynamicId).append("<span class=\"error\">*</span>");
				}
				CloseLightbox();
			});
		}
	});
</script>
<?php 
}
?>