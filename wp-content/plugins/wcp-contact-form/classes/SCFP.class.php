<?php
use Webcodin\WCPContactForm\Core\Agp_Module;
use Webcodin\WCPContactForm\Core\Agp_Session;

class SCFP extends Agp_Module {
    
    /**
     * Form Settings
     * 
     * @var SCFP_FormSettings
     */
    private $formSettings;    
    
    /**
     * Plugin settings
     * 
     * @var SCFP_Settings
     */
    private $settings;    
    
    
    /**
     * Session
     * 
     * @var Agp_Session
     */
    private $session;

    /**
     * Form entries
     * 
     * @var SCFP_FormEntries
     */
    private $formEntries;

    /**
     * Ajax
     * 
     * @var SCFP_Ajax 
     */
    private $ajax;
    
    /**
     * LESS Parser
     * 
     * @var Less_Parser
     */
    private $lessParser;
    
    /**
     * The single instance of the class 
     * 
     * @var object 
     */
    protected static $_instance = null;    
    
	/**
	 * Main Instance
	 *
     * @return object
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}    
    
	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
    }        
    
    public function __construct() {
        parent::__construct(dirname(dirname(__FILE__)));
        
        include_once ( $this->getBaseDir() . '/types/form-entries-post-type.php' );     
        include_once ( $this->getBaseDir() . '/inc/cool-php-captcha/captcha.php' );     
        include_once ( $this->getBaseDir() . '/vendor/autoload.php' );     
        
        $this->lessParser = new Less_Parser();
        $this->settings = SCFP_Settings::instance( $this );
        $this->formSettings = SCFP_FormSettings::instance();        
        $this->formEntries = SCFP_FormEntries::instance();
        $this->session = Agp_Session::instance();
        $this->ajax = SCFP_Ajax::instance();
        
        add_action( 'init', array($this, 'init' ) );                
        add_action( 'wp_enqueue_scripts', array($this, 'enqueueScripts' ) );                
        add_action( 'admin_enqueue_scripts', array($this, 'enqueueAdminScripts' ));            
        add_shortcode( 'scfp', array($this, 'doScfpShortcode') ); 
        add_shortcode( 'wcp_contactform', array($this, 'doScfpShortcode') ); 
        add_action( 'widgets_init', array($this, 'initWidgets' ) );
        add_action( 'admin_init', array($this, 'tinyMCEButtons' ) ); 
        add_filter( 'clean_url', array($this, 'deferJavascripts' ), 11, 1 );
    }

    
    public function deferJavascripts ( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( !strpos( $url, 'recaptcha/api.js' ) || !strpos( $url, 'scfpOnLoadCallback' ) ) return $url;
        
        return "$url' async='async' defer='defer";
    }
    
    public function init() {
        $this->settings->applyUpdateChanges();
    }
    
    public function initWidgets() {
        register_widget('SCFP_FormWidget');
    }
    
    public function enqueueScripts () {
        wp_register_script( 'scfp', $this->getAssetUrl('js/main.js'), array('jquery') ); 
        wp_localize_script( 'scfp', 'ajax_scfp', array( 
            'base_url' => site_url(),         
            'ajax_url' => admin_url( 'admin-ajax.php' ), 
            'ajax_nonce' => wp_create_nonce('ajax_atf_nonce'),        
        ));  
        
        $recaptcha = SCFP()->getSettings()->getRecaptchaSettings();
        $hl = !empty($recaptcha['rc_wp_lang']) ? '&hl=' . get_locale() : '';
        
        wp_register_script( 'scfp-recaptcha', $this->getAssetUrl('js/recaptcha.js'), array('jquery', 'scfp') );         
        wp_register_script( 'scfp-recaptcha-api', 'https://www.google.com/recaptcha/api.js?onload=scfpOnLoadCallback&render=explicit'.$hl, array('jquery', 'scfp-recaptcha') );         
        wp_register_style( 'scfp-css', $this->getAssetUrl('css/style.css') );         
        
        $form_settings = $this->settings->getFormSettings();
        if (empty($form_settings['scripts_in_footer'])) {
            wp_enqueue_script( 'scfp' );         
            wp_enqueue_script( 'scfp-recaptcha' );         
            wp_enqueue_script( 'scfp-recaptcha-api' );         
        }
        
        wp_enqueue_style( 'scfp-css' );                         
    }        
    
    public function enqueueAdminScripts () {
        global $current_screen;
        
        wp_enqueue_style( 'wp-color-picker' );        
        wp_enqueue_script( 'wp-color-picker' );            
        wp_enqueue_script( 'jquery-ui-sortable' );            
        
        wp_enqueue_script( 'scfp', $this->getAssetUrl('js/admin.js'), array('jquery', 'wp-color-picker') );                                                         
        wp_enqueue_style( 'scfp-css', $this->getAssetUrl('css/admin.css'), array('wp-color-picker') );   
        
        wp_localize_script('scfp', 'csvVar', array(
            'href' => add_query_arg(array('download_csv' => 1)),
            'active' =>  'form-entries' == $current_screen->post_type,
        ));
    }
    
    public function tinyMCEButtons () {
        
        $form_settings = $this->settings->getFormSettings();
        if ( current_user_can('edit_posts') && current_user_can('edit_pages') && !empty($form_settings['tinymce_button_enabled'])) {
            if ( get_user_option('rich_editing') == 'true' ) {
               add_filter( 'mce_buttons', array($this, 'tinyMCERegisterButtons'));                
               add_filter( 'mce_external_plugins', array($this, 'tinyMCEAddPlugin') );
            }        
        }        
    }
    
    public function tinyMCERegisterButtons( $buttons ) {
       array_push( $buttons, "|", "wcp_contactform" );
       return $buttons;
    }    
    
    public function tinyMCEAddPlugin( $plugin_array ) {
        $plugin_array['wcp_contactform'] = $this->getAssetUrl() . '/js/wcp-contactform.js';
        return $plugin_array;        
    }            
    
    public function getFormDynamicStyle ($id) {
        $this->lessParser->parseFile($this->getBaseDir() . '/assets/less/style.less');
        
        $styleSettings = SCFP()->getSettings()->getStyleSettings();
        $this->lessParser->ModifyVars( array (
                'id' => $id,
                'no_border' => !empty($styleSettings['no_border']) ? $styleSettings['no_border'] : '',
                'border_size' => !empty($styleSettings['border_size']) ? $styleSettings['border_size'] : '',
                'border_style' => !empty($styleSettings['border_style']) ? $styleSettings['border_style'] : '',
                'border_color' => !empty($styleSettings['border_color']) ? $styleSettings['border_color'] : '',            
                'field_label_text_color' => !empty($styleSettings['field_label_text_color']) ? $styleSettings['field_label_text_color'] : '',
                'field_label_marker_text_color' => !empty($styleSettings['field_label_marker_text_color']) ? $styleSettings['field_label_marker_text_color'] : '',            
                'field_text_color' => !empty($styleSettings['field_text_color']) ? $styleSettings['field_text_color'] : '',
                'no_background' => !empty($styleSettings['no_background']) ? $styleSettings['no_background'] : '',
                'background_color' => !empty($styleSettings['background_color']) ? $styleSettings['background_color'] : '',
                'button_color' => !empty($styleSettings['button_color']) ? $styleSettings['button_color'] : '',
                'text_color' => !empty($styleSettings['text_color']) ? $styleSettings['text_color'] : '',  
                'hover_button_color' => !empty($styleSettings['hover_button_color']) ? $styleSettings['hover_button_color'] : '',
                'hover_text_color' => !empty($styleSettings['hover_text_color']) ? $styleSettings['hover_text_color'] : '',              
            )
        );
        
        return '<style type="text/css" >' . $this->lessParser->getCss() . '</style>';        
    }    
    
    public function doScfpShortcode ($atts) {
        $form_settings = $this->settings->getFormSettings();
        if (!empty($form_settings['scripts_in_footer'])) {
            wp_enqueue_script( 'scfp' );         
            wp_enqueue_script( 'scfp-recaptcha' );         
            wp_enqueue_script( 'scfp-recaptcha-api' ); 
            wp_enqueue_style( 'scfp-css' );                         
        }
        
        $atts = shortcode_atts( array(
            'id' => 'default-contactform-id',
        ), $atts );        
        
        if (!empty($atts['id'])) {
            $id = $atts['id'];
            $form = new SCFP_Form($id);
            
            if ( isset($_POST['form_id']) && $_POST['form_id'] == $id 
                && isset($_POST['action']) && $_POST['action'] == 'scfp-form-submit' ) 
            {        
                $form->submit($_POST);
                
                unset($_POST['action']);                
                unset($_POST['form_id']);
            }
            
            $atts['form'] = $form;
            return $this->getTemplate('scfp', $atts);                
        }
    }
    
    public function doContactFormWidget($atts){
        $form_settings = $this->settings->getFormSettings();
        if (!empty($form_settings['scripts_in_footer'])) {
            wp_enqueue_script( 'scfp' );         
            wp_enqueue_script( 'scfp-recaptcha' );         
            wp_enqueue_script( 'scfp-recaptcha-api' );    
            wp_enqueue_style( 'scfp-css' );                         
        }
        
        $atts = shortcode_atts( array(
            'id' => NULL,
        ), $atts );        
        
        if (!empty($atts['id'])) {
            $id = $atts['id'];
            $form = new SCFP_Form($id);
            
            if ( isset($_POST['form_id']) && $_POST['form_id'] == $id 
                && isset($_POST['action']) && $_POST['action'] == 'scfp-form-submit' ) 
            {        
                $form->submit($_POST);
                
                unset($_POST['action']);                
                unset($_POST['form_id']);
            }
            
            $atts['form'] = $form;
            return $this->getTemplate('scfp-widget', $atts);                
        }    
    }
 
    public function getSettings() {
        return $this->settings;
    }

    function getFormEntries() {
        return $this->formEntries;
    }
    
    function getFormSettings() {
        return $this->formSettings;
    }    

    public function getLessParser() {
        return $this->lessParser;
    }

}
