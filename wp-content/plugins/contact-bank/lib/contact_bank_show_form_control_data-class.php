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
	if(isset($_REQUEST["param"]))
	{
		if($_REQUEST["param"] == "bind_text_control")
		{
			$form_id = intval($_REQUEST["form_id"]);
			$field_type = intval($_REQUEST["control_type"]);
			$dynamicId = intval($_REQUEST["dynamicId"]);
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
						intval($control_id)
					)
				);
				$form_settings[$dynamicId]["dynamic_id"] = $dynamicId;
				$form_settings[$dynamicId]["control_type"] = $field_type;
				$form_settings[$dynamicId]["control_id"] = intval($control_id);
				for($flag = 0; $flag<count($form_data);$flag++)
				{
					if($form_data[$flag]->dynamic_settings_key == "cb_dropdown_option_id" || $form_data[$flag]->dynamic_settings_key == "cb_dropdown_option_val" 
					|| $form_data[$flag]->dynamic_settings_key == "cb_checkbox_option_id" || $form_data[$flag]->dynamic_settings_key == "cb_checkbox_option_val"
					|| $form_data[$flag]->dynamic_settings_key == "cb_radio_option_id" || $form_data[$flag]->dynamic_settings_key == "cb_radio_option_val")
						{
							$form_settings[$dynamicId][$form_data[$flag]->dynamic_settings_key] = unserialize($form_data[$flag]->dynamic_settings_value);
						}
						else 
						{
							$form_settings[$dynamicId][$form_data[$flag]->dynamic_settings_key] = $form_data[$flag]->dynamic_settings_value;
						}
				}
			}
			echo json_encode($form_settings);
			die();
		}	
	}
}	