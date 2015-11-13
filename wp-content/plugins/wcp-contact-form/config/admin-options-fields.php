<?php
return array(
    'scfp_form_settings' => array(
        'sections' => array(
            'field_settings' => array(
                'label' => 'Fields Settings',
            ),            
            'send_button_settings' => array(
                'label' => 'Submit Button',
            ),                     
            'thankyou_page_settings' => array(
                'label' => '"Thank You" Page',
            ),            
            'other_settings' => array(
                'label' => 'Other Settings',
            ),                                    
        ),
        'fields' => array(
            'field_settings' => array(
                'type' => 'metabox',
                'label' => '',
                'default' => '',
                'section' => 'field_settings',
                'class' => '',
                'note' => 'You can configure fields of the contact form in the table below. Each field has following available parameters for configuration : '
                . '<strong>Type</strong> - allows to choose field type from preset; '
                . '<strong>Name</strong> - allows to define field label for displaying; '
                . '<strong>Visibility</strong> - allows to enable/disable field visibility; '
                . '<strong>Required</strong> - allows to make field required; '
                . '<strong>Export to CSV</strong> - allows to add field to CSV export.',
                'atts' => array(
                ),                
            ),            
            'button_name' => array(
                'type' => 'text',
                'label' => 'Caption',
                'default' => 'Send',
                'section' => 'send_button_settings',
                'class' => 'widefat regular-text',
                'note' => 'option allows to change submit button text',
                'atts' => array(
                ),                
            ),        
            'button_position' => array(
                'type' => 'select',
                'label' => 'Button Position',
                'fieldSet' => 'buttonPosition',
                'default' => 'left',
                'section' => 'send_button_settings',
                'class' => 'widefat regular-select',
                'note' => 'option allows to set submit button position',
            ),                  
            'page_name' => array(
                'type' => 'select',
                'label' => 'Select Page',
                'fieldSet' => 'pages',
                'default' => '',
                'section' => 'thankyou_page_settings',
                'class' => 'widefat regular-select',
                'note' => 'option allows to set "Thank You" page from the list of existed pages',
            ),      
            'html5_enabled' => array(
                'type' => 'checkbox',
                'label' => 'Enable HTML5 Validation',
                'default' => 1,
                'section' => 'other_settings',
                'note' => 'option allows to enable/disable HTML5 validation on the contact form',
                'class' => '',
            ),                                      
            'tinymce_button_enabled' => array(
                'type' => 'checkbox',
                'label' => 'TinyMCE Support',
                'default' => 1,
                'section' => 'other_settings',
                'note' => 'option allows to enable/disable button in the TinyMCE editor for adding contact form shortcode to editor area',
                'class' => '',
            ),                                                  
            'scripts_in_footer' => array(
                'type' => 'checkbox',
                'label' => 'Footer Scripts',
                'default' => 1,
                'section' => 'other_settings',
                'note' => 'option allows to enqueue scripts and styles only for the pages with contact form',
                'class' => '',
            ),                                      
            
        ),
    ),
    'scfp_style_settings' => array(
        'sections' => array(
            'send_button_settings' => array(
                'label' => 'Submit Button',
            ),                     
            'field_style_settings' => array(
                'label' => 'Fields Style',
            ),                                 
        ),  
        'fields' => array(
            'button_color' => array(
                'type' => 'colorpicker',
                'label' => 'Background Color',
                'default' => '#404040',
                'section' => 'send_button_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to change background color of the "Submit" button',
                'atts' => array(
                ),                                
            ),
            'text_color' => array(
                'type' => 'colorpicker',
                'label' => 'Text Color',
                'default' => '#FFF',
                'section' => 'send_button_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to change text color of the "Submit" button',
                'atts' => array(
                ),                                
            ),        
            'hover_button_color' => array(
                'type' => 'colorpicker',
                'label' => 'Hover Background Color',
                'default' => '',
                'section' => 'send_button_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to change hover background color of the "Submit" button',
                'atts' => array(
                ),                                
            ),
            'hover_text_color' => array(
                'type' => 'colorpicker',
                'label' => 'Hover Text Color',
                'default' => '',
                'section' => 'send_button_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to change hover text color of the "Submit" button',
                'atts' => array(
                ),                                
            ),        
            'field_label_text_color' => array(
                'type' => 'colorpicker',
                'label' => 'Label Color',
                'default' => '',
                'section' => 'field_style_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to change color of field labels (labels are displayed above the form fields)',
                'atts' => array(
                ),                                
            ),                    
            'field_label_marker_text_color' => array(
                'type' => 'colorpicker',
                'label' => '"Required" Marker Color',
                'default' => '',
                'section' => 'field_style_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to change color of "Required" marker (*)',
                'atts' => array(
                ),                                
            ),                                
            'field_text_color' => array(
                'type' => 'colorpicker',
                'label' => 'Text Color',
                'default' => '',
                'section' => 'field_style_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to change field text color inside the form fields',
                'atts' => array(
                ),                                
            ),                           
            'no_border' => array(
                'type' => 'checkbox',
                'label' => 'No Border',
                'default' => 0,
                'section' => 'field_style_settings',
                'class' => '',
                'note' => 'option allows to disable border around the form fields'
            ),                  
            'border_size' => array(
                'type' => 'text',
                'label' => 'Border Size',
                'default' => '',
                'section' => 'field_style_settings',
                'class' => 'widefat regular-text',
                'note' => 'option allows to set size of the border around the form fields (positive digital value with "px")',
                'atts' => array(
                ),                
            ),  
            'border_style' => array (
                'type' => 'select',
                'label' => 'Border Style',
                'fieldSet' => 'borderStyle',
                'default' => 'solid',
                'section' => 'field_style_settings',
                'class' => 'widefat regular-select',
                'note' => 'option allows to set style of the border around the form fields',                
            ),
            'border_color' => array(
                'type' => 'colorpicker',
                'label' => 'Border Color',
                'default' => '',
                'section' => 'field_style_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to set color of the border around the form fields',
                'atts' => array(
                ),                                
            ),   
            'no_background' => array(
                'type' => 'checkbox',
                'label' => 'No Background',
                'default' => 0,
                'section' => 'field_style_settings',
                'class' => '',
                'note' => 'option allows to disable background inside the form fields'
            ),      
            'background_color' => array(
                'type' => 'colorpicker',
                'label' => 'Background Color',
                'default' => '',
                'section' => 'field_style_settings',
                'class' => 'scfp-color-picker',
                'note' => 'option allows to set background color inside the form fields',
                'atts' => array(
                ),                                
            ),               
        ),
    ),            
    'scfp_error_settings' => array(
        'sections' => array(
            'error_settings' => array(
                'label' => 'Error Messages',
            ),            
            'notification_settings' => array(
                'label' => 'Notification Messages',
            ),                        
        ),  
        'fields' => array(
            'errors' => array(
                'type' => 'errors',
                'label' => '',
                'default' => '',
                'section' => 'error_settings',
                'class' => '',
                'note' => 'You can change error messages for non-HTML5 validation below',
            ),        
            'submit_confirmation' => array(
                'type' => 'text',
                'label' => 'Submit Success',
                'default' => 'Thanks for contacting us! We will get in touch with you shortly.',
                'section' => 'notification_settings',
                'class' => 'widefat',
                'note' => 'option allows to set submit success message for the form',
                'atts' => array(
                ),                
            ),                    
        ),
    ),    
    'scfp_notification_settings' => array(
        'sections' => array(
            'general_notifications_settings' => array(
                'label' => 'General Settings',
            ),                        
            'admin_notifications_settings' => array(
                'label' => 'Admin Notifications',
            ),            
            'user_notifications_settings' => array(
                'label' => 'User Notifications',
            ),                        
        ),  
        'fields' => array(
            'user_email' => array(
                'type' => 'select',
                'label' => 'User Email Field',
                'fieldSet' => 'emails',
                'default' => 'email',
                'section' => 'general_notifications_settings',
                'class' => 'widefat regular-select',
                'note' => 'option allows to set default field for user notification if you use more than one email field in the contact form',
                'atts' => array(
                ),                
            ),                                    
            'user_name' => array(
                'type' => 'select',
                'label' => 'User Name Field',
                'fieldSet' => 'userNames',
                'default' => 'name',
                'section' => 'general_notifications_settings',
                'class' => 'widefat regular-select',
                'note' => 'option allows to set default field for {$user_name} variable in the contact form',
                'atts' => array(
                ),                
            ),                                                
            'another_email' => array(
                'type' => 'text',
                'label' => 'Send to Email',
                'default' => '',
                'section' => 'admin_notifications_settings',
                'class' => 'widefat regular-text',
                'note' => 'option allows to set administrator email address for notifications. Default email address is used from: Settings --> General --> E-mail Address',
                'atts' => array(
                ),                
            ),            
            'subject' => array(
                'type' => 'text',
                'label' => 'Subject',
                'default' => 'New submission from contact form',
                'section' => 'admin_notifications_settings',
                'class' => 'widefat regular-text',
                'note' => 'option allows to set default subject of administrator notification message',
                'atts' => array(
                ),                
            ),                        
            'message' => array(
                'type' => 'textarea',
                'label' => 'Message',
                'default' => "Dear {\$admin_name},\nYou have got a new message from contact form!\n\nForm message:\n{\$data}",
                'section' => 'admin_notifications_settings',
                'class' => 'widefat',
                'note' => 'option allows to set default text of administrator notification message. You can use the following variables:<br/>{$admin_name} - Administrator name<br/>{$user_name} - User name<br/>{$user_email} - User email<br/>{$data} - Form data',
                'atts' => array(
                ),                
            ),  
            'disable' => array(
                'type' => 'checkbox',
                'label' => 'Disable Admin Notifications',
                'default' => 0,
                'section' => 'admin_notifications_settings',
                'class' => '',
                'note' => 'option allows to disable notifications of new form submissions'
            ),                                                  
            'user_subject' => array(
                'type' => 'text',
                'label' => 'Subject',
                'default' => 'Form submission confirmation',
                'section' => 'user_notifications_settings',
                'class' => 'widefat regular-text',
                'note' => 'option allows to set default subject of user notification message',
                'atts' => array(
                ),                
            ),                        
            'user_message' => array(
                'type' => 'textarea',
                'label' => 'Message',
                'default' => "Dear {\$user_name},\nThanks for contacting us!\nWe will get in touch with you shortly.\n\nYour message:\n{\$data}",
                'section' => 'user_notifications_settings',
                'class' => 'widefat',
                'note' => 'option allows to set default text of user notification message. You can use the following variables:<br/>{$admin_name} - Administrator name<br/>{$user_name} - User name<br/>{$user_email} - User email<br/>{$data} - Form data',
                'atts' => array(
                ),                
            ),  
            'user_disable' => array(
                'type' => 'checkbox',
                'label' => 'Disable User Notifications',
                'default' => 0,
                'section' => 'user_notifications_settings',
                'note' => 'option allows to disable notifications for successful form submission',
                'class' => '',
            ),               
            
        ),
    ),        
    'scfp_recaptcha_settings' => array(
        'sections' => array(
            'general_recaptcha_settings' => array(
                'label' => 'General Settings',
            ),                        
            'render_recaptcha_settings' => array(
                'label' => 'Render Settings',
            ),                                    
            'lang_recaptcha_settings' => array(
                'label' => 'Language Settings',
            ),                                                
            
        ),
        'fields' => array(
            'rc_key' => array(
                'type' => 'text',
                'label' => 'Key',
                'default' => '',
                'section' => 'general_recaptcha_settings',
                'class' => 'widefat regular-text',
                'note' => 'allows to set <a href="https://www.google.com/recaptcha" title="Get the reCAPTCHA key" target="_blank">reCAPTCHA key</a>',
                'atts' => array(
                ),
            ),
            'rc_secret_key' => array(
                'type' => 'text',
                'label' => 'Secret Key',
                'default' => '',
                'section' => 'general_recaptcha_settings',
                'class' => 'widefat regular-text',
                'note' => 'allows to set <a href="https://www.google.com/recaptcha" title="Get the reCAPTCHA secret key" target="_blank">reCAPTCHA secret key</a>',
                'atts' => array(
                ),
            ),            
            'rc_theme' => array(
                'type' => 'select',
                'label' => 'Theme',
                'fieldSet' => 'recaptchaTheme',
                'default' => 'light',
                'section' => 'render_recaptcha_settings',
                'class' => 'widefat regular-select',
                'note' => 'allows to set reCAPTCHA theme',
                'atts' => array(
                ),                
            ),                                                            
            'rc_type' => array(
                'type' => 'select',
                'label' => 'Type',
                'fieldSet' => 'recaptchaType',
                'default' => 'image',
                'section' => 'render_recaptcha_settings',
                'class' => 'widefat regular-select',
                'note' => 'allows to set reCAPTCHA type',
                'atts' => array(
                ),                
            ),                                                                        
            'rc_size' => array(
                'type' => 'select',
                'label' => 'Size',
                'fieldSet' => 'recaptchaSize',
                'default' => 'normal',
                'section' => 'render_recaptcha_settings',
                'class' => 'widefat regular-select',
                'note' => 'allows to set reCAPTCHA size',
                'atts' => array(
                ),                
            ),          
            'rc_wp_lang' => array(
                'type' => 'checkbox',
                'label' => 'Use current WordPress language',
                'default' => 0,
                'section' => 'lang_recaptcha_settings',
                'class' => '',
                'note' => "option allows to change default reCAPTCHA language (if it's possible)",
            ),                                                  
            
        ),
    ),
);