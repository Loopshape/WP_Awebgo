<?php
return array(
    'fields' => array(
        'name' => array(
            'default' => array(
                'name' => 'Name',
                'visibility' => 1,
                'required' => 1,
                'exportCSV' => 1,
            ),
            'type' => 'text',
        ),
        'email' => array(
            'default' => array(
                'name' => 'Email',
                'visibility' => 1,
                'required' => 1,
                'exportCSV' => 1,
            ),
            'type' => 'email',
        ),  
        'phone' => array(
            'default' => array(
                'name' => 'Phone',
                'visibility' => 1,
                'required' => 0,
                'exportCSV' => 1,
            ),
            'type' => 'text',
        ),          
        'subject' => array(
            'default' => array(
                'name' => 'Subject',
                'visibility' => 1,
                'required' => 1,
                'exportCSV' => 1,
            ),
            'type' => 'text',
        ),          
        'message' => array(
            'default' => array(
                'name' => 'Message',
                'visibility' => 1,
                'required' => 1,
                'exportCSV' => 1,
            ),
            'type' => 'textarea',
        ), 
        'captcha' => array(
            'default' => array(
                'name' => 'Captcha',
                'visibility' => 1,
                'required' => 1,
                'exportCSV' => 0,
            ),
            'type' => 'captcha',
        ),            
    ),
    'userParams' => array(
        'name' => array(
            'label' => 'Name',
            'type' => 'text'
        ),
        'visibility' => array(
            'label' => 'Visibility',
            'type' => 'checkbox',

        ),
        'required' => array(
            'label' => 'Required',
            'type' => 'checkbox',
        ),                    
        'exportCSV' => array(
            'label' => 'Export to CSV',
            'type' => 'checkbox',
        ),                            
    ),
    'errors' => array(
        'required_error' => array(
            'label' => 'Required Field',
            'default' => "This field can not be empty. Please enter required information",
            'note' => 'option allows to set error message for "required" fields',
        ),
        'email_error' => array(
            'label' => 'Email Field',
            'default' => "Email address is not correct. Please fill in this field carefully.",
            'note' => 'option allows to set error message for "email "fields',
        ),
        'captcha_error' => array(
            'label' => 'Captcha Field',
            'default' => "Captcha is not correct. Please fill in this field carefully.",
            'note' => 'option allows to set error message for "CAPTCHA" field',
        ),
        'number_error' => array(
            'label' => 'Number Field',
            'default' => "Value must be numeric. Please fill in this field carefully.",
            'note' => 'option allows to set error message for "number" fields',
        ),
    ),
);