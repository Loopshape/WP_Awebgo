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
	<form id="frm_auto_update" class="layout-form">
		<div id="poststuff" style="width: 99% !important;">
			<div id="post-body" class="metabox-holder">
				<div id="postbox-container-2" class="postbox-container">
					<div id="advanced" class="meta-box-sortables">
						<div id="contact_bank_get_started" class="postbox" >
							<h3 class="hndle"><span><?php _e("Plugin Updates", contact_bank); ?></span></h3>
							<div class="inside">
								<div id="ux_dashboard" class="contact_bank_layout">
									<div class="layout-control-group" style="margin: 10px 0 0 0 ;">
										<label class="layout-control-label"><?php _e("Plugin Updates", contact_bank); ?> :</label>
										<div class="layout-controls-radio">
											<?php $contact_updates = get_option("contact-bank-automatic_update");?>
											<input type="radio" name="ux_contact_update" id="ux_enable_update" onclick="contact_bank_autoupdate(this);" <?php echo $contact_updates == "1" ? "checked=\"checked\"" : "";?> value="1"><label style="vertical-align: baseline;"><?php _e("Enable", contact_bank); ?></label>
											<input type="radio" name="ux_contact_update" id="ux_disable_update" onclick="contact_bank_autoupdate(this);" <?php echo $contact_updates == "0" ? "checked=\"checked\"" : "";?> style="margin-left: 10px;" value="0"><label style="vertical-align: baseline;"><?php _e("Disable", contact_bank); ?></label>
										</div>
									</div>
									<div class="layout-control-group" style="margin:10px 0 10px 0 ;">
										<strong><i>This feature allows the plugin to update itself automatically when a new version is available on WordPress Repository.<br/>This allows to stay updated to the latest features. If you would like to disable automatic updates, choose  the disable option above.</i></strong>
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
		function contact_bank_autoupdate(control)
		{
			var contact_updates = jQuery(control).val();
			jQuery.post(ajaxurl, "contact_updates="+contact_updates+"&param=contact_plugin_updates&action=add_contact_form_library", function(data)
			{
			});
		}
	</script>
<?php 
}
?>