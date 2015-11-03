<?php
	global $wpdb;
	$sql = "DROP TABLE " .contact_bank_contact_form();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .create_control_Table();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .contact_bank_dynamic_settings_form();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .contact_bank_email_template_admin();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .frontend_controls_data_Table();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .contact_bank_frontend_forms_Table();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .contact_bank_form_settings_Table();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .contact_bank_layout_settings_Table();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .contact_bank_licensing();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .contact_bank_roles_capability();
	$wpdb->query($sql);
	
	delete_option("contact-bank-info-popup");
	delete_option("contact-bank-version-number");
	delete_option("contact-bank-automatic_update");
?>