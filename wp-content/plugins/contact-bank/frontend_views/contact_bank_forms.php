<?php
global $wpdb;
$control_settings_array = array();
$form_settings_array = array();
$layout_settings_array = array();
$form_name = $wpdb->get_var
(
	$wpdb->prepare
	(
		"SELECT form_name FROM " .contact_bank_contact_form()." WHERE form_id = %d",
		$form_id
	)
);
$form_fields = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT control_id,column_dynamicId,field_id,sorting_order FROM " .create_control_Table()." WHERE form_id = %d ORDER BY sorting_order asc",
		$form_id
	)
);
for($flag=0;$flag<count($form_fields);$flag++)
{
	$control_settings = $wpdb->get_results
	(
		$wpdb->prepare
		(
			"SELECT * FROM " .contact_bank_dynamic_settings_form()." WHERE dynamicId  = %d",
			$form_fields[$flag]->control_id
		)
	);
	for($flag1=0;$flag1<count($control_settings);$flag1++)
	{
		$column_dynamicId = $form_fields[$flag]->column_dynamicId;
		$control_settings_array[$column_dynamicId][$control_settings[$flag1]->dynamic_settings_key] = $control_settings[$flag1]->dynamic_settings_value;
	}
}

$form_settings = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT form_message_key,form_message_value FROM " .contact_bank_form_settings_Table()." WHERE form_id = %d",
		$form_id
	)
);
for($flag2=0;$flag2<count($form_settings);$flag2++)
{
	$form_settings_array[$form_id][$form_settings[$flag2]->form_message_key] = $form_settings[$flag2]->form_message_value;
}

$forms_layout_settings = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT form_settings_key,form_settings_value FROM " .contact_bank_layout_settings_Table()." WHERE form_id = %d",
		$form_id
	)
);
for($flag3=0;$flag3<count($forms_layout_settings);$flag3++)
{
	$layout_settings_array[$form_id][$forms_layout_settings[$flag3]->form_settings_key] = $forms_layout_settings[$flag3]->form_settings_value;
}

$forms_email_settings = $wpdb->get_row
(
	$wpdb->prepare
	(
		"SELECT * FROM " .contact_bank_email_template_admin()." WHERE form_id = %d",
		$form_id
	)
);
$rand_value = RAND(10,10000);
?>

<style type="text/css">

	.main_container_form
	{
		display: inline-block !important;
		width: 100% !important;
	}
	.cb_form_wrapper
	{
		overflow: inherit;
		margin: 10px 0;
		max-width: 98%
	}
	.label_control
	{
		font-family: <?php echo $layout_settings_array[$form_id]["label_setting_font_family"]; ?> !important;
		color: <?php echo $layout_settings_array[$form_id]["label_setting_font_color"]; ?> !important;
		<?php
			if($layout_settings_array[$form_id]["label_setting_font_style"] == "italic")
			{
				?>
				font-style: <?php echo $layout_settings_array[$form_id]["label_setting_font_style"]; ?> !important;
				<?php
			}
			else
			{
				?>
				font-weight: <?php echo $layout_settings_array[$form_id]["label_setting_font_style"]; ?> !important;
				<?php
			}
			if($layout_settings_array[$form_id]["label_setting_label_position"] == "top")
			{
				?>
				float: none !important;
				text-align: <?php echo $layout_settings_array[$form_id]["label_setting_font_align_left"] == "0" ? "left" : "right"; ?> !important;
				<?php
			}
			else if($layout_settings_array[$form_id]["label_setting_label_position"] == "right")
			{
				?>
				text-align: right !important;
				<?php
			}
			else 
			{
				?>
				text-align: <?php echo $layout_settings_array[$form_id]["label_setting_font_align_left"] == "0" ? "left" : "right"; ?> !important;
				<?php
			}
		?>
		font-size: <?php echo $layout_settings_array[$form_id]["label_setting_font_size"] . "px"; ?> !important;
		display: <?php echo $layout_settings_array[$form_id]["label_setting_hide_label"] == "0" ? "inline-block" : "none"; ?> !important;
		direction: <?php echo $layout_settings_array[$form_id]["label_setting_text_direction"]; ?> !important;
	}
	.input_control
	{
		
		font-family: <?php echo $layout_settings_array[$form_id]["input_field_font_family"]; ?> !important;
		color: <?php echo $layout_settings_array[$form_id]["input_field_font_color"]; ?> !important;
		<?php
			if($layout_settings_array[$form_id]["input_field_font_style"] == "italic")
			{
		?>
				font-style: <?php echo $layout_settings_array[$form_id]["input_field_font_style"]; ?> !important;
		<?php
			}
			else
			{
		?>
				font-weight: <?php echo $layout_settings_array[$form_id]["input_field_font_style"]; ?> !important;
		<?php
			}
		?>
		background-color: <?php echo $layout_settings_array[$form_id]["input_field_clr_bg_color"]; ?> !important;
		font-size: <?php echo $layout_settings_array[$form_id]["input_field_font_size"] . "px"; ?> !important;
		border: <?php echo $layout_settings_array[$form_id]["input_field_border_size"] . "px ".$layout_settings_array[$form_id]["input_field_border_style"].$layout_settings_array[$form_id]["input_field_border_color"]; ?>  !important;
		border-radius: <?php echo $layout_settings_array[$form_id]["input_field_border_radius"] . "px"; ?> !important;
		-moz-border-radius: <?php echo $layout_settings_array[$form_id]["input_field_border_radius"] . "px"; ?> !important;
		-webkit-border-radius: <?php echo $layout_settings_array[$form_id]["input_field_border_radius"] . "px"; ?> !important;
		-khtml-border-radius: <?php echo $layout_settings_array[$form_id]["input_field_border_radius"] . "px"; ?> !important;
		-o-border-radius: <?php echo $layout_settings_array[$form_id]["input_field_border_radius"] . "px"; ?> !important;
		text-align: <?php echo $layout_settings_array[$form_id]["input_field_rdl_text_align"] == "0" ? "left" : "right"; ?> !important;
		direction: <?php echo $layout_settings_array[$form_id]["input_field_text_direction"]; ?> !important;
		min-width:250px;
		max-width:500px;
	}
	.layout_according_label_position
	{
		<?php
		if($layout_settings_array[$form_id]["label_setting_label_position"] == "top")
		{
			?>
			margin-left: 0px !important;
			<?php
		}
		
		?>
	}
	.field_description
	{
		display:block !important;
		font-family: <?php echo $layout_settings_array[$form_id]["label_setting_font_family"]; ?> !important;
		font-style: italic !important;
		color: <?php echo $layout_settings_array[$form_id]["label_setting_font_color"]; ?> !important;
		<?php
		if($layout_settings_array[$form_id]["label_setting_font_style"] == "italic")
		{
		?>
			font-style: <?php echo $layout_settings_array[$form_id]["label_setting_font_style"]; ?> !important;
		<?php
		}
		else
		{
		?>
			font-weight: <?php echo $layout_settings_array[$form_id]["label_setting_font_style"]; ?> !important;
		<?php
		}
		?>
		font-size: <?php echo $layout_settings_array[$form_id]["label_setting_field_size"] . "px"; ?> !important;
		text-align: <?php echo $layout_settings_array[$form_id]["label_setting_field_align"]; ?> !important; 
	}
	.btn_submit
	{
		<?php
		if($layout_settings_array[$form_id]["submit_button_font_style"] == "italic")
		{
		?>
			font-style: <?php echo $layout_settings_array[$form_id]["submit_button_font_style"]; ?> !important;
		<?php
		}
		else
		{
		?>
			font-weight: <?php echo $layout_settings_array[$form_id]["submit_button_font_style"]; ?> !important;
		<?php
		}
		?>
		padding: 12px 25px !important;
		background-color: #3A3C41 !important;
		font-size: 14px !important;
		color: #FFF !important;
		font-weight: 700 !important;
		border: medium none !important;
		cursor: pointer;
		letter-spacing: 1px !important;
		border: medium none !important;
		background-color: #333333 !important;
		color: #FFF !important;
	}
	.btn_submit:hover
	{
		background-color: #999999 !important;
	}
	.success_message
	{
		
		background-color: <?php echo $layout_settings_array[$form_id]["success_msg_bg_color"]; ?> !important;
		border: <?php echo "2px Solid ".$layout_settings_array[$form_id]["success_msg_border_color"]; ?>  !important;
		color: <?php echo $layout_settings_array[$form_id]["success_msg_text_color"]; ?> !important;
		text-align: <?php echo $layout_settings_array[$form_id]["success_msg_rdl_text_align"] == "0" ? "left" : "right"; ?> !important;
		direction: <?php echo $layout_settings_array[$form_id]["success_msg_text_direction"]; ?> !important;
		background: url(<?php echo plugins_url("/assets/images/icons/icon-succes.png" , dirname(__FILE__));?>) no-repeat 1px 8px #EBF9E2;
	}
	.sucess_message_text
	{
		font-family: <?php echo $layout_settings_array[$form_id]["success_msg_font_family"]; ?> !important;
		font-size: <?php echo $layout_settings_array[$form_id]["success_msg_font_size"] . "px"; ?> !important;
	}
	label.error_field
	{
		font-family: <?php echo $layout_settings_array[$form_id]["error_msg_font_family"]; ?> !important;
		font-size: <?php echo $layout_settings_array[$form_id]["error_msg_font_size"] . "px"; ?> !important;
		background-color: <?php echo $layout_settings_array[$form_id]["error_msg_bg_color"]; ?> !important;
		border: <?php echo "2px Solid ".$layout_settings_array[$form_id]["error_msg_border_color"]; ?>  !important;
		color: <?php echo $layout_settings_array[$form_id]["error_msg_text_color"]; ?> !important;
		text-align: <?php echo $layout_settings_array[$form_id]["error_msg_rdl_text_align"] == "0" ? "left" : "right"; ?> !important;
		direction: <?php echo $layout_settings_array[$form_id]["error_msg_text_direction"]; ?> !important;
		<?php
		if($layout_settings_array[$form_id]["label_setting_label_position"] == "left")
		{
			?>
				margin-left: 10px;
			<?php
		}
		else if($layout_settings_array[$form_id]["label_setting_label_position"] == "right")
		{
			?>
				margin-right: 10px;
			<?php
		}
		?>
	}
</style>
<div class="cb_form_wrapper" id="cb_form_wrapper_<?php echo $form_id; ?>">
	<form id="ux_frm_front_end_form_<?php echo $form_id ."_". $rand_value; ?>" method="post" action="#">
		<div id="form_success_message_frontend_<?php echo $rand_value;?>" class="custom-message success_message" style="display: none;margin-bottom: 10px;">
			<span class="sucess_message_text" >
				<strong><?php echo $form_settings_array[$form_id]["success_message"]; ?></strong>
			</span>
		</div>
		<div>
			<?php
				if($show_title == "true")
				{
					?>
					<h4><?php _e($form_name, contact_bank ); ?></h4>
					<?php 
				}
				if($show_desc == "true")
				{
					?>
					<div class="layout-control-group">
						<span><?php echo $form_settings_array[$form_id]["form_description"]; ?></span>
					</div>
					<?php
				}
			?>
			</div>
			<?php 
				for($flag=0;$flag<count($form_fields);$flag++)
				{
				?>
					<div class="layout-control-group">
						<label class="label_control layout-control-label">
						<?php
							_e($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_label_value"], contact_bank ) . " :";
							if($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_control_required"] == "1")
							{
							?>
								<span class="error">*</span>
							<?php
							}
						?>
						</label>
						<?php
						switch($form_fields[$flag]->field_id)
						{
							case 1:
							?>
								<div class="layout-controls layout_according_label_position">
									<input class="hovertip input_control" type="text"  id="ux_txt_control_<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>" name="ux_txt_control_<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>" data-original-title="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_tooltip_txt"]; ?>" placeholder="<?php _e($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_default_txt_val"], contact_bank );?>" data-alpha="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_alpha_filter"];?>" data-alpha_num="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_ux_checkbox_alpha_num_filter"];?>" data-digit="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_digit_filter"];?>" data-strip="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_strip_tag_filter"];?>" data-trim="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_trim_filter"];?>" onfocus="prevent_paste(this.id);" />
									<span class="field_description" id="txt_description_"><?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_description"]; ?></span>
								</div>
							<?php
							break;
							case 2:
								?>
								<div class="layout-controls layout_according_label_position">
									<textarea class="hovertip input_control" id="ux_textarea_control_<?php echo $form_fields[$flag]->column_dynamicId."_". $rand_value; ?>" placeholder="<?php _e($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_default_txt_val"], contact_bank );?>" name="ux_textarea_control_<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>" onfocus="prevent_paste(this.id);" data-alpha="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_alpha_filter"];?>" data-alpha_num="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_ux_checkbox_alpha_num_filter"];?>" data-digit="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_digit_filter"];?>" data-strip="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_strip_tag_filter"];?>" data-trim="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_trim_filter"];?>" data-original-title="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_tooltip_txt"]; ?>"></textarea>
									<span class="field_description" id="txt_description_"><?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_description"]; ?></span>
								</div>
								<?php
							break;
							case 3:
									?>
									<div class="layout-controls layout_according_label_position">
										<input class="hovertip input_control" type="text"  id="ux_txt_email_<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>" name="ux_txt_email_<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>" data-original-title="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_tooltip_txt"]; ?>" placeholder="<?php _e($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_default_txt_val"], contact_bank );?>"onfocus="prevent_paste(this.id);"/>
										<span class="field_description" id="txt_description_"><?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_description"]; ?></span>
									</div>
									<?php
							break;
							case 4:
									$ddl_values = unserialize($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_dropdown_option_val"]);
									$ddl_ids = unserialize($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_dropdown_option_id"]);
									?>
									<div class="layout-controls layout_according_label_position hovertip" data-original-title="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_tooltip_txt"]; ?>">
										<select class="input_control" type="select" id="ux_select_default_<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>"  name="ux_select_default_<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>">
											<option value="<?php echo count($ddl_values) == 0 ? " " : ""; ?>"><?php _e("Select Option", contact_bank); ?></option>
											<?php
											foreach($ddl_ids as $key => $value )
											{
												?>
												<option value="<?php echo $ddl_values[$key]; ?>"><?php echo $ddl_values[$key]; ?></option>
												<?php
											}
											?>
										</select>
									</div>
									<?php
							break;
							case 5:
								$chk_values = unserialize($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_option_val"]);
								$chk_ids = unserialize($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_checkbox_option_id"]);
								if(count($chk_ids) > 0)
								{
									?>
									<div class="layout-controls layout_according_label_position hovertip" data-original-title="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_tooltip_txt"]; ?>">
										<?php
										foreach($chk_ids as $key => $value )
										{
											?>
											<input type="checkbox" id="ux_chk_control_<?php echo $value ."_". $rand_value; ?>" name="<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>_chk[]" value ="<?php echo $chk_values[$key]; ?>" />
												<label style="margin:0px;vertical-align: middle;" id="chk_id_<?php echo $value; ?>">
													<?php echo $chk_values[$key]; ?>
												</label>
											<?php
										}
										?>
									</div>
									<?php
								}
								else 
								{
									?>
									<div class="layout-controls layout_according_label_position hovertip" data-original-title="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_tooltip_txt"]; ?>">
										<input type="checkbox" id="ux_chk_control_" />
									</div>
									<?php
								}
							break;
							case 6:
								$rdl_values = unserialize($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_radio_option_val"]);
								$rdl_ids = unserialize($control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_radio_option_id"]);
								if(count($rdl_ids) > 0)
								{
									?>
									<div class="layout-controls layout_according_label_position hovertip" data-original-title="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_tooltip_txt"]; ?>">
									<?php
										foreach($rdl_ids as $key => $value )
										{
											if($key == "0")
											{
												if($layout_settings_array[$form_id]["input_field_rdl_multiple_row"] == "0")
												{
													?>
													<input type="radio" checked="checked" class="hovertip" id="ux_rdl_control_<?php echo $value ."_". $rand_value; ?>" name="<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>_rdl" value ="<?php echo $rdl_values[$key]; ?>" />
													<label style="margin:0px;vertical-align: sub;" id="rdl_id_<?php echo $value; ?>">
														<?php echo $rdl_values[$key]; ?>
													</label>
													<br>
													<?php
												}
												else
												{
													?>
													<input type="radio" checked="checked" class="hovertip" id="ux_rdl_control_<?php echo $value ."_". $rand_value; ?>" name="<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>_rdl" value ="<?php echo $rdl_values[$key]; ?>" />
													<label style="margin:0px;vertical-align: sub;" id="rdl_id_<?php echo $value; ?>">
														<?php echo $rdl_values[$key]; ?>
													</label>
													<?php
												}
											}
											else
											{
												if($layout_settings_array[$form_id]["input_field_rdl_multiple_row"] == "0")
												{
													?>
													<input type="radio" class="hovertip" id="ux_rdl_control_<?php echo $value ."_". $rand_value; ?>" name="<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>_rdl" value ="<?php echo $rdl_values[$key]; ?>" />
													<label style="margin:0px;vertical-align: sub;" id="rdl_id_<?php echo $value; ?>">
														<?php echo $rdl_values[$key]; ?>
													</label>
													<br>
													<?php
												}
												else
												{
													?>
													<input type="radio" class="hovertip" id="ux_rdl_control_<?php echo $value ."_". $rand_value; ?>" name="<?php echo $form_fields[$flag]->column_dynamicId ."_". $rand_value; ?>_rdl" value ="<?php echo $rdl_values[$key]; ?>" />
													<label style="margin:0px;vertical-align: sub;" id="rdl_id_<?php echo $value; ?>">
														<?php echo $rdl_values[$key]; ?>
													</label>
													<?php
												}
											}
										}
									?>
									</div>
									<?php
								}
								else 
								{
									?>
									<div class="layout-controls layout_according_label_position hovertip" data-original-title="<?php echo $control_settings_array[$form_fields[$flag]->column_dynamicId]["cb_tooltip_txt"]; ?>">
										<input type="radio" id="ux_rdl_control_" />
									</div>
									<?php
								}
							break;
						}
					?>
					</div>
				<?php
				}
			?>
		<div class="layout-control-group">
			<button type="submit"  class="btn_submit"><?php _e(trim($layout_settings_array[$form_id]["submit_button_text"]),contact_bank);?></button>
		</div>
	</form>
</div>
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url("admin-ajax.php"); ?>";
jQuery.extend(jQuery.validator.messages, {
	required: "<?php echo $form_settings_array[$form_id]["blank_field_message"];?>",
	email: "<?php echo $form_settings_array[$form_id]["incorrect_email_message"];?>"
});
function prevent_paste(control_id)
{
	jQuery("#"+control_id).live("paste",function(e)
	{
		e.preventDefault();
	});
}
jQuery("#ux_frm_front_end_form_<?php echo $form_id ."_". $rand_value; ?>").validate
({
	rules: 
	{
		<?php
			$dynamic = "";
			for($flag4=0;$flag4<count($form_fields);$flag4++)
			{
				if($control_settings_array[$form_fields[$flag4]->column_dynamicId]["cb_control_required"] == 1)
				{
					switch($form_fields[$flag4]-> field_id) 
					{
						case 1:
							$dynamic .= "ux_txt_control_".$form_fields[$flag4]->column_dynamicId ."_". $rand_value. ":{ required :true }";
						break;
						case 2:
							$dynamic .= "ux_textarea_control_".$form_fields[$flag4]->column_dynamicId ."_". $rand_value. ":{ required :true }";
						break;
						case 3:
							$dynamic .= "ux_txt_email_".$form_fields[$flag4]->column_dynamicId ."_". $rand_value. ":{ required :true,email :true }";
						break;
						case 4:
							$dynamic .= "ux_select_default_".$form_fields[$flag4]->column_dynamicId ."_". $rand_value. ":{ required: true}";
						break;
						case 5:
							$dynamic .= "'".$form_fields[$flag4]->column_dynamicId ."_". $rand_value. "_chk[]'". ":{ required :true }";
						break;
						case 6:
							$dynamic .= "'".$form_fields[$flag4]->column_dynamicId ."_". $rand_value. "_rdl'". ":{ required :true }";
						break;
						
					}
					if( count($form_fields)> 1 && $flag4 < count($form_fields) - 1 )
					{
						$dynamic .= ",";
					}
				}
				
			}
			echo $dynamic;
		?>
	},
	errorPlacement: function(error, element)
	{
		<?php
		
		if($layout_settings_array[$form_id]["label_setting_label_position"] == "top")
		{
			?>
			if(element.attr("type") === "time" || element.attr("type") === "date")
			{
				element.parent().parent().children("label").remove(".error_field");
				error.insertAfter(element.parent());
			}
			else
			{
				error.insertAfter(element.parent());
			}
			<?php
		}
		else
		{
			?>
			if (element.attr("type") === "radio" || element.attr("type") === "checkbox") 
			{
				error.insertAfter(element.parent().children("label:last-child"));
			}
			else if(element.attr("type") === "time" || element.attr("type") === "date")
			{
				element.parent().children("label").remove();
				error.insertBefore(element.parent().children("br"));
			}
			else
			{
				error.insertAfter(element);
			}
			<?php
		}
		?>
	},
	submitHandler: function(form)
	{
		jQuery("body,html").animate({
		scrollTop: jQuery("body,html").position().top}, "slow");
		var form_id = "<?php echo $form_id ;?>";
		jQuery.post(ajaxurl, jQuery(form).serialize() +"&form_id="+form_id+"&rand="+<?php echo $rand_value;?>+"&param=frontend_submit_controls&action=frontend_contact_form_library", function(data)
		{
			jQuery("#form_success_message_frontend_<?php echo $rand_value;?>").css("display","block");
			var submit_id = data;
			jQuery.post(ajaxurl, "form_id="+form_id+"&submit_id="+submit_id+"&param=email_management&action=email_management_contact_form_library", function(data) 
			{
				setTimeout(function()
				{
					jQuery("#form_success_message_frontend_<?php echo $rand_value;?>").css("display","none");
					window.location.href = "<?php echo $form_settings_array[$form_id]["redirect_url"];?>";
				}, 2000);
			});
		});
	}
});
</script>