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
		if($_REQUEST["param"] == "frontend_form_data")
		{
			$form_id = intval($_REQUEST["form_id"]);
			$form_data = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"SELECT * FROM " .create_control_Table()." WHERE form_id = %d ORDER BY sorting_order ASC",
					$form_id
				)
			);
			?>
			<div id="dvData">
			<table class="table table-striped" id="data-table-frontend" style="width:100%;">
				<thead>
					<tr>
					<?php
					for($flag=0;$flag<count($form_data);$flag++)
					{
						$form_control_labels = $wpdb->get_var
						(
							$wpdb->prepare
							(
								"SELECT dynamic_settings_value FROM " .contact_bank_dynamic_settings_form()." WHERE dynamicId = %d AND dynamic_settings_key = %s",
								$form_data[$flag]->control_id,
								"cb_label_value"
							)
						);
					?>
					<td><?php echo $form_control_labels ?></td>
					<?php
					}
					?>
					<td></td>
					</tr>
				</thead>
				<tbody>
					<?php
						$form_submit_count = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT * FROM ".contact_bank_frontend_forms_Table()." WHERE form_id = %d",
								$form_id
							)
						);
						for($flag1=0;$flag1<count($form_submit_count);$flag1++)
						{
							?>
							<tr>
							<?php
								for($flag2=0;$flag2<count($form_data);$flag2++)
								{
									$form_control_labels_values = $wpdb->get_var
									(
										$wpdb->prepare
										(
											"SELECT dynamic_frontend_value FROM " .frontend_controls_data_Table()." WHERE dynamic_control_id = %d AND form_id = %d AND form_submit_id = %d",
											$form_data[$flag2]->control_id,
											$form_id,
											$form_submit_count[$flag1]->submit_id
										)
									);
									if($form_data[$flag2]->field_id == 5)
									{
										if($form_control_labels_values != "")
										{
											$chk_options =  str_replace("-",", ", $form_control_labels_values);
											?>
											<td><?php echo $chk_options; ?></td>
											<?php
										}
										else
										{
											?>
											<td ></td>
											<?php
										}
									}
									
									else 
									{
										?>
										<td ><?php echo $form_control_labels_values; ?></td>
										<?php
									}
								}
							?>
							<td style="vertical-align: middle;">
								<a herf="#" onclick="delete_form_entry()" class="btn hovertip" data-original-title="<?php _e("Delete Form Entry",contact_bank)?>">
									<i class="icon-trash"></i>
								</a>
							</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
			</div>
			<script type="text/javascript">
				oTable = jQuery('#data-table-frontend').dataTable
				({
					"bJQueryUI": false,
					"bAutoWidth": true,
					"sPaginationType": "full_numbers",
					"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
					"oLanguage":
					{
						"sLengthMenu": "<span>Show entries:</span> _MENU_"
					},
					"aaSorting": [[ 0, "asc" ]]
				});
				
			</script> 
			<?php
			die();
		}
	}
}
?>