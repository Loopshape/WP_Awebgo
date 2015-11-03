
<div class="white_content" id="setting_controls_postback">
</div>
<div class="black_overlay"></div>
<script type="text/javascript">
var array_form_settings = [];
var field_dynamic_id = [];
var array_delete_form_controls = [];
 var form_id = "<?php echo $form_id;?>";
jQuery(document).ready(function()
{
	
	jQuery(window).resize(function()
	{
		var windowHeight =  window.innerHeight - 200;
		var windowWidth =  window.innerWidth - 200;
		var lightboxHeight = jQuery("#setting_controls_postback").height();
		var lightboxWidth = jQuery("#setting_controls_postback").width();
		var proposedTop =  (window.innerHeight - lightboxHeight - 40) / 2 ;
		var proposedLeft =  (window.innerWidth - lightboxWidth - 40) / 2 ;
		jQuery("#setting_controls_postback").css("top",proposedTop + "px");
		jQuery("#setting_controls_postback").css("left",proposedLeft + "px");
	});

	jQuery("#left_block").sortable
	({
		opacity: 0.6,
		cursor: "move",
		update: function()
		{

			var field_dynamic_id = [];
			var order = jQuery("#left_block").sortable("toArray");
			for(var flag=0;flag<order.length;flag++)
			{
				var field_order_str = order[flag].split("div_");
				field_dynamic_id.push(field_order_str[1].split("_")[0]);
			}
			jQuery.post(ajaxurl,"form_id="+form_id+"&field_dynamic_id="+JSON.stringify(field_dynamic_id)+"&param=form_fields_sorting_order&action=add_contact_form_library", function(data)
			{
			});
		}
	});
show_url_control();
});
function enter_admin_label(dynamicId)
{
	var ux_label = jQuery("#ux_label_text_"+dynamicId).val();
	jQuery("#ux_admin_label_"+dynamicId).val(ux_label);
}

function delete_textbox(dynamicId,control_type,control_id)
{
	array_delete_form_controls.push(control_id);
	jQuery("#div_"+dynamicId+"_"+control_type).remove();
}
function add_settings(dynamicId,field_type)
{
	jQuery.post(ajaxurl, "form_id="+form_id+"&dynamicId="+dynamicId+"&field_type="+field_type+"&param=add_settings_div&action=add_contact_form_library", function(data)
	{
		jQuery("#setting_controls_postback").html(data);
		show_Popup();
	});
}
function show_Popup()
{
	jQuery(".black_overlay").css("display","block");
	jQuery(".white_content").css("display","block");
	var windowHeight =  window.innerHeight - 200;
	var windowWidth =  window.innerWidth - 200;
	var anchor = jQuery("<a class=\"closeButtonLightbox\" onclick=\"CloseLightbox();\"></a>");
	jQuery("#setting_controls_postback").append(anchor);
	var lightboxHeight = jQuery("#setting_controls_postback").height();
	var lightboxWidth = jQuery("#setting_controls_postback").width();
	var proposedTop =  (window.innerHeight - lightboxHeight - 40) / 2 ;
	var proposedLeft =  (window.innerWidth - lightboxWidth - 40) / 2 ;
	jQuery("#setting_controls_postback").css("top",proposedTop + "px");
	jQuery("#setting_controls_postback").css("left",proposedLeft + "px");
	jQuery("#setting_controls_postback").fadeIn(200);
}
function CloseLightbox()
{
	jQuery("#setting_controls_postback").css("display","none");
	jQuery(".black_overlay").css("display","none");
	jQuery("#fade").fadeOut(200);
}
function show_url_control()
{
	if(jQuery("#ux_rdl_page").prop("checked") == true)
	{
		jQuery("#div_url").hide();
		jQuery("#div_page").show();
	}
	else
	{
		jQuery("#div_page").hide();
		jQuery("#div_url").show();
	}
}
function create_control(control_type,dynamicId,type)
{
	
    dynamicId = typeof dynamicId !== "undefined" ? dynamicId : Math.floor((Math.random()*100000)+1);
	switch(parseInt(control_type))
	{
		case 1:
			jQuery("#div_1_1").clone(false).attr("id","div_"+dynamicId+"_1").appendTo("#left_block");
			jQuery("#div_"+dynamicId+"_1").children("label").attr("id","control_label_"+dynamicId);
			jQuery("#div_"+dynamicId+"_1").children("div").attr("id","show_tooltip"+dynamicId);
			jQuery("#show_tooltip"+dynamicId ).children("input[type=\"text\"]").attr("id","ux_txt_textbox_control_"+dynamicId);
			jQuery("#show_tooltip"+dynamicId ).children("input[type=\"text\"]").attr("name","ux_txt_textbox_control_"+dynamicId);
			jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("id","add_setting_control_"+dynamicId);
			jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("onclick","add_settings("+dynamicId+",1)");
			jQuery("#show_tooltip"+dynamicId).children("#anchor_del_").attr("id","anchor_del_"+dynamicId);
			jQuery("#show_tooltip"+dynamicId).children("span").attr("id","txt_description_"+dynamicId);
			jQuery("#div_"+dynamicId+"_1").attr("style","display:block");
			
			if(typeof type == "undefined")
			{
				jQuery.post(ajaxurl,"form_id="+form_id+"&ux_hd_textbox_dynamic_id="+dynamicId+"&event=add&param=save_text_control&action=add_contact_form_library", function(data)
				{
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+",1,"+data+");");
				});
			}
			else
			{
				
				jQuery.post(ajaxurl,"form_id="+form_id+"&dynamicId="+dynamicId+"&control_type="+control_type+"&param=bind_text_control&action=show_form_control_data_contact_library", function(data)
				{
					var bind_data = JSON.parse(data);
					jQuery("#control_label_"+dynamicId).html(bind_data[dynamicId].cb_label_value+" :");
                    jQuery("#txt_description_"+dynamicId).html(bind_data[dynamicId].cb_description);
	                jQuery("#show_tooltip"+dynamicId).attr("data-original-title",bind_data[dynamicId].cb_tooltip_txt);
	                jQuery("#ux_txt_textbox_control_"+dynamicId).attr("placeholder",bind_data[dynamicId].cb_default_txt_val);
	                if(bind_data[dynamicId].cb_control_required == "1")
	                {
	                	jQuery("#control_label_"+dynamicId).append("<span class=\"error\">*</span>");
	                }
					var control_id = bind_data[dynamicId].control_id;
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+","+control_type+","+control_id+");");
	           });
			}
			break;
		case 2:
			jQuery("#div_2_2").clone(false).attr("id","div_"+dynamicId+"_2").appendTo("#left_block");
			jQuery("#div_"+dynamicId+"_2").children("label").attr("id","control_label_"+dynamicId);
			jQuery("#div_"+dynamicId+"_2").children("div").attr("id","show_tooltip"+dynamicId);
			jQuery("#show_tooltip"+dynamicId ).children("textarea[type=\"textarea\"]").attr("id","ux_textarea_control_"+dynamicId);
			jQuery("#show_tooltip"+dynamicId ).children("textarea[type=\"textarea\"]").attr("name","ux_textarea_control_"+dynamicId);
			jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("id","add_setting_control_"+dynamicId);
			jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("onclick","add_settings("+dynamicId+",2)");
			jQuery("#show_tooltip"+dynamicId).children("#anchor_del_").attr("id","anchor_del_"+dynamicId);
			jQuery("#show_tooltip"+dynamicId).children("span").attr("id","txt_description_"+dynamicId);
			jQuery("#div_"+dynamicId+"_2").attr("style","display:block");
			
			if(typeof type == "undefined")
			{
				jQuery.post(ajaxurl,"form_id="+form_id+"&ux_hd_textbox_dynamic_id="+dynamicId+"&event=add&param=save_textarea_control&action=add_contact_form_library", function(data)
				{
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+",2,"+data+");");
				});
			}
			else
			{
				jQuery.post(ajaxurl,"form_id="+form_id+"&dynamicId="+dynamicId+"&control_type="+control_type+"&param=bind_text_control&action=show_form_control_data_contact_library", function(data)
				{
					var bind_data = JSON.parse(data);
					jQuery("#control_label_"+dynamicId).html(bind_data[dynamicId].cb_label_value+" :");
	                jQuery("#txt_description_"+dynamicId).html(bind_data[dynamicId].cb_description);
	                jQuery("#show_tooltip"+dynamicId).attr("data-original-title",bind_data[dynamicId].cb_tooltip_txt);
	                jQuery("#ux_textarea_control_"+dynamicId).attr("placeholder",bind_data[dynamicId].cb_default_txt_val);
	                if(bind_data[dynamicId].cb_control_required == "1")
	                {
	                    jQuery("#control_label_"+dynamicId).append("<span class=\"error\">*</span>");
	                }
					var control_id = bind_data[dynamicId].control_id;
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+","+control_type+","+control_id+");");
				});
			}
			break;
        case 3:
            jQuery("#div_3_3").clone(false).attr("id","div_"+dynamicId+"_3").appendTo("#left_block");
            jQuery("#div_"+dynamicId+"_3").children("label").attr("id","control_label_"+dynamicId);
            jQuery("#div_"+dynamicId+"_3").children("div").attr("id","show_tooltip"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("input[type=\"text\"]").attr("id","ux_txt_email_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("input[type=\"text\"]").attr("name","ux_txt_email_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("id","add_setting_control_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("onclick","add_settings("+dynamicId+",3)");
            jQuery("#show_tooltip"+dynamicId).children("#anchor_del_").attr("id","anchor_del_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("span").attr("id","txt_description_"+dynamicId);
            jQuery("#div_"+dynamicId+"_3").attr("style","display:block");
            
            if(typeof type == "undefined")
			{
				jQuery.post(ajaxurl,"form_id="+form_id+"&ux_hd_textbox_dynamic_id="+dynamicId+"&event=add&param=save_email_control&action=add_contact_form_library", function(data)
				{
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+",3,"+data+");");
				});
			}
			else
			{
				jQuery.post(ajaxurl,"form_id="+form_id+"&dynamicId="+dynamicId+"&control_type="+control_type+"&param=bind_text_control&action=show_form_control_data_contact_library", function(data)
				{
					var bind_data = JSON.parse(data);
					jQuery("#control_label_"+dynamicId).html(bind_data[dynamicId].cb_label_value+" :");
	                jQuery("#txt_description_"+dynamicId).html(bind_data[dynamicId].cb_description);
	                jQuery("#show_tooltip"+dynamicId).attr("data-original-title",bind_data[dynamicId].cb_tooltip_txt);
	                jQuery("#ux_txt_email_"+dynamicId).attr("placeholder",bind_data[dynamicId].cb_default_txt_val);
	                if(bind_data[dynamicId].cb_control_required == "1")
	                {
	                    jQuery("#control_label_"+dynamicId).append("<span class=\"error\">*</span>");
	                }
	                var control_id = bind_data[dynamicId].control_id;
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+","+control_type+","+control_id+");");
				});
			}
            break;
        case 4:
            jQuery("#div_4_4").clone(false).attr("id","div_"+dynamicId+"_4").appendTo("#left_block");
            jQuery("#div_"+dynamicId+"_4").children("label").attr("id","control_label_"+dynamicId);
            jQuery("#div_"+dynamicId+"_4").children("div").attr("id","show_tooltip"+dynamicId);
            jQuery("#show_tooltip"+dynamicId ).children("select[type=\"select\"]").attr("id","ux_ddl_select_control"+dynamicId);
            jQuery("#show_tooltip"+dynamicId ).children("select[type=\"select\"]").attr("name","ux_ddl_select_control"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("id","add_setting_control_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("onclick","add_settings("+dynamicId+",4)");
            jQuery("#show_tooltip"+dynamicId).children("#anchor_del_").attr("id","anchor_del_"+dynamicId);
            jQuery("#div_"+dynamicId+"_4").attr("style","display:block");
            
            if(typeof type == "undefined")
			{
				jQuery.post(ajaxurl,"form_id="+form_id+"&ux_hd_textbox_dynamic_id="+dynamicId+"&event=add&param=save_drop_down_control&action=add_contact_form_library", function(data)
				{
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+",4,"+data+");");
				});
			}
			else
			{
				jQuery.post(ajaxurl,"form_id="+form_id+"&dynamicId="+dynamicId+"&control_type="+control_type+"&param=bind_text_control&action=show_form_control_data_contact_library", function(data)
				{
					var bind_data = JSON.parse(data);
					jQuery("#control_label_"+dynamicId).html(bind_data[dynamicId].cb_label_value+" :");
	                jQuery("#txt_description_"+dynamicId).html(bind_data[dynamicId].cb_description);
	                jQuery("#show_tooltip"+dynamicId).attr("data-original-title",bind_data[dynamicId].cb_tooltip_txt);
	                if(bind_data[dynamicId].cb_control_required == "1")
	                {
	                    jQuery("#control_label_"+dynamicId).append("<span class=\"error\">*</span>");
	                }
	                var bind_data_list =  bind_data[dynamicId].cb_dropdown_option_id;
	                for(var flag = 0; flag<bind_data_list.length;flag++)
				    {
				        jQuery("#ux_ddl_select_control"+dynamicId).append("<option value=\""+bind_data_list[flag]+"\">"+bind_data[dynamicId].cb_dropdown_option_val[flag]+"</option>");
				    }
					var control_id = bind_data[dynamicId].control_id;
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+","+control_type+","+control_id+");");
				});
			}
            break;
        case 5:
            jQuery("#div_5_5").clone(false).attr("id","div_"+dynamicId+"_5").appendTo("#left_block");
            jQuery("#div_"+dynamicId+"_5").children("label").attr("id","control_label_"+dynamicId);
            jQuery("#div_"+dynamicId+"_5").children("div").attr("id","post_back_checkbox_"+dynamicId);
            jQuery("#post_back_checkbox_"+dynamicId).children("div").attr("id","show_tooltip"+dynamicId);
            jQuery("#show_tooltip"+dynamicId ).children("input[type=\"checkbox\"]").attr("id","ux_chk_checkbox_control_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId ).children("input[type=\"checkbox\"]").attr("name","ux_chk_checkbox_control_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId ).children("span").attr("id","add_chk_options_here_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("id","add_setting_control_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("onclick","add_settings("+dynamicId+",5)");
            jQuery("#show_tooltip"+dynamicId).children("#anchor_del_").attr("id","anchor_del_"+dynamicId);
            jQuery("#div_"+dynamicId+"_5").attr("style","display:block");
            
            if(typeof type == "undefined")
            {
                jQuery.post(ajaxurl,"form_id="+form_id+"&ux_hd_textbox_dynamic_id="+dynamicId+"&event=add&param=save_check_box_control&action=add_contact_form_library", function(data)
                {
                	jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+",5,"+data+");");
                });
            }
            else
            {
				jQuery.post(ajaxurl,"form_id="+form_id+"&dynamicId="+dynamicId+"&control_type="+control_type+"&param=bind_text_control&action=show_form_control_data_contact_library", function(data)
				{
					var bind_data = JSON.parse(data);
					jQuery("#control_label_"+dynamicId).html(bind_data[dynamicId].cb_label_value+" :");
	                jQuery("#txt_description_"+dynamicId).html(bind_data[dynamicId].cb_description);
	                jQuery("#post_back_checkbox_"+dynamicId).attr("data-original-title",bind_data[dynamicId].cb_tooltip_txt);
	                if(bind_data[dynamicId].cb_control_required == "1")
	                {
	                    jQuery("#control_label_"+dynamicId).append("<span class=\"error\">*</span>");
	                }
	                var bind_chk_list =  bind_data[dynamicId].cb_checkbox_option_id;
	                for(var flag = 0; flag<bind_chk_list.length;flag++)
				    {
				    	jQuery("#ux_chk_checkbox_control_"+dynamicId).hide();
                		jQuery("#add_chk_options_here_"+dynamicId).append("<span id=\"input_id_"+bind_chk_list[flag]+"\"><input id=\"ux_chk_checkbox_control_"+bind_chk_list[flag]+"\" name=\"ux_chk_checkbox_control_"+bind_chk_list[flag]+"\" type=\"checkbox\"/><label class=\"rdl\">"+bind_data[dynamicId].cb_checkbox_option_val[flag]+"</label></span>");
				    }
					var control_id = bind_data[dynamicId].control_id;
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+","+control_type+","+control_id+");");
				});
            }
		break;
        case 6:
            jQuery("#div_6_6").clone(false).attr("id","div_"+dynamicId+"_6").appendTo("#left_block");
            jQuery("#div_"+dynamicId+"_6").children("label").attr("id","control_label_"+dynamicId);
            jQuery("#div_"+dynamicId+"_6").children("div").attr("id","post_back_radio_button_"+dynamicId);
            jQuery("#post_back_radio_button_"+dynamicId).children("div").attr("id","show_tooltip"+dynamicId);
            jQuery("#show_tooltip"+dynamicId ).children("input[type=\"radio\"]").attr("id","ux_radio_button_control_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId ).children("input[type=\"radio\"]").attr("name","ux_radio_button_control_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId ).children("span").attr("id","add_radio_options_here_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("id","add_setting_control_"+dynamicId);
            jQuery("#show_tooltip"+dynamicId).children("a.btn").attr("onclick","add_settings("+dynamicId+",6)");
            jQuery("#show_tooltip"+dynamicId).children("#anchor_del_").attr("id","anchor_del_"+dynamicId);
            jQuery("#div_"+dynamicId+"_6").attr("style","display:block");
            
            if(typeof type == "undefined")
            {
                jQuery.post(ajaxurl,"form_id="+form_id+"&ux_hd_textbox_dynamic_id="+dynamicId+"&event=add&param=save_multiple_control&action=add_contact_form_library", function(data)
                {
                	jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+",6,"+data+");");
                });
            }
            else
            {
				jQuery.post(ajaxurl,"form_id="+form_id+"&dynamicId="+dynamicId+"&control_type="+control_type+"&param=bind_text_control&action=show_form_control_data_contact_library", function(data)
				{
					var bind_data = JSON.parse(data);
					jQuery("#control_label_"+dynamicId).html(bind_data[dynamicId].cb_label_value+" :");
	                jQuery("#txt_description_"+dynamicId).html(bind_data[dynamicId].cb_description);
	                jQuery("#post_back_radio_button_"+dynamicId).attr("data-original-title",bind_data[dynamicId].cb_tooltip_txt);
	                if(bind_data[dynamicId].cb_control_required == "1")
	                {
	                    jQuery("#control_label_"+dynamicId).append("<span class=\"error\">*</span>");
	                }
	                var bind_rdl_list =  bind_data[dynamicId].cb_radio_option_id;
	                for(var flag = 0; flag<bind_rdl_list.length;flag++)
				    {
				    	jQuery("#ux_radio_button_control_"+dynamicId).hide();
                		jQuery("#add_radio_options_here_"+dynamicId).append("<span id=\"input_id_"+bind_rdl_list[flag]+"\"><input id=\"ux_radio_button_control_"+bind_rdl_list[flag]+"\" name=\"ux_radio"+dynamicId+"\" type=\"radio\"/><label class=\"rdl\">"+bind_data[dynamicId].cb_radio_option_val[flag]+"</label></span>");
                		if(flag == 0)
				    	{
				    		jQuery("#ux_radio_button_control_"+bind_rdl_list[flag]).attr("checked","checked");
				    	}
				    }
					var control_id = bind_data[dynamicId].control_id;
					jQuery("#show_tooltip"+dynamicId).children("#anchor_del_"+dynamicId).attr("onclick","delete_textbox("+dynamicId+","+control_type+","+control_id+");");
				});
            }
            break;
		case 7:
			alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
			break;
		case 8:
			alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
			break;
		case 9:
				alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
		break;
		case 10:
			alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
			break;
		case 11:
			alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
			break;
        case 12:
            alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
            break;
        case 13:
           alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
			break;
		case 15:
			alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
			break;
		case 16:
			alert("<?php _e( "This Feature is only available in Paid Premium Edition!", contact_bank ); ?>");
			break;
	}
}
<?php
$form_data = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM " .create_control_Table(). " where form_id= %d order by sorting_order asc",
		$form_id
	)
);
for($flag = 0; $flag < count($form_data);$flag++)
{
	?>
		create_control(<?php echo $form_data[$flag]->field_id;?>,<?php echo $form_data[$flag]->column_dynamicId;?>,"edit");
	<?php
}
?>
function prevent_paste(control_id)
{
	jQuery("#"+control_id).live("paste",function(e)
	{
		e.preventDefault();
	});
}

</script>