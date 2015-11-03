<?php
use Webcodin\WCPContactForm\Core\Agp_RepeaterAbstract;

class SCFP_FormSettings extends Agp_RepeaterAbstract {
    
    /**
     * The single instance of the class 
     * 
     * @var Fac_Slider 
     */
    protected static $_instance = null;    

	/**
	 * Main Instance
	 *
     * @return object
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self(dirname(dirname(__FILE__)));
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
    
    public function __construct($baseDir) {
        parent::__construct($baseDir);

        $this->init('scfp_form_settings', 'Fields Settings', 'scfp_plugin_options', 'normal');

        $this->setHeaderTemplateAdminName("admin/form/header");
        $this->setLayoutTemplateAdminName("admin/form/layout");
        $this->setRowTemplateAdminName("admin/form/row"); 
    }
    
    public function enqueueScripts () {
        wp_enqueue_script( 'scfp-form-repeater', $this->getAssetUrl('repeater/js/main.js'), array('jquery') );                                                         
        wp_enqueue_style( 'scfp-form-repeater-css', $this->getAssetUrl('repeater/css/style.css') );  
    }        
    
    public function enqueueAdminScripts () {
        wp_enqueue_script( 'scfp-form-repeater', $this->getAssetUrl('repeater/js/admin.js'), array('jquery') );                                                         
        wp_enqueue_style( 'scfp-form-repeater-css', $this->getAssetUrl('repeater/css/admin.css') );  
    }                    
    
    public function getData($post_id) {
        $data = array();
        if ($this->getId()) {
            
            $options = get_option($post_id);
            if (!empty($options)) {
                if (is_serialized($options)) {
                    $options = unserialize($options);
                }    

                if (!empty($options['field_settings'])) {
                    $data = $options['field_settings'];
                }                
            }
        }
        
        if (isset($data[0])) {
            unset($data[0]);
        }
        
        return $data;        
    }    
    
    public function getMaxRow($post_id) {
        if ($this->getId()) {
            $data = $this->getData($post_id);
            if (!empty($data) && is_array($data)) {
                $tmp = array();                
                foreach($data as $k => $v) {
                    if (is_numeric($k)) {
                        $tmp[$k] = $v;
                    }
                }
                if (!empty($tmp)) {
                    return max(array_keys($tmp));        
                } else {
                    return 0;
                }
            }
        }
        return 1;
    }    
}

