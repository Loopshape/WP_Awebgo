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
if(!current_user_can($cb_user_role_permission))
{
	return;
}
else
{
	if(isset($_REQUEST["param"]))
	{
		switch($_REQUEST["param"])
		{
			case "add_settings_div":
				$dynamicId = intval($_REQUEST["dynamicId"]);
				$field_type = intval($_REQUEST["field_type"]);
				$form_id = intval($_REQUEST["form_id"]);
				switch($field_type)
				{
					case 1:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_text.php";
						break;
					case 2:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_textarea.php";
						break;
					case 3:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_email.php";
						break;
					case 4:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_dropdown.php";
						break;
					case 5:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_checkbox.php";
						break;
					case 6:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_multiple.php";
						break;
					case 7:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_number.php";
						break;
					case 8:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_name.php";
						break;
					case 9:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_file_upload.php";
						break;
					case 10:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_phone.php";
						break;
					case 11:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_address.php";
						break;
					case 12:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_date.php";
						break;
					case 13:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_time.php";
						break;
					case 14:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_hidden.php";
						break;
					case 15:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_password.php";
						break;
					case 16:
						include_once CONTACT_BK_PLUGIN_DIR ."/includes/cb_url.php";
						break;
				}
				die();
			break;
			
			case "delete_form":
				$form_id =  intval($_REQUEST["id"]);
				$control_id = $wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT control_id FROM " .create_control_Table()." WHERE form_id = %d ",
						$form_id
					)
				);
				$sql = "";
				if(count($control_id) != 0)
				{
					for($flag =0;$flag<count($control_id);$flag++)
					{
						$dynamic_Id = $control_id[$flag]->control_id;
						$sql[] = $dynamic_Id;
					}
					$wpdb->query
					(
						$wpdb->prepare
						(
							"DELETE FROM " .contact_bank_dynamic_settings_form()." WHERE dynamicId IN (".implode(',', $sql).")",""
						)
					);
				}
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM " .contact_bank_email_template_admin()." WHERE form_id = %d ",
						$form_id
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM " .contact_bank_form_settings_Table()." WHERE form_id = %d ",
						$form_id
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM " .frontend_controls_data_Table()." WHERE form_id = %d ",
						$form_id
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM " .contact_bank_frontend_forms_Table()." WHERE form_id = %d ",
						$form_id
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM " .contact_bank_layout_settings_Table()." WHERE form_id = %d ",
						$form_id
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM " .create_control_Table()." WHERE form_id = %d ",
						$form_id
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM " .contact_bank_contact_form()." WHERE form_id = %d ",
						$form_id
					)
				);
				die();
			break;
			
			case "delete_forms":
				
				global $wpdb;
				$wpdb->query
				(
					"TRUNCATE Table ".contact_bank_dynamic_settings_form()
				);
				$wpdb->query
				(
					"TRUNCATE Table ".contact_bank_email_template_admin()
				);
				$wpdb->query
				(
					"TRUNCATE Table ".contact_bank_form_settings_Table()
				);
				$wpdb->query
				(
					"TRUNCATE Table ".frontend_controls_data_Table()
				);
				$wpdb->query
				(
					"TRUNCATE Table ".contact_bank_frontend_forms_Table()
				);
				$wpdb->query
				(
					"TRUNCATE Table ".contact_bank_layout_settings_Table()
				);
				$wpdb->query
				(
					"TRUNCATE Table ".create_control_Table()
				);
				$wpdb->query
				(
					"TRUNCATE Table ".contact_bank_contact_form()
				);
				die();
			break;
			
			case "submit_form_messages_settings":
				
				$sql= "";
				$labels_for_email = "";
				$sql1=array();
				$form_id = intval($_REQUEST["form_id"]);
				$form_settings = json_decode(urldecode(stripcslashes($_REQUEST["form_settings"])),true);
				$array_delete_form_controls = json_decode(stripcslashes($_REQUEST["array_delete_form_controls"]),true);
				foreach($array_delete_form_controls as $element)
				{
					$sql1[] = $element;
				}
				if(count($sql1) > 0)
				{
					$wpdb->query
					(
						$wpdb->prepare
						(
							"Delete FROM " . contact_bank_dynamic_settings_form() . " where dynamicId in (".implode(',', $sql1).")",""
						)
					);
					$wpdb->query
					(
						$wpdb->prepare
						(
							"Delete FROM " . create_control_Table() . " where control_id in (".implode(',', $sql1).")",""
						)
					);
				}
				foreach($form_settings as $element)
				{
					foreach ($element as $val => $keyInner)
					{
						if($val == "form_name")
						{
							$form_name=htmlspecialchars(htmlspecialchars_decode($keyInner));
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE " . contact_bank_contact_form() . " SET `form_name` =%s where form_id = %d ",
									$form_name,
									$form_id
								)
							);
						}
						else
						{
							$labels_for_email = $val;
							if($val == "redirect_url")
							{
								$sql .= ' WHEN `form_message_key` = "'.($val).'" THEN "'.html_entity_decode($keyInner).'"';
							}
							else
							{
								$sql .= ' WHEN `form_message_key` = "'.($val).'" THEN "'.htmlspecialchars(htmlspecialchars_decode($keyInner)).'"';
							}
						}
					}
					$wpdb->query
					(
						$wpdb->prepare
						(
							"UPDATE " . contact_bank_form_settings_Table() . " SET `form_message_value` = CASE ". strip_tags($sql) . " END where form_id = %d ",
							$form_id
						)
					);
				}
				$fields_created = $wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT dynamicId, dynamic_settings_value,field_id	FROM ". contact_bank_dynamic_settings_form(). " JOIN " . create_control_Table(). " ON " . contact_bank_dynamic_settings_form().". dynamicId  = ". create_control_Table(). ".control_id WHERE `dynamic_settings_key` = 'cb_admin_label' and form_id = %d Order By ".create_control_Table().".sorting_order",
						$form_id
					)
				);
				$controls = "";
				$email_dynamicId = "";
				for($flag=0;$flag<count($fields_created);$flag++)
				{
					$show_in_email = $wpdb->get_var
					(
						$wpdb->prepare
						(
							"SELECT dynamic_settings_value FROM ". contact_bank_dynamic_settings_form(). " WHERE `dynamic_settings_key` = 'cb_show_email' and dynamicId = %d",
							$fields_created[$flag]->dynamicId
						)
					);
					if($show_in_email == "0")
					{
						$controls .= "<strong>".$fields_created[$flag]->dynamic_settings_value ."</strong>: ". "[control_".$fields_created[$flag]->dynamicId."] <br>";
					}
					if($fields_created[$flag]->field_id == 3)
					{
						$email_dynamicId = $fields_created[$flag]->dynamicId;
					}
				}
				$body_message = "Hello Admin,<br><br>
				A new user visited your website.<br><br>
				Here are the details :<br><br>
				".$controls."
				<br>Thanks,<br><br>
				<strong>Technical Support Team</strong>";
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE " . contact_bank_email_template_admin() . " SET `body_content` = %s where form_id = %d and name = %s",
						$body_message,
						$form_id,
						"Admin Notification"
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE " . contact_bank_email_template_admin() . " SET `email_to` = %s where form_id = %d and name = %s",
						"[control_".$email_dynamicId."]",
						$form_id,
						"Client Notification"
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE " . contact_bank_email_template_admin() . " SET `send_to` = %d where form_id = %d and name = %s",
						1,
						$form_id,
						"Client Notification"
					)
				);	
				die();
			break;
			
			case "restore_factory_settings":
				
				include_once CONTACT_BK_PLUGIN_DIR ."/lib/restore_factory_settings.php";
				die();
				
			break;
			
			case "save_text_control":
				
				$dynamic_Id = intval($_REQUEST["ux_hd_textbox_dynamic_id"]);
				$form_id = intval($_REQUEST["form_id"]);
				$event = esc_attr($_REQUEST["event"]);
				$controlId = isset($_REQUEST["controlId"]) ? intval($_REQUEST["controlId"]) : 0;
				$form_settings = isset($_REQUEST["form_settings"]) ? json_decode(stripcslashes($_REQUEST["form_settings"]),true) : array();
				$form_settings[$dynamic_Id]["dynamic_id"] = $dynamic_Id;
				$form_settings[$dynamic_Id]["control_type"] = "1";
				$form_settings[$dynamic_Id]["cb_label_value"] = isset($_REQUEST["ux_label_text_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_label_text_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_description"] = isset($_REQUEST["ux_description_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_description_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_control_required"] = isset($_REQUEST["ux_required_control_radio_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_required_control_radio_".$dynamic_Id]) : "0";
				$form_settings[$dynamic_Id]["cb_tooltip_txt"] = isset($_REQUEST["ux_tooltip_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_tooltip_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_default_txt_val"] = isset($_REQUEST["ux_default_value_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_default_value_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_admin_label"] = isset($_REQUEST["ux_admin_label_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_admin_label_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_show_email"] = isset($_REQUEST["ux_show_email_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_checkbox_alpha_filter"] = isset($_REQUEST["ux_checkbox_alpha_filter_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_ux_checkbox_alpha_num_filter"] = isset($_REQUEST["ux_checkbox_alpha_num_filter_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_checkbox_digit_filter"] = isset($_REQUEST["ux_checkbox_digit_filter_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_checkbox_strip_tag_filter"] = isset($_REQUEST["ux_checkbox_strip_tag_filter_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_checkbox_trim_filter"] = isset($_REQUEST["ux_checkbox_trim_filter_".$dynamic_Id]) ? "1" : "0";
					
				foreach($form_settings as $element)
				{
					$id = $element["dynamic_id"];
					$control_type = $element["control_type"];
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . create_control_Table() . "(form_id,field_id,column_dynamicId) VALUES(%d,%d,%d)",
								$form_id,
								$control_type,
								$id
							)
						);
						echo $dynamic_control_id=$wpdb->insert_id;
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . create_control_Table() . " SET `sorting_order` = %d where form_id = %d and field_id = %d and column_dynamicId = %d",
								$dynamic_control_id,
								$form_id,
								$control_type,
								$id
							)
						);
					}
					else
					{
						$sql= "";
					}
					foreach($element as $key => $value)
					{
						if($key == "dynamic_id" || $key == "control_type")
						{
							continue;
						}
						else
						{
							if($event == "add")
							{
								$sql[] = '('.$dynamic_control_id.',"'.$key.'", "'.$value.'")';
							}
							else {
								$sql .= 'WHEN `dynamic_settings_key` = "'.$key.'" THEN "'.$value.'"';
							}
						}
					}
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . contact_bank_dynamic_settings_form() . "(dynamicId,dynamic_settings_key,dynamic_settings_value) VALUES ".implode(',', $sql),""
							)
						);
					}
					else
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . contact_bank_dynamic_settings_form() . " SET `dynamic_settings_value` = CASE ".strip_tags($sql). " END where dynamicId = %d ",
								$controlId
							)
						);
					}
				}
				die();
			break;
						
			case "save_textarea_control":
				
				$dynamic_Id = intval($_REQUEST["ux_hd_textbox_dynamic_id"]);
				$form_id = intval($_REQUEST["form_id"]);
				$event = esc_attr($_REQUEST["event"]);
				$controlId = isset($_REQUEST["controlId"]) ? intval($_REQUEST["controlId"]) : 0;
				$form_settings = isset($_REQUEST["form_settings"]) ? json_decode(stripcslashes($_REQUEST["form_settings"]),true) : array();
				$form_settings[$dynamic_Id]["dynamic_id"] = $dynamic_Id;
				$form_settings[$dynamic_Id]["control_type"] = "2";
				$form_settings[$dynamic_Id]["cb_label_value"] = isset($_REQUEST["ux_label_text_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_label_text_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_description"] = isset($_REQUEST["ux_description_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_description_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_control_required"] = isset($_REQUEST["ux_required_control_radio_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_required_control_radio_".$dynamic_Id]) : "0";
				$form_settings[$dynamic_Id]["cb_tooltip_txt"] = isset($_REQUEST["ux_tooltip_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_tooltip_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_default_txt_val"] = isset($_REQUEST["ux_default_value_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_default_value_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_admin_label"] = isset($_REQUEST["ux_admin_label_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_admin_label_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_show_email"] = isset($_REQUEST["ux_show_email_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_checkbox_alpha_filter"] = isset($_REQUEST["ux_checkbox_alpha_filter_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_ux_checkbox_alpha_num_filter"] = isset($_REQUEST["ux_checkbox_alpha_num_filter_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_checkbox_digit_filter"] = isset($_REQUEST["ux_checkbox_digit_filter_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_checkbox_strip_tag_filter"] = isset($_REQUEST["ux_checkbox_strip_tag_filter_".$dynamic_Id]) ? "1" : "0";
				$form_settings[$dynamic_Id]["cb_checkbox_trim_filter"] = isset($_REQUEST["ux_checkbox_trim_filter_".$dynamic_Id]) ? "1" : "0";
				
				foreach($form_settings as $element)
				{
					$id = $element["dynamic_id"];
					$control_type = $element["control_type"];
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . create_control_Table() . "(form_id,field_id,column_dynamicId) VALUES(%d,%d,%d)",
								$form_id,
								$control_type,
								$id
							)
						);
						echo $dynamic_control_id=$wpdb->insert_id;
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . create_control_Table() . " SET `sorting_order` = %d where form_id = %d and field_id = %d and column_dynamicId = %d",
								$dynamic_control_id,
								$form_id,
								$control_type,
								$id
							)
						);
					}
					else
					{
						$sql= "";
					}
					foreach($element as $key => $value)
					{
						if($key == "dynamic_id" || $key == "control_type")
						{
							continue;
						}
						else
						{
							if($event == "add")
							{
								$sql[] = '('.$dynamic_control_id.',"'.$key.'", "'.$value.'")';
							}
							else
							{
								$sql .= 'WHEN `dynamic_settings_key` = "'.$key.'" THEN "'.$value.'"';
							}
						}
					}
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . contact_bank_dynamic_settings_form() . "(dynamicId,dynamic_settings_key,dynamic_settings_value) VALUES ".implode(',', $sql),""
							)
						);
					}
					else
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . contact_bank_dynamic_settings_form() . " SET `dynamic_settings_value` = CASE ".$sql . " END where dynamicId = %d ",
								$controlId
							)
						);
					}
				}
				die();
			break;
			
			case "save_email_control":
				
				$dynamic_Id = intval($_REQUEST["ux_hd_textbox_dynamic_id"]);
				$form_id = intval($_REQUEST["form_id"]);
				$event = esc_attr($_REQUEST["event"]);
				$controlId = isset($_REQUEST["controlId"]) ? intval($_REQUEST["controlId"]) : 0;
				$form_settings = isset($_REQUEST["form_settings"]) ? json_decode(stripcslashes($_REQUEST["form_settings"]),true) : array();
				$form_settings[$dynamic_Id]["dynamic_id"] = $dynamic_Id;
				$form_settings[$dynamic_Id]["control_type"] = "3";
				$form_settings[$dynamic_Id]["cb_label_value"] = isset($_REQUEST["ux_label_text_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_label_text_".$dynamic_Id]) : "Email";
				$form_settings[$dynamic_Id]["cb_description"] = isset($_REQUEST["ux_description_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_description_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_control_required"] = isset($_REQUEST["ux_required_control_radio_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_required_control_radio_".$dynamic_Id]) : "1";
				$form_settings[$dynamic_Id]["cb_tooltip_txt"] = isset($_REQUEST["ux_tooltip_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_tooltip_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_default_txt_val"] = isset($_REQUEST["ux_default_value_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_default_value_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_admin_label"] = isset($_REQUEST["ux_default_value_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_admin_label_".$dynamic_Id]) : "Email";
				$form_settings[$dynamic_Id]["cb_show_email"] = isset($_REQUEST["ux_show_email_".$dynamic_Id]) ? "1" : "0";
					
				foreach($form_settings as $element)
				{
					$id = $element["dynamic_id"];
					$control_type = $element["control_type"];
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . create_control_Table() . "(form_id,field_id,column_dynamicId) VALUES(%d,%d,%d)",
								$form_id,
								$control_type,
								$id
							)
						);
						echo $dynamic_control_id=$wpdb->insert_id;
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . create_control_Table() . " SET `sorting_order` = %d where form_id = %d and field_id = %d and column_dynamicId = %d",
								$dynamic_control_id,
								$form_id,
								$control_type,
								$id
							)
						);
					}
					else
					{
						$sql= "";
					}
					foreach($element as $key => $value)
					{
						if($key == "dynamic_id" || $key == "control_type")
						{
							continue;
						}
						else
						{
							if($event == "add")
							{
								$sql[] = '('.$dynamic_control_id.',"'.$key.'", "'.$value.'")';
							}
							else
							{
								$sql .= 'WHEN `dynamic_settings_key` = "'.$key.'" THEN "'.$value.'"';
							}
						}
					}
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . contact_bank_dynamic_settings_form() . "(dynamicId,dynamic_settings_key,dynamic_settings_value) VALUES ".implode(',', $sql),""
							)
						);
					}
					else
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . contact_bank_dynamic_settings_form() . " SET `dynamic_settings_value` = CASE ".$sql . " END where dynamicId = %d ",
								$controlId
							)
						);
					}
				}
				die();
			break;
			
			case "save_drop_down_control":
				
				$dynamic_Id = intval($_REQUEST["ux_hd_textbox_dynamic_id"]);
				$form_id = intval($_REQUEST["form_id"]);
				$event = esc_attr($_REQUEST["event"]);
				$controlId = isset($_REQUEST["controlId"]) ? intval($_REQUEST["controlId"]) : 0;
				$form_settings = isset($_REQUEST["form_settings"]) ? json_decode(stripcslashes($_REQUEST["form_settings"]),true) : array();
				$ddl_options_id = isset($_REQUEST["ddl_options_id"]) ? json_decode(stripcslashes($_REQUEST["ddl_options_id"]),true) : array();
				$options_value = isset($_REQUEST["options_value"]) ? json_decode(stripcslashes($_REQUEST["options_value"]),true) : array();
				$form_settings[$dynamic_Id]["dynamic_id"] = $dynamic_Id;
				$form_settings[$dynamic_Id]["control_type"] = "4";
				$form_settings[$dynamic_Id]["cb_label_value"] = isset($_REQUEST["ux_label_text_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_label_text_".$dynamic_Id]) :"Untitled";
				$form_settings[$dynamic_Id]["cb_control_required"] = isset($_REQUEST["ux_required_control_radio_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_required_control_radio_".$dynamic_Id]) : "0";
				$form_settings[$dynamic_Id]["cb_tooltip_txt"] = isset($_REQUEST["ux_tooltip_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_tooltip_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_admin_label"] = isset($_REQUEST["ux_admin_label_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_admin_label_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_show_email"] = isset($_REQUEST["ux_show_email_".$dynamic_Id]) ? "1" : "0";
					
				$options = serialize($ddl_options_id);
				$options_val = serialize($options_value);
				$form_settings[$dynamic_Id]["cb_dropdown_option_id"] = str_replace('"','\"',"$options");
				$form_settings[$dynamic_Id]["cb_dropdown_option_val"] = str_replace('"','\"',"$options_val");
				foreach($form_settings as $element)
				{
					$id = $element["dynamic_id"];
					$control_type = $element["control_type"];
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . create_control_Table() . "(form_id,field_id,column_dynamicId) VALUES(%d,%d,%d)",
								$form_id,
								$control_type,
								$id
							)
						);
						echo $dynamic_control_id=$wpdb->insert_id;
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . create_control_Table() . " SET `sorting_order` = %d where form_id = %d and field_id = %d and column_dynamicId = %d",
								$dynamic_control_id,
								$form_id,
								$control_type,
								$id
							)
						);
					}
					else
					{
						$sql= "";
					}
					foreach($element as $key => $value)
					{
						if($key == "dynamic_id" || $key == "control_type")
						{
							continue;
						}
						else
						{
							if($event == "add")
							{
								$sql[] = '('.$dynamic_control_id.',"'.$key.'", "'.$value.'")';
							}
							else {
								$sql .= 'WHEN `dynamic_settings_key` = "'.$key.'" THEN "'.$value.'"';
							}
						}
					}
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . contact_bank_dynamic_settings_form() . "(dynamicId,dynamic_settings_key,dynamic_settings_value) VALUES ".implode(',', $sql),""
							)
						);
					}
					else
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . contact_bank_dynamic_settings_form() . " SET `dynamic_settings_value` = CASE ".$sql . " END where dynamicId = %d ",
								$controlId
							)
						);
					}
				}
				die();
			break;
			
			case "save_check_box_control":
				
				$dynamic_Id = intval($_REQUEST["ux_hd_textbox_dynamic_id"]);
				$form_id = intval($_REQUEST["form_id"]);
				$event = esc_attr($_REQUEST["event"]);
				$controlId = isset($_REQUEST["controlId"]) ? intval($_REQUEST["controlId"]) : 0;
				$form_settings = isset($_REQUEST["form_settings"]) ? json_decode(stripcslashes($_REQUEST["form_settings"]),true) : array();
				$ddl_options_id = isset($_REQUEST["ddl_options_id"]) ? json_decode(stripcslashes($_REQUEST["ddl_options_id"]),true) : array();
				$options_value = isset($_REQUEST["options_value"]) ? json_decode(stripcslashes($_REQUEST["options_value"]),true) : array();
				$form_settings[$dynamic_Id]["dynamic_id"] = $dynamic_Id;
				$form_settings[$dynamic_Id]["control_type"] = "5";
				$form_settings[$dynamic_Id]["cb_label_value"] = isset($_REQUEST["ux_label_text_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_label_text_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_control_required"] = isset($_REQUEST["ux_required_control_radio_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_required_control_radio_".$dynamic_Id]) : "0";
				$form_settings[$dynamic_Id]["cb_tooltip_txt"] = isset($_REQUEST["ux_tooltip_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_tooltip_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_admin_label"] = isset($_REQUEST["ux_admin_label_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_admin_label_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_show_email"] = isset($_REQUEST["ux_show_email_".$dynamic_Id]) ? "1" : "0";
				$options = serialize($ddl_options_id);
				$options_val = serialize($options_value);
				$form_settings[$dynamic_Id]["cb_checkbox_option_id"] = str_replace('"','\"',"$options");
				$form_settings[$dynamic_Id]["cb_checkbox_option_val"] = str_replace('"','\"',"$options_val");
				foreach($form_settings as $element)
				{
					$id = $element["dynamic_id"];
					$control_type = $element["control_type"];
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . create_control_Table() . "(form_id,field_id,column_dynamicId) VALUES(%d,%d,%d)",
								$form_id,
								$control_type,
								$id
							)
						);
						echo $dynamic_control_id=$wpdb->insert_id;
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . create_control_Table() . " SET `sorting_order` = %d where form_id = %d and field_id = %d and column_dynamicId = %d",
								$dynamic_control_id,
								$form_id,
								$control_type,
								$id
							)
						);
					}
					else {
						$sql= "";
					}
					foreach($element as $key => $value)
					{
						if($key == "dynamic_id" || $key == "control_type")
						{
							continue;
						}
						else
						{
							if($event == "add")
							{
								$sql[] = '('.$dynamic_control_id.',"'.$key.'", "'.$value.'")';
							}
							else
							{
								$sql .= 'WHEN `dynamic_settings_key` = "'.$key.'" THEN "'.$value.'"';
							}
						}
					}
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . contact_bank_dynamic_settings_form() . "(dynamicId,dynamic_settings_key,dynamic_settings_value) VALUES ".implode(',', $sql),""
							)
						);
					}
					else
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . contact_bank_dynamic_settings_form() . " SET `dynamic_settings_value` = CASE ".$sql . " END where dynamicId = %d ",
								$controlId
							)
						);
					}
				}
				die();
			break;
			case "save_multiple_control":
				$dynamic_Id = intval($_REQUEST["ux_hd_textbox_dynamic_id"]);
				$form_id = intval($_REQUEST["form_id"]);
				$event = esc_attr($_REQUEST["event"]);
				$controlId = isset($_REQUEST["controlId"]) ? intval($_REQUEST["controlId"]) : 0;
				$form_settings = isset($_REQUEST["form_settings"]) ? json_decode(stripcslashes($_REQUEST["form_settings"]),true) : array();
				$ddl_options_id = isset($_REQUEST["ddl_options_id"]) ? json_decode(stripcslashes($_REQUEST["ddl_options_id"]),true) : array();
				$options_value = isset($_REQUEST["options_value"]) ? json_decode(stripcslashes($_REQUEST["options_value"]),true) : array();
				$form_settings[$dynamic_Id]["dynamic_id"] = $dynamic_Id;
				$form_settings[$dynamic_Id]["control_type"] = "6";
				$form_settings[$dynamic_Id]["cb_label_value"] = isset($_REQUEST["ux_label_text_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_label_text_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_control_required"] = isset($_REQUEST["ux_required_control_radio_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_required_control_radio_".$dynamic_Id]) : "0";
				$form_settings[$dynamic_Id]["cb_tooltip_txt"] = isset($_REQUEST["ux_tooltip_control_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_tooltip_control_".$dynamic_Id]) : "";
				$form_settings[$dynamic_Id]["cb_admin_label"] = isset($_REQUEST["ux_admin_label_".$dynamic_Id]) ? esc_attr($_REQUEST["ux_admin_label_".$dynamic_Id]) : "Untitled";
				$form_settings[$dynamic_Id]["cb_show_email"] = isset($_REQUEST["ux_show_email_".$dynamic_Id]) ? "1" : "0";
				$options = serialize($ddl_options_id);
				$options_val = serialize($options_value);
				$form_settings[$dynamic_Id]["cb_radio_option_id"] = str_replace('"','\"',"$options");
				$form_settings[$dynamic_Id]["cb_radio_option_val"] = str_replace('"','\"',"$options_val");
					
				foreach($form_settings as $element)
				{
					$id = $element["dynamic_id"];
					$control_type = $element["control_type"];
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . create_control_Table() . "(form_id,field_id,column_dynamicId) VALUES(%d,%d,%d)",
								$form_id,
								$control_type,
								$id
							)
						);
						echo $dynamic_control_id=$wpdb->insert_id;
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . create_control_Table() . " SET `sorting_order` = %d where form_id = %d and field_id = %d and column_dynamicId = %d",
								$dynamic_control_id,
								$form_id,
								$control_type,
								$id
							)
						);
					}
					else {
						$sql= "";
					}
					foreach($element as $key => $value)
					{
						if($key == "dynamic_id" || $key == "control_type")
						{
							continue;
						}
						else
						{
							if($event == "add")
							{
								$sql[] = '('.$dynamic_control_id.',"'.$key.'", "'.$value.'")';
							}
							else
							{
								$sql .= 'WHEN `dynamic_settings_key` = "'.$key.'" THEN "'.$value.'"';
							}
						}
					}
					if($event == "add")
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"INSERT INTO " . contact_bank_dynamic_settings_form() . "(dynamicId,dynamic_settings_key,dynamic_settings_value) VALUES ".implode(',', $sql),""
							)
						);
					}
					else
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE " . contact_bank_dynamic_settings_form() . " SET `dynamic_settings_value` = CASE ".$sql . " END where dynamicId = %d ",
								$controlId
							)
						);
					}
				}
				die();
			break;
			
			case "":
				
				$form_id = intval($_REQUEST["form_id"]);
				$field_dynamic_id = isset($_REQUEST["field_dynamic_id"]) ? json_decode(stripcslashes($_REQUEST["field_dynamic_id"]),true) : array();
				$sql= "";
				foreach($field_dynamic_id as $key => $val)
				{
					$sql .= ' WHEN `column_dynamicId` = "'.$val.'" THEN "'.$key.'"';
				}
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE " . create_control_Table() . " SET `sorting_order` = CASE " . $sql . " END where form_id = %d ",
						$form_id
					)
				);
				die();
			break;
			
			case "update_option":
				
				update_option("contact-bank-info-popup", "no");
				die();
			break;
			
			case "form_fields_sorting_order":
				
				$form_id = intval($_REQUEST["form_id"]);
				$field_dynamic_id = isset($_REQUEST["field_dynamic_id"]) ? json_decode(stripcslashes($_REQUEST["field_dynamic_id"]),true) : array();
				$sql= "";
				foreach($field_dynamic_id as $key => $val)
				{
					$sql .= ' WHEN `column_dynamicId` = "'.$val.'" THEN "'.$key.'"';
				}
				$wpdb->query
				(
						$wpdb->prepare
						(
								"UPDATE " . create_control_Table() . " SET `sorting_order` = CASE " . $sql . " END where form_id = %d ",
								$form_id
						)
				);
				die();
			break;
			
			case "contact_plugin_updates":
				
				$contact_updates = intval($_REQUEST["contact_updates"]);
				update_option("contact-bank-automatic_update",$contact_updates);
				die();
			break;
		}
	}
}
?>