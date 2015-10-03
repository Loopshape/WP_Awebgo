<?php
/**
 * @package Unlimited
 * @version 0.5
 */
/*
	Plugin Name: Unlimited
	Plugin URI: http://wordpress.org/plugins/unlimited/
	Description: Infinite scrolling for wordpress.
	Author: Plugin Builders
	Version: 0.5
	Author URI: http://plugin.builders/
	Text Domain: unlimited
	Domain Path: languages
*/

class WPB_Unlimited{
	function __construct(){
		add_action('admin_menu', array($this, 'createMenu'));
		
		add_action('admin_enqueue_scripts', array($this, 'loadDashJs'));
		add_action('wp_enqueue_scripts', array($this, 'loadJs'));
		add_action('plugins_loaded', array($this, 'loadTextDomain') );
		
		add_action('wp_ajax_pb_un_get', array($this, 'getAll'));
		add_action('wp_ajax_pb_un_save', array($this, 'save'));
		add_action('wp_ajax_pb_un_delete', array($this, 'delete'));
	}
	
	public function createMenu(){
		add_submenu_page(
			'options-general.php',
			'Unlimited',
			'Unlimited',
			'manage_options',
			'unlimited',
			array($this, 'pageTemplate')
		);
	}
	
	public function loadTextDomain(){
		load_plugin_textdomain( 'unlimited', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	
	public function pageTemplate(){ ?>
		<div class="wrap pb-un-wrapper">
			<div id="icon-themes" class="icon32"></div>
			<h2>Unlimited</h2>
			<div id="pb-un-wrapper" data-theme="<?php echo wp_get_theme(); ?>" data-site="<?php echo get_option('siteurl'); ?>">
				<div id="pb-un-items"></div>
				<button id="pb-un-add-new" class="button button-primary"><?php _e('Add New', 'unlimited'); ?></button>
			</div>
			<div id="pb-un-editor"></div>
			<div id="pbc-feedback">
				<a class="button" href="mailto:suggest@plugin.builders?subject=Extend Unlimited"><?php _e('Suggest Feature', 'unlimited'); ?></a>
				<a class="button" href="mailto:support@plugin.builders?subject=Unlimited Problem"><?php _e('Report Issue', 'unlimited'); ?></a>
				<a class="button" href="https://wordpress.org/support/view/plugin-reviews/unlimited?#postform" target="_blank"><?php _e('Write a review', 'unlimited'); ?></a>
			</div>
		</div>
		<?php
		$this->templates();
	}
	
	public function templates(){
		include 'templates/templates.php';
	}	
		
	public function loadDashJs($hook){
		if($hook == 'settings_page_unlimited'){
			wp_register_script('wpb_un_settings', plugins_url('/js/settings.js', __FILE__), array('jquery', 'underscore'), null, 1);
			wp_enqueue_script('wpb_un_settings');
			wp_register_style('wpb_un_style', plugins_url('/css/dash.css', __FILE__));
			wp_enqueue_style('wpb_un_style');
		}		
	}
	
	public function loadJs(){
		$v = get_option('wpb_unlimited');
		wp_register_script('wpb_un', plugins_url('/js/un.js', __FILE__), array('jquery'), null, 1);
		wp_enqueue_script('wpb_un');
		wp_localize_script('wpb_un', 'unlimited_server_values', $v);
		wp_register_style('wpb_un_style', plugins_url('/css/style.css', __FILE__));
		wp_enqueue_style('wpb_un_style');
	}
	
	/**
	 * stores input types,  not listed ones are supposed to be strings.
	 *
	*/
	
	public $fields = array(
		'threshold' => 'int',
		'loader_img_url' => 'url'
	);
	
	public function save(){
		$d = json_decode(stripslashes($_POST['un_data']));
				
		if(isset($_FILES['loader_img'])){
			$loader_img = $this->upload($_FILES['loader_img']);
			if($loader_img){
				$d->loader_img_name = $loader_img[0];
				$d->loader_img_url = $loader_img[1];
			}
		}
		
		$d = $this->validate($d);
		
		$uns = get_option('wpb_unlimited');
		$uns = $uns ? $uns : array();
		$key = $d->key;
		$key_present = $key;
		
		if($key) {
			$uns[$key] = $d;
		}	
		else {
			$key = 'pb_un_'.time();
			$d->key = $key;
			$uns[$key] = $d;
		}	
				
		$key = update_option('wpb_unlimited', $uns) ? $key : ($key_present ? $key_present : false);
		wp_send_json($key);
	}
	
	public function validate($ins){
		$rins = array();
		foreach($ins as $key=>$value){
			$rins[$key] = $this->cleanse(
				( array_key_exists($key, $this->fields) ? $this->fields[$key] : 'string' ),
			$value);
		}
		return (object)$rins;
	}
	
	public function cleanse($type, $value){
		switch($type){
			case 'int':
				return intval($value);
				break;
			case 'url':
				return esc_url($value);
				break;
			default:
				return sanitize_text_field($value);
				break;
		} 
	}
	
	public function delete(){
		$uns = get_option('wpb_unlimited');
		unset($uns[$_POST['del_key']]);
		wp_send_json(update_option('wpb_unlimited', $uns));
	}
	
	public function upload($file){
		if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
		$uploadedfile = $file;
		$upload_overrides = array( 'test_form' => false );
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
		if($movefile){
			$m = explode('/', $movefile['url']);
			return array($m[sizeof($m)-1], $movefile['url']);
		} else {
			return false;
		}
	}
	
	public function getAll(){
		wp_send_json(get_option('wpb_unlimited'));
	}
		
} 

new WPB_Unlimited();
?>