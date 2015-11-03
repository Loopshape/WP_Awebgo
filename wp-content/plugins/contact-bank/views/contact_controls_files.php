<?php
global $wpdb,$current_user,$cb_user_role_permission;
if (is_super_admin())
{
	$cb_role = "administrator";
}
else
{
	$cb_role = $wpdb->prefix . "capabilities";
	$current_user->role = array_keys($current_user->$cb_role);
	$cb_role = $current_user->role[0];
}

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

<div class="layout-control-group div_border" id="div_1_1" style="display: none;">
	<label class="layout-control-label" id="control_label_">
		<?php _e("Untitled", contact_bank); ?> :
	</label>
	<div class="layout-controls hovertip" id="show_tooltip">
		<input class="layout-span7" type="text" id="ux_txt_textbox_control_" name="ux_txt_textbox_control_"/>
		<a class="btn btn-info inline delete_control" id="add_setting_control_" href="#setting_controls_postback">
			<?php _e("Settings", contact_bank); ?>
		</a>
		<a style="cursor:pointer;" id="anchor_del_">
			<img class="delete_control" src="<?php echo plugins_url("/assets/images/delete-bg.png" , dirname(__FILE__));?>"/>
		</a>
		<br/>
		<span class="span-description" id="txt_description_"></span>
	</div>
</div>
<div class="layout-control-group div_border" id="div_2_2" style="display: none;">
	<label class="layout-control-label" id="control_label_">
		<?php _e("Untitled", contact_bank); ?> :
	</label>
	<div class="layout-controls hovertip" id="show_tooltip">
		<textarea type="textarea" class="layout-span7" id="ux_textarea_control_" name="ux_textarea_control_"></textarea>
		<a class="btn btn-info inline delete_control" id="add_setting_control_" href="#setting_controls_postback">
			<?php _e("Settings", contact_bank); ?>
		</a>
		<a style="cursor:pointer;" id="anchor_del_">
			<img class="delete_control" src="<?php echo plugins_url("/assets/images/delete-bg.png" , dirname(__FILE__));?>"/>
		</a>
		<br/>
		<span class="span-description" id="txt_description_"></span>
	</div>
</div>
<div class="layout-control-group div_border" id="div_3_3" style="display: none;">
	<label class="layout-control-label" id="control_label_">
		<?php _e("Email", contact_bank); ?> :
		<span id="txt_required_" class="error">*</span>
	</label>
	<div class="layout-controls hovertip" id="show_tooltip">
		<input type="text" class="layout-span7" id="ux_txt_email_" name="ux_txt_email_"/>
		<a class="btn btn-info inline delete_control" id="add_setting_control_" href="#setting_controls_postback">
			<?php _e("Settings", contact_bank); ?>
		</a>
		<a style="cursor:pointer;" id="anchor_del_">
			<img class="delete_control" src="<?php echo plugins_url("/assets/images/delete-bg.png" , dirname(__FILE__));?>"/>
		</a>
		<br/>
		<span class="span-description" id="txt_description_"></span>
	</div>
</div>
<div class="layout-control-group div_border" id="div_4_4" style="display: none;">
	<label class="layout-control-label" id="control_label_">
		<?php _e("Untitled", contact_bank); ?> :
	</label>
	<div class="layout-controls hovertip" id="show_tooltip">
		<select type="select" class="layout-span7" id="ux_ddl_select_control" name="ux_ddl_select_control">
			<option value="0"><?php _e("Select Option", contact_bank); ?></option>
		</select>
		<a class="btn btn-info inline delete_control" href="#setting_controls_postback" id="add_setting_control_">
			<?php _e("Settings", contact_bank); ?>
		</a>
		<a style="cursor:pointer;" id="anchor_del_">
			<img class="delete_control" src="<?php echo plugins_url("/assets/images/delete-bg.png" , dirname(__FILE__));?>"/>
		</a>
	</div>
</div>
<div class="layout-control-group div_border" id="div_5_5" style="display: none;">
	<label class="layout-control-label" id="control_label_">
		<?php _e("Untitled", contact_bank); ?> :
	</label>
	<div class="layout-controls hovertip" id="post_back_checkbox_" style="padding-top: 5px;">
		<div id="show_tooltip">
			<input type="checkbox" id="ux_chk_checkbox_control_" name="ux_chk_checkbox_control_">
			<span id="add_chk_options_here_"></span>
			<a class="btn btn-info inline delete_control" href="#setting_controls_postback" id="add_setting_control_">
				<?php _e("Settings", contact_bank); ?>
			</a>
			<a style="cursor:pointer;" id="anchor_del_">
				<img class="delete_control" src="<?php echo plugins_url("/assets/images/delete-bg.png" , dirname(__FILE__));?>"/>
			</a>
		</div>
	</div>
</div>
<div class="layout-control-group div_border" id="div_6_6" style="display: none;">
	<label class="layout-control-label" id="control_label_">
		<?php _e("Untitled", contact_bank); ?> :
	</label>
	<div class="layout-controls hovertip" id="post_back_radio_button_">
		<div id="show_tooltip">
			<input type="radio" id="ux_radio_button_control_" name="ux_radio_button_control_"/>
			<span id="add_radio_options_here_"></span>
			<a class="btn btn-info inline delete_control" id="add_setting_control_" href="#setting_controls_postback">
				<?php _e("Settings", contact_bank); ?>
			</a>
			<a style="cursor:pointer;" id="anchor_del_">
				<img class="delete_control" src="<?php echo plugins_url("/assets/images/delete-bg.png" , dirname(__FILE__));?>"/>
			</a>
		</div>
	</div>
</div>
<?php 
}
?>
