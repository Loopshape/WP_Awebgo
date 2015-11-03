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
		if($_REQUEST["param"] == "fetch_control_values")
		{
			$form_id = intval($_REQUEST["form_id"]);
			$layout_settings = array();
			$form_settings_controls = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"SELECT form_settings_key,form_settings_value FROM " .contact_bank_layout_settings_Table()." WHERE form_id = %d order by id ASC",
					$form_id
				)
			);
			for($flag = 0; $flag<count($form_settings_controls);$flag++)
			{
				$layout_settings[$form_settings_controls[$flag]->form_settings_key] = $form_settings_controls[$flag]->form_settings_value;
			}
			echo json_encode($layout_settings);
			die();
		}
		
	}
	
}
	