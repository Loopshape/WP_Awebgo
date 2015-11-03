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
<form id="contact_bank_pricing" class="layout-form">
	<div id="poststuff" style="width: 99% !important;">
		<div id="post-body" class="metabox-holder">
			<div id="postbox-container" class="postbox-container">
				<div id="advanced" class="meta-box-sortables">
					<div id="contact_bank_get_started" class="postbox" >
						<div class="handlediv" data-target="#ux_contact_email_settings" title="Click to toggle" data-toggle="collapse"><br></div>
						<h3 class="hndle"><span><?php _e( "Email Settings", contact_bank ); ?></span></h3>
						<div class="inside">
							<div id="ux_contact_email_settings" class="contact_bank_layout">
								<a class="btn btn-info" href="admin.php?page=contact_dashboard"><?php _e("Back to Dashboard", contact_bank);?></a>
								<div class="separator-doubled"></div>
								<div class="fluid-layout">
									<div class="layout-control-group span">
										<label class="layout-control-label"><?php _e( "Select Form", contact_bank ); ?> :</label>
										<div class="layout-controls">
											<?php
											global $wpdb;
											$forms = $wpdb->get_results
											(
												"SELECT form_id,form_name FROM " .contact_bank_contact_form()
												
											);
											$email_count = $wpdb->get_var
											(
												"SELECT count(email_id) FROM ".contact_bank_email_template_admin()
											);
											
											?>
											<select class=" layout-span10" id="ux_ddl_select_form" name="ux_ddl_select_form" onchange="select_form();">
												<option value="0"><?php _e("Select Form",contact_bank); ?></option>
											<?php
											for($flag=0;$flag<count($forms);$flag++)
											{
												if(isset($_REQUEST["form_id"]) && intval($_REQUEST["form_id"]) == $forms[$flag]->form_id )
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
											<?php
											if($email_count < 1)
											{
												?>
												<a class="btn btn-info" onclick="add_new_settings();"><?php _e("Add New", contact_bank);?></a>
												<?php
											}
											?>
										</div>
									</div>
									<div class="fluid-layout">
										<div class="layout-span12">
											<div class="widget-layout">
												<div class="widget-layout-title">
													<h4><?php _e( "Email Confirmation", contact_bank ); ?></h4>
												</div>
												<div class="widget-layout-body">
													<table class="table table-striped" id="data-table-email-settings" style="width:100%;">
														<thead>
															<th style="width:40%;">Name</th>
															<th style="width:40%;">Subject</th>
															<th style="width:20%;"></th>
														</thead>
														<tbody id="ux_email_settings_postback">
															
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
	</div>
</form>

<script type="text/javascript">

jQuery(document).ready(function()
{
	select_form();
});

jQuery(".fluid-layout .table thead th").css("vertical-align","top");
function select_form()
{
	var form_id = jQuery("#ux_ddl_select_form").val();
	if(form_id != 0)
	{
		jQuery.post(ajaxurl, "form_id="+form_id+"&param=email_settings&action=email_contact_form_library", function(data)
		{
			var oTable = jQuery("#data-table-email-settings").dataTable();
 			oTable.fnDestroy();
			jQuery("#ux_email_settings_postback").empty();
			jQuery("#ux_email_settings_postback").append(data);
		
			oTable.fnDraw();
		});
	}
	else
	{
		jQuery("#ux_email_settings_postback").empty();
		oTable = jQuery("#data-table-email-settings").dataTable
		({
			"bJQueryUI": false,
			"bAutoWidth": true,
			"bPaginate": false, 
			"bDestroy": true, 
			"sDom": "<\"datatable-header\"fl>t<\"datatable-footer\"ip>",
			"oLanguage": 
			{
				"sLengthMenu": "<span>Show entries:</span> _MENU_"
			},
			"aaSorting": [[ 0, "asc" ]]
		});
 		oTable.fnClearTable();
	}
}
function delete_email_settings(email_id)
{
	var checkstr =  confirm("<?php _e( "Are you sure, you want to delete this Email Setting?", contact_bank ); ?>");
	if(checkstr == true)
	{
		jQuery.post(ajaxurl, "email_id="+email_id+"&param=delete_email_settings&action=email_contact_form_library", function(data)
		{
			location.reload();
		});
	}
}
function add_new_settings()
{
	var form_id = jQuery("#ux_ddl_select_form").val();
	if(form_id != 0)
	{
		window.location.href = "admin.php?page=add_contact_email_settings&form_id="+form_id;
	}
	else
	{
		alert("<?php _e( "Please select the Form first.", contact_bank ); ?>");
	}
}
</script>
<?php 
}
?>