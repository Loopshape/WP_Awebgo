<?php // (C) Copyright Bobbing Wide 2012, 2013
/**
 * Display a message when cookie-cat is not functional due to the dependencies not being activated or installed
 * Note: We can't use oik APIs here as we don't know if it's activated.
*/
function cookie_cat_inactive( $plugin=null, $dependencies=null ) {
  $plug_name = plugin_basename( $plugin );
  $message = '<div class="error">';
  $message .= "$plug_name is not yet functional. It is dependent upon the following plugins: $dependencies. Please install and activate these plugins.";
  $message .= "</div>";
  echo $message; 
}

/**
 * Test if cookie_cat is functional
 * 
 * Unless oik is installed and activated we won't do anything
 * Note: If oik is installed and activated then we would shouldn't have any problem
 * although there could be a version number requirement to satisfy as well! Not yet implemented.
*/
function cookie_cat_lazy_activation( $plugin=null, $dependencies=null, $callback=null ) {
  if ( function_exists( "oik_depends" ) ) {  
    /* Good - oik appears to be activated and loaded */
    oik_depends( $plugin, $dependencies, $callback );
  } else {
    if ( is_callable( $callback )) {
      call_user_func( $callback, $plugin, $dependencies );
    }  
  }   
}

/**
 * Define cookie-cat settings fields and page
 */
function cookie_cat_lazy_admin_menu() {
  register_setting( 'cookie_cat_options', 'cookie_cat_options', 'oik_plugins_validate' ); // No validation 
  add_submenu_page( 'oik_menu', 'cookie-cat settings', "cookie cat", 'manage_options', 'cookie_cat', "cookie_cat_options_do_page" );
}

/**
 * cookie-cat options page
*/
function cookie_cat_options_do_page() {
  oik_require( "shortcodes/cookie-cat.php", "cookie-cat" );
  oik_menu_header( "Cookie-cat options" );
  oik_box( NULL, NULL, "Options", "cookie_cat_options" );
  oik_box( null, null, "Warning", "cookie_cat_warning_message" );
  oik_box( null, null, "Feed", "cookie_cat_feed" );
  oik_box( NULL, NULL, "Cookie catalog", "cookie_cat_catalog" );
  oik_menu_footer();
  bw_flush();
}

function cookie_cat_options() {
  p( "" );
  $option = "cookie_cat_options";
  $options = bw_form_start( $option, "cookie_cat_options" );
  $options = bw_reset_options( $option, $options, "cookie_cat_default_options", "_cookie_cat_reset" ); 
  bw_trace2( $options );
  $len = 100;
  bw_form_start( $option, 'cookie_cat_options' );    
  bw_textfield_arr( $option, "cookie cat url - you shouldn't need to change this", $options, "url", 100 );
  bw_textarea_arr( $option, "Plugin list. These are the active plugins.", $options, "plugins", $len, 5 );
  bw_textarea_arr( $option, "Extra values. e.g. ,wordpress,PHP,comments", $options, "extras", $len, 2 );
  //bw_textarea-arr( $option, "Cookie list", $options, "cookies", $len, 5  );
  bw_checkbox_arr( $option, "Default <b>browser=y</b> for the [cookies] shortcode", $options, "browser" );
  bw_tablerow( array( "", "<input type=\"submit\" name=\"ok\" value=\"Save options\" class=\"button-primary\"/>") ); 
  etag( "table" );
  etag( "form" );
  cookie_cat_reset_form(); 			
  bw_flush();
} 

/**
 * Return the cookie list parameter for the request
 * Note: we pass the full cookie name to the server
 * since we expect it to be able to perform a better job in cookie_cat_simplify()
 */
function cookie_cat_cookie_list() {
  bw_trace2( $_COOKIE );
  $cookies = "&cookies="; 
  if ( count( $_COOKIE ) ) {
    foreach ( $_COOKIE as $cookie => $val ) {
      $cookies .= $cookie . "," ;
    }  
  }
  return( $cookies );
}

function cookie_cat_feeder_url() {
  $url = "&furl=";
  $url .= network_admin_url( oik_version() . '/' . bw_format_date( null, "Y/m/d H:i:s") );
  return( $url );
}  

/** 
 * 
 * This should become an oik API, with a bit of error checking
 */
function cookie_cat_load_xml( $url ) {
  $request_url = urlencode( $url );
  $response_xml = simplexml_load_file( $request_url );
  bw_trace( $response_xml, __FUNCTION__, __LINE__, __FILE__, "response_xml" );
  return $response_xml;
}

function cookie_cat_load_feed() {
  $options = get_option( "cookie_cat_options" );
  $url = bw_array_get_dcb( $options, "url", null, "cookie_cat_default_url" );
  $extras = bw_array_get_dcb( $options, "extras", null, "cookie_cat_default_extras" );
  $plugins = bw_array_get_dcb( $options, "plugins", null, "cookie_cat_plugins" );
  $request_url = $url . $plugins . $extras;
  $request_url .= cookie_cat_cookie_list();
  $request_url .= cookie_cat_feeder_url();
  $xml = cookie_cat_load_xml( $request_url );
  return( $xml ); 
}

function cookie_cat_write_temp_xml( $temp_xml ) {
  $tempxml = cookie_cat_default_temp_xml();
  $temp_xml_string = $temp_xml->asXML( $tempxml );
  //$temp_xml_string = $temp_xml->asXML();
  return( $tempxml );  
}

/**
 */
function cookie_cat_save_xml() {
  $options = "cookie_cat_saved";
  $save_xml = bw_array_get( $_REQUEST, "_cookie_cat_save_xml", null );
  $last_saved = bw_get_option( "last_saved", $options ); 
  $target = cookie_cat_default_saved_xml(); // bw_get_option( "savedxml", $options );
  if ( $save_xml ) {
    $source = cookie_cat_default_temp_xml(); //bw_get_option( "tempxml", $options );
    bw_trace2( $target, "target", false );
    bw_trace2( $source, "source", false );
    if ( $source && $target ) { 
      $success = copy( $source, $target );
      if ( $success ) { 
        $last_saved = bw_format_date( null, "Y-m-d H:i:s" ); 
        bw_update_option( "last_saved", $last_saved, $options );
      }
    }      
  }
  if ( $last_saved ) { 
    p( "Latest XML saved on $last_saved." ); 
    $url = bw_file2url( $target );
    $link = retlink( null, $url, $target, "View the latest XML file" );
    p( "XML file: $link" );
    
  } 
  bw_flush(); 
}

if ( !function_exists( "bw_update_option" ) ) {
/** Set the value of an option field in the options group
 *
 * @param string $field the option field to be set
 * @param mixed $value the value of the option
 * @param string $options - the name of the option field
 * @return mixed $value
 *
 * Parms are basically the same as for update_option
 */
function bw_update_option( $field, $value=NULL, $options="bw_options" ) {
  $bw_options = get_option( $options );
  $bw_options[ $field ] = $value;
  bw_trace2( $bw_options );
  update_option( $options, $bw_options );
  return( $value );
}
}  

function cookie_cat_load_temp_xml() {   
  $load_xml = bw_array_get( $_REQUEST, "_cookie_cat_load_xml", null );
  if ( $load_xml ) {
    $temp_xml = cookie_cat_load_feed();
    $tempxml = cookie_cat_write_temp_xml( $temp_xml );
    $last_loaded = bw_format_date( null, "Y-m-d H:i:s");
    bw_update_option( "last_loaded", $last_loaded, "cookie_cat_saved" );
  } else {
    $tempxml = cookie_cat_default_temp_xml(); //bw_get_option( "tempxml", "cookie_cat_options" );
    bw_trace2( $tempxml, "tempxml", false ); 
    $last_loaded = bw_get_option( "last_loaded", "cookie_cat_saved" );
  }
  if ( $tempxml ) { 
    p( "Latest XML loaded on $last_loaded." ); 
    $url = bw_file2url( $tempxml );
    $link = retlink( null, $url, $tempxml, "View the temporary XML file" );
    p( "Temporary XML file: $link" );
    
  }  
}

if ( !function_exists( "bw_file2url" ) ) {  
/**
 * Convert an upload dir file name to an URL
 */
function bw_file2url( $file ) {
  $upload_dir = wp_upload_dir();
  $url = str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $file);
  return( $url );
}

function bw_url2file( $url ) {
  $upload_dir = wp_upload_dir();
  $file = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $url);
  return( $file );
}
}

/** 
 * Display the cookie catalog 
 *
 */
function cookie_cat_catalog() {
  $kvs = "";

  $temp = bw_array_get( $_REQUEST, "_cookie_cat_temp_xml", "0");
  $temping = bw_validate_torf( $temp, ",,on" );
  if ( $temping ) {
    p( "Current cookie-cat catalog, using temporary XML file." );
    $kvs .= kv( "temp", "Y" );
  } else {   
    p( "Current cookie-cat catalog." );
  }
  bw_form();
  //bw_trace2( $_REQUEST, "dollar request" );
  $browser = bw_array_get( $_REQUEST, "_cookie_cat_browser", "0" );
  //bw_trace2( $browser, "browser", false );
  bw_checkbox( "_cookie_cat_browser", "Show browser cookies?", $browser );
  bw_checkbox( "_cookie_cat_temp_xml", "Use temp XML file?", $temp );
  
  $browser = bw_validate_torf( $browser, ",,on" );
  if ( $browser ) { 
    $kvs .= kv( "browser" , "Y" );
  } else {
    bw_trace2( $browser, "browser not true" );
  }     
  $redisplay = "<input type=\"submit\" name=\"_cookie_cat_catalog\" value=\"Redisplay\" class=\"button-secondary\"/>";
  e( $redisplay );
  etag( "form" );
  oik_require( "includes/oik-sc-help.inc" );
  bw_invoke_shortcode( "cookies", $kvs , "Cookie catalog" );
}

/**
 * Produce message telling user that information will be passed to another server
 */
function cookie_cat_warning_message() {
  p( "When you select the <b>Load XML</b> function, information from your website is passed to the cookie-cat server." );
  p( "This includes the names of cookies which are currently set in your browser. Only the cookie names are passed, not the content." );
  p( "This information may be used to help identify the mapping of cookies to plugins." );
  p( "If you do not want this information to be passed then please don't use the function." );
  alink( null, "http://cookie-cat.co.uk/cookie-cat-design-part-ia-cookie-cat-v1-1/", "Read about the cookie-cat design" );
}  

/**
 *  
 */
function cookie_cat_feed() {
  p( "Click on <b>Load XML</b> to load the cookie-cat XML from the server." ); 
  p( "Click on <b>Save XML</b> to save the new cookie-cat XML mapping file." );
  cookie_cat_load_temp_xml();
  cookie_cat_save_xml();
  cookie_cat_xml_form();
}

function cookie_cat_xml_form() {
  bw_form();
  $load_xml = "<input type=\"submit\" name=\"_cookie_cat_load_xml\" value=\"Load XML\" class=\"button-primary\"/>";
  e( $load_xml );
  e( "&nbsp;" );
  e( "By clicking on this button you authorize the passing of information to the cookie-cat server." );
  br();
  $save_xml = "<input type=\"submit\" name=\"_cookie_cat_save_xml\" value=\"Save XML\" class=\"button-secondary\"/>";
  e ( $save_xml );
  etag( "form" );
}

function cookie_cat_reset_form() {
  bw_form();
  $reset = "<input type=\"submit\" name=\"_cookie_cat_reset\" value=\"Reset to defaults\" class=\"button-secondary\"/>";
  e ( $reset );
  etag( "form" );
}
