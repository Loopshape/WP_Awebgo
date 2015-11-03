<?php
return array(
    'page' => 'scfp_plugin_options', //page slug
    'title' => 'WCP Contact Form Settings',
    'tabs' => include (__DIR__ . '/admin-options-tabs.php'),
    'fields' => include (__DIR__ . '/admin-options-fields.php'),
    'fieldSet' => include (__DIR__ . '/admin-options-fieldset.php'),
);