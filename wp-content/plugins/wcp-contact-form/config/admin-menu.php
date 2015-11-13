<?php

return array(
    'scfp' => array(
        'page_title' => 'Contact Form', 
        'menu_title' => 'Contact Form', 
        'capability' => 'manage_options',
        'function' => '',
        'icon_url' => '', 
        'position' => null, 
        'hideInSubMenu' => TRUE,
        'submenu' => array(
            'scfp_plugin_options' => array(
                'page_title' => 'Settings', 
                'menu_title' => 'Settings', 
                'capability' => 'manage_options',
                'function' => array('SCFP_Settings', 'renderSettingsPage'),                         
            ),            
        ),
    ),
);
    