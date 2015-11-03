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
	$last_form_id = $wpdb->get_var
	(
		"SELECT form_id FROM " .contact_bank_contact_form(). " order by form_id desc limit 1"
	);
	$contact_id = count($last_form_id) == 0 ? 1 : $last_form_id + 1;
	?>
	<form id="frmdashboard" class="layout-form">
		<div id="poststuff" style="width: 99% !important;">
			<div id="post-body" class="metabox-holder">
				<div id="postbox-container-2" class="postbox-container">
					<div id="advanced" class="meta-box-sortables">
						<div id="contact_bank_get_started" class="postbox" >
							<div class="handlediv" data-target="#ux_shortcode" title="Click to toggle" data-toggle="collapse"><br></div>
							<h3 class="hndle"><span><?php _e("Contact Bank Short-Codes", contact_bank); ?></span></h3>
							<div class="inside">
								<div id="ux_dashboard" class="contact_bank_layout">
									<?php
									$form_count = $wpdb->get_var
									(
										"SELECT count(form_id) FROM ".contact_bank_contact_form()
									);
									if($form_count < 2)
									{
										?>
											<a class="btn btn-info"
												href="admin.php?page=contact_bank&form_id=<?php echo $contact_id; ?>"><?php _e("Add New Form", contact_bank); ?>
											</a>
										<?php
									}
									?>
									<a class="btn btn-info" href="#"
													onclick="delete_forms();"><?php _e("Delete All Forms", contact_bank); ?>
									</a>
									<a class="btn btn-danger" href="#"
										onclick="restore_factory_settings();"><?php _e("Restore Factory Settings", contact_bank); ?>
									</a>
									<div class="separator-doubled" style="margin-bottom: 5px;"></div>
									<a rel="prettyPhoto[contact]"  href="<?php echo plugins_url("/assets/images/how-to-setup-short-code-cb.png" , dirname(__FILE__));?>">How to setup Short-Codes for Contact Bank into your WordPress Page/Post?</a>
									<div class="fluid-layout">
										<div class="layout-span12" >
											<div class="widget-layout">
												<div class="widget-layout-title">
													<h4>
														<?php _e("Form", contact_bank); ?>
													</h4>
												</div>
												<div class="widget-layout-body">
													<table class="table table-striped" id="data-table-form">
														<thead>
														<tr>
															<th style="width: 15%"><?php _e("Form", contact_bank); ?></th>
															<th style="width: 30%"><?php _e("Shortcode", contact_bank); ?></th>
															<th style="width: 15%"><?php _e("Total Controls", contact_bank); ?></th>
															<th style="width: 45%" style="padding-left: 5%;"></th>
														</tr>
														</thead>
														<tbody>
														<?php
														global $wpdb;
														$form_data = $wpdb->get_results
														(
															"SELECT * FROM " . contact_bank_contact_form()
														);
														for ($flag = 0; $flag < count($form_data); $flag++) 
														{
															$total_control = $wpdb->get_var
															(
																$wpdb->prepare
																(
																	" SELECT count(" . contact_bank_contact_form() . ".form_id) FROM " . contact_bank_contact_form() . " JOIN ". create_control_Table() . " ON " . create_control_Table() .".form_id = ".contact_bank_contact_form(). 
																	".form_id WHERE " . contact_bank_contact_form() . ".form_id = %d",
																	$form_data[$flag]->form_id
																)
															);
															?>
															<tr>
																<td>
																	<?php echo $form_data[$flag]->form_name; ?>
																</td>
																<td>
																	<?php echo "[contact_bank form_id=" . $form_data[$flag]->form_id . "]"; ?>
																</td>
																<td>
																	<?php echo $total_control;?>
																</td>
																<td>
																	<a href="admin.php?page=contact_bank&form_id=<?php echo $form_data[$flag]->form_id; ?>"
																					class="btn hovertip"
																					data-original-title="<?php _e("Edit Form", contact_bank) ?>">
																					<i class="icon-pencil"></i>
																	</a>
																	<a href="admin.php?page=contact_layout_settings&form_id=<?php echo $form_data[$flag]->form_id; ?>"
																		class="btn hovertip"
																		data-original-title="<?php _e("Global Settings", contact_bank) ?>">
																		<i class="icon-wrench"></i>
																	</a>
																	<a href="admin.php?page=contact_email&form_id=<?php echo $form_data[$flag]->form_id; ?>"
																		class="btn hovertip"
																		data-original-title="<?php _e("Email Settings", contact_bank) ?>">
																		<i class="icon-envelope"></i>
																	</a>
																	<a href="admin.php?page=contact_frontend_data&form_id=<?php echo $form_data[$flag]->form_id; ?>"
																		class="btn hovertip"
																		data-original-title="<?php _e("Form Entries", contact_bank) ?>">
																		<i class="icon-tasks"></i>
																	</a>
																	<a href="admin.php?page=form_preview&form_id=<?php echo $form_data[$flag]->form_id; ?>"
																		class="btn hovertip"
																		data-original-title="<?php _e("Form Preview", contact_bank) ?>">
																		<i class="icon-eye-open"></i>
																	</a>
																	<a herf="#" onclick="delete_form(<?php echo $form_data[$flag]->form_id; ?>);"
																	class="btn hovertip"
																	data-original-title="<?php _e("Delete Form", contact_bank) ?>">
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
	</form>
	<script type="text/javascript">
		
		jQuery(document).ready(function()
		{

			jQuery("a[rel^=\"prettyPhoto\"]").prettyPhoto
			({
				animation_speed: 1000, 
				slideshow: 4000, 
				autoplay_slideshow: false,
				opacity: 0.80, 
				show_title: false,
				allow_resize: true
			});	
		});
		oTable = jQuery("#data-table-form").dataTable
		({
			"bJQueryUI": false,
			"bAutoWidth": true,
			"sPaginationType": "full_numbers",
			"sDom": "<\"datatable-header\"fl>t<\"datatable-footer\"ip>",
			"oLanguage": {
			"sLengthMenu": "<span>Show entries:</span> _MENU_"
			},
			"aaSorting": [
				[ 0, "asc" ]
			],
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [2] }
			]
		});
		function delete_form(form_Id) {
			var check_str = confirm("<?php _e( "Are you sure, you want to delete this Form?", contact_bank ); ?>");
			if (check_str == true)
			{
				jQuery.post(ajaxurl, "id=" + form_Id + "&param=delete_form&action=add_contact_form_library", function (data)
				{
					location.reload();
				});
			}
		}
		function delete_forms() {
			var checkstr = confirm("<?php _e( "Are you sure, you want to delete all Forms?", contact_bank ); ?>");
			if (checkstr == true) 
			{
				jQuery.post(ajaxurl, "param=delete_forms&action=add_contact_form_library", function (data) {
				location.reload();
				});
			}
		}
		function restore_factory_settings() {
			alert("<?php _e("This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
		}
		function close_popup()
		{
			jQuery( "#contact_bank_popup" ).dialog( "close" );
			jQuery.post(ajaxurl, "param=update_option&action=add_new_album_library", function()
			{
			}); 
		}
	</script>
<?php 
}
?>