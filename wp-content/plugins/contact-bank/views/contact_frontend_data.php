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
<form id="" class="layout-form">
	<div id="poststuff" style="width: 99% !important;">
		<div id="post-body" class="metabox-holder">
			<div id="postbox-container" class="postbox-container">
				<div id="advanced" class="meta-box-sortables">
					<div id="contact_bank_get_started" class="postbox" >
						<div class="handlediv" data-target="#ux_form_entries_div" title="Click to toggle" data-toggle="collapse"><br></div>
						<h3 class="hndle"><span><?php _e( "Form Entries", contact_bank ); ?></span></h3>
						<div class="inside">
							<div id="ux_form_entries_div" class="contact_bank_layout">
								<a class="btn btn-info" href="admin.php?page=contact_dashboard"><?php _e("Back to Dashboard", contact_bank);?></a>
								<a class="btn btn-info" id="export" ><?php _e("Export to Excel", contact_bank);?></a>
								<div class="separator-doubled"></div>
								<div class="fluid-layout">
									<div class="layout-span12">
										<div class="widget-layout">
											<div class="widget-layout-title">
												<h4><?php _e( "Form", contact_bank ); ?></h4>
											</div>
											<div class="widget-layout-body" >
												<div class="fluid-layout">
													<div class="layout-control-group">
														<label class="layout-control-label"><?php _e( "Select Form", contact_bank ); ?> :</label>
														<div class="layout-controls">	
															<?php
															global $wpdb;
															$form_data = $wpdb->get_results
															(
																"SELECT * FROM " .contact_bank_contact_form()
															);
															?>
															<select class=" layout-span12" id="select_form" name="select_form" onchange="select_form_id();">
																<option value="0"><?php _e("Select Form",contact_bank); ?></option>
																<?php
																for($flag=0;$flag<count($form_data);$flag++)
																{
																	if(isset($_REQUEST["form_id"]) && intval($_REQUEST["form_id"]) == $form_data[$flag]->form_id)
																	{
																		?>
																		<option value="<?php echo $form_data[$flag]->form_id ;?>" selected="selected"><?php echo $form_data[$flag]->form_name ;?></option>
																		<?php
																	}
																	else
																	{
																		?>
																		<option value="<?php echo $form_data[$flag]->form_id ;?>"><?php echo $form_data[$flag]->form_name ;?></option>
																		<?php
																	}
																}
																?>
															</select>
														</div>
													</div>
												</div>
												<div id="ux_frontend_data_postback" style="overflow-x: auto;overflow-y: hidden;padding-bottom: 1%;margin-top:10px;"></div>
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
	select_form_id();
	
			function exportTableToCSV(table, filename) 
			{
	
			var rows = table.find('tr:has(td)'),
				csv = "";
	            tmpColDelim = String.fromCharCode(11),
	            tmpRowDelim = String.fromCharCode(0), 
				colDelim = '","',
	            rowDelim = '"\r\n"',
					csv = '"' + rows.map(function (i, row) {
	            	var row = jQuery(row),
	                    cols = row.find('td'); 
					return cols.map(function (j, col) {
	                    var col = jQuery(col),
	                        text = col.text();
	
	                    return text.replace('"', '""');
	
	                }).get().join(tmpColDelim);
	
	            }).get().join(tmpRowDelim)
	            	
	                .split(tmpRowDelim).join(rowDelim)
	                .split(tmpColDelim).join(colDelim) + '"',
					csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
			
	        jQuery(this)
	            .attr({
	            'download': filename,
	                'href': csvData,
	                'target': '_blank'
	        });
	    }
		jQuery("#export").on('click', function (event) 
	    {
	    	var form_id = jQuery("#select_form").val();
	    	if(form_id != 0)
			{
				exportTableToCSV.apply(this, [jQuery('#data-table-frontend'), 'Form Entries.csv']);
			}
			else
			{
				alert("<?php _e( "Please select the Form first.", contact_bank ); ?>");
			}
	    });
	
	
});
function select_form_id()
{
	var form_id = jQuery("#select_form").val();
	if(form_id != 0)
	{
		jQuery.post(ajaxurl, "form_id="+form_id+"&param=frontend_form_data&action=frontend_data_contact_library", function(data)
		{
			if(jQuery('#data-table-frontend').length > 0)
			{
				oTable = jQuery('#data-table-frontend').dataTable();
				oTable.fnDestroy();
				jQuery("#ux_frontend_data_postback").empty();
				
				jQuery("#ux_frontend_data_postback").append(data);
				jQuery(".fluid-layout .table thead th").css('vertical-align','top');
				oTable.fnDraw();
			}
			else
			{
				jQuery("#ux_frontend_data_postback").append(data);
				jQuery(".fluid-layout .table thead th").css('vertical-align','top');
			}
		});
	}
}
function delete_form_entry()
{
	alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
}






</script>
<?php 
}
?>