<?php
/*
Plugin Name: Simple Ajax Shoutbox
Plugin URI: https://wordpress.org/plugins/simple-ajax-shoutbox/
Description: This plugin will enable shoutbox into your sidebar widget. Using AJAX technology so visitor doesn't have to refresh each time they post messages into this shoutbox. It also has simple design, so it will definetely fit in your site, does'nt matter what your template is.
Version: 2.1.2
Author: Indra Prasetya, Honza Skýpala
Author URI: http://www.honza.info

Copyright 2009-2015, Indra Prasetya
Copyright 2015-present, Honza Skýpala

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class Ajax_Shoutbox_Widget extends WP_Widget {
  const version = "2.1.2";
  const SHOUTBOX_ID_BASE = "ajax_shoutbox";

  const tld = "ac|ad|aero|ae|af|ag|ai|al|am|an|ao|aq|arpa|ar|asia|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|biz|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cf|cg|ch|ci|ck|cl|cm|cn|com|coop|co|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|firm|fi|fj|fk|fm|fo|fr|fx|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|info|int|in|io|iq|ir|is|it|je|jm|jobs|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|museum|mu|mv|mw|mx|my|mz|name|nato|na|nc|net|ne|nf|ng|ni|nl|nom|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pro|pr|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|store|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|travel|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|va|vc|ve|vg|vi|vn|vu|web|wf|ws|xxx|xyz|ye|yt|yu|za|zm|zr|zw";
  const url_path = '[a-z0-9?@%_+:\-\#\.?!&=/();]*';
  private static $url_match;
  const img_path = '[a-z0-9?@%_+:\-\.?!&=/();]*';
  private static $img_match;
  const rss_path = 'shoutbox-rss';

  function __construct() {
    self::$url_match = '([a-z0-9\-\_]+\.)+('.self::tld.')(/'.self::url_path.')?';
    self::$img_match = '([a-z0-9\-\_]+\.)+('.self::tld.')(/'.self::img_path.')?';

    parent::__construct(self::SHOUTBOX_ID_BASE, 'Shoutbox',
                        array('classname' => 'Ajax_Shoutbox_Widget',
                              'description' => __('Adds simple chat to your blog', 'shoutbox2') ),
                        array('width' => 300));
    add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));
    add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts'));
  }

  function widget($args, $instance) {
      extract($args);
      $instance = Ajax_Shoutbox_Widget::merge_defaults($instance);
      $siteurl = get_option('siteurl');
      $maxmsglen = 255;

      $output = "";

      if (function_exists('current_user_can') && current_user_can('moderate_comments')) {
        $ajax_nonce = wp_create_nonce("shoutbox_moderator");
        $output .= "<data id=\"nonce\" value=\"$ajax_nonce\"></data>";
      }

      $output .= "<div id='sb_messages'>";
      $output .= self::content($instance);  // load messages into box
      $output .= "</div>\n"; // sb_messages

      $output .= "<div id='input_area'>\n";
      $output .= "<form action=\"#\" id=\"sb_form\">";

      if ($instance['registered_user'] == 'true' && !is_user_logged_in())
        $output .= '<div class="info">' . __('Only registered user allowed', 'shoutbox2') . '</div>';
      else {
        if (is_user_logged_in()) {
          global $current_user;  get_currentuserinfo();
          $output .= "<input type='hidden' id='sb_name' value='" . $current_user->display_name . "'>"
                   . "<input type='hidden' id='sb_website' value='" . $current_user->user_url . "'>";
        } else {
          $output .= "<input id='sb_name' type='text' class='sb_input' placeholder='" . __('Name') . "' maxlength='100'>"
                    . "<input id='sb_website' type='text' class='sb_input' placeholder='" . __('Website') . "' maxlength='255'>";
        }
        $output .= "<textarea id='sb_message' class='sb_input' placeholder='" . __('Message', 'shoutbox2') . "' maxlength='$maxmsglen'></textarea>";
        $output .= "<a href=\"#\" id=\"sb_addmessage\" class=\"button\" title=\"" . __('Ctrl-Enter', 'shoutbox2') . "\">" . __('Publish', 'shoutbox2') . "</a>";
        $output .= '<span class="spinner"></span>';
        $output .= "<span id='sb_status'></span>";

        $translatedSmiley = translate_smiley(array(":-)"));
        $smiley = '<span id="sb_showsmiles" title="' . __('Smilies', 'shoutbox2') .'"';
        if (preg_match('/class=[\'"][\w\-\s]*[\'"]/i', $translatedSmiley, $matches))
          $smiley .= " $matches[0]";
        if (preg_match('/src=[\'"]([\w\-\s\:\/\?\.\=\%\&\;]+)[\'"]/i', $translatedSmiley, $matches))
          $smiley .= " style=\"background-image: url('$matches[1]')\"";
        $smiley .= "></span>";
        $output .= $smiley;
      }
      $output .= "</form>"; // #sb_form

      self::enqueue_js($instance['shoutbox_reload'], $instance['max_messages'], $maxmsglen);

      $output .= '<div id="sb_smiles">';
      global $wpsmiliestrans;
      $shoutbox_smiliestrans = array_unique($wpsmiliestrans);
      foreach ((array)$shoutbox_smiliestrans as $smiley => $img ) {
        $smiley_masked = esc_attr(trim($smiley));
        $translatedSmiley = translate_smiley(array($smiley_masked));
        $smiley = "<span title=\"$smiley_masked\" class=\"wp-smiley\"";
//        if (preg_match('/class=[\'"][\w\-\s]*[\'"]/i', $translatedSmiley, $matches))
//          $smiley .= " $matches[0]";
        if (preg_match('/src=[\'"]([\w\-\s\:\/\?\.\=\%\&\;]+)[\'"]/i', $translatedSmiley, $matches))
          $smiley .= " style=\"background-image: url('$matches[1]')\"";
        $smiley .= ">";
        if (!preg_match('/</', $translatedSmiley))
          $smiley .= $translatedSmiley;
        $smiley .= "</span>";
        $output .= $smiley;
      }
      $output .= "</div>\n"; // sb_smilies

      $output .= "</div>\n"; // input_area

      $output .= "<div class=\"icons\">";
      if ($instance['shoutbox_rss'] == 'true') $output .= "<a href='".get_site_url() . '/' . self::rss_path."' target='_blank' title='". __('Shoutbox RSS channel', 'shoutbox2') ."' class='sb_rss_link'>". __('Shoutbox RSS channel', 'shoutbox2') ."</a>";
      $output .= "<span class=\"warning\" title=\"" . __('Update of chat failer; will try again shortly', 'shoutbox2') . "\"></span>";
      $output .= "<span class=\"spinner\"></span>";
      $output .= "<span class=\"lock\"></span>";
      $output .= "<span class=\"speaker" . (isset($_COOKIE["shoutbox_speaker"]) && $_COOKIE["shoutbox_speaker"] == "true" ? " active" : "") . "\" title=\"" . __('Sound on new message', 'shoutbox2') . "\"></span>";
      $output .= "</div>";

      $output .= '<audio id="notify"><source src="' . plugins_url("/audio/whistle.mp3", __FILE__) . '" type="audio/mpeg"></audio>';

      $output = apply_filters('shoutbox_widget_output', $output, $this, $args, $instance);

      if ($output != "") {
        echo $before_widget;
        echo $before_title . $instance['title'] . $after_title;
        echo $output;
        echo $after_widget;
      }
  }

  function form($instance) {
    $instance = Ajax_Shoutbox_Widget::merge_defaults($instance);

    $title_name           = $this->get_field_name('title');
    $max_messages_name    = $this->get_field_name('max_messages');
    $shoutbox_reload_name = $this->get_field_name('shoutbox_reload');
    $registered_user_name = $this->get_field_name('registered_user');
    $url_clickable_name   = $this->get_field_name('url_clickable');
    $check_spam_name      = $this->get_field_name('check_spam');
    $shoutbox_rss_name    = $this->get_field_name('shoutbox_rss');

    echo "<p><label for=\"$title_name\">" . __('Title:') ."<input class=\"widefat\" id=\"" . $this->get_field_id('title') ."\" name=\"$title_name\"  type=\"text\" value=\"" . htmlspecialchars($instance['title'], ENT_QUOTES) . "\" /></label></p>"

         . "<p>"
         . "<span><label for=\"$max_messages_name\">" . __('Max messages in shoutbox:', 'shoutbox2') . "</label><input id=\"" . $this->get_field_id('max_messages') . "\" name=\"$max_messages_name\" type=\"number\" class=\"small-text\" min=\"10\" value=\"{$instance['max_messages']}\" /></span>"
         . "<span><label for=\"$shoutbox_reload_name\">" . __('Reload time in seconds:', 'shoutbox2') . "</label><input id=\"" . $this->get_field_id('shoutbox_reload') . "\" name=\"$shoutbox_reload_name\" type=\"number\" class=\"small-text\" min=\"10\" value=\"{$instance['shoutbox_reload']}\" /></span>"
         . "</p>"

         . "<p>"
         . "<span><input type=\"checkbox\" id=\"" . $this->get_field_id('registered_user') . "\" name=\"$registered_user_name\" value=\"true\"" . ($instance['registered_user'] == 'true' ? ' checked="checked"' : '') . " /><label for=\"$registered_user_name\">" . __('Only registered user allowed.', 'shoutbox2') . "</label></span>"
         . "<span><input type=\"checkbox\" id=\"" . $this->get_field_id('url_clickable') . "\" name=\"$url_clickable_name\" value=\"true\"" . ($instance['url_clickable'] == 'true' ? ' checked="checked"' : '') . " /><label for=\"$url_clickable_name\">" . __('By enabling this submitted URLs will become clickable.', 'shoutbox2') . "</label></span>"
         . "<span><input type=\"checkbox\" id=\"" . $this->get_field_id('check_spam') . "\" name=\"$check_spam_name\" value=\"true\"" . ($instance['check_spam'] == 'true' ? ' checked="checked"' : '') . " /><label for=\"$check_spam_name\">" . __('Check using Akismet, may degrades process time.', 'shoutbox2') . "</label></span>"
         . "<span><input type=\"checkbox\" id=\"" . $this->get_field_id('shoutbox_rss') . "\" name=\"$shoutbox_rss_name\" value=\"true\"" . ($instance['shoutbox_rss'] == 'true' ? ' checked="checked"' : '') . " /><label for=\"$shoutbox_rss_name\">" . __('Display link to RSS channel containing shoutbox messages.', 'shoutbox2') . "</label></span>"
         . "</p>"

         . "";
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;

    foreach (array('title',
                   'max_messages',
                   'flood_time',
                   'shoutbox_reload',
                   'allow_html',
                   'url_clickable',
                   'check_spam',
                   'registered_user',
                   'shoutbox_rss') as $value)
      $instance[$value] = strip_tags($new_instance[$value]);

    return $instance;
  }

  private static function merge_defaults($instance) {
     $instance = wp_parse_args((array) $instance, array(  'title'                    => ''
                                                        , 'max_messages'             => '20'
                                                        , 'flood_time'               => '30'
                                                        , 'shoutbox_reload'          => '30'
                                                        , 'allow_html'               => 'false'
                                                        , 'url_clickable'            => 'true'
                                                        , 'shoutbox_rss'             => 'true'
                                                        , 'check_spam'               => 'true'
                                                        , 'registered_user'          => 'false'
                                                        , 'registered_user'          => 'false'
                                                       )
                              );
    return $instance;
  }

  public static function activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . "messagebox";
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
        id int(10) NOT NULL auto_increment,
        user_login varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
        website varchar(255) COLLATE latin1_general_ci NOT NULL default '',
        post_date datetime NOT NULL default '0000-00-00 00:00:00',
        message text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
        status tinyint(1) NOT NULL default '0',
        ip varchar(15) COLLATE latin1_general_ci NOT NULL default '',
        PRIMARY KEY  (id)
      );";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
    }
    self::add_cache_table();
  }

  private static function add_cache_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "messagebox_embed_cache";
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
        url VARCHAR(200) NOT NULL,
        timestamp INT UNSIGNED NOT NULL,
        content LONGTEXT,
        PRIMARY KEY  (url)
      );";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
    }
    wp_schedule_event(time(), 'daily', __CLASS__ . '::truncate_old_cache');
  }

  public static function deactivate() {
	  wp_clear_scheduled_hook(__CLASS__ . '::truncate_old_cache');
  }

  static function init() {
    // we do not do this in __construct(), because we want it only once, not for every instance
    self::update_version();
    load_plugin_textdomain("shoutbox2", false, basename(dirname(__FILE__)) . "/lang/");

    // ajax actions
    add_action('wp_ajax_shoutbox_refresh',            array(__CLASS__, 'refresh'));
    add_action('wp_ajax_nopriv_shoutbox_refresh',     array(__CLASS__, 'refresh'));
    add_action('wp_ajax_shoutbox_delete_message',     array(__CLASS__, 'delete_message'));
    add_action('wp_ajax_shoutbox_add_message',        array(__CLASS__, 'add_message'));
    add_action('wp_ajax_nopriv_shoutbox_add_message', array(__CLASS__, 'add_message'));
    add_action('wp_ajax_shoutbox_single',             array(__CLASS__, 'single'));
    add_action('wp_ajax_nopriv_shoutbox_single',      array(__CLASS__, 'single'));

    // rewrite endpoint for rss output
    add_rewrite_endpoint(self::rss_path, EP_ROOT);
    add_action('template_redirect', array(__CLASS__, 'rss_output'));

    $can_moderate = (function_exists('current_user_can') && current_user_can('moderate_comments')) ? true : false;

    add_filter('shoutbox_message', array(__CLASS__, 'sanitize_message'), 5, 2);
    add_filter('shoutbox_message', 'stripslashes', 6);
    add_filter('shoutbox_message', 'convert_smilies');
    add_filter('shoutbox_message', 'wptexturize');
    add_filter('shoutbox_message', array(__CLASS__, 'custom_texturize'));
    add_filter('shoutbox_message', array(__CLASS__, 'asterisk_formatting'));
    add_filter('shoutbox_message', array(__CLASS__, 'reply_message'));
    add_filter('shoutbox_message', array(__CLASS__, 'custom_youtube_embed'), 10, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'facebook_img_embed'), 9, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'facebook_event_embed'), 9, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'custom_img_embed'), 10, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'custom_audio_embed'), 10, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'custom_video_embed'), 10, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'custom_ebay_embed'), 10, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'custom_amazon_embed'), 10, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'custom_imageshack_embed'), 10, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'custom_tumblr_embed'), 10, 2);
    // add_filter('shoutbox_message', array(__CLASS__, 'custom_instagram_embed'), 10, 2);
    // add_filter('shoutbox_message', array(__CLASS__, 'custom_kickstarter_embed'), 10, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'oembed_message'), 20, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'general_embed'), 45, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'make_emails_clickable'), 49, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'make_links_clickable'), 50, 2);
    add_filter('shoutbox_message', array(__CLASS__, 'shorten_links_content'), 51, 2);

    add_filter('shoutbox_menu', array(__CLASS__, 'reply_link'), 5, 4);
    if ($can_moderate) {
      add_filter('shoutbox_menu', array(__CLASS__, 'delete_link'), 6, 4);
      add_filter('shoutbox_menu', array(__CLASS__, 'ip_address'), 9, 5);
    }
  }

  private static function update_version() {
    $user = wp_get_current_user();
    if (!in_array('administrator', $user->roles))
      return;
    $registered_version = get_option(self::SHOUTBOX_ID_BASE . '_version', '0');
    if (version_compare($registered_version, self::version, '<')) {
      if (version_compare($registered_version, '2.0.0', '<'))
        self::add_cache_table();
      update_option(self::SHOUTBOX_ID_BASE . '_version', self::version);
    }
  }

  static function enqueue_scripts() {
    $suffix = '.min';
    wp_register_script('simple_ajax_shoutbox', plugins_url("/js/ajax_shoutbox$suffix.js", __FILE__), array('jquery'));

    if (self::js_to_head())
      self::enqueue_js();

    wp_register_style('ajax_shoutbox', plugins_url("css/ajax_shoutbox$suffix.css", __FILE__));
    wp_enqueue_style('ajax_shoutbox');

    $theme = wp_get_theme();
    if (file_exists(__DIR__ . "/css/" . $theme->get_template() . "$suffix.css")) {
      wp_register_style('ajax_shoutbox_theme', plugins_url("css/" . $theme->get_template() . "$suffix.css", __FILE__));
      wp_enqueue_style('ajax_shoutbox_theme');
    }
    if ($theme->get_template() != $theme->get_stylesheet() && file_exists(__DIR__ . "/css/" . $theme->get_stylesheet() . "$suffix.css")) {
      wp_register_style('ajax_shoutbox_child_theme', plugins_url("css/" . $theme->get_stylesheet() . "$suffix.css", __FILE__));
      wp_enqueue_style('ajax_shoutbox_child_theme');
    }

    wp_enqueue_style('dashicons');
  }

  private static function js_to_head() {
    $active_plugins = get_option("active_plugins");
    if (is_array($active_plugins) && in_array('wp-minify/wp-minify.php', $active_plugins)) {
      $wp_minify = get_option("wp_minify");
      if (is_array($wp_minify) && array_key_exists('enable_js', $wp_minify) && $wp_minify['enable_js'])
        return true;
    }
    return false;
  }

  private static function enqueue_js($reload_time = 30, $max_messages = 20, $max_msglen = 255) {
      wp_localize_script('simple_ajax_shoutbox',
                         'SimpleAjaxShoutbox',
                         array(
                           'ajaxurl'               => admin_url('admin-ajax.php'),
                           'reload_time'           => $reload_time,
                           'max_messages'          => $max_messages,
                           'max_msglen'            => $max_msglen,
                           'max_msglen_error_text' => __("Max length of message is %maxlength% characters, length of your message is %length% characters. Please shorten it.", 'shoutbox2'),
                           'name_empty_error_text' => __("Name empty.", 'shoutbox2'),
                           'msg_empty_error_text'  => __("Message empty.", 'shoutbox2'),
                           'delete_message_text'   => __('Delete this message?', 'shoutbox2')
                        ));
      wp_enqueue_script('simple_ajax_shoutbox');
  }

  public function admin_enqueue_scripts($hook) {
    if ($hook != 'widgets.php')
      return;
    $suffix = '.min';
    wp_enqueue_style('simple_ajax_shoutbox-admin', plugins_url("/css/admin$suffix.css", __FILE__));
    wp_enqueue_style('dashicons');
  }

  static function refresh() {
    extract($_POST);
    wp_send_json(self::content(self::widget_instance($id), $m));
  }

  static function single() {
    extract($_POST);
    global $wpdb;
    $table_name = $wpdb->prefix . "messagebox";
    if ($row = $wpdb->get_row("SELECT * , post_date FROM $table_name WHERE id=$m_id")) {
      wp_send_json(self::format_message($row->user_login, $row->message, $row->post_date, $row->id, $row->website, $row->ip, self::widget_instance($id)));
    } else {
      wp_send_json("");
    }
  }

  private static function content($options, $limit=-1) {
    $return = '';
    if ($limit < 0) $limit = $options['max_messages'];
    global $wpdb;
    $table_name = $wpdb->prefix . "messagebox";

    if ($result = $wpdb->get_results("SELECT *,post_date FROM " . $table_name . " ORDER BY id DESC LIMIT " . $limit)) {
      foreach ($result as $row)
        $return .= self::format_message($row->user_login, $row->message, $row->post_date, $row->id, $row->website, $row->ip, $options);
    } else
      $return .= "<div align='center'><b>" . __('No messages.', 'shoutbox2') . "</b></div>";
    return $return;
  }

  private static function format_message($username, $message_text, $message_date, $message_id = 0, $userwebsite = "", $ip_address = '', $options, $new_message = false) {

    $userwebsite = preg_replace('/^http[s]?:\/\//i', '', $userwebsite);

    if ($options['allow_html'] != 'true')
      $username = htmlspecialchars(strip_tags($username));
    $userdisplay = (!empty($userwebsite)) ? "<a href=\"http://$userwebsite\" rel=\"external nofollow\">$username</a>" : $username;

    $message_date = strtotime($message_date);
    if (StrFTime("%Y", $message_date) == StrFTime("%Y", Time())) {
      if (StrFTime("%d.%m", $message_date) == StrFTime("%d.%m", Time())) {
        $message_date = StrFTime("%H:%M", $message_date);
      } else {
        $message_date = StrFTime("%d.%m %H:%M", $message_date);
      }
    } else {
      $message_date = StrFTime("%d.%m.%Y %H:%M", $message_date);
    }

    $message_id = intval($message_id);

    $message_text = apply_filters('shoutbox_message', $message_text, $options);

    $msg_header  = "<div class=\"sb_message_header\">";
    $msg_header .= self::get_avatar(self::get_user_id($username));

    $menu = apply_filters('shoutbox_menu', "", $message_text, $username, $options, $ip_address);
    if ($menu != "")
      $msg_header .= "<span class=\"menu\">$menu</span>";

    $msg_header .= "<span class=\"username\">$userdisplay</span> <span class=\"info\">$message_date</span>";
    $msg_header .= "</div>";
    
    $msg_body = "<div class=\"sb_message_body\">$message_text</div>";

    $msg_inner = $msg_header . $msg_body;

    $msg_outer = "<div id=\"sb_message_$message_id\" class=\"sb_message" . ($new_message ? " new_message" : "") . "\" hash=\"" . hash("md5", $msg_inner) . "\">"
                 . $msg_inner
                 . "</div>\n";

    return $msg_outer;
  }

  public static function get_user_id($user_display_name) {
    static $cache = array();
    if (!array_key_exists($user_display_name, $cache)) {
      $user = get_user_by('login', $user_display_name);
      if ($user == false) {
        global $wpdb;
        $user_id = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE display_name = '" . $user_display_name . "'");
        $cache[$user_display_name] = is_numeric($user_id) ? $user_id : "";
      } else
        $cache[$user_display_name] = $user->ID;
    }

    return $cache[$user_display_name];
  }

  private static function get_avatar($user_id) {
    $wp_avatar = get_avatar($user_id);
    $result = "<span";
    if (preg_match('/class=[\'"][\w\-\s]*[\'"]/i', $wp_avatar, $matches))
      $result .= " $matches[0]";
    if (preg_match('/src=[\'"]([\w\-\s\:\/\?\.\=\%\&\;#]+)[\'"]/i', $wp_avatar, $matches))
      $result .= " style=\"background-image: url('$matches[1]')\"";
    $result .= "></span>";
    return $result;
  }

  public static function sanitize_message($text, $options = NULL) {
    if (is_null($options) || $options['allow_html'] == 'true')
      $text = strip_tags($text);
    $text = str_replace("\\n", chr(10), $text);
    $text = stripslashes(htmlspecialchars($text));

    return $text;

  }

  public static function asterisk_formatting($text) {
    $matches = null;
    while (preg_match('~(?:^|(?<=\s))([\*\/\_])(.*?\w)\1(?=(?:$|\s))~', $text, $matches)) {
      switch ($matches[1]) {
      case "*":
        $tag = "strong";
        break;
      case "/":
        $tag = "em";
        break;
      case "_":
        $tag = "u";
        break;
      default:
        $tag = "span";
        break;
      }
      $text = str_replace($matches[0], "<$tag>{$matches[0]}</$tag>", $text);
      $matches = null;
    }
    return $text;
  }

  public static function custom_texturize($text) {
    $replacements = array('/\+-(\d)/' => '±\1',
                          '/->/'      => '→'
                         );
    return preg_replace(array_keys($replacements), array_values($replacements), $text);
  }

  public static function get_message_author($message_id) {
    static $cache = array();
    if (!array_key_exists($message_id, $cache)) {
      global $wpdb;
      $table_name = $wpdb->prefix . "messagebox";
      $cache[$message_id] = $wpdb->get_var("SELECT user_login FROM $table_name WHERE id=" . $message_id);
    }
    return $cache[$message_id];
  }

  public static function reply_message($text) {
    $text = preg_replace_callback("/{reply (\d+)}/", create_function('$matches', 'return "<span class=\"reply\" rel=\"$matches[1]\">" . Ajax_Shoutbox_Widget::get_message_author($matches[1]) . "</span>";'), $text);
    return $text;
  }

  public static function make_links_clickable($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('#([\s,]|^)(((http|ftp)s?://)?'.self::$url_match.')(\W|$)#i', create_function('$matches', 'return preg_match("/^[a-z]+\.[A-Z][a-z]+$/", $matches[2]) ? "$matches[1]$matches[2]$matches[8]" : "$matches[1]<a href=\"".Ajax_Shoutbox_Widget::shorten_youtube(($matches[3]==""?"http://":"").$matches[2])."\" target=\"_blank\" title=\"$matches[2]\">".$matches[2]."</a>$matches[8]";'), $text);
  }

  public static function make_emails_clickable($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    $mail_match ='[a-z0-9_\.\-]+@([a-z0-9\-\_]+\.)+('.self::tld.')';

    $text = preg_replace('#([ \.\n\t\-]|^|mailto:)('.$mail_match.')#i', '${1}<a href="mailto:${2}">${2}</a>', $text);

    return $text;
  }

  public static function custom_youtube_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('#(?<=[\s,]|^)((http|ftp)s?://)?((www\.)?youtube\.com/watch|youtu\.be/)'.self::url_path.'#i', create_function('$matches', '
      if (preg_match("%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^\"&?/ ]{11})%i", $matches[0], $match)) {
        return  "<span class=\"youtube-embed-wrapper\">
                <span class=\"youtube-embed-video\" style=\"background-image: url(https://i.ytimg.com/vi/$match[1]/hqdefault.jpg)\"><a href=\"https://www.youtube.com/watch?v=$match[1]\" target=\"_blank\" class=\"play-button\" rel=\"$match[1]\"></a></span>
                </span>"
                ;
      }
      return $matches[0];
    '), $text);
  }

  public static function general_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('#(?<=[\s,]|^)(((http|ftp)s?://)?'.self::$url_match.')(?=\W|$)#i', array(__CLASS__, "general_embed_replace"), $text);
  }

  public static function general_embed_replace($matches) {
    $url = $matches[0];
    if (strpos($url, "/") > 0) {
      $html = self::get_http($url);
      if ($html !== false) {
        if (preg_match('/<meta[^>]+property="og:title"[^>]+content="([^"]+)"/', $html, $titmatches))
          $title = $titmatches[1];
        else if (preg_match('#<h1[^>]+class="entry-title">(.+)</h1>#', $html, $titmatches))
          $title = $titmatches[1];
        else if (preg_match('#<title>([^<]+)</title>#', $html, $titmatches))
          $title = $titmatches[1];
        else
          $title = "";
        if ($title != "") {
          $title = preg_replace("/\s+\|\s+[\w\.]+$/", "", $title);
          if (preg_match('/<meta[^>]+property="og:image"[^>]+content="([^"]+)"/', $html, $imgmatches))
            $img = "<img src=\"{$imgmatches[1]}\">";
          else if (preg_match('/<img[^>]+src="([^"]+)"[^>]+class="(?:[^"]*\s)?wp-post-image(?:\s[^"]*)?"/', $html, $imgmatches))
            $img = "<img src=\"{$imgmatches[1]}\">";
          return "<div class=\"general-embed\"><a href=\"{$matches[0]}\" target=\"_blank\" class=\"title\">$title$img<div class=\"url\">$url</div></a></div>";
        }
      }
    }
    return $url;
  }

  public static function custom_ebay_embed_replace($matches) {
    $html = self::get_http($matches[1], 15);
    if ($html !== false && preg_match('/<meta.*?property="og:title".*?content="(.*?)"/', $html, $titmatches)) {
      $title = $titmatches[1];
      if (preg_match('/<img.*?id="icImg".*?src="(.*?)"/', $html, $imgmatches))
        $img = "<img src=\"{$imgmatches[1]}\">";
      if (preg_match('/<span.*?id="prcIsum(?:_bidPrice)?".*?>(.*?)<\/span>/', $html, $prcmatches))
        $price = "<span class=\"price\">{$prcmatches[1]}</span>";
      if ($price == "" && preg_match('/<span.*?class="\w+ vi-VR-cvipPrice".*?>(.*?)<\/span>/', $html, $prcmatches))
        $price = "<span class=\"price\">{$prcmatches[1]}</span>";
      return "<div class=\"ebay-embed\"><a href=\"{$matches[0]}\" target=\"_blank\" class=\"title\">$title$img</a>$price</div>";
    }
    return $matches[0];
  }
  
  public static function custom_ebay_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('~(?:^|(?<=\s))((?:http://)?www\.ebay\.[\w\.]+/itm/[\w\-]+/\d+)(?:\?\S*)?(?=(?:$|\s))~', array(__CLASS__, "custom_ebay_embed_replace"), $text);
  }

  public static function custom_amazon_embed_replace($matches) {
    $url = $matches[0];
    if (preg_match('#^https?(.*?)/(ref=\w+)\?.*#', $url, $urlmatch))
      $url = "http$urlmatch[1]?$urlmatch[2]";
    $html = self::get_http($url);
    if ($html !== false && preg_match('/<span\s+id="productTitle"[^>]*>([^<]+)<\/span>/', $html, $titmatches)) {
      $title = $titmatches[1];
      if (preg_match('/<img[^>]*data-a-dynamic-image="{&quot;([^&]+)&/si', $html, $imgmatches))
        $img = "<img src=\"{$imgmatches[1]}\">";
      if (preg_match('/<span\s+id="priceblock_ourprice"[^>]*>\s*([^\s<]+)\s*<\/span>/is', $html, $prcmatches))
        $price = "<span class=\"price\">{$prcmatches[1]}</span>";
      else if (preg_match('/<li\s+class="swatchElement\s+selected">.*?<span\s+class="a-color-price">\s*([^\s<]+)\s*<\/span>/is', $html, $prcmatches))
        $price = "<span class=\"price\">{$prcmatches[1]}</span>";
      else if (preg_match('/<li[^>]+class="swatchSelect">.*?<span\s+class="a-size-mini">\s*([^\s<]+)\s*<\/span>/is', $html, $prcmatches))
        $price = "<span class=\"price\">2</span>";
      return "<div class=\"amazon-embed\"><a href=\"{$matches[0]}\" target=\"_blank\" class=\"title\">$title$img</a>$price</div>";
    }
    return $matches[0];
  }
  
  public static function custom_amazon_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('~(?:^|(?<=\s))(?:https?://)?www\.amazon\.(?:co\.)?(?:' . self::tld . ')/[/\w&\-\?;=]+(?=(?:$|\s))~', array(__CLASS__, "custom_amazon_embed_replace"), $text);
  }

  public static function custom_imageshack_embed_replace($matches) {
    $html = self::get_http(str_replace("https://", "http://", $matches[0]));
    if ($html !== false && preg_match('/<img.*?id="lp-image".*?src="(.*?)"/', $html, $imgmatches)) {
      return "<a href=\"{$imgmatches[1]}\" target=\"_blank\"><img src=\"{$imgmatches[1]}\" alt=\"\"></a>";
    }
    
    return $matches[0];
  }

  public static function custom_imageshack_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    $text = preg_replace_callback('~(?:^|(?<=\s))(?:https?://)?(?:www\.)?imageshack\.us/i/\w+~', array(__CLASS__, "custom_imageshack_embed_replace"), $text);
    return preg_replace('~(?:^|(?<=\s))(?:http://)?(?:www\.)?imageshack\.com/i/\w+~', '<a href="\0" target="_blank"><img src="\0" alt=""></a>', $text);
  }

  public static function custom_instagram_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace('~(?:^|(?<=\s))(?:https?://)?(?:www\.)?instagram\.com/p/\w+/~', '<iframe class="instagram-embed" src="\0embed/captioned/?v=4"></iframe>', $text);
  }

  public static function custom_tumblr_embed_replace($text, $options = NULL) {
    $html = self::get_http($matches[0]);
    if ($html !== false && preg_match('/<img.*?id="content-image".*?data-src="(.*?)"/', $html, $imgmatches))
      return "<a href=\"{$imgmatches[1]}\" target=\"_blank\"><img src=\"{$imgmatches[1]}\" alt=\"\"></a>";

    return $matches[0];
  }
  
  public static function custom_tumblr_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('~(?:^|(?<=\s))(?:http://)?\w+\.tumblr\.com/image/\d+[\w:]+~', array(__CLASS__, "custom_tumblr_embed_replace"), $text);
  }

  public static function custom_kickstarter_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return $text;
  }

  private static $http_cache = array();
  public static function get_http($URL, $cachetime = 3600, $header = 0) {
    if (!isset(self::$http_cache[$URL])) {
      global $wpdb;
      $use_cache = true;
      $table_name = $wpdb->prefix . "messagebox_embed_cache";
      $hash = hash('ripemd160', $URL);
      if ($use_cache) {
        if ($cached = $wpdb->get_row("SELECT timestamp, content FROM $table_name WHERE url='$hash'")) {
          if ($cached->timestamp + $cachetime < time())
            $wpdb->delete($table_name, array('url' => $hash));
          else
            self::$http_cache[$URL] = unserialize($cached->content);
        }
      }

      if (!isset(self::$http_cache[$URL])) {
        if (!function_exists('curl_init'))
          return FALSE;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $fetch = curl_exec($ch);
        $errno = curl_errno($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($fetch !== false && $info['http_code'] == 200 && ! $errno > 0) {
          self::$http_cache[$URL] = $fetch;
          if ($use_cache)
            $wpdb->insert($table_name,
                          array(
                            'url'       => $hash,
                            'timestamp' => time(),
                            'content'   => serialize(trim(self::$http_cache[$URL]))));
        }
      }
    }

    if (array_key_exists($URL, self::$http_cache))
      return self::$http_cache[$URL];
    else
      return "";
  }

  public static function truncate_old_cache() {
    global $wpdb;
    $table_name = $wpdb->prefix . "messagebox_embed_cache";
    $timestamp = time() - 24 * 60 * 60; // delete all cached objects older than 24h
    $wpdb->query("DELETE FROM $table_name WHERE timestamp < $timestamp");
  }

  public static function custom_img_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('#([\s,]|^)(((http|ftp)s?://)?'.self::$img_match.'\.(jpg|jpeg|png|gif))#i', create_function('$matches', 'return "$matches[1]<a href=\"".($matches[3]==""?"http://":"").$matches[2]."\" target=\"_blank\"><img src=\"".($matches[3]==""?"http://":"").$matches[2]."\" alt=\"\"></a>";'), $text);
  }

  public static function facebook_img_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace('~(?:^|(?<=\s))(?:https://)?(?:[\w\.\-]+\.fbcdn\.net|fbcdn-sphotos-[\w\.\-]+\.akamaihd\.net)/[\w\.\-/]+\.jpg\?[\w\.\-/=&;]+~', '<a href="\0" target="_blank"><img src="\0" alt=""></a>', $text);
  }

  public static function facebook_event_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('~(?:^|(?<=\s))((?:https?://)?www\.facebook\.com/events/\d+/?)(?:\?[\w=&;%]+)?~', array(__CLASS__, "facebook_event_embed_replace"), $text);
  }
  
  public static function facebook_event_embed_replace($matches) {
    $html = self::get_http($matches[1]);
    if ($html !== false && preg_match('/\["DocumentTitle","set",\[\],\["([^"]+)"/', $html, $titmatches)) {
      $title = json_decode("\"$titmatches[1]\"");
      if (preg_match('/<img\s+class="[\w\s]*coverPhotoImg[\w\s]*"\s+src="([^"]+)"/', $html, $imgmatches))
        $img = "<img src=\"{$imgmatches[1]}\">";
      if (preg_match('~<a\s+href="/events/calendar\?adjusted_ts.*?</td>~', $html, $tmatches))
        $time = preg_replace("~(?<=:\d\d)[\w\s]+UTC[-+]\d\d~", "", preg_replace("/<[^>]+>/", "", preg_replace('/<a\s[^>]+getForecast[^>]+>[^<]*<\/a>/is', '', preg_replace('~<span(?:\s+role="presentation"[^>]*)?>[^<]+</span>~i', "", preg_replace('~<a\s[^<]+</a>~', '\0 ', preg_replace('~<div\s+class="_5xhp\sfsm\sfwn\sfcg">[^<]*</div>~i', '', $tmatches[0]))))));
      return "<div class=\"fb-event-embed\"><a href=\"{$matches[0]}\" target=\"_blank\" class=\"title\">$title$img</a>$time</div>";
    }
    return $matches[0];
  }

  public static function custom_video_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('#([\s,]|^)(((http|ftp)s?://)?'.self::$img_match.'\.('.implode("|", wp_get_video_extensions()).'))#i', create_function('$matches', 'return $matches[1] . wp_video_shortcode(array("src" => ($matches[3]==""?"http://":"").$matches[2]));'), $text);
  }

  public static function custom_audio_embed($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    return preg_replace_callback('#([\s,]|^)(((http|ftp)s?://)?'.self::$img_match.'\.('.implode("|", wp_get_audio_extensions()).'))#i', create_function('$matches', 'return $matches[1] . wp_audio_shortcode(array("src" => ($matches[3]==""?"http://":"").$matches[2]));'), $text);
  }

  public static function oembed_message($text, $options = NULL) {
    if (is_null($options) || $options['url_clickable'] != 'true')
      return $text;

    $index = version_compare($GLOBALS["wp_version"], "4.2", "<") ? 1 : 2;
    $own = get_option('siteurl');
    return preg_replace_callback('#([\s,]|^)(((http|ftp)s?://)?'.self::$url_match.')(\W|$)#i',
                                  create_function('$matches',
                                                  '$url = ($matches[3]==""?"http://":"").$matches[2];
                                                   if (strpos($matches[2], "/") === FALSE || "'.$own.'" == substr($url, 0, strlen("'.$own.'"))) return $matches[1] . $matches[2] . $matches[8];
                                                   $oembed = wp_oembed_get($url);
                                                   if ($url == trim($oembed) || $oembed == "")
                                                     $oembed = $GLOBALS["wp_embed"]->autoembed_callback(array('.$index.' => $url));
                                                   return $matches[1] . ($url == trim($oembed) || $oembed == "" ? $matches[2] : $oembed) . $matches[8];'),
                                  $text);
  }

  private static function widget_instance($widget_id = FALSE) {
      $settings = get_option('widget_' . self::SHOUTBOX_ID_BASE);

      if ( !is_array($settings) )
        $settings = array();

      if ( !array_key_exists('_multiwidget', $settings) ) {
        // old format, conver if single widget
        $settings = wp_convert_widget_settings(strtolower(self::SHOUTBOX_ID_BASE), 'widget_' . self::SHOUTBOX_ID_BASE, $settings);
      }

      unset($settings['_multiwidget'], $settings['__i__']);

      if ($widget_id === FALSE) {
        foreach ($settings as $instance) {
          if (is_array($instance))
            return $instance;
        }
      } else if (array_key_exists($widget_id, $settings)) {
        $instance = $settings[$widget_id];
        return $instance;
      }
  }

  public static function shorten_links_content($text) {
    return preg_replace_callback('#>(ht|f)tps?://[^<]*#', create_function('$matches', '
      $result = substr($matches[0], 1);
      if (strlen($result) > 25 && substr($result, 0, 7) == "http://") $result = substr($result, 7);
      if (strlen($result) > 25 && substr($result, 0, 8) == "https://") $result = substr($result, 8);
      if (strlen($result) > 25 && substr($result, 0, 4) == "www.") $result = substr($result, 4);
      return ">" . $result;'), $text);
  }

  public static function shorten_youtube($url) {
    return preg_replace('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', 'http://youtu.be/$1', $url);
  }

  static function delete_message() {
    check_ajax_referer("shoutbox_moderator");
    extract($_POST);
    if (is_user_logged_in()) {
      if (function_exists('current_user_can') && current_user_can('moderate_comments')) {
        global $wpdb;
        $wpdb->delete($wpdb->prefix . "messagebox", array('id' => $m_id));
        wp_send_json($m_id);
      }
    }
    wp_send_json(0);
  }

  static function add_message() {
    $return = '';

    global $wpdb;
    $table_name = $wpdb->prefix . "messagebox";

    $widgetID = 0;
    if (array_key_exists('id', $_POST))
      $widgetID = $_POST['id'];
    else if (array_key_exists('id', $_GET))
      $widgetID = $_GET['id'];
    $options = self::widget_instance($widgetID);

    $siteurl = get_option('siteurl');

    if (is_user_logged_in ()) {
      global $current_user;
      get_currentuserinfo();
      $user = $current_user->display_name;
      $website = $current_user->user_url;
      $proceed = true;
    } else if ($options['registered_user'] == 'true') {
      $return .= "<div class='error_message'>" . __('Only registered user allowed.', 'shoutbox2') . "</div>";
      $proceed = false;
    } else if (isset($_POST['user'])) {
      if (username_exists(trim ($_POST['user']))) {
        $return .= "<div class='error_message'>" . __('Name already exists, please choose another.', 'shoutbox2') . "</div>";
        $proceed = false;
      } else if (strlen($_POST['user']) == 0) {
        $return .= "<div class='error_message'><b>" . __('Name empty.', 'shoutbox2') . "</b></div>";
        $proceed = false;
      } else {
        $user = esc_sql(trim(strip_tags($_POST['user'])));
        $website = esc_sql(esc_attr($_POST['website']));
        $proceed = true;
      }
    } else {
      if (!@validate($_POST['user'])) {
        $return .= "<div class='error_message'>" . __('Name empty.', 'shoutbox2') . "</div>";
        $proceed = false;
      } else {
        $proceed = true;
      }
    }

    $message = esc_sql($_POST['message']);

    if (strlen($message) == 0) {
      $return .= "<div class='error_message'><b>" . __('Message empty.', 'shoutbox2') . "</b></div>";
      $proceed = false;
    }

    $key = get_option('wordpress_api_key');
    if ($options['check_spam'] == 'true' && !empty($key)) {
      $akismet_api_host = $key . '.rest.akismet.com';

      $comment ['user_ip'] = preg_replace ( '/[^0-9., ]/', '', $_SERVER ['REMOTE_ADDR'] );
      $comment ['user_agent'] = $_SERVER ['HTTP_USER_AGENT'];
      $comment ['referrer'] = $httpreferer;
      $comment ['blog'] = get_option ( 'home' );
      $comment ['comment_author'] = $user;
      $comment ['comment_author_url'] = 'http://' . preg_replace ( '/^http[s]?:\/\//i', '', $website );
      $comment ['comment_content'] = $message;

      $ignore = array ('HTTP_COOKIE' );

      foreach ($_SERVER as $key => $value)
        if (!in_array ($key, $ignore))
          $comment ["$key"] = $value;

      $query_string = '';
      foreach ($comment as $key => $data) {
        $query_string .= $key . '=' . urlencode(stripslashes(strval($data))) . '&';
      }
      $response = self::spam_check($query_string, $akismet_api_host, '/1.1/comment-check', 80);

      if ('true' == $response [1]) {
        $return .= "<div class='error_message'><b>" . __('Blocked by Akismet.', 'shoutbox2') . "</b></div>";
        $proceed = false;
      }
    }

    if ($proceed) {
      $tzNOW = current_time('mysql');

      if (!is_numeric($options['flood_time'])) $options['flood_time'] = 3;
      if ($wpdb->get_var("SELECT count(*) FROM " . $table_name . " WHERE ip='" . @$_SERVER['REMOTE_ADDR'] . "' AND (post_date + INTERVAL " . $options['flood_time'] . " SECOND) > '$tzNOW'") > 1) {
        $return .= "<div class='error_message'>" . __('Please try again after a few seconds.', 'shoutbox2' ) . "</div>";

      } else if ($wpdb->insert($table_name,
                               array(
                                 'user_login' => $user,
                                 'website'    => $website,
                                 'post_date'  => $tzNOW,
                                 'message'    => $message,
                                 'status'     => '1',
                                 'ip'         => @$_SERVER['REMOTE_ADDR']
                               ))) {
        $return .= self::format_message($user, $message, $tzNOW, $wpdb->insert_id, $website, @$_SERVER['REMOTE_ADDR'], $options, true);
        do_action('shoutbox_new_message', $user, $_POST['message'], $options);

      } else {
        $return .= "<div class='error_message'><b>" . __('Database insert failure. Try reinstall plugin.', 'shoutbox2') . "</b></div>";
      }
    }
    wp_send_json($return);
  }

  private static function spam_check($request, $host, $path, $port = 80) {
    $http_request = "POST $path HTTP/1.0\r\n";
    $http_request .= "Host: $host\r\n";
    $http_request .= "Content-Type: application/x-www-form-urlencoded; charset=" . get_settings ( 'blog_charset' ) . "\r\n";
    $http_request .= "Content-Length: " . strlen ( $request ) . "\r\n";
    $http_request .= "User-Agent: WordPress/$wp_version | Akismet/1.11\r\n";
    $http_request .= "\r\n";
    $http_request .= $request;

    $response = '';
    if (false !== ($fs = @fsockopen($host, $port, $errno, $errstr, 3))) {
      @fwrite($fs, $http_request);
      while (!feof($fs))
        $response .= @fgets($fs, 1160);
      fclose($fs);
      $response = explode("\r\n\r\n", $response, 2);
    }
    return $response;
  }

  public static function reply_link($menu, $message_text, $username, $options) {
    $menu .= '<a href="#" class="command reply">' . __('Reply') . '</a>';
    return $menu;
  }

  public static function delete_link($menu, $message_text, $username, $options) {
    $menu .= '<a href="#" class="command delete">' . __('Delete') . '</a>';
    return $menu;
  }

  public static function ip_address($menu, $message_text, $username, $options, $ip) {
    $menu .= '<span class="info ip-address" title="' . __("IP address", "shoutbox2") . '">' . $ip . '</span>';
    return $menu;
  }

  public static function rss_output() {
    $request_uri = $_SERVER["REQUEST_URI"];
    if (substr($request_uri, -1) == '/') $request_uri = substr($request_uri, 0, strlen($request_uri) - 1);
    if ($request_uri != substr(get_site_url() . '/' . self::rss_path, -strlen($request_uri)))
        return;

    $options = self::widget_instance();
    if ($options['shoutbox_rss'] != 'true') {
    	header("HTTP/1.0 403 Forbidden");
    	exit;
    }

    header('Expires: ' . gmdate('D, d M Y H:i:s') . '  GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . '  GMT');
    header('Content-Type: text/xml; charset=utf-8');

    $blogname = get_bloginfo('name');
    $home = get_bloginfo('url');
    if (substr($home, -1) != '/') $home .= '/';

    ob_start();
    echo '<?xml version="1.0" encoding="utf-8"?>';
    /* echo '<?xml-stylesheet type="text/css" href="css/ajax_shoutbox_rss.css" ?>'; /* */
    echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/">'
         . '<channel>'
         . '<title>' . str_replace('%blogname%', $blogname, __('%blogname% chat', 'shoutbox2')) . '</title>'
         . "<link>$home</link>"
         . '<lastBuildDate>' . gmdate("D, d M Y H:i:s")." GMT" . '</lastBuildDate>'
         ;

  	global $wpdb;
  	$table_name = $wpdb->prefix . "messagebox";
  	$limit = 20;

   	if ($result = $wpdb->get_results("SELECT *,post_date FROM " . $table_name . " ORDER BY id DESC LIMIT " . $limit)) {
   		foreach ($result as $row) {
      	$title = __('Message from %username% | %blogname% chat', 'shoutbox2');
      	$title = str_replace('%blogname%', $blogname, $title);
      	$title = str_replace('%username%', htmlspecialchars ( strip_tags ( $row->user_login ) ), $title);
        $message = htmlspecialchars(strip_tags($row->message));
        echo '<item>'
             . "<title>$title</title>"
             . "<dc:creator>" . htmlspecialchars(strip_tags($row->user_login)) . "</dc:creator>"
             . "<link>$home</link>"
             . "<guid isPermaLink=\"false\">$home?shoutbox=" . intval( $row->id ) . "</guid>"
             . "<pubDate>" . gmdate("D, d M Y H:i:s", strtotime($row->post_date)) . "</pubDate>"
             . "<description>$message</description>"
             . "<content:encoded>\n<![CDATA[\n"
             . "<p>". self::make_links_clickable($message, array('url_clickable' => 'true')) . "</p>"
             . "]]>\n</content:encoded>"
             . "</item>";
  		}
    }
    echo "</channel></rss>";
    $out1 = ob_get_contents();
    ob_end_clean();
    echo apply_filters('shoutbox_rss_result', $out1);
    die;
  }

}

register_activation_hook(__FILE__, 'Ajax_Shoutbox_Widget::activate');
register_deactivation_hook(__FILE__, 'Ajax_Shoutbox_Widget::deactivate');
add_action('widgets_init', create_function('', 'register_widget("Ajax_Shoutbox_Widget");'));
add_action('init', array('Ajax_Shoutbox_Widget', 'init'));
?>