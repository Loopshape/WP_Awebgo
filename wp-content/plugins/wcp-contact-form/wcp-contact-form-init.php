<?php
use Webcodin\WCPContactForm\Core\Agp_Autoloader;

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'scfp_output_buffer');
function scfp_output_buffer() {
    ob_start();
}

if (file_exists(dirname(__FILE__) . '/agp-core/agp-core.php' )) {
    include_once (dirname(__FILE__) . '/agp-core/agp-core.php' );
} 

add_action( 'plugins_loaded', 'scfp_activate_plugin' );
function scfp_activate_plugin() {
    if (class_exists('Webcodin\WCPContactForm\Core\Agp_Autoloader') && !function_exists('SCFP')) {
        $autoloader = Agp_Autoloader::instance();
        $autoloader->setClassMap(array(
            'paths' => array(
                __DIR__ => array('classes'),
            ),
            'namespaces' => array(
                'Webcodin\WCPContactForm\Core' => array(
                    __DIR__ => array('agp-core'),
                ),
            ),
            'classmaps' => array (
                __DIR__ => 'classmap.json',
            ),            
        ));
        //$autoloader->generateClassMap(__DIR__);
            
        function SCFP() {
            return SCFP::instance();
            
        }    

        SCFP();                
    }
}

scfp_activate_plugin();
