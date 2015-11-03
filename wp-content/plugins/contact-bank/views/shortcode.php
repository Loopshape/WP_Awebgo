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
<form id="shortcode" class="layout-form" method="post">
	<div id="poststuff" style="width: 99% !important;">
		<div id="post-body" class="metabox-holder">
			<div id="postbox-container-2" class="postbox-container">
				<div id="advanced" class="meta-box-sortables">
					<div id="contact_bank_get_started" class="postbox" >
						<div class="handlediv" data-target="#ux_shortcode" title="Click to toggle" data-toggle="collapse"><br></div>
						<h3 class="hndle"><span><?php _e("How to setup Short-Codes for Contact Bank into your WordPress Page/Post?", contact_bank); ?></span></h3>
						<div class="inside">
							<div id="ux_shortcode" class="contact_bank_layout">
								<img src="<?php echo plugins_url("/assets/images/how-to-setup-short-code-cb.png" , dirname(__FILE__));?>" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<?php 
}
?>