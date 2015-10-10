<?php // (C) Copyright Bobbing Wide 2012-2014 

/**
 * Set the location of the temporary XML file, in the upload directory folder
 */
function cookie_cat_default_temp_xml() {
  $upload_dir = wp_upload_dir();
  $basedir = bw_array_get( $upload_dir, "basedir", null );
  $file = $basedir . '/' . "temp_mapping.xml";
  return( $file );
}


/**
 * Set the location of the cc_mapping.xml file delivered as part of the plugin
 */
function cookie_cat_default_xml() {
  return( oik_path( "xml/cc_mapping.xml", "cookie-cat" ) );
}

/**
 * Set the location of the "saved" cc_mapping XML file
 */
function cookie_cat_default_saved_xml() {
  $upload_dir = wp_upload_dir();
  $basedir = bw_array_get( $upload_dir, "basedir", null );
  $file = $basedir . '/' . "cc_mapping.xml";
  return( $file );
}

/**
 * Build the default URL for the feed request
 * 
 * Note: the first plugin is "wordpress"
 */
function cookie_cat_default_url() {
  return( "http://www.cookie-cat.co.uk/feed/cc_mapping?plugins=" );
}


/**
 * Set the extra values for the dummy plugins: wordpress, PHP 
 * 
 * Note: The extras option is used by the shortcode. 
 * The plugins option is used for the feed, but not for the shortcode.
 * The preceeding comma is required. **?** Need to code a more robust solution.
 *
 * @return string - the extra values
 */
function cookie_cat_default_extras() {
  return( ",wordpress,PHP" );
}

/**
 * Return a comma separated list of active plugin names ( without directory or .php)
 *
 * bw_get_active_plugins is a new API for oik v1.14
 * 
 * @return string - list of plugin slugs
 */
function cookie_cat_plugins() {
  oik_require( "admin/oik-depends.inc" );
  if ( !function_exists( "bw_get_active_plugins" ) ) {
    $plugins = cc_get_active_plugins();
  } else {
    $plugins = bw_get_active_plugins();
  }  
  $plugin_keys = array_keys( $plugins );
  $pluginlist = implode( ",", $plugin_keys );
  return( $pluginlist );
} 

/**
 * Default to not reporting browser cookies
 * 
 * @return string - "n"
 */
function cookie_cat_default_browser() {
  return( "n" );
}  

/** 
 * Set the cookie cat default option fields using callback functions
 *
 * @return array - defaults
 */
function cookie_cat_default_options() {
  $defaults = array( "url" => cookie_cat_default_url()
                   , "plugins" => cookie_cat_plugins()
                   , "extras" => cookie_cat_default_extras()
                   , "browser" => cookie_cat_default_browser()
                   );
  //update_option( 
                   
  add_option( "cookie_cat_options", $defaults, null, "no" );
  return( $defaults );                 
}

/**
 * Display the cookie rows
 * 
 * @param array $cookies - array of the cookies, indexed by name
 */
function cookie_cat_rows( $cookies ) {
  bw_trace2();
  if ( count( $cookies )) {
    foreach ( $cookies as $cookie => $cookie_info ) {
      cookie_cat_row( $cookie, $cookie_info );
    }  
  }
}  

/**
 * Display a cookie row: consisting of cookie name, category, description and duration
 * @param string $cookie - the simplified cookie name
 * @param array $cookie_info - the cookie information to be showen
 * @uses calls the callback function $cb to determine the description of the cookie
 * plugins should ensure that this function is callable when the 'cookies' filter is applied
 */        
function cookie_cat_row( $cookie, $cookie_info ) {
  bw_trace2();
  $dur = "&nbsp";
  
  if ( is_array( $cookie_info ) ) {
    extract( $cookie_info );
    if ( is_callable( $cb ) ) {
      $desc = call_user_func( $cb, $cookie );
    } else {
      $desc = $cb;
      // "Cannot load description for cookie: $cookie. Function not callable: $cb " ;
    }
    $name = str_replace( ",", " ", $cookie );       
  } else {
    $name = $cookie;
    $cat = "unknown";
    $desc = $cookie_info;
    
    // $row = array( $cookie, "unknown", $cookie_info, $dur ); 
  }  
  if ( !$dur ) 
    $dur = "session"; // **?** QAD
  $row = array( $name, $cat, $desc, $dur ); 
  bw_tablerow( $row );
}  

/**
 * Display the table of cookies 
 * @param array $cookies - array of cookies
 * 
 */ 
function cookie_cat_table( $cookies ) { 
  bw_trace2();
  oik_require( "bobbforms.inc" ); 
  stag( "table", "cookies wide-fat" );
  stag( "thead" );
  bw_tablerow( array( "Cookie Name", "Cookie Category", "Description", "Duration" ) );
  etag( "thead" );
  cookie_cat_rows( $cookies );
  etag( "table" );
}

/**
 * Load the cookie-cat mapping of plugins to cookies
 */
function cookie_cat_info_defaults( $options, $temp=false ) {
  if ( $temp ) {   
    $xmlfile = cookie_cat_default_temp_xml();
  } else { 
    $xmlfile = cookie_cat_default_saved_xml();
  }
   
  if ( !file_exists( $xmlfile ) ) { 
    
    $xmlfile = cookie_cat_default_xml();
  } 
  bw_trace2( $xmlfile, "xmlfile", false ); 
  // $request_url = oik_path( $xmlfile, "cookie-cat" );
  $response_xml = simplexml_load_file( $xmlfile );
  bw_trace2( $response_xml, "response_xml", false );
  return( $response_xml );
}

/**
 * Return an array of cookies
 */
function cookie_cat_as_array( $cookies ) {
  $cookie_cat = array(); 
  foreach ( $cookies->cookie as $key => $cookie ) {
    bw_trace2( $cookie, "cooky" );
    $cookie_name = (string) $cookie->name;
    $cookie_cat[$cookie_name] = cookie_cat_info( (string)  $cookie->_cookie_category
                                                , (string) $cookie->_cookie_category_duration
                                                , (string) $cookie->description
                                                );
  }
  return( $cookie_cat );
}

/**
 * Implement the [cookies] shortcode
 *  
 * @param array $atts attributes
 *   cookies="cookie list" - if not specified it builds a default list based on what's in $_COOKIE
 * and the active_plugins 
 *
 */ 
function cookie_cat( $atts=null ) {
  // oik_require( "shortcodes/oik-cookie-list-defaults.inc", "oik-cookie-list" );
  
  $options = get_option( "cookie_cat_options" );
  if ( $options === FALSE )
    $options = cookie_cat_default_options();
    
  $temp = bw_array_get( $atts, "temp", "N" );
  $temp = bw_validate_torf( $temp );
  $cookie_info_defaults = cookie_cat_info_defaults( $options, $temp );
  
  $cookie_list = bw_array_get( $atts, "cookies", null ); 
  $plugin_list = bw_array_get( $atts, "plugins", null );
  $browser_cookies = bw_array_get( $atts, "browser", null );
  if ( !$browser_cookies ) { 
    $browser_cookies = bw_array_get_dcb( $options, "browser", null, "cookie_cat_default_browser" );
  }
  $cookie_list = cookie_cat_defaults( $cookie_info_defaults, bw_validate_torf( $browser_cookies ), $cookie_list, $plugin_list );
  bw_trace2( $cookie_list );
  $cookie_names = explode( "," , $cookie_list );
  
  bw_trace2( $cookie_names );
  $cookie_cat = cookie_cat_as_array( $cookie_info_defaults->cookies );
  bw_trace2( $cookie_cat );
  $cookies = array();
  foreach ( $cookie_names as $name => $value ) {
    bw_trace2( "$name=$value" );
    $cookies[$value] = bw_array_get( $cookie_cat, $value, "unknown" );
  }
  
  bw_trace2( $cookies );
  
  $cookies = apply_filters( 'cookies', $cookies );
  cookie_cat_table( $cookies );
  return( bw_ret());
}

/** 
 * Define a cookie, category and callback for description
 * 
 * @param string $cookie_cat - Category as defined by the ICC UK Cookie Guide
 * @param string $cookie_duration - expiration of the cookie
 * @param string $cookie_cb
 *  if null then the default call back is useed
 *  if it's a callable function then this will be invoked
 *  otherwise - we treat it as the actual string
 * @return array $cookie info 
 */
function cookie_cat_info( $cookie_cat=2, $cookie_duration=null, $cookie_cb=null ) {
  if ( !$cookie_cb ) { 
    $cookie_cb = "cookie_cat_desc_defaults";
  }  
  $cookie_info = array( 'cat' => $cookie_cat, 'dur' => $cookie_duration, 'cb' => $cookie_cb,);
  return( $cookie_info );
}

/**
 * Simplify the cookie name 
 *  
 * @param string $cookie_name - the full cookie name - which may include suffices
 * @param string $preg_cookies - a list of base cookies names separated by '|'
 * @return string $simple_name - the "base" cookie name
 */
function cookie_cat_simplify( $cookie_name, $preg_cookies="wordpress_logged_in" ) {
  $simple_name = preg_replace( "/(${preg_cookies})(.*)/", "$1", $cookie_name );
  bw_trace2( $simple_name );
  return( $simple_name );
}

/**
 * Return a string of cookies for cookie_cat_simplify 
 * 
 * @param array $cookie_defaults - default information for common cookies
 * @param array $plugin_cookies - known cookies by plugin
 * @return string $preg_cookies - a '|' separated list of base cookie names
 * 
 */
function oik_get_preg_cookies( $cookie_defaults, $plugin_cookies ) {
  $preg_cookies = "";
  $sep = "";
  foreach( $cookie_defaults->cookies->cookie as $cookie ) {    
    bw_trace( $cookie, __FUNCTION__, __LINE__, __FILE__, "cookie" );
    $preg_cookies .= $sep;
    $preg_cookies .= (string) $cookie->name;
    $sep = "|";
  }
  bw_trace2( $preg_cookies );

  foreach ( $plugin_cookies as $plugin => $cookies ) {
    $preg_cookies .= $sep;
    $preg_cookies .= $cookies;
    $sep = "|";
  }    
  bw_trace2( $preg_cookies );
  return( $preg_cookies );   
} 

/**
 * Build a list of the defaults based on the current cookies 
 * AND the activated plugins OR the selected cookies
 *
 */
function cookie_cat_defaults( $cookie_info_defaults, $browser_cookies= false, $cookie_list=null, $plugin_list=null ) {
  $plugin_cookies = oik_active_plugin_cookies( $cookie_info_defaults, $plugin_list );
  
  $cookies = array();
  if ( $browser_cookies ) {
    bw_trace2( $_COOKIE );
    if ( count( $_COOKIE ) ) {
      $preg_cookies = oik_get_preg_cookies( $cookie_info_defaults, $plugin_cookies ); 
      foreach ( $_COOKIE as $cookie => $value ) {
        $cooky = cookie_cat_simplify( $cookie, $preg_cookies ); 
        if ( $cooky )
          $cookies[$cooky] = $cooky;
      }
    }
  } 
  
  if ( $cookie_list ) {
    $cookie_cookies = explode( ",", $cookie_list );
    if ( $plugin_list ) {
      $plugin_cookies = array_merge( $plugin_cookies, $cookie_cookies );
    } else {
      $plugin_cookies = $cookie_cookies;
    }
  }
  $cookies = array_merge( $cookies, $plugin_cookies );
  bw_trace2( $cookies );  

  $defaults = implode( ",", $cookies );
  bw_trace2( $defaults );
  return( $defaults );
}

/**
 * Return the cookies for a specific plugin ( or theme - **?**)
 * 
 * @param string $plugin - the plugin slug
 * @param array $default_plugin_cookies - array of default plugin cookies
 * @return array plugin cookies
 */
function oik_query_plugin_cookies( $plugin, $default_plugin_cookies ) {
  bw_trace2();
  $plug = basename( $plugin, ".php" );
  $pcl = bw_array_get( $default_plugin_cookies, $plug, null );
  if ( $pcl ) 
    $plugin_cookies = bw_assoc( explode( ",", $pcl ) );
  else
    $plugin_cookies = null; 
  bw_trace( $plugin_cookies );   
  return( $plugin_cookies );
}  


/** 
 * Return an array listing the default cookies that a WordPress site could use
 *
 * @return array $plugin_cookies array keyed by the short plugin name pointing to an array of 'simplified' cookie names 
 * The hardcoded cookie-cat-info for these cookies are:
 * WordPress cookies:
 *                , 'wordpress_logged_in_'  => oik_cookie_info( 2, "session", "WordPress cookie for a logged in user" )
 *                , 'wordpress_test_'       => oik_cookie_info( 2, "session", "WordPress cookie for a logged in user" )
 *                , 'wordpress_test_cookie' => oik_cookie_info( 1, "session", "WordPress test cookie" )
 *                , 'wordpress_'            => oik_cookie_info( 2, "session", "WordPress cookie for a logged in user" )
 *                , 'wp-settings-time-'     => oik_cookie_info( 1, "1 year", "cookie_desc_wp_settings" )
 *                , 'wp-settings-'          => oik_cookie_info( 1, "1 year", "cookie_desc_wp_settings"  )
 * PHP cookies:
 *                , 'PHPSESSID'             => oik_cookie_info( 1, "session" ) 
 *                , 'SESS'                  => oik_cookie_info( 1, "session" )
 

(
    [title] => Cookie-cat for plugins
    [cc_mapping] => Array
        (
            [0] => SimpleXMLElement Object
                (
                    [plugin-name] => oik
                )

            [1] => SimpleXMLElement Object
                (
                    [plugin-name] => googleanalytics
                    [cookies] => Array
                        (
                            [0] => SimpleXMLElement Object
                                (
                                    [cookie-name] => __utma
                                )

                            [1] => SimpleXMLElement Object
                                (
                                    [cookie-name] => __utmb
                                )

                            [2] => SimpleXMLElement Object
                                (
                                    [cookie-name] => __utmc
                                )

                            [3] => SimpleXMLElement Object
                                (
                                    [cookie-name] => __utmz
                                )

                        )

                )

            [2] => SimpleXMLElement Object
                (
                    [plugin-name] => oo
                )

        )

 *
 */
function oik_default_plugin_cookies( $cookie_info_defaults ) {
  $plugin_cookies = array( 'wordpress'        => "wordpress_test_cookie,wordpress_,wp-settings-" 
                         , 'PHP'              => "SESS,PHPSESSID" 
                         );
                         
  // get the one from the XML file 
  $cc_mapping = $cookie_info_defaults->cc_mapping;
  foreach ( $cc_mapping as $sxmlo ) {
    // bw_trace2( $sxmlo );
    if ( $sxmlo->cookies ) {
      $cookies = array();
      foreach ( $sxmlo->cookies as $sxmlco ) { 
        bw_trace2( $sxmlco, "sxmlco", false );
        $cookies[] = bw_array_get( $sxmlco, 'cookie-name', null );
      }
      // $plugin_name = bw_array_get( $sxmlo, 'plugin-name', null );
      $plugin_name = (string) $sxmlo->{'plugin-name'};
      bw_trace2( $plugin_name, "plugin_name", false );
      $plugin_cookies[$plugin_name] = implode( ",", $cookies );
    }
  }
  bw_trace2( $plugin_cookies, "plugin_cookies", false );
  return( $plugin_cookies ); 
}

/**
 * Return an array of ALL active plugins - for single or multisite 
 * 
 * @return associative array
 * **?** HACK for bw_get_active_plugins() which is coming in oik v1.14
 * 
 */
function cc_get_active_plugins() {
  if ( is_multisite() ) {
    $active_plugins = get_site_option( 'active_sitewide_plugins');
    $names = bw_ms_get_all_plugin_names( $active_plugins );
  } else {
    $active_plugins = get_option( 'active_plugins' );
    $names = bw_get_all_plugin_names( $active_plugins );
  }  
  bw_trace2( $active_plugins, "active plugins" );
  bw_trace2( $names, "active plugin names" );
  return( $names );
}  

/**
 * Return an array of default cookie names for the active or specially identified plugins
 *
 * Some plugins such as 'googleanalytics' don't create the cookies themselves
 * but we know that if they are active then Google Analytics cookies will be used
 * 
 */
function oik_active_plugin_cookies( $cookie_info_defaults, $plugin_list ) {
  $cookies = array();
  oik_require( "admin/oik-depends.inc" );
  if ( $plugin_list ) {
    $plugins = explode( ",", $plugin_list );
  } else {    
    $extras = bw_get_option( "extras", "cookie_cat_options" );
    bw_trace2( $extras, "extras", false );
    $plugins = explode( ",", $extras );
    $plugins = array_merge( $plugins, cc_get_active_plugins() );
  }
  
  $default_plugin_cookies = oik_default_plugin_cookies( $cookie_info_defaults );
  
  if ( count( $plugins ) ) {
    foreach ( $plugins as $plugin ) {
      $plugin_cookies = oik_query_plugin_cookies( $plugin, $default_plugin_cookies );
      if ($plugin_cookies ) {
        
        $cookies = array_merge( $cookies, $plugin_cookies );
      }  
    }
  }
  bw_trace2( $cookies );  
  return( $cookies );
}

/** 
 *  'cookies' filter     oik's own implementation of the
 * 
 * Doesn't do anything except trace the cookie_list 
 * Other plugins should add to the cookie list the cookies that it suppports
 *
 * e.g. 
 * $cookie_list['oik-norty1'] = cookie_cat_info( 4, "permanent", "A category 4 cookie of the highest naughtiness" );
 * $cookie_list['oik-norty2']  = cookie_cat_info( 3, "1 second", "oik_norty_desc_cb" ); 
 *
 * where oik_norty_desc_cb() is the function that actually provides the description of this cookie
 * Note: You will need to load this function so that it can be run when the table is being generated.
 *
 * @param array $cookie_list
 * @return array - the filtered cookie list
 *
 *  
 */
function oik_lazy_cookie_filter( $cookie_list ) {
  bw_trace2();
  return( $cookie_list );
}

function cookies__syntax( $shortcode="cookies" ) {
  $syntax = array( "browser" => bw_skv( "N", "Y", "show browser cookies" )
                 , "cookies" => bw_skv( "", "<i>cookie1,cookie2</i>", "Optional list of cookie names." ) 
                 , "plugins" => bw_skv( "", "<i>plugin1,plugin2</i>", "Optional list of plugin names. Defaults to ALL active plugins" )
                 , "temp" => bw_skv( "N", "Y", "Use the temporary cc_mapping XML file" )
                 );
  return( $syntax );   
}

function cookies__help( $shortcode="cookies" ) {
  return( "Display table of cookies, by category" );
}
